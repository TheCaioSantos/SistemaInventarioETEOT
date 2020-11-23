<?php 

include_once '../model/bem.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$id_bem = isset($_GET['id-bem']) ? trim($_GET['id-bem']) : null;
	$operacao = isset($_GET['operacao']) ? trim($_GET['operacao']) : null;
	$validacao = validarBem($_POST);

	if (count($validacao['erros']) == 0) {
		if ($id_bem) {
			$gravou = atualizarBem($validacao['bem'], $id_bem);
		} else {
			$gravou = inserirBem($validacao['bem']);
		}

		if ($gravou) {
			if ($id_bem) {
				header('Location: ../painel.php?pagina=bem/atualizar&msg-bem=5&id-bem=' . $id_bem . '&operacao=' . $operacao);
			} else {
				header('Location: ../painel.php?pagina=bem/cadastrar&msg-bem=2');
			}
			exit();
		} else {
			if ($id_bem) {
				header('Location: ../painel.php?pagina=bem/atualizar&msg-bem=3&id-bem=' . $id_bem . '&operacao=' . $operacao);
			} else{
				header('Location: ../painel.php?pagina=bem/cadastrar&msg-bem=4');
			}
			exit();
		}
	} else {
		$parametros_erro = '';
		foreach ($validacao['erros'] as $i => $campo) {
			$parametros_erro .= '&erro' . $i . '=' . $campo;
		}

		if ($id_bem) {
			header('Location: ../painel.php?pagina=bem/atualizar' . $parametros_erro . '&id-bem=' . $id_bem . '&operacao=' . $operacao);
		} else{
			header('Location: ../painel.php?pagina=bem/cadastrar' . $parametros_erro);
		}
	}
} else {
	header('Location: ../painel.php?pagina=bem/cadastrar');
	exit();
}
