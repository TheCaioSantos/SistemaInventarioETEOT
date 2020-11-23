<?php 
if (!isset($_SESSION)){
	session_start();
}

#Verifica se o usuário está logado e seu nível de acesso
if (!isset($_SESSION['id_usuario']) || $_SESSION['nivel_usuario'] != 1) {
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
				<li class="breadcrumb-item text-success">Detalhes</li>
			</ol>
		</div>
	</div>
</div>

<?php 
if (isset($_GET['id-usuario']) && $id_usuario = trim($_GET['id-usuario'])) {
	include_once 'model/usuario.php';
	$usuario = consultarUsuario($id_usuario);
	$usuario = mysqli_fetch_assoc($usuario);
	$quantidade = consultarBensUsuariosDetalhes($_GET['id-usuario']);
}
?>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				
				<center class="m-t-30"> <img src="images/usuarios/<?php echo $usuario['avatar_usuario']; ?>" class="img-circle" width="150">
					<h4 class="card-title m-t-10"><?php echo $usuario['nome_usuario']; ?></h4>
					<h6 class="">Bens cadastrados</h6>
					<div class="row text-center justify-content-center">
						<div class="col-4">
							<h4><?php echo $quantidade ?></h4>
						</div>
					</div>
				</center>
			</div>

		</div>
	</div>

	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="fas fa-user"></li> Dados do Usuário</h4>

				<div class="row">
					<div class="col-6 col-md-4">
						<label><b>Nome</b></label>
						<p class="text-muted"><?php echo $usuario['nome_usuario']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Sobrenome</b></label>
						<p class="text-muted"><?php echo $usuario['sobrenome_usuario']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Email</b></label>
						<p class="text-muted"><?php echo $usuario['email_usuario']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Nivel de Acesso</b></label>
						<p class="text-muted"><?php echo $usuario['nome_nivel']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>CPF</b></label>
						<p class="text-muted"><?php echo $usuario['cpf_usuario']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Telefone</b></label>
						<p class="text-muted"><?php echo $usuario['telefone_usuario']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Celular</b></label>
						<p class="text-muted"><?php echo $usuario['celular_usuario']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Data de Cadastro</b></label>
						<p class="text-muted"><?php echo date('d/m/Y',strtotime($usuario['data_cadastro_usuario'])); ?></p>
					</div>

					<div class="col-12">
						<a href="?pagina=usuario/listar" class="btn waves-effect waves-light btn-danger ">Voltar</a>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>