<?php 
//Sempre que for utilizar '$_SESSION' é preciso iniciar a sessão
session_start();
//Chamando arquivo que tem a função de validar dados de login
include_once '../model/login.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//Chamando função que valida o dados de login
	$situacao = validarLogin($_POST);
	
	//Verfificando se o usuário está bloqueado
	if (isset($situacao['status_usuario']) && $situacao['status_usuario'] == 0) {
		header('Location: ../index.php?msg-login=3');
		exit();
	} elseif (is_array($situacao)) {
		$_SESSION['id_usuario'] = $situacao['id_usuario'];
		$_SESSION['nome_usuario'] = $situacao['nome_usuario'];
		$_SESSION['nivel_usuario'] = $situacao['nivel_usuario'];
		$_SESSION['sexo_usuario'] = $situacao['sexo_usuario'];
		$_SESSION['avatar_usuario'] = $situacao['avatar_usuario'];
		header('Location: ../painel.php');		
	} else {
		header('Location: ../index.php?msg-login=' . $situacao);
		exit();
	}
} else {
	header('Location: ../index.php');
	exit();
}