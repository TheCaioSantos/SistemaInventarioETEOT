<?php 
if (!isset($_SESSION)){
	session_start();
}

#Verifica se o usuário está logado e seu nível de acesso
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
				<li class="breadcrumb-item text-success">Editar</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="far fa-clipboard"></li> Atualizar Dados</h4>

				<!-- Mensagens para o usuário -->

				<?php if (isset($_GET['msg-usuario']) && $_GET['msg-usuario'] == '5'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Erro ao tentar atualizar.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-usuario']) && $_GET['msg-usuario'] == '6'): ?>
					<div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Usuário atualizado com sucesso.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>


				<?php
				if (count($_GET) > 1) {
					unset($_GET['pagina']);
					foreach ($_GET as $i => $campo) {
						if ($campo == 'senha-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										A SENHA deve ser preenchida.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'senha-invalida-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										A SENHA deve ter no minimo 8 caracteres.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						}
					}
				}
				?>
				<!-- Fim das Mensagens -->

				<?php 
				
				include_once 'model/usuario.php';

				$usuario = consultarUsuario($_SESSION['id_usuario']);
				$usuario = mysqli_fetch_assoc($usuario);
				
				 ?>

				<form class="form-material row" action="controller/senha.php" method="POST">


					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-12 col-sm-12 mensagem-campo">
						Depois de alterar a senha, você será desconectado, e será redirecionado para página de login.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				
					<div class="form-group col-md-6 m-t-20">
						<fieldset disabled="">
							<label for="disabledTextInput" class="sr-only">Senha atual criptografada</label>
							<input type="text" id="disabledTextInput" class="form-control" placeholder="Senha atual criptografada: <?php echo $usuario['senha_usuario']; ?>">
						</fieldset>
					</div>

					<div class="form-group col-md-6 m-t-20">
						<label class="sr-only">Nova Senha</label>
						<input type="password" name="senha-usuario" class="form-control form-control-line" placeholder="Digite a nova senha"> 
					</div>
			
					<div class="button-group col-12">
						<button type="submit" class="btn waves-effect waves-light btn-success">Atualizar</button>
						<a href="?pagina=usuario/listar" class="btn waves-effect waves-light btn-danger">Cancelar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>