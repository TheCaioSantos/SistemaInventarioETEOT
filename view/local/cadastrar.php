<?php 
if (!isset($_SESSION)){
	session_start();
}

#Verifica se o usuário está logado e seu nível de acesso
if (!isset($_SESSION['id_usuario']) || !in_array($_SESSION['nivel_usuario'], array(1, 2))) {
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
				<li class="breadcrumb-item text-success">Cadastrar</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="far fa-clipboard"></li> Cadastrar Local</h4>

				<!-- Mensagens para o usuário -->
				<?php if (isset($_GET['msg-local']) && $_GET['msg-local'] == '2'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Erro ao tentar Cadastrar.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-local']) && $_GET['msg-local'] == '1'): ?>
					<div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Local cadastrado com sucesso.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>	

				<?php
				if (count($_GET) > 1) {
					unset($_GET['pagina']);
					foreach ($_GET as $i => $campo) {
						if ($campo == 'id-bem') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O BEM deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'id-setor') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O SETOR deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} 
					}
				}
				?>

				<!-- Fim das Mensagens -->
				<form class="form-material row" action="controller/local.php" method="POST">
					<div class="form-group col-md-4 m-t-30">
						<select class="js-example-basic-single col-md-12" name="id-bem" data-placeholder="Escolha o Bem...">
							<option value=""></option>
							<?php 
							include_once 'model/local.php';

							$bens = consultarBensLocal();
							?>

							<?php while ($bem = mysqli_fetch_assoc($bens)) : ?>
								<option value="<?php echo $bem['id_bem']; ?>"><?php echo $bem['numero_inventario_bem'].' - '.$bem['identificacao_bem']; ?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<div class="form-group col-md-4 m-t-30">
						<select class="js-example-basic-single col-md-12" name="id-setor" data-placeholder="Escolha o Setor...">
							<option value=""></option>
							<?php 

							$setores = consultarSetoresLocal();
							?>

							<?php while ($setor = mysqli_fetch_assoc($setores)) : ?>
								<option value="<?php echo $setor['id_setor']; ?>"><?php echo $setor['nome_setor']; ?></option>
							<?php endwhile; ?>
						</select>
					</div>
					
					<div class="button-group col-12">
						<button type="submit" class="btn waves-effect waves-light btn-success">Cadastrar</button>
						<a href="?pagina=setor/listar" class="btn waves-effect waves-light btn-danger">Cancelar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>