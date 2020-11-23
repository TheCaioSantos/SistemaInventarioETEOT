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
				<li class="breadcrumb-item">Setor</li>
				<li class="breadcrumb-item text-success">Atualizar</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="far fa-clipboard"></li> Atualizar Setor</h4>

				<!-- Mensagens para o usuário -->
				<?php if (isset($_GET['msg-setor']) && $_GET['msg-setor'] == '1'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						O Setor escolhido já foi cadastrado.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-setor']) && $_GET['msg-setor'] == '4'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Erro ao tentar Atualizar.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-setor']) && $_GET['msg-setor'] == '5'): ?>
					<div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Setor atualizado com sucesso.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php
				if (count($_GET) > 1) {
					unset($_GET['pagina']);
					foreach ($_GET as $i => $campo) {
						if ($campo == 'nome-setor') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O NOME DO SETOR deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'categoria-setor') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										A CATEGORIA DO SETOR deve ser preenchida.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} 
					}
				}
				?>

				<?php 
				if (isset($_GET['id-setor']) && $id_setor = trim($_GET['id-setor'])) {
					include_once 'model/setor.php';

					$setor = consultarSetor($id_setor);
					$setor = mysqli_fetch_assoc($setor);
				} else {
					header('Location: painel.php?pagina=setor/listar');
					exit();
				}
				 ?>

				<!-- Fim das Mensagens -->
				<form class="form-material row" action="controller/setor.php<?php echo isset($_GET['id-setor']) ? '?id-setor=' . $_GET['id-setor'] : ''; ?>" method="POST">
					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="nome-setor" class="form-control form-control-line" placeholder="Nome Setor" value="<?php echo $setor['nome_setor'] ?>"> 
					</div>
					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="categoria-setor" class="form-control" placeholder="Categoria Setor" value="<?php echo $setor['categoria_setor'] ?>"> 
					</div>
					
					<div class="button-group col-12">
						<button type="submit" class="btn waves-effect waves-light btn-success">Atualuzar</button>
						<a href="?pagina=setor/listar" class="btn waves-effect waves-light btn-danger">Cancelar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>