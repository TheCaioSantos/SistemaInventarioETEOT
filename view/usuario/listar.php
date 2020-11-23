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
				<li class="breadcrumb-item">Usuários</li>
				<li class="breadcrumb-item text-success">Lista</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="fas fa-users"></li> Lista de Usuários</h4>

				<!-- Mensagens para o usuário -->
				<?php if (isset($_GET['msg-usuario']) && $_GET['msg-usuario'] == '7'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-12 col-sm-12 mensagem">
						O usuário logado não pode se bloquear. 
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php 
				include_once 'model/usuario.php';
				include_once 'model/funcoes.php';

				$quantidade_por_pagina = 10;
				$page = isset($_GET['page']) && trim($_GET['page']) ? (int)$_GET['page'] : 1;
				$inicio = $quantidade_por_pagina * $page - $quantidade_por_pagina;

				$usuarios = consultarUsuario(null, $inicio, $quantidade_por_pagina);
				 ?>

				<div class=" table-sm table-responsive table-hover table-striped text-center">
					<table class="table color-bordered-table success-bordered-table">
						<thead>
							<tr>
								<th>Nome</th>
								<th>Sobrenome</th>
								<th>Nível de Acesso</th>
								<th>Status</th>
								<?php if ($_SESSION['nivel_usuario'] == 1): ?>
									<th>Email</th>
									<th>Ações</th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>

						<?php if (mysqli_num_rows($usuarios) > 0): ?>
							<?php while ($usuario = mysqli_fetch_assoc($usuarios)): ?>
								<tr>
									<td><?php echo $usuario['nome_usuario']; ?></td>
									<td><?php echo $usuario['sobrenome_usuario']; ?></td>
									<td><?php echo $usuario['nome_nivel']; ?></td>
									<td>
										<?php if($usuario['status_usuario'] == 0): ?>
											<h4>
												<span class="badge badge-danger">Bloqueado</span>
											</h4>
										<?php elseif ($usuario['status_usuario'] == 1): ?>
											<h4>
												<span class="badge badge-success">Ativo</span>
											</h4>
										<?php endif; ?>
									</td>
									<?php if ($_SESSION['nivel_usuario'] == 1): ?>
										<td><?php echo $usuario['email_usuario']; ?></td>
										<td>
											<div class="btn-group" role="group" aria-label="Basic example">
												<a href="painel.php?pagina=usuario/detalhes&id-usuario=<?php echo $usuario['id_usuario']; ?>" class="btn btn-success btn-sm btn-secondary">
													<i class="fa fa-plus"></i>
													Detalhes
												</a>
												<a href="painel.php?pagina=usuario/atualizar&id-usuario=<?php echo $usuario['id_usuario']; ?>" class="btn btn-warning btn-sm btn-secondary">
													<i class="fa fa-edit"></i>
													Atualizar
												</a>

												<?php if ($usuario['id_usuario'] == $_SESSION['id_usuario']): ?>
													<button class="btn btn-danger btn-sm btn-secondary" disabled>
														<i class="fa fa-unlock-alt"></i>
														Bloquear
													</button>
												<?php elseif ($usuario['status_usuario'] == 1): ?>
													<a href="controller/usuario.php?status-usuario=0&id-usuario=<?php echo $usuario['id_usuario']; ?>" class="btn btn-danger btn-sm btn-secondary">
														<i class="fa fa-unlock-alt"></i>
														Bloquear
													</a>
												<?php elseif ($usuario['status_usuario'] == 0): ?>
													<a href="controller/usuario.php?status-usuario=1&id-usuario=<?php echo $usuario['id_usuario']; ?>" class="btn btn-success btn-sm btn-secondary">
														<i class="fa fa-unlock"></i>
														Desbloquear
													</a>
												<?php endif; ?>

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
					<nav aria-label="...">
						<ul class="pagination pagination-md justify-content-center">
							<?php paginacao("usuario", "usuario/listar", $quantidade_por_pagina); ?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>