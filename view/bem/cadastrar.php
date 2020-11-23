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
				<li class="breadcrumb-item">Bens</li>
				<li class="breadcrumb-item text-success">Cadastrar</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="far fa-clipboard"></li> Cadastrar Bem</h4>




				<!-- Mensagens para o usuário -->
				<?php if (isset($_GET['msg-bem']) && $_GET['msg-bem'] == '1'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						O BEM escolhido já foi cadastrado.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-bem']) && $_GET['msg-bem'] == '2'): ?>
					<div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						BEM cadastrado com sucesso.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-bem']) && $_GET['msg-bem'] == '4'): ?>
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
						if ($campo == 'id-codigo-classificacao') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										A CLASSIFICAÇÃO deve ser preenchida.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'numero-inventario-bem') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O NÚMERO DO INVENTÁRIO deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'identificacao-bem') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										A IDENTIFICAÇÃO deve ser preenchida.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'operacao-bem') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										A OPERAÇÃO deve ser preenchida.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						}
					}
				}
				 ?>
				<!-- Fim das Mensagens -->

				<form class="form-material row" action="controller/bem.php" method="POST">

					<div class="form-group col-md-4 m-t-30">

					<select class="js-example-basic-single col-md-12" name="titulo-codigo-classificacao" data-placeholder="Escolha o Código de classificação..." id="titulo-codigo-classificacao">
						<option value=""></option>
						<?php 
						include_once 'model/bem.php';

						$codigos = consultarTituloCodigoDeClassificacao();
						?>
						<?php while ($codigo = mysqli_fetch_assoc($codigos)) : ?>
							<option value="<?php echo $codigo['numero_titulo_codigo_classificacao']; ?>"><?php echo $codigo['numero_titulo_codigo_classificacao'].' - '.$codigo['titulo_codigo_classificacao']; ?></option>
						<?php endwhile; ?>
					</select>
					</div>

					<div class="form-group col-md-4 m-t-30">
						<select class="js-example-basic-single col-md-12" name="subtitulo-codigo-classificacao" data-placeholder="Escolha o Código de classificação..." id="subtitulo-codigo-classificacao">
						</select>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="numero-inventario-bem" class="form-control" placeholder="Número de Inventário"> 
					</div>

					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="identificacao-bem" class="form-control" placeholder="Identificação"> 
					</div>


					<div class="form-group col-md-4 m-t-20">
						<select id="select-operacao" name="operacao-bem" class="form-control">
							<option value="">Operação</option>
							<option value="1">Compra</option>
							<option value="2">Transferência</option>
							<option value="3">Doação</option>
						</select>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<select name="situacao-bem" class="form-control" >
							<option value="">Ativo</option>
						</select>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<select name="conservacao-historico" class="form-control" >
							<option value="">Conservação</option>
							<option value=""></option>
							<option value="OK">OK</option>
						</select>
					</div>


					<div class="form-group col-md-4 m-t-20">
						<textarea name="historico-bem-historico" class="form-control" rows="1" placeholder="Histórico Bem"></textarea>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<textarea name="historico-operacao-historico" class="form-control" rows="1" placeholder="Histórico da Operação"></textarea>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<textarea name="observacao-bem" class="form-control" rows="1" placeholder="Observação"></textarea>
					</div>

					<div class="form-group col-md-4 m-t-20" id="valor-entrada">
						<input type="text" name="valor-entrada" class="form-control mascara-dinheiro" placeholder="Valor Entrada"> 
					</div>

					<div class="form-group col-md-4 m-t-20" id="valor-transferencia">
						<input type="text" name="valor-transferencia" class="form-control mascara-dinheiro" placeholder="Valor Transferência"> 
					</div>

					<div class="form-group col-md-4 m-t-20" id="valor-doacao">
						<input type="text" name="valor-doacao" class="form-control mascara-dinheiro" placeholder="Valor Doação"> 
					</div>

					<div class="form-group col-md-4 m-t-20" id="nome-instituicao">
						<input type="text" name="nome-instituicao" class="form-control" placeholder="Nome Instituição"> 
					</div>

					<div class="form-group col-md-4 m-t-20" id="numero-recibo">
						<input type="text" name="numero-recibo" class="form-control" placeholder="Documento Hábil"> 
					</div>

					<div class="form-group row col-md-4 m-t-20" id="data-recibo">
						<label class="control-label text-right col-md-3">Data Recibo</label>
						<div class="col-md-9">
							<input name="data-recibo" type="date" class="form-control" placeholder="dd/mm/yyyy">
						</div>
					</div>

					<div class="form-group row col-md-4 m-t-20" id="data-transferencia">
						<label class="control-label text-right col-md-3">Data Transferência</label>
						<div class="col-md-9">
							<input name="data-entrada-transferencia" type="date" class="form-control" placeholder="dd/mm/yyyy">
						</div>
					</div>

					<div class="form-group row col-md-4 m-t-20" id="data-doacao">
						<label class="control-label text-right col-md-3">Data Doação</label>
						<div class="col-md-9">
							<input name="data-doacao" type="date" class="form-control" placeholder="dd/mm/yyyy">
						</div>
					</div>

					<div class="form-group col-md-4 m-t-20" id="telefone-instituicao">
						<input type="text" name="telefone-instituicao" class="form-control form-control-line mascara-telefone" placeholder="Telefone Instituição" maxlength="14"> 
					</div>

					<div class="form-group col-md-4 m-t-20" id="cnpj-instituicao">
						<input type="text" name="cnpj-instituicao" id="mascara-cnpj" class="form-control form-control-line" placeholder="CNPJ Instituição" maxlength="14"> 
					</div>




					
				
					<div class="button-group col-12">
						<button type="submit" class="btn waves-effect waves-light btn-success">Cadastrar</button>
						<a href="?pagina=bem/listar" class="btn waves-effect waves-light btn-danger">Cancelar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>