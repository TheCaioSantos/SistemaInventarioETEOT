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
				<li class="breadcrumb-item text-success">Detalhes</li>
			</ol>
		</div>
	</div>
</div>

<?php 
if (isset($_GET['id-saida']) && $id_saida = trim($_GET['id-saida'])) {
	include_once 'model/baixa.php';
	$baixa = consultarBaixa($id_saida);
	$baixa = mysqli_fetch_assoc($baixa);
}
?>

<div class="row">
	
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="fas fa-user"></li> Dados da Classificação</h4>

				<div class="row">
					<div class="col-6 col-md-4">
						<label><b>Número do Processo</b></label>
						<p class="text-muted"><?php echo $baixa['numero_processo_baixa']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Data do Processo</b></label>
						<p class="text-muted"><?php echo date('d/m/Y',strtotime($baixa['data_processo_baixa'])); ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Data de Saída	</b></label>
						<p class="text-muted"><?php echo isset($baixa['data_saida']) ? date('d/m/Y',strtotime($baixa['data_saida'])) : '-' ;?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Motivo</b></label>
						<p class="text-muted"><?php echo $baixa['motivo_saida']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Bem</b></label>
						<p class="text-muted"><?php echo $baixa['identificacao_bem']; ?></p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Situação</b></label>
						<p class="text-muted">
							<?php if ($baixa['situacao_bem'] == 1): ?>
								Ativo
							<?php elseif ($baixa['situacao_bem'] == 2): ?>
								Processo de Baixa
							<?php elseif ($baixa['situacao_bem'] == 3): ?>
								Morto
							<?php endif ?>
						</p>
					</div>

					<div class="col-6 col-md-4">
						<label><b>Baixa Por</b></label>
						<p class="text-muted"><?php echo $baixa['nome_usuario']; ?></p>
					</div>

					<div class="col-12">
						<a href="?pagina=baixa/listar" class="btn waves-effect waves-light btn-danger ">Voltar</a>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>