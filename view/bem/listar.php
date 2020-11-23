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
				<li class="breadcrumb-item">Bens</li>
				<li class="breadcrumb-item text-success">Lista</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="fa fa-folder-open"></li> Lista de Bens</h4>

				<?php 
				include_once 'model/bem.php';
				include_once 'model/funcoes.php';

				$quantidade_por_pagina = 10;
				$page = isset($_GET['page']) && trim($_GET['page']) ? (int)$_GET['page'] : 1;
				$inicio = $quantidade_por_pagina * $page - $quantidade_por_pagina;

				

				if (isset($_POST['identificacao']) && $_POST['identificacao'] != '') {
					$bens = filtroIdentificacaoBem($_POST['identificacao']);
				} elseif (isset($_POST['situacao']) && $_POST['situacao'] != '') {
					$bens = filtroSituacaoBem($_POST['situacao']);
				} elseif (isset($_POST['operacao'])  && $_POST['operacao'] != '') {
					$bens = filtroOperacaoBem($_POST['operacao']);
				} else{
					$bens = consultarBem(null, $inicio, $quantidade_por_pagina);
				}
				 ?>


				<div class="row">
					<div class="col-md-3 form-filtro">
						<form class="form-material" action="?pagina=bem/listar" method="POST">
							<div class=" form-group">
								<label for="identificacao">Filtrar por Identificação</label>
								<div class="input-group">
									<input type="text" name="identificacao" class="form-control">
									<button class="btn waves-effect waves-light btn-success">Filtrar</button>
								</div>
							</div>
						</form>
					</div>

					<div class="col-md-3 form-filtro">
						<form class="form-material" action="?pagina=bem/listar" method="POST">
							<div class=" form-group">
								<label for="situacao">Filtrar por Situação</label>
								<div class="input-group">
									<select name="situacao" class="form-control">
										<option></option>
										<option value="1">Ativo</option>
										<option value="2">Processo de Baixa</option>
										<option value="3">Morto</option>
									</select>
									<button class="btn waves-effect waves-light btn-success">Filtrar</button>
								</div>
							</div>
						</form>
					</div>

					<div class="col-md-3 form-filtro">
						<form class="form-material" action="?pagina=bem/listar" method="POST">
							<div class=" form-group">
								<label for="operacao">Filtrar por Operação</label>
								<div class="input-group">
									<select name="operacao" class="form-control">
										<option></option>
										<option value="1">Compra</option>
										<option value="2">Transferência</option>
										<option value="3">Doação</option>
									</select>
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
								<th>Identificação</th>
								<th>Operação</th>
								<th>Situação</th>
								<th>Cadastrado Por</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>

						<?php if (mysqli_num_rows($bens) > 0): ?>
							<?php while ($bem = mysqli_fetch_assoc($bens)): ?>
								<tr>
									<td>
										<h4>
											<span class="badge badge-dark"><?php echo $bem['numero_inventario_bem']; ?></span>
										</h4>
									</td>
									<td><?php echo $bem['identificacao_bem']; ?></td>
									<td><?php echo $bem['nome_operacao']; ?></td>
									<td>
										<?php if ($bem['situacao_bem'] == 1): ?>
											<h4>
                                            	<span class="badge badge-success">Ativo</span>
                                            </h4>
                                        <?php elseif ($bem['situacao_bem'] == 2): ?>
                                        	<h4>
                                            	<span class="badge badge-warning">Processo de Baixa</span>
                                            </h4>
                                        <?php elseif ($bem['situacao_bem'] == 3): ?>
                                        	<h4>
                                            	<span class="badge badge-danger">Morto</span>
                                            </h4>
                                        <?php endif ?>
									</td>

									<td><?php echo $bem['nome_usuario']; ?></td>
									<td>
										<div class="btn-group" role="group" aria-label="Basic example">
											<a href="painel.php?pagina=bem/detalhes&id-bem=<?php echo $bem['id_bem']; ?>&operacao=<?php echo $bem['operacao_bem']; ?>" class="btn btn-success btn-sm btn-secondary">
												<i class="fa fa-plus"></i>
												Detalhes
											</a>
											<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))): ?>
											<a href="painel.php?pagina=bem/atualizar&id-bem=<?php echo $bem['id_bem']; ?>&operacao=<?php echo $bem['operacao_bem']; ?>" class="btn btn-warning btn-sm btn-secondary">
												<i class="fa fa-edit"></i>
												Atualizar
											</a>
											<?php endif ?>
										</div>
									</td>
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
					<?php if (empty($_POST['identificacao']) && empty($_POST['situacao']) && empty($_POST['operacao'])) :?>
						<nav aria-label="...">
							<ul class="pagination pagination-md justify-content-center">
								<?php paginacao("bem", "bem/listar", $quantidade_por_pagina); ?>
							</ul>
						</nav>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>