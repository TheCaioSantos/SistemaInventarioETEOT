<?php 

include_once '../model/classificacao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$id_codigo_classificacao = isset($_GET['id-codigo-classificacao']) ? trim($_GET['id-codigo-classificacao']) : null;
	$validacao = validarClassificacao($_POST);
	if (count($validacao['erros']) == 0) {
		if ($id_codigo_classificacao) {
			$gravou = atualizarClassificacao($validacao['classificacao'], $id_codigo_classificacao);
		} else {
			$gravou = inserirClassificacao($validacao['classificacao']);
		}

		if ($gravou) {
			if ($id_codigo_classificacao) {
				header('Location: ../painel.php?pagina=classificacao/atualizar&msg-classificacao=4&id-codigo-classificacao=' . $id_codigo_classificacao);
				
			}  else {
				header('Location: ../painel.php?pagina=classificacao/cadastrar&msg-classificacao=2');
			}
			exit();
		} else {
			if ($id_codigo_classificacao) {
				header('Location: ../painel.php?pagina=classificacao/atualizar&msg-classificacao=3&id-codigo-classificacao=' . $id_codigo_classificacao);
			} else{
				header('Location: ../painel.php?pagina=classificacao/cadastrar&msg-classificacao=1');
			}
			exit();
		}
	} else {
		$parametros_erro = '';
		foreach ($validacao['erros'] as $i => $campo) {
			$parametros_erro .= '&erro' . $i . '=' . $campo;
		}

		if ($id_codigo_classificacao) {
			header('Location: ../painel.php?pagina=classificacao/atualizar' . $parametros_erro . '&id-codigo-classificacao=' . $id_codigo_classificacao);
		} else{
			header('Location: ../painel.php?pagina=classificacao/cadastrar' . $parametros_erro);
		}
	}


} else {
	header('Location: ../painel.php?pagina=classificacao/cadastrar');
	exit();
}



