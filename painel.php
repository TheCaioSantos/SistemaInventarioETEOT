<?php 
session_start();

#https://pt.stackoverflow.com/questions/4251/erro-cannot-modify-header-information-headers-already-sent
ob_start();

#Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
	header('Location: index.php');
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
	<link rel="icon" type="image/png" sizes="16x16" href="images/logo-caixa-40.png">
	<title>Inventário ETEOT</title>
	<!-- This page CSS -->
	<!-- chartist CSS -->
	<!--c3 plugins CSS -->
	<link href="assets/node_modules/c3-master/c3.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="html/dist/css/style.css" rel="stylesheet">

	<link href="css/select2.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="css/estilo.css">


</head>

<body class="skin-green-dark fixed-layout">



<div id="main-wrapper">
	<header class="topbar">
		<nav class="navbar top-navbar navbar-expand-md navbar-dark">
			<div class="navbar-header">
				<a class="navbar-brand" href="painel.php">
					<b>
						<img src="images/logo-caixa-40.png" alt="homepage" class="dark-logo"><img src="images/logo-caixa-40.png" alt="homepage" class="light-logo">
					</b>
					<span>
						<img src="images/logo-inventario-26.png" alt="homepage" class="dark-logo">
						<img src="images/logo-inventario-26.png" class="light-logo" alt="homepage">
					</span>
				</a>
			</div>
			<div class="navbar-collapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item hidden-sm-up">
						<a class="nav-link nav-toggler waves-effect waves-light" href="javascript:void(0)">
							<i class="ti-menu"></i>
						</a>
					</li>
					<li class="nav-item search-box">
						<a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i>
						</a>
						<form class="app-search">
							<input type="text" class="form-control" placeholder="Search &amp; enter">
							<a class="srh-btn">
								<i class="ti-close"></i>
							</a>
						</form>
					</li>
				</ul>
				<ul class="navbar-nav my-lg-0">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							
							<img src="images/usuarios/<?php echo $_SESSION['avatar_usuario']; ?>" alt="user" class="img-circle" width="30">
							<span class="nome-usuario text-uppercase"><?php echo $_SESSION['nome_usuario'];?></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
							<span class="with-arrow box-profile">
								<span class="bg-primary"></span>
							</span>

							<a class="dropdown-item" href="?pagina=usuario/perfil">
								<i class="ti-user m-r-5 m-l-5"></i>
								Perfil
							</a>
							<a class="dropdown-item" href="model/logout.php">
								<i class="fa fa-power-off m-r-5 m-l-5"></i>
								Sair
							</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<aside class="left-sidebar">
		<div class="d-flex no-block nav-text-box align-items-center">
			<span>
				<img src="images/logo-caixa-40.png" alt="elegant admin template">
			</span>
			<a class="nav-lock waves-effect waves-dark ml-auto hidden-md-down" id="icone-menu" href="javascript:void(0)">
				<i class="ti-menu"></i>
			</a>
			<a class="nav-toggler waves-effect waves-dark ml-auto hidden-sm-up" href="javascript:void(0)">
				<i class="ti-menu ti-close"></i>
			</a>
		</div>
		<!-- Sidebar scroll-->
		<div class="scroll-sidebar ps-container ps-theme-default ps-active-y" data-ps-id="f9b62727-b9fe-c4fb-5cd5-58c9447586c4">
			<!-- Sidebar navigation-->
			<nav class="sidebar-nav">
				<ul id="sidebarnav">

					<li>
						<a class=" waves-effect waves-dark" href="painel.php" aria-expanded="false">
							<i class="fas fa-laptop"></i>
							<span class="hide-menu">Painel </span>
						</a>
					</li>

					<li>
						<a class="has-arrow waves-effect waves-dark" aria-expanded="false">
							<i class="fa fa-users"></i>
							<span class="hide-menu">Usuário</span>
						</a>
						<ul aria-expanded="false" class="collapse">
							<li>
								<a href="?pagina=usuario/listar">Ver Usuários 
									<i class="far fa-eye"></i>
								</a>
							</li>

							<?php if ($_SESSION['nivel_usuario'] == 1) : ?>
								<li>
									<a href="?pagina=usuario/cadastrar">Cadastrar Usuários 
										<i class="far fa-clipboard"></i>
									</a>
								</li>
							<?php endif; ?>

						</ul>
					</li>

					<li>
						<a class="has-arrow waves-effect waves-dark" aria-expanded="false">
							<i class="fa fa-folder-open"></i>
							<span class="hide-menu">Bem</span>
						</a>
						<ul aria-expanded="false" class="collapse">
							<li>
								<a href="?pagina=bem/listar">Ver Bens 
									<i class="far fa-eye"></i>
								</a>
							</li>

							<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))) : ?>
								<li>
									<a href="?pagina=bem/cadastrar">Cadastrar Bens 
										<i class="far fa-clipboard"></i>
									</a>
								</li>
							<?php endif; ?>

						</ul>
					</li>

					<li>
						<a class="has-arrow waves-effect waves-dark" aria-expanded="false">
							<i class="fas fa-bullseye"></i>
							<span class="hide-menu">Setor</span>
						</a>
						<ul aria-expanded="false" class="collapse">
							<li>
								<a href="?pagina=setor/listar">Ver Setores 
									<i class="far fa-eye"></i>
								</a>
							</li>

							<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))) : ?>
								<li>
									<a href="?pagina=setor/cadastrar">Cadastrar Setor 
										<i class="far fa-clipboard"></i>
									</a>
								</li>
							<?php endif; ?>

						</ul>
					</li>


					<li>
						<a class="has-arrow waves-effect waves-dark" aria-expanded="false">
							<i class="fas fa-asterisk"></i>
							<span class="hide-menu">Classificação</span>
						</a>
						<ul aria-expanded="false" class="collapse">
							<li>
								<a href="?pagina=classificacao/listar">Ver Classificações 
									<i class="far fa-eye"></i>
								</a>
							</li>

							<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))) : ?>
								<li>
									<a href="?pagina=classificacao/cadastrar">Cadastrar Classificação 
										<i class="far fa-clipboard"></i>
									</a>
								</li>
							<?php endif; ?>

						</ul>
					</li>

					<li>
						<a class="has-arrow waves-effect waves-dark" aria-expanded="false">
							<i class="fas fa-map-marker-alt"></i>
							<span class="hide-menu">Local</span>
						</a>
						<ul aria-expanded="false" class="collapse">
							<li>
								<a href="?pagina=local/listar">Ver Locais 
									<i class="far fa-eye"></i>
								</a>
							</li>

							<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))) : ?>
								<li>
									<a href="?pagina=local/cadastrar">Cadastrar Local 
										<i class="far fa-clipboard"></i>
									</a>
								</li>
							<?php endif; ?>

						</ul>
					</li>
					<?php if (in_array($_SESSION['nivel_usuario'], array(1, 2))) : ?>
						<li>
							<a class="has-arrow waves-effect waves-dark" aria-expanded="false">
								<i class="fas fa-level-down-alt"></i>
								<span class="hide-menu">Baixa</span>
							</a>
							<ul aria-expanded="false" class="collapse">
								<li>
									<a href="?pagina=baixa/listar">Ver Baixa 
										<i class="far fa-eye"></i>
									</a>
								</li>

								
									<li>
										<a href="?pagina=baixa/cadastrar">Cadastrar Baixa 
											<i class="far fa-clipboard"></i>
										</a>
									</li>
								

							</ul>
						</li>
					<?php endif; ?>

					</ul>
				</nav>
				<!-- End Sidebar navigation 
				<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
					<div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;">

					</div>
				</div>
				<div class="ps-scrollbar-y-rail" style="top: 0px; height: 737px; right: 3px;">
					<div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 478px;">

					</div>
				</div>
			</div>
			End Sidebar scroll-->
		</aside>

		<div class="page-wrapper">
			<div class="container-fluid">

		<?php include_once 'controller/router.php'; ?>

			</div>
		</div>

		<footer class="footer">
			© System by Caio Santos - Version 1.0 Lambda | Theme by Wrappixel
		</footer>

		</div>

		<script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
		<script src="js/jquery.mask.min.js"></script>

		<!-- Bootstrap popper Core JavaScript -->
		<script src="assets/node_modules/popper/popper.min.js"></script>
		<script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- slimscrollbar scrollbar JavaScript -->
		<script src="html/dist/js/perfect-scrollbar.jquery.min.js"></script>
		<!--Wave Effects -->
		<script src="html/dist/js/waves.js"></script>
		<!--Menu sidebar -->
		<script src="html/dist/js/sidebarmenu.js"></script>
		<!--Custom JavaScript -->
		<script src="html/dist/js/custom.min.js"></script>


		<!--morris JavaScript -->
		<script src="assets/node_modules/raphael/raphael-min.js"></script>
		<script src="assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
		<!--c3 JavaScript -->
		<script src="assets/node_modules/d3/d3.min.js"></script>
		<script src="assets/node_modules/c3-master/c3.min.js"></script>
		<!-- Chart JS -->

		<script src="js/select2.min.js"></script>

		<script src="js/main.js"></script>

<?php if (isset($_GET['pagina']) && $_GET['pagina'] == 'bem/atualizar'): ?>
	<!-- GAMBIARRA PARA PÁGINA bem/atualizar -->
	<script>
		document.getElementById('select-operacao').value = <?php echo $bem['operacao_bem'] ?>;
	</script>
<?php endif ?>
		
	</body>
	</html>
