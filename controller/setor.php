<?php 

include_once '../model/setor.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$id_setor = isset($_GET['id-setor']) ? trim($_GET['id-setor']) : null;
	$validacao = validarSetor($_POST);
	if (count($validacao['erros']) == 0) {
		if ($id_setor) {
			$gravou = atualizarSetor($validacao['setor'], $id_setor);
		} else {
			$gravou = inserirSetor($validacao['setor']);
		}

		if ($gravou) {
			if ($id_setor) {
				header('Location: ../painel.php?pagina=setor/atualizar&msg-setor=5&id-setor=' . $id_setor);
			} else {
				header('Location: ../painel.php?pagina=setor/cadastrar&msg-setor=2');
			}
			exit();
		} else {
			if ($id_setor) {
				header('Location: ../painel.php?pagina=setor/atualizar&msg-setor=3&id-setor=' . $id_setor);
			} else{
				header('Location: ../painel.php?pagina=setor/cadastrar&msg-setor=4');
			}
			exit();
		}
	} else {
		$parametros_erro = '';
		foreach ($validacao['erros'] as $i => $campo) {
			$parametros_erro .= '&erro' . $i . '=' . $campo;
		}

		if ($id_setor) {
			header('Location: ../painel.php?pagina=setor/atualizar' . $parametros_erro . '&id-setor=' . $id_setor);
		} else{
			header('Location: ../painel.php?pagina=setor/cadastrar' . $parametros_erro);
		}
	}


} else {
	header('Location: ../painel.php?pagina=setor/cadastrar');
	exit();
}