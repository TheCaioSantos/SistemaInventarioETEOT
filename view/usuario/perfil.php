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
				<?php if (isset($_GET['msg-usuario']) && $_GET['msg-usuario'] == '1'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						O E-mail escolhido já foi cadastrado.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-usuario']) && $_GET['msg-usuario'] == '2'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						O CPF escolhido já foi cadastrado.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-usuario']) && $_GET['msg-usuario'] == '3'): ?>
					<div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Usuário cadastrado com sucesso.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-usuario']) && $_GET['msg-usuario'] == '4'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Erro ao tentar cadastrar.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

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
						if ($campo == 'nome-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O PRIMEIRO NOME deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'sobrenome-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O SOBRENOME deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'email-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O EMAIL deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'email-invalido-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										EMAIL inválido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';

						} elseif ($campo == 'senha-usuario') {
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
						} elseif ($campo == 'nivel-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O NÍVEL deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'nivel-invalido-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										NÍVEL inválido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'telefone-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O TELEFONE deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'telefone-invalido-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										TELEFONE inválido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'celular-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O CELULAR deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'celular-invalido-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										CELULAR inválido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'cpf-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O CPF deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'cpf-invalido-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										NÚMERO DE CPF INVÁLIDO.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'sexo-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O SEXO deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'sexo-invalido-usuario') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										SEXO INVÁLIDO.
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
				if (isset($_SESSION['id_usuario'])) {
					include_once 'model/usuario.php';

					$usuario = consultarUsuario($_SESSION['id_usuario']);
					$usuario = mysqli_fetch_assoc($usuario);
				} else {
					header('Location: painel.php?pagina=usuario/listar');
					exit();
				}
				 ?>

				<form class="form-material row" action="controller/usuario.php" method="POST">
					<input type="hidden" name="perfil-id-usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="nome-usuario" class="form-control form-control-line" value="<?php echo $usuario['nome_usuario']; ?>"> 
					</div>
					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="sobrenome-usuario" class="form-control" value="<?php echo $usuario['sobrenome_usuario']; ?>"> 
					</div>
					<div class="form-group col-md-4 m-t-20">
						<input type="email" name="email-usuario" class="form-control form-control-line" value="<?php echo $usuario['email_usuario']; ?>"> 
					</div>

					<?php
					$nivel_usuario = array(
						'1' => 'Nível 1 (Administrador)',
						'2' => 'Nível 2 (Funcionário)',
						'3' => 'Nível 3 (Visitante)',
					);
					?>
					
					<div class="form-group col-md-4 m-t-20">
						<select name="" class="form-control">
							<option value="<?php echo $usuario['nivel_usuario'] ?>"><?php echo $nivel_usuario[$usuario['nivel_usuario']] ?></option>
						</select>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="cpf-usuario" id="cpf-usuario" class="form-control" value="<?php echo $usuario['cpf_usuario']; ?>"> 
					</div>
					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="telefone-usuario" id="telefone-usuario" class="form-control form-control-line" value="<?php echo $usuario['telefone_usuario']; ?>"> 
					</div>
					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="celular-usuario" id="celular-usuario" class="form-control form-control-line" value="<?php echo $usuario['celular_usuario']; ?>"> 
					</div>

					<?php
					$sexo_usuario = array(
						'M' => 'Masculino',
						'F' => 'Feminino',
					);
					?>

					<div class="form-group col-md-4 m-t-20">
						<select name="sexo-usuario" class="form-control">
							<option value="">Sexo</option>
							<?php foreach ($sexo_usuario as $posicao => $valor): ?>
								<?php if (isset($usuario) && $usuario['sexo_usuario'] == $posicao): ?>
									<option value="<?php echo $posicao; ?>" selected><?php echo $valor; ?></option>
								<?php else: ?>
									<option value="<?php echo $posicao; ?>"><?php echo $valor ?></option>
								<?php endif; ?>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-md-4 m-t-20">

						<a href="painel.php?pagina=usuario/senha-perfil" class="text-danger"><i class="fa fa-lock"></i> Alterar Senha</a>
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