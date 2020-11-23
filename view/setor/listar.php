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
				<li class="breadcrumb-item">Setores</li>
				<li class="breadcrumb-item text-success">Lista</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="fas fa-bullseye"></li> Lista de Setores</h4>

				<?php 
				include_once 'model/setor.php';
				include_once 'model/funcoes.php';

				$quantidade_por_pagina = 10;
				$page = isset($_GET['page']) && trim($_GET['page']) ? (int)$_GET['page'] : 1;
				$inicio = $quantidade_por_pagina * $page - $quantidade_por_pagina;

				if (isset($_POST['categoria']) && $_POST['categoria'] != '') {
					$setores = filtroCategoriaSetor($_POST['categoria']);
				} else{
					$setores = consultarSetor(null, $inicio, $quantidade_por_pagina);
				}
			
				 ?>

				 <div class="row">
					<div class="col-md-3 form-filtro">
						<form class="form-material" action="?pagina=setor/listar" method="POST">
							<div class=" form-group">
								<label for="situacao">Filtrar por Situação</label>
								<div class="input-group">
									<select name="categoria" class="form-control">
										<option value=""></option>
										<option value="Administrativo">Administrativo</option>
										<option value="Diversos">Diversos</option>
										<option value="Labóratório de Análises Clínicas">Labóratório de Análises Clínicas</option>
										<option value="Laboratório de Informática">Laboratório de Informática</option>
										<option value="Salas de Aula">Salas de Aulas</option>
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
								<th>Nome</th>
								<th>Categoria</th>
								<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))): ?>
									<th>Ações</th>
								<?php endif ?>
							</tr>
						</thead>
						<tbody>

						<?php if (mysqli_num_rows($setores) > 0): ?>
							<?php while ($setor = mysqli_fetch_assoc($setores)): ?>
								<tr>
									<td><?php echo $setor['nome_setor']; ?></td>
									<td><?php echo $setor['categoria_setor']; ?></td>
									<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))): ?>
										<td>
											<a href="painel.php?pagina=setor/atualizar&id-setor=<?php echo $setor['id_setor']; ?>" class="btn btn-warning btn-sm btn-secondary">
												<i class="fa fa-edit"></i>
												Atualizar
											</a>
										</td>
									<?php endif ?>
								</tr>
							<?php endwhile; ?>
						<?php else: ?>
							<tr>
								<td>-</td>
								<td>-</td>
								<td>-</td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>
					<?php if (empty($_POST['categoria'])) :?>
						<nav aria-label="...">
							<ul class="pagination pagination-md justify-content-center">
								<?php paginacao("setor", "setor/listar", $quantidade_por_pagina); ?>
							</ul>
						</nav>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>