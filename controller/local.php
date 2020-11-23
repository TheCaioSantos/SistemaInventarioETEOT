<?php 

include_once '../model/local.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$id_local = isset($_GET['id-local']) ? trim($_GET['id-local']) : null;
	$validacao = validarLocal($_POST);
	if (count($validacao['erros']) == 0) {
		if ($id_local) {
			$gravou = transferirLocal($validacao['local'], $id_local);
		} else {
			$gravou = inserirLocal($validacao['local']);
		}

		if ($gravou) {
			if ($id_local) {
				header('Location: ../painel.php?pagina=local/atualizar&msg-local=3&id-local=' . $id_local);
			} else {
				header('Location: ../painel.php?pagina=local/cadastrar&msg-local=1');
			}
			exit();
		} else {
			if ($id_local) {
				header('Location: ../painel.php?pagina=local/atualizar&msg-local=4&id-local=' . $id_local);
			} else{
				header('Location: ../painel.php?pagina=local/cadastrar&msg-local=2');
			}
			exit();
		}
	} else {
		$parametros_erro = '';
		foreach ($validacao['erros'] as $i => $campo) {
			$parametros_erro .= '&erro' . $i . '=' . $campo;
		}

		if ($id_local) {
			header('Location: ../painel.php?pagina=local/atualizar' . $parametros_erro . '&id-local=' . $id_local);
		} else{
			header('Location: ../painel.php?pagina=local/cadastrar' . $parametros_erro);
		}
	}


} else {
	header('Location: ../painel.php?pagina=local/cadastrar');
	exit();
}
