<?php 
//Chamando arquivo que tem as funções de validar, consulta, editar, inserir
include_once '../model/usuario.php';

$id_usuario = $_SESSION['id_usuario'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$validacao = validarSenha($_POST);

	if (count($validacao['erros']) == 0) {
		$gravou = atualizarSenha($validacao['dados'], $id_usuario);

		if ($gravou) {
			include_once '../model/logout.php';
			header('Location: ../painel.php?pagina=usuario/senha-perfil&msg-usuario=6');
			exit();
		} else {
			header('Location: ../painel.php?pagina=usuario/senha-perfil&msg-usuario=5');
			exit();
		}
	} else {
		//Passa por GET os erros na validação
		$parametrosErro = '';
		foreach ($validacao['erros'] as $i => $campo) {
			$parametrosErro .= '&erro' . $i . '=' . $campo;
		}

		header('Location: ../painel.php?pagina=usuario/senha-perfil' . $parametrosErro);
		exit();
	}
} else {
	//Se o envio dos dados não for pelo método POST, o usuário é redirecionado para página de alterar senha
	header('Location: ../painel.php?pagina=usuario/senha-perfil');
	exit;
}