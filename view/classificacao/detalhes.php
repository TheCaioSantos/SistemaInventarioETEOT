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
if (isset($_GET['id-codigo-classificacao']) && $id_codigo_classificacao = trim($_GET['id-codigo-classificacao'])) {
	include_once 'model/classificacao.php';
	$classificacao = consultarClassificacao($id_codigo_classificacao);
	$classificacao = mysqli_fetch_assoc($classificacao);
}
?>

<div class="row">
	
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="fas fa-user"></li> Dados da Classificação</h4>

				<div class="row">
					<div class="col-6 col-md-4">
						<label><b>Número do Título</b></label>
						<p class="text-muted"><?php echo $classificacao['numero_titulo_codigo_classificacao']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Titulo da Classificação</b></label>
						<p class="text-muted"><?php echo $classificacao['titulo_codigo_classificacao']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Número de Subtítulo</b></label>
						<p class="text-muted"><?php echo $classificacao['numero_subtitulo_codigo_classificacao']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Subtítulo da Classificacao</b></label>
						<p class="text-muted"><?php echo $classificacao['subtitulo_codigo_classificacao']; ?></p>
					</div>

					<div class="col-12">
						<a href="?pagina=classificacao/listar" class="btn waves-effect waves-light btn-danger ">Voltar</a>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>