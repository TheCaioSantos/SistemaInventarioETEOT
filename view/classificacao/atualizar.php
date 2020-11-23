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
				<li class="breadcrumb-item text-success">Atualizar</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="far fa-clipboard"></li> Atualizar Classificação</h4>

				<!-- Mensagens para o usuário -->

				<?php if (isset($_GET['msg-classificacao']) && $_GET['msg-classificacao'] == '4'): ?>
					<div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Classificação atualizada com sucesso.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-classificacao']) && $_GET['msg-classificacao'] == '3'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Erro ao tentar atualizar.
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


				<?php 
				if (isset($_GET['id-codigo-classificacao']) && $id_codigo_classificacao = trim($_GET['id-codigo-classificacao'])) {
					include_once 'model/classificacao.php';

					$classificacao = consultarClassificacao($id_codigo_classificacao);
					$classificacao = mysqli_fetch_assoc($classificacao);
				} else {
					header('Location: painel.php?pagina=classificacao/listar');
					exit();
				}
				 ?>

				<!-- Fim das Mensagens -->
				<form class="form-material row" action="controller/classificacao.php<?php echo isset($_GET['id-codigo-classificacao']) ? '?id-codigo-classificacao=' . $_GET['id-codigo-classificacao'] : ''; ?>" method="POST">
					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="numero-titulo-codigo-classificacao" class="form-control form-control-line" placeholder="Número do Título" value="<?php echo $classificacao['numero_titulo_codigo_classificacao'] ?>"> 
					</div>

					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="titulo-codigo-classificacao" class="form-control" placeholder="Titulo da Classificação" value="<?php echo $classificacao['titulo_codigo_classificacao'] ?>"> 
					</div>

					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="numero-subtitulo-codigo-classificacao" class="form-control form-control-line" placeholder="Número de Subtítulo" value="<?php echo $classificacao['numero_subtitulo_codigo_classificacao'] ?>"> 
					</div>

					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="subtitulo-codigo-classificacao" class="form-control form-control-line" placeholder="Subtítulo da Classificacao" value="<?php echo $classificacao['subtitulo_codigo_classificacao'] ?>"> 
					</div>
					
					<div class="button-group col-12">
						<button type="submit" class="btn waves-effect waves-light btn-success">Atualizar</button>
						<a href="?pagina=classificacao/listar" class="btn waves-effect waves-light btn-danger">Cancelar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>