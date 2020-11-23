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
				<li class="breadcrumb-item">Classificação</li>
				<li class="breadcrumb-item text-success">Lista</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="fas fa-asterisk"></li> Lista de Classificação</h4>

				<?php 
				include_once 'model/classificacao.php';
				include_once 'model/funcoes.php';

				$quantidade_por_pagina = 15;
				$page = isset($_GET['page']) && trim($_GET['page']) ? (int)$_GET['page'] : 1;
				$inicio = $quantidade_por_pagina * $page - $quantidade_por_pagina;

				if (isset($_POST['titulo']) && $_POST['titulo'] != '') {
					$classificacoes = filtroTituloBem($_POST['titulo']);
				} else{
					$classificacoes = consultarClassificacao(null, $inicio, $quantidade_por_pagina);
				}

				 ?>

				<div class="row">
					<div class="col-md-3 form-filtro">
						<form class="form-material" action="?pagina=classificacao/listar" method="POST">
							<div class=" form-group">
								<label for="titulo">Filtrar por Título</label>
								<div class="input-group">
									<input type="text" name="titulo" class="form-control">
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
								<th>N° Título</th>
								<th>Título</th>
								<th>N° Subtítulo</th>
								<th>Subtítulo</th>
								<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))): ?>
									<th>Ações</th>
								<?php endif ?>
							</tr>
						</thead>
						<tbody>

						<?php if (mysqli_num_rows($classificacoes) > 0): ?>
							<?php while ($classificacao = mysqli_fetch_assoc($classificacoes)): ?>
								<tr>
									<td><?php echo $classificacao['numero_titulo_codigo_classificacao']; ?></td>
									<td><?php echo substr($classificacao['titulo_codigo_classificacao'], 0, 50); ?></td>
									<td><?php echo $classificacao['numero_subtitulo_codigo_classificacao']; ?></td>
									<td><?php echo substr($classificacao['subtitulo_codigo_classificacao'], 0, 50); ?></td>
									<td>
										<div class="btn-group" role="group" aria-label="Basic example">
											<a href="painel.php?pagina=classificacao/detalhes&id-codigo-classificacao=<?php echo $classificacao['id_codigo_classificacao']; ?>" class="btn btn-success btn-sm btn-secondary">
												<i class="fa fa-plus"></i>
												Detalhes
											</a>
											<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))): ?>
												
													<a href="painel.php?pagina=classificacao/atualizar&id-codigo-classificacao=<?php echo $classificacao['id_codigo_classificacao']; ?>" class="btn btn-warning btn-sm btn-secondary">
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
							</tr>
						<?php endif; ?>
						</tbody>
					</table>
					<?php if (empty($_POST['titulo'])) :?>
						<nav aria-label="...">
							<ul class="pagination pagination-md justify-content-center">
								<?php paginacao("codigo_classificacao", "classificacao/listar", $quantidade_por_pagina); ?>
							</ul>
						</nav>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>