<?php 
//Sempre que for utilizar '$_SESSION' é preciso iniciar a sessão
session_start();

//Se o usuario estiver logado, ele não consegue ver a tela de login, ele é redirecionado para 'painel.php'
if (isset($_SESSION['id_usuario'])) {
	header('Location: painel.php');
	exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
	<title>Inventário ETEOT</title>
	<!-- This page CSS -->
	<!-- chartist CSS -->
	<!--c3 plugins CSS -->
	<!-- Custom CSS -->
	<link rel="stylesheet" href="html/dist/css/pages/login-register-lock.css">
	<link href="html/dist/css/style.css" rel="stylesheet">

	<link href="html/dist/css/pages/floating-label.css" rel="stylesheet">
	<!-- Dashboard 1 Page CSS -->
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="css/estilo.css">
</head>

<body class="skin-default-dark fixed-layout">
	<section id="wrapper">
		<div class="login-register">
			<div class="login-box card">
				<div class="card-body">
					<form class="form-horizontal form-material" id="loginform" action="controller/login.php" method="POST">
						<img class="mx-auto d-block" src="images/logo-login-md.png" alt="">


						<!-- Mensagens para o usuário -->
						<?php if (isset($_GET['msg-login']) && $_GET['msg-login'] == '1'): ?>
							<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center">
								O E-mail e a senha devem ser preenchidos.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						<?php endif ?>

						<?php if (isset($_GET['msg-login']) && $_GET['msg-login'] == '2'): ?>
							<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center">
								E-mail ou senha incorretos.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						<?php endif ?>

						<?php if (isset($_GET['msg-login']) && $_GET['msg-login'] == '3'): ?>
							<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center">
								Usuário Bloqueado.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						<?php endif ?>
						<!-- fim das mensagens -->


						<div class="form-group">
							<div class="col-xs-12">
								<input class="form-control" name="email-login" type="email" required placeholder="Email" autocomplete="off"> 
							</div>
						</div>
						<div class="form-group ">
							<div class="col-xs-12">
								<input class="form-control" name="senha-login" type="password" required placeholder="Senha"> 
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<div class="custom-control custom-checkbox">
									<a href="javascript:void(0)" id="to-recover" class="text-dark float-right"><i class="fa fa-lock m-r-5"></i> Esqueceu a Senha?</a>
								</div>
							</div>
						</div>
						<div class="form-group text-center">
							<div class="col-xs-12 p-b-20">
								<button class="btn btn-block btn-lg botao-login" type="submit">Entrar</button>
							</div>
						</div>
					</form>
					<form class="form-horizontal" id="recoverform" action="index.html">
						<div class="form-group ">
							<div class="col-xs-12">
								<h3>Recover Password</h3>
								<p class="text-muted">Enter your Email and instructions will be sent to you! </p>
							</div>
						</div>
						<div class="form-group ">
							<div class="col-xs-12">
								<input class="form-control" type="text" required="" placeholder="Email">
							</div>
						</div>
						<div class="form-group text-center m-t-20">
							<div class="col-xs-12">
								<button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>


	<script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
	<!-- Bootstrap popper Core JavaScript -->
	<script src="assets/node_modules/popper/popper.min.js"></script>
	<script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

	<script src="html/dist/js/custom.min.js"></script>

	<script type="text/javascript">
		$(function() {
			$(".preloader").fadeOut();
		});
		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		});
// ============================================================== 
// Login and Recover Password 
// ============================================================== 
		$('#to-recover').on("click", function() {
			$("#loginform").slideUp();
			$("#recoverform").fadeIn();
		});
	</script>
</body>

</html>