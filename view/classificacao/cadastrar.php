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
				<li class="breadcrumb-item">Classificação</li>
				<li class="breadcrumb-item text-success">Cadastrar</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="far fa-clipboard"></li> Cadastrar Classificação</h4>

				<!-- Mensagens para o usuário -->
				<?php if (isset($_GET['msg-classificacao']) && $_GET['msg-classificacao'] == '2'): ?>
					<div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Classificação cadastrada com sucesso.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-classificacao']) && $_GET['msg-classificacao'] == '1'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Erro ao tentar Cadastrar.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php
				if (count($_GET) > 1) {
					unset($_GET['pagina']);
					foreach ($_GET as $i => $campo) {
						if ($campo == 'numero-titulo-codigo-classificacao') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O Número do Título deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'titulo-codigo-classificacao') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O Titulo da Classificação deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'numero-subtitulo-codigo-classificacao') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O Número de Subtítulo deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'subtitulo-codigo-classificacao') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O Subtítulo da Classificacao deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} 
					}
				}
				?>

				<!-- Fim das Mensagens -->
				<form class="form-material row" action="controller/classificacao.php" method="POST">
					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="numero-titulo-codigo-classificacao" class="form-control form-control-line" placeholder="Número do Título"> 
					</div>

					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="titulo-codigo-classificacao" class="form-control" placeholder="Titulo da Classificação"> 
					</div>

					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="numero-subtitulo-codigo-classificacao" class="form-control form-control-line" placeholder="Número de Subtítulo"> 
					</div>

					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="subtitulo-codigo-classificacao" class="form-control form-control-line" placeholder="Subtítulo da Classificacao"> 
					</div>
					
					<div class="button-group col-12">
						<button type="submit" class="btn waves-effect waves-light btn-success">Cadastrar</button>
						<a href="?pagina=classificacao/listar" class="btn waves-effect waves-light btn-danger">Cancelar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>