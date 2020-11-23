<?php 
//Função que valida o dados de login
function validarLogin($dados) {
	$email_login = isset($dados['email-login']) && trim($dados['email-login']) ? trim($dados['email-login']) : null;
	$senha_login = isset($dados['senha-login']) && trim($dados['senha-login']) ? trim($dados['senha-login']) : null;

	if ($email_login && $senha_login) {
		//Conexao com Banco de Dados
		include_once '../model/conexao.php';

		//A função mysqli_real_escape_string, protege contra ataques de SQL Injection
		$email_login = mysqli_real_escape_string($conexao, $email_login);
		$senha_login = mysqli_real_escape_string($conexao, $senha_login);

		//Criando query
		$query = "SELECT * FROM usuario WHERE email_usuario = '$email_login' and senha_usuario = md5('$senha_login')";

		//Executando a query
		$resultado = mysqli_query($conexao, $query) or die (mysqli_error($conexao));

		if (mysqli_num_rows($resultado) == 1) {
			return mysqli_fetch_assoc($resultado);
		} else {
			return '2';
		}
	} else {
		return '1';
	}
}
