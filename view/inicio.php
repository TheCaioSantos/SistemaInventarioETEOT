<?php 
if (!isset($_SESSION)){
	session_start();
}

#Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
	header('Location: ../index.php');
	exit();
}

include_once 'model/bem.php';
        //Chamando função de consulta
$situacao = consultarBensSituacao();

?>

<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">Painel</h4>
	</div>
	<div class="col-md-7 align-self-center text-right">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="painel.php">Painel</a></li>
				<li class="breadcrumb-item text-success">Inicio</li>
			</ol>
			
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex p-10 no-block">
					<div class="align-slef-center">
						<h6 class="text-muted m-b-0">Bens Cadastrados</h6>
						<h2 class="m-b-0 count"><?php echo $situacao[0] ?></h2>
					</div>
					<div class="align-self-center display-6 ml-auto"><i class="text-info fas fa-folder-open"></i></div>
				</div>
			</div>
			<div class="progress">
				<div class="progress-bar bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%; height:3px;"></div>
			</div>
		</div>
	</div>

	<div class="col-lg-3 col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex p-10 no-block">
					<div class="align-slef-center">
						<h6 class="text-muted m-b-0">Bens Ativos</h6>
						<h2 class="m-b-0 count"><?php echo $situacao[1] ?></h2>
					</div>
					<div class="align-self-center display-6 ml-auto"><i class="text-success fas fa-level-up-alt"></i></div>
				</div>
			</div>
			<div class="progress">
				<div class="progress-bar bg-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%; height:3px;"></div>
			</div>
		</div>
	</div>

	<div class="col-lg-3 col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex p-10 no-block">
					<div class="align-slef-center">
						<h6 class="text-muted m-b-0">Bens em Processo de Baixa</h6>
						<h2 class="m-b-0 count"><?php echo $situacao[2] ?></h2>
					</div>
					<div class="align-self-center display-6 ml-auto"><i class="text-warning fas fa-level-down-alt"></i></div>
				</div>
			</div>
			<div class="progress">
				<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%; height:3px;"></div>
			</div>
		</div>
	</div>

	<div class="col-lg-3 col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex p-10 no-block">
					<div class="align-slef-center">
						<h6 class="text-muted m-b-0">Bens Mortos</h6>
						<h2 class="m-b-0 count"><?php echo $situacao[3] ?></h2>
					</div>
					<div class="align-self-center display-6 ml-auto"><i class="text-danger fas fa-times"></i></div>
				</div>
			</div>
			<div class="progress">
				<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%; height:3px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Últimos Bens Cadastrados</h4>
				<?php
				include_once 'model/bem.php';
				//Chamando função de consulta
				$bens = consultarBensUltimos();
				?>

				<div class="table-responsive text-center">
					<table class="table color-bordered-table success-bordered-table">
						<thead>
							<tr>
								<th>N° Inven.</th>
								<th>Identificação</th>
								<th>Operação</th>
								<th>Situação</th>
							</tr>
						</thead>
						<tbody>
							<?php if (mysqli_num_rows($bens) > 0) : ?>
								<?php while ($bem = mysqli_fetch_assoc($bens)) : ?>
							<tr>
								<td><?php echo $bem['numero_inventario_bem']; ?></td>
								<td><?php echo $bem['identificacao_bem']; ?></td>
								<td><?php echo $bem['nome_operacao']; ?></td>
								<td>
									<?php if ($bem['situacao_bem'] == 1): ?>
										<span class="badge badge-success">Ativo</span>
									<?php elseif ($bem['situacao_bem'] == 2): ?>
										<span class="badge badge-warning">Processo de Baixa</span>
									<?php elseif ($bem['situacao_bem'] == 3): ?>
										<span class="badge badge-danger">Morto</span>
									<?php endif ?>
								</td>
							</tr>
							<?php endwhile; ?>
							<?php endif; ?>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-6">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Usuários que mais cadastraram Bens</h4>
				<?php
				include_once 'model/bem.php';
				//Chamando função de consulta
				$usuarios = consultarBensUsuarios();
				?>
				<div class="table-responsive text-center">
					<table class="table color-bordered-table success-bordered-table">
						<thead>
							<tr>
								<th>Nome</th>
								<th>Sobrenome</th>
								<th>Nivel</th>
								<th>Status</th>
								<th>Quantidade</th>
							</tr>
						</thead>
						<tbody>
							<?php if (mysqli_num_rows($usuarios) > 0) : ?>
								<?php while ($usuario = mysqli_fetch_assoc($usuarios)) : ?>
							<tr>
								<td><?php echo $usuario['nome_usuario']; ?></td>
								<td><?php echo $usuario['sobrenome_usuario']; ?></td>
								<td><?php echo $usuario['nome_nivel']; ?></td>
								<td>
									 <?php if ($usuario['status_usuario'] == 0): ?>
                                        <span class="badge badge-danger">Bloqueado</span>
                                    <?php elseif ($usuario['status_usuario'] == 1): ?>
                                        <span class="badge badge-success">Ativo</span>
                                    <?php endif ?>
								</td>
								<td><span class="count"><?php echo $usuario['total']; ?></span></td>
							</tr>
							<?php endwhile; ?>
							<?php endif; ?>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
