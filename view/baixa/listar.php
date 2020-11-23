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
				<li class="breadcrumb-item">Baixa</li>
				<li class="breadcrumb-item text-success">Lista</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="fas fa-bullseye"></li> Lista de Baixa</h4>

				<?php 
				include_once 'model/baixa.php';
				include_once 'model/funcoes.php';

				$quantidade_por_pagina = 10;
				$page = isset($_GET['page']) && trim($_GET['page']) ? (int)$_GET['page'] : 1;
				$inicio = $quantidade_por_pagina * $page - $quantidade_por_pagina;

				if (isset($_POST['numero-processo-baixa']) && $_POST['numero-processo-baixa'] != '') {
					$baixas = filtroNumeroProcessoBaixa($_POST['numero-processo-baixa']);
				} else{
					$baixas = consultarBaixa(null, $inicio, $quantidade_por_pagina);
				}
			
				 ?>

				 <div class="row">
					<div class="col-md-3 form-filtro">
						<form class="form-material" action="?pagina=baixa/listar" method="POST">
							<div class=" form-group">
								<label for="numero-processo-baixa">Filtrar por Número do Processo</label>
								<div class="input-group">
									<input type="text" name="numero-processo-baixa" class="form-control">
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
								<th>Número do Processo</th>
								<th>Data do Processo</th>
								<th>Data de Saída</th>
								<th>Bem</th>
								<th>Baixa Por</th>
								<th>Situação</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>

						<?php if (mysqli_num_rows($baixas) > 0): ?>
							<?php while ($baixa = mysqli_fetch_assoc($baixas)): ?>
								<tr>
									<td><?php echo $baixa['numero_processo_baixa']; ?></td>
									<td><?php echo date('d/m/Y',strtotime($baixa['data_processo_baixa'])); ?></td>
									<td><?php echo isset($baixa['data_saida']) ? date('d/m/Y',strtotime($baixa['data_saida'])) : '-' ;?></td>
									<td><?php echo $baixa['identificacao_bem']; ?></td>
									<td><?php echo $baixa['nome_usuario']; ?></td>
									<td>
										<?php if ($baixa['situacao_bem'] == 1): ?>
											<h4>
                                            	<span class="badge badge-success">Ativo</span>
                                            </h4>
                                        <?php elseif ($baixa['situacao_bem'] == 2): ?>
                                        	<h4>
                                            	<span class="badge badge-warning">Processo de Baixa</span>
                                            </h4>
                                        <?php elseif ($baixa['situacao_bem'] == 3): ?>
                                        	<h4>
                                            	<span class="badge badge-danger">Morto</span>
                                            </h4>
                                        <?php endif ?>
									</td>

									<td>
										<div class="btn-group" role="group" aria-label="Basic example">
											<a href="painel.php?pagina=baixa/detalhes&id-saida=<?php echo $baixa['id_saida']; ?>" class="btn btn-success btn-sm btn-secondary">
												<i class="fa fa-plus"></i>
												Detalhes
											</a>
											<?php if ($baixa['situacao_bem'] == 2): ?>
												<a href="controller/baixa.php?id-saida=<?php echo $baixa['id_saida']; ?>&id-bem=<?php echo $baixa['id_bem']; ?>&morto=true" class="btn btn-danger btn-sm btn-secondary">
													<i class=" fas fa-times"></i>
													Morto
												</a>
											<?php elseif ($baixa['situacao_bem'] == 3): ?>
												<button class="btn btn-danger btn-sm btn-secondary" disabled>
													<i class=" fas fa-times"></i>
														Morto
												</button>
											<?php endif; ?>
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
					<?php if (empty($_POST['categoria'])) :?>
						<nav aria-label="...">
							<ul class="pagination pagination-md justify-content-center">
								<?php paginacao("saida", "baixa/listar", $quantidade_por_pagina); ?>
							</ul>
						</nav>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>