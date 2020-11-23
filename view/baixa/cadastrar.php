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
				<li class="breadcrumb-item">Baixa</li>
				<li class="breadcrumb-item text-success">Cadastrar</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="far fa-clipboard"></li> Cadastrar Baixa</h4>

				<!-- Mensagens para o usuário -->
				<?php if (isset($_GET['msg-baixa']) && $_GET['msg-baixa'] == '2'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Erro ao tentar Cadastrar.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-baixa']) && $_GET['msg-baixa'] == '1'): ?>
					<div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Baixa cadastrada com sucesso.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>


				<?php
				if (count($_GET) > 1) {
					unset($_GET['pagina']);
					foreach ($_GET as $i => $campo) {
						if ($campo == 'numero-processo-baixa') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O NÚMERO DE PROCESSO deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'data-processo-baixa') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										A DATA DO PROCESSO deve ser preenchida.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'motivo-baixa') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O MOTIVO deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'id-bem-baixa') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O BEM deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} 
					}
				}
				?>

				<!-- Fim das Mensagens -->
				<form class="form-material row" action="controller/baixa.php" method="POST">
					<div class="form-group col-md-6 m-t-20">
						<input type="text" name="numero-processo-baixa" class="form-control form-control-line" placeholder="Número do Processo"> 
					</div>

					<div class="form-group row col-md-6 m-t-20" id="data-processo-baixa" style="display: flex;">
						<label class="control-label text-right col-md-3">Data do Processo</label>
						<div class="col-md-9">
							<input name="data-processo-baixa" type="date" class="form-control" placeholder="dd/mm/yyyy">
						</div>
					</div>

					<div class="form-group col-md-6 m-t-30">

						<select class="js-example-basic-single col-md-12" name="id-bem-baixa" data-placeholder="Escolha Bem..." id="id-bem-baixa">
							<option value=""></option>
							<?php 
							include_once 'model/baixa.php';

							$bens = consultarBensAtivo();
							?>
							<?php while ($bem = mysqli_fetch_assoc($bens)) : ?>
								<option value="<?php echo $bem['id_bem']; ?>"><?php echo $bem['numero_inventario_bem'].' - '.$bem['identificacao_bem']; ?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<div class="form-group col-md-6 m-t-20">
						<textarea name="motivo-baixa" class="form-control" rows="1" placeholder="Motivo"></textarea>
					</div>
					
					<div class="button-group col-12">
						<button type="submit" class="btn waves-effect waves-light btn-success">Cadastrar</button>
						<a href="?pagina=baixa/listar" class="btn waves-effect waves-light btn-danger ">Cancelar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>