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
				<li class="breadcrumb-item">Usuários</li>
				<li class="breadcrumb-item text-success">Editar</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><li class="far fa-clipboard"></li> Atualizar Dados</h4>

				<!-- Mensagens para o usuário -->
				<?php if (isset($_GET['msg-local']) && $_GET['msg-local'] == '2'): ?>
					<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Erro ao tentar Cadastrar.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php if (isset($_GET['msg-local']) && $_GET['msg-local'] == '1'): ?>
					<div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem">
						Local cadastrado com sucesso.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>	

				
				<?php
				if (count($_GET) > 1) {
					unset($_GET['pagina']);
					foreach ($_GET as $i => $campo) {
						if ($campo == 'id-bem') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O BEM deve ser preenchido.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						} elseif ($campo == 'id-setor') {
							echo '
									<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center col-lg-3 col-sm-12 mensagem-campo">
										O SETOR deve ser preenchido.
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
				if (isset($_GET['id-local']) && $id_local= trim($_GET['id-local'])) {
					include_once 'model/local.php';
					$local = consultarLocal($id_local);
					$local = mysqli_fetch_assoc($local);
				} else {
					header('Location: painel.php?pagina=local/listar');
					exit();
				}
				 ?>

				<form class="form-material row" action="controller/local.php<?php echo isset($_GET['id-local']) ? '?id-local=' . $_GET['id-local'] : ''; ?>" method="POST">
					<div class="form-group col-md-4 m-t-30">
						<label>Bem</label>
						<input type="hidden" name="id-bem" value="<?php echo $local['id_bem']?>" class="form-control">
						<input class="form-control" type="text" placeholder="<?php echo $local['numero_inventario_bem'].' - '.$local['identificacao_bem']; ?>" readonly="">
					</div>

					<div class="form-group col-md-4 m-t-30">
						<?php if (empty($local['data_fim_local'])): ?>
                                    <select class="js-example-basic-single col-md-12" name="id-setor" data-placeholder="Escolha o Setor...">
                                        <option value="" label="default"></option>
                                        <?php 

                                        $setores = consultarSetoresLocal();
                                        ?>
                                        <?php while ($setor = mysqli_fetch_assoc($setores)) : ?>
                                            <?php if ($local['nome_setor'] == $setor['nome_setor'] ): ?>
                                                <option value="<?php echo $setor['id_setor']; ?>" selected><?php echo $setor['nome_setor']; ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $setor['id_setor']; ?>"><?php echo $setor['nome_setor']; ?></option>
                                            <?php endif; ?>
                                        <?php endwhile; ?>
                                    </select>
                                    <?php else: ?>
                                        
                                        <label>Setor</label>
                                        <input type="text" placeholder="<?php echo $local['nome_setor']; ?>" readonly="" class="form-control">
                                <?php endif ?>
					</div>

					<div class="form-group col-md-4 m-t-20">
						<label>Data Inicial</label>
						<input class="form-control" type="text" placeholder="<?php echo date('d/m/Y',strtotime($local['data_inicio_local'])); ?>" readonly="">
					</div>

					<div class="form-group col-md-4 m-t-20">
						<label>Data Final</label>
						<input class="form-control" type="text" placeholder="<?php echo isset($local['data_fim_local']) ? date('d/m/Y',strtotime($local['data_fim_local'])) : '-' ;  ?>" readonly="">
					</div>


					
					<div class="button-group col-12">
						<?php if (empty($local['data_fim_local'])): ?>
							<button type="submit" class="btn waves-effect waves-light btn-success">Transferir</button>
						<?php endif ?>
						<a href="?pagina=local/listar" class="btn waves-effect waves-light btn-danger">Cancelar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>