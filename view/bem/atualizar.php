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

				<?php if (isset($_GET['msg-bem']) && $_GET['msg-bem'] == '3'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Erro ao tentar Atualizar.
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

				<?php if (isset($_GET['msg-bem']) && $_GET['msg-bem'] == '5'): ?>
					<div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						BEM atualizado com sucesso.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>







				<?php 
				if (count($_GET) > 1) {
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
						} elseif ($campo == 'XXXXXX') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										XXXXXXXXXXXXXXXXXXXX.
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
				if (isset($_GET['id-bem']) && $id_bem = trim($_GET['id-bem'])) {
					include_once 'model/bem.php';
					$operacao = isset($_GET['operacao']) && trim($_GET['operacao']) ? trim($_GET['operacao']) : null;
					if ($operacao == 1) {
						$bem = consultarBemCompra($id_bem);
					} elseif ($operacao == 2) {
						$bem = consultarBemTransferencia($id_bem);
					} elseif ($operacao == 3) {
						$bem = consultarBemDoacao($id_bem);
					}

					$bem = mysqli_fetch_assoc($bem);
				}

				?>



				<form class="form-material row" action="controller/bem.php<?php echo isset($_GET['id-bem']) ? '?id-bem=' . $_GET['id-bem'] : ''; ?><?php echo '&operacao=' . $operacao ?>" method="POST">

					<div class="form-group col-md-4 m-t-30">

					<select class="js-example-basic-single col-md-12" name="titulo-codigo-classificacao" data-placeholder="Escolha o Código de classificação..." id="titulo-codigo-classificacao">
						<option value=""></option>
						<?php 
						include_once 'model/bem.php';

						$codigos = consultarTituloCodigoDeClassificacao();
						?>
						<?php while ($codigo = mysqli_fetch_assoc($codigos)) : ?>
							<?php if ($bem['titulo_codigo_classificacao'] == $codigo['titulo_codigo_classificacao'] ): ?>
								<option value="<?php echo $codigo['numero_titulo_codigo_classificacao']; ?>" selected><?php echo $codigo['numero_titulo_codigo_classificacao'].' - '.$codigo['titulo_codigo_classificacao']; ?></option>
							<?php else: ?>
								<option value="<?php echo $codigo['numero_titulo_codigo_classificacao']; ?>"><?php echo $codigo['numero_titulo_codigo_classificacao'].' - '.$codigo['titulo_codigo_classificacao']; ?></option>
							<?php endif; ?>
						<?php endwhile; ?>
					</select>
					</div>

					<div class="form-group col-md-4 m-t-30">
						<select class="js-example-basic-single col-md-12" name="subtitulo-codigo-classificacao" data-placeholder="Escolha o Código de classificação..." id="subtitulo-codigo-classificacao">
							<option value=""></option>
							<?php 
							include_once 'model/bem.php';

							$cod = $bem['numero_titulo_codigo_classificacao'];

							$cods = consultarSubtituloCodigoDeClassificacaoEditar($cod);


							?>

							<?php while ($cod = mysqli_fetch_assoc($cods)) : ?>
								<?php if ($bem['subtitulo_codigo_classificacao'] == $cod['subtitulo_codigo_classificacao'] ): ?>
									<option value="<?php echo $cod['id_codigo_classificacao']; ?> " selected><?php echo $cod['numero_subtitulo_codigo_classificacao'].' - '.$cod['subtitulo_codigo_classificacao'] ?></option>
								<?php else: ?>
									<option value="<?php echo $cod['id_codigo_classificacao']; ?>"><?php echo $cod['numero_subtitulo_codigo_classificacao'].' - '.$cod['subtitulo_codigo_classificacao'] ?></option>
								<?php endif; ?>

							<?php endwhile; ?>
						</select>
					</div>


					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="numero-inventario-bem" class="form-control" placeholder="Número de Inventário" value="<?php echo $bem['numero_inventario_bem'] ?>"> 
					</div>

					<div class="form-group col-md-4 m-t-20">
						<input type="text" name="identificacao-bem" class="form-control" placeholder="Identificação" value="<?php echo $bem['identificacao_bem'] ?>"> 
					</div>


					<?php
					$operacao_bem = array(
						'1' => 'Compra',
						'2' => 'Transferência',
						'3' => 'Doação',
					);
					?>

					<div class="form-group col-md-4 m-t-20">
						<select id="select-operacao" name="operacao-bem" class="form-control">
							<option value="">Operação</option>
							<?php foreach ($operacao_bem as $posicao => $valor): ?>
								<?php if (isset($bem) && $bem['operacao_bem'] == $posicao): ?>
									<option value="<?php echo $posicao; ?>" selected><?php echo $valor; ?></option>
									<?php else: ?>
										<option value="<?php echo $posicao; ?>"><?php echo $valor ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
								
							</select>
						</div>


					<div class="form-group col-md-4 m-t-20">
						<select name="situacao-bem" class="form-control" >
							<option value="<?php echo $bem['situacao_bem'] ?>"><?php echo $bem['nome_situacao'] ?></option>
						</select>
					</div>

					<?php
					$conservacao = array(
						'OK' => 'OK',
					);
					?>

					<div class="form-group col-md-4 m-t-20">
						<select name="conservacao-historico" class="form-control" >
							<option value="">Conservação</option>
							<option value=""></option>
							<?php foreach ($conservacao as $posicao => $valor): ?>
								<?php if (isset($bem) && $bem['conservacao_historico'] == $posicao): ?>
									<option value="<?php echo $posicao ?>" selected><?php echo $valor ?></option>
								<?php else: ?>
									<option value="<?php echo $posicao ?>"><?php echo $valor ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</div>


					<div class="form-group col-md-4 m-t-20">
						<textarea name="historico-bem-historico" class="form-control" rows="1" placeholder="Histórico Bem"><?php echo $bem['historico_bem_historico'] ?></textarea>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<textarea name="historico-operacao-historico" class="form-control" rows="1" placeholder="Histórico da Operação"><?php echo $bem['historico_operacao_historico'] ?></textarea>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<textarea name="observacao-bem" class="form-control" rows="1" placeholder="Observação"><?php echo $bem['observacao_bem'] ?></textarea>
					</div>

					<div class="form-group col-md-4 m-t-20" id="valor-entrada">
						<input type="text" name="valor-entrada" class="form-control mascara-dinheiro" placeholder="Valor Entrada" value="<?php echo isset($bem['valor_entrada']) ? trim($bem['valor_entrada']) : ''; ?>"> 
					</div>

					<div class="form-group col-md-4 m-t-20" id="valor-transferencia">
						<input type="text" name="valor-transferencia" class="form-control mascara-dinheiro" placeholder="Valor Transferência" value="<?php echo isset($bem['valor_transferencia']) ? trim($bem['valor_transferencia']) : ''; ?>"> 
					</div>

					<div class="form-group col-md-4 m-t-20" id="valor-doacao">
						<input type="text" name="valor-doacao" class="form-control mascara-dinheiro" placeholder="Valor Doação" value="<?php echo isset($bem['valor_doacao']) ? trim($bem['valor_doacao']) : ''; ?>"> 
					</div>

					<div class="form-group col-md-4 m-t-20" id="nome-instituicao">
						<input type="text" name="nome-instituicao" class="form-control" placeholder="Nome Instituição" value="<?php echo isset($bem['nome_instituicao']) ? trim($bem['nome_instituicao']) : ''; ?>"> 
					</div>


					<div class="form-group col-md-4 m-t-20" id="numero-recibo">
						<input type="text" name="numero-recibo" class="form-control" placeholder="Documento Hábil" value="<?php echo isset($bem['numero_recibo']) ? trim($bem['numero_recibo']) : ''; ?>"> 
					</div>

					<div class="form-group row col-md-4 m-t-20" id="data-recibo">
						<label class="control-label text-right col-md-3">Data Recibo</label>
						<div class="col-md-9">
							<input name="data-recibo" type="date" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo isset($bem['data_recibo']) ? trim($bem['data_recibo']) : ''; ?>">
						</div>
					</div>

					<div class="form-group row col-md-4 m-t-20" id="data-transferencia">
						<label class="control-label text-right col-md-3">Data Transferência</label>
						<div class="col-md-9">
							<input name="data-entrada-transferencia" type="date" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo isset($bem['data_entrada_transferencia']) ? trim($bem['data_entrada_transferencia']) : ''; ?>">
						</div>
					</div>

					<div class="form-group row col-md-4 m-t-20" id="data-doacao">
						<label class="control-label text-right col-md-3">Data Doação</label>
						<div class="col-md-9">
							<input name="data-doacao" type="date" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo isset($bem['data_entrada_doacao']) ? trim($bem['data_entrada_doacao']) : ''; ?>">
						</div>
					</div>

					<div class="form-group col-md-4 m-t-20" id="telefone-instituicao">
						<input type="text" name="telefone-instituicao" class="form-control form-control-line mascara-telefone" placeholder="Telefone Instituição" maxlength="14" value="<?php echo isset($bem['telefone_instituicao']) ? trim($bem['telefone_instituicao']) : ''; ?>"> 
					</div>

					<div class="form-group col-md-4 m-t-20" id="cnpj-instituicao">
						<input type="text" name="cnpj-instituicao" id="mascara-cnpj" class="form-control form-control-line" placeholder="CNPJ Instituição" maxlength="14" value="<?php echo isset($bem['cnpj_instituicao']) ? trim($bem['cnpj_instituicao']) : ''; ?>"> 
					</div>

	
					<div class="button-group col-12">
						<button type="submit" class="btn waves-effect waves-light btn-success">Atualizar</button>
						<a href="?pagina=bem/listar" class="btn waves-effect waves-light btn-danger">Cancelar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
