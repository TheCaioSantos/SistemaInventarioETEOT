<?php 
if (!isset($_SESSION)){
	session_start();
}

#Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
	header('Location: ../../index.php');
	exit();
}

?>

<div class="row page-titles">
	<div class="col-md-12 align-self-center text-right">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="painel.php">Painel</a></li>
				<li class="breadcrumb-item">Local</li>
				<li class="breadcrumb-item text-success">Lista</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="fas fa-users"></li> Lista de Locais</h4>

				<?php 
				include_once 'model/local.php';
				include_once 'model/funcoes.php';

				$quantidade_por_pagina = 10;
				$page = isset($_GET['page']) && trim($_GET['page']) ? (int)$_GET['page'] : 1;
				$inicio = $quantidade_por_pagina * $page - $quantidade_por_pagina;

				if (isset($_POST['setor']) && $_POST['setor'] != '') {
					$locais = filtroSetorLocal($_POST['setor']);
				} elseif (isset($_POST['inventario']) && $_POST['inventario'] != '') {
					$locais = filtroInventarioLocal($_POST['inventario']);
				} else {
					$locais = consultarLocal(null, $inicio, $quantidade_por_pagina);
				}
				?>


				 <div class="row">
					<div class="col-md-3 form-filtro">
						<form class="form-material" action="?pagina=local/listar" method="POST">
							<div class=" form-group">
								<label for="setor">Filtrar por Setor</label>
								<div class="input-group">
									<select name="setor" class="form-control">
										<option value=""></option>
										<?php
										include_once 'model/local.php';

										$setores = consultarSetoresLocal();
										?>

										<?php while ($setor = mysqli_fetch_assoc($setores)) : ?>
											<option value="<?php echo $setor['id_setor']; ?>"><?php echo $setor['nome_setor'] ?></option>
										<?php endwhile; ?>
									</select>
									<button class="btn waves-effect waves-light btn-success">Filtrar</button>
								</div>
							</div>
						</form>
					</div>

					<div class="col-md-3 form-filtro">
						<form class="form-material" action="?pagina=local/listar" method="POST">
							<div class=" form-group">
								<label for="inventario">Filtrar por N° Inven.</label>
								<div class="input-group">
									<input type="text" name="inventario" class="form-control">
									<button class="btn waves-effect waves-light btn-success">Filtrar</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class=" table-sm table-responsive table-hover table-striped text-center">
					<table class="table color-bordered-table success-bordered-table">
						<thead>
							<tr>
								<th>N° Inven.</th>
								<th>Bem</th>
								<th>Setor</th>
								<th>Status</th>
								<th>Data Inicial</th>
								<th>Final</th>
								<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))): ?>
									<th>Ações</th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>

						<?php if (mysqli_num_rows($locais) > 0): ?>
							<?php while ($local = mysqli_fetch_assoc($locais)): ?>
								<tr>
									<td>
										<h4>
											<span class="badge badge-dark"><?php echo $local['numero_inventario_bem']; ?></span>
										</h4>
									</td>
									<td><?php echo $local['identificacao_bem']; ?></td>
									<td><?php echo $local['nome_setor']; ?></td>
									<td>
										<?php if($local['status_local_local'] == 0): ?>
											<h4>
												<span class="badge badge-danger">Off</span>
											</h4>
										<?php elseif ($local['status_local_local'] == 1): ?>
											<h4>
												<span class="badge badge-success">On</span>
											</h4>
										<?php endif; ?>
									</td>
									<td><?php echo date('d/m/Y',strtotime($local['data_inicio_local'])); ?></td>
									<td><?php echo isset($local['data_fim_local']) ? date('d/m/Y',strtotime($local['data_fim_local'])) : '-' ;  ?></td>
									
									<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))): ?>
										<td>
											<div class="btn-group" role="group" aria-label="Basic example">
												<a href="painel.php?pagina=local/atualizar&id-local=<?php echo $local['id_local']; ?>" class="btn btn-success btn-sm btn-secondary">
													<i class=" fas fa-exchange-alt"></i>
													Transferir
												</a>
											</div>
										</td>
									<?php endif; ?>
								</tr>
							<?php endwhile; ?>
						<?php else: ?>
							<tr>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>

					<?php if (isset($_POST['setor']) && $_POST['setor'] != '') : ?>
						<form action="controller/relatorio-local.php" method="POST" target="blank">
							<input type="hidden" name="relatorio-local" value="<?php echo $_POST['setor'] ?>">
							<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-print"></i>&nbsp; Imprimir</button>
						</form>
					<?php endif; ?>


					<?php if (empty($_POST['setor']) && empty($_POST['inventario'])) :?>
						<nav aria-label="...">
							<ul class="pagination pagination-md justify-content-center">
								<?php paginacao("local", "local/listar", $quantidade_por_pagina); ?>
							</ul>
						</nav>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>