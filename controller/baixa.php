<?php 

include_once '../model/baixa.php';

if (isset($_GET['morto']) && $_GET['morto'] == true) {
	morto($_GET['id-saida'], $_GET['id-bem']);
	header('Location: ../painel.php?pagina=baixa/listar');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$validacao = validarBaixa($_POST);
	if (count($validacao['erros']) == 0) {
		$gravou = inserirBaixa($validacao['baixa']);
		if ($gravou) {
			header('Location: ../painel.php?pagina=baixa/cadastrar&msg-baixa=1');
			exit();
		} else {
			header('Location: ../painel.php?pagina=baixa/cadastrar&msg-baixa=2');
			exit();
		}
	} else {
		$parametros_erro = '';
		foreach ($validacao['erros'] as $i => $campo) {
			$parametros_erro .= '&erro' . $i . '=' . $campo;
		}
		
		header('Location: ../painel.php?pagina=baixa/cadastrar' . $parametros_erro);
		exit();
	}
} else {
	header('Location: ../painel.php?pagina=baixa/cadastrar');
	exit();
}
