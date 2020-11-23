<?php 
if (!isset($_SESSION)){
	session_start();
}

#Verifica se o usuário está logado e seu nível de acesso
if (!isset($_SESSION['id_usuario'])) {
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
				<li class="breadcrumb-item text-success">Detalhes</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="fa fa-folder-open"></li> Dados do Bem</h4>

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



				<div class="row">
					<div class="form-group col-md-4 m-t-30">
						<label><b>Código de classificação</b></label>
						<p class="text-muted"><?php echo $bem['numero_titulo_codigo_classificacao'] . ' - ' . $bem['titulo_codigo_classificacao'] ?></p>
					</div>

					<div class="form-group col-md-4 m-t-30">
						<label><b>Classificação</b></label>
						<p class="text-muted"><?php echo $bem['numero_subtitulo_codigo_classificacao'] . ' - ' . $bem['subtitulo_codigo_classificacao'] ?></p>
					</div>


					<div class="form-group col-md-4 m-t-20">
						<label><b>Número de Inventário</b></label>
						<p class="text-muted"><?php echo $bem['numero_inventario_bem'] ?></p>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<label><b>Identificação</b></label>
						<p class="text-muted"><?php echo $bem['identificacao_bem'] ?></p>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<label><b>Operação</b></label>
						<p class="text-muted"><?php echo $bem['nome_operacao'] ?></p>
					</div>


					<div class="form-group col-md-4 m-t-20">
						<label><b>Situação</b></label>
						<p class="text-muted"><?php echo $bem['situacao_bem'] ?></p>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<label><b>Conservação</b></label>
						<p class="text-muted"><?php echo $bem['conservacao_historico'] ?></p>
					</div>


					<div class="form-group col-md-4 m-t-20">
						<label><b>Histórico Bem</b></label>
						<p class="text-muted"><?php echo $bem['historico_bem_historico'] ?></p>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<label><b>Histórico Operação</b></label>
						<p class="text-muted"><?php echo $bem['historico_operacao_historico'] ?></p>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<label><b>Observação</b></label>
						<p class="text-muted"><?php echo $bem['observacao_bem'] ?></p>
					</div>
					
					<?php if ($operacao == 1): ?>
						<div class="form-group col-md-4 m-t-20">
							<label><b>Valor Entrada</b></label>
							<p class="text-muted"><?php echo $bem['valor_entrada'] ?></p>
						</div>

						<div class="form-group col-md-4 m-t-20">
							<label><b>Valor Entrada</b></label>
							<p class="text-muted"><?php echo $bem['numero_recibo'] ?></p>
						</div>

						<div class="form-group col-md-4 m-t-20">
							<label><b>Data Recibo</b></label>
							<p class="text-muted"><?php echo date('d/m/Y',strtotime($bem['data_recibo'])) ?></p>
						</div>


					<?php endif ?>


					<?php if ($operacao == 2 or $operacao == 3): ?>
						<div class="form-group col-md-4 m-t-20">
							<label><b>Nome Instituição</b></label>
							<p class="text-muted"><?php echo $bem['nome_instituicao'] ?></p>
						</div>

						<div class="form-group col-md-4 m-t-20">
							<label><b>Telefone Instituição</b></label>
							<p class="text-muted"><?php echo $bem['telefone_instituicao'] ?></p>
						</div>

						<div class="form-group col-md-4 m-t-20">
							<label><b>CNPJ Instituição</b></label>
							<p class="text-muted"><?php echo $bem['cnpj_instituicao'] ?></p>
						</div>
					<?php endif ?>

					<?php if ($operacao == 2): ?>
						<div class="form-group col-md-4 m-t-20">
							<label><b>Data Transferência</b></label>
							<p class="text-muted"><?php echo date('d/m/Y',strtotime($bem['data_entrada_transferencia'])) ?></p>
						</div>

						<div class="form-group col-md-4 m-t-20">
							<label><b>Valor Transferência</b></label>
							<p class="text-muted"><?php echo $bem['valor_transferencia'] ?></p>
						</div>
					<?php endif ?>

					<?php if ($operacao == 3): ?>
						<div class="form-group col-md-4 m-t-20">
							<label><b>Data Doação</b></label>
							<p class="text-muted"><?php echo date('d/m/Y',strtotime($bem['data_entrada_doacao'])) ?></p>
						</div>

						<div class="form-group col-md-4 m-t-20">
							<label><b>Valor Doação</b></label>
							<p class="text-muted"><?php echo $bem['valor_doacao'] ?></p>
						</div>
					<?php endif ?>

					<div class="button-group col-12">
						<a href="?pagina=bem/listar" class="btn waves-effect waves-light btn-danger">Voltar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
