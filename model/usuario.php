<?php 
//Função que valida os campos de cadastro
function validarUsuario($dados, $id_usuario = null) {
	$erros = array();

	//Verificando se está preenchido
	$nome_usuario = isset($dados['nome-usuario']) && trim($dados['nome-usuario']) ? trim($dados['nome-usuario']) : null;
	$sobrenome_usuario = isset($dados['sobrenome-usuario']) && trim($dados['sobrenome-usuario']) ? trim($dados['sobrenome-usuario']) : null;
	$email_usuario = isset($dados['email-usuario']) && trim($dados['email-usuario']) ? trim($dados['email-usuario']) : null;
	$senha_usuario = isset($dados['senha-usuario']) && trim($dados['senha-usuario']) ? trim($dados['senha-usuario']) : null;
	$nivel_usuario = isset($dados['nivel-usuario']) && trim($dados['nivel-usuario']) ? trim($dados['nivel-usuario']) : null;
	$cpf_usuario = isset($dados['cpf-usuario']) && trim($dados['cpf-usuario']) ? trim($dados['cpf-usuario']) : null;
	$telefone_usuario = isset($dados['telefone-usuario']) && trim($dados['telefone-usuario']) ? trim($dados['telefone-usuario']) : null;
	$celular_usuario = isset($dados['celular-usuario']) && trim($dados['celular-usuario']) ? trim($dados['celular-usuario']) : null;
	$sexo_usuario = isset($dados['sexo-usuario']) && trim($dados['sexo-usuario']) ? trim($dados['sexo-usuario']) : null;
	
	if (!$nome_usuario) {
		$erros[] = 'nome-usuario';
	}

	if (!$sobrenome_usuario) {
		$erros[] = 'sobrenome-usuario';
	}

	if (!$email_usuario) {
		$erros[] = 'email-usuario';
	} elseif (!filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
		$erros[] = 'email-invalido-usuario';
	}

	if (!isset($id_usuario)) {
		if (!$senha_usuario) {
			$erros[] = 'senha-usuario';
		} elseif (strlen($senha_usuario) < 8) {
			$erros[] = 'senha-invalida-usuario';
		}
	}

	if (!$nivel_usuario) {
		$erros[] = 'nivel-usuario';
	} elseif ($nivel_usuario != 1 && $nivel_usuario != 2 && $nivel_usuario != 3) {
		$erros[] = 'nivel-invalido-usuario';
	}

	if (!$telefone_usuario) {
		$erros[] = 'telefone-usuario';
	} elseif ($telefone_usuario && strlen($telefone_usuario) != 14) {
		$erros[] = 'telefone-invalido-usuario';
	}

	if (!$celular_usuario) {
		$erros[] = 'celular-usuario';
	} elseif ($celular_usuario && strlen($celular_usuario) != 15) {
		$erros[] = 'celular-invalido-usuario';
	}

	if (!$cpf_usuario) {
		$erros[] = 'cpf-usuario';
	} elseif ($cpf_usuario && !validaCPF($cpf_usuario)){
		$erros[] = 'cpf-invalido-usuario';
	}

	if(!$sexo_usuario){
		$erros[] = 'sexo-usuario';
	} elseif ($sexo_usuario != 'M' && $sexo_usuario != 'F') {
		$erros[] = 'sexo-invalido-usuario';
	}

	//Retornando array 'erros' e 'dados'
	return array(
		'erros' => $erros,
		'dados' => array(
			'nome-usuario' => $nome_usuario,
			'sobrenome-usuario' => $sobrenome_usuario,
			'email-usuario' => $email_usuario,
			'senha-usuario' => $senha_usuario,
			'nivel-usuario' => $nivel_usuario,
			'cpf-usuario' => $cpf_usuario,
			'telefone-usuario' => $telefone_usuario,
			'celular-usuario' => $celular_usuario,
			'sexo-usuario' => $sexo_usuario,
		)
	);
}

//função que valida o CPF
function validaCPF($cpf = null) {

	// Verifica se um número foi informado
	if (empty($cpf)) {
		return false;
	}

	// Elimina possivel mascara
	$cpf = preg_replace("/[^0-9]/", "", $cpf);
	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

	// Verifica se o numero de digitos informados é igual a 11 
	if (strlen($cpf) != 11) {
		return false;
	}
	// Verifica se nenhuma das sequências invalidas abaixo 
	// foi digitada. Caso afirmativo, retorna falso
	else if ($cpf == '00000000000' ||
		$cpf == '11111111111' ||
		$cpf == '22222222222' ||
		$cpf == '33333333333' ||
		$cpf == '44444444444' ||
		$cpf == '55555555555' ||
		$cpf == '66666666666' ||
		$cpf == '77777777777' ||
		$cpf == '88888888888' ||
		$cpf == '99999999999') {
		return false;
    // Calcula os digitos verificadores para verificar se o
    // CPF é válido
	} else {

		for ($t = 9; $t < 11; $t++) {

			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf{$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf{$c} != $d) {
				return false;
			}
		}

		return true;
	}
}

function inserirUsuario($dados) {
	//Conexão com Banco de Dados
	include_once '../model/conexao.php';

	$nome_usuario = $dados['nome-usuario'];
	$sobrenome_usuario = $dados['sobrenome-usuario'];
	$email_usuario = $dados['email-usuario'];
	$senha_usuario = $dados['senha-usuario'];
	$nivel_usuario = $dados['nivel-usuario'];
	$cpf_usuario = $dados['cpf-usuario'];
	$telefone_usuario = $dados['telefone-usuario'];
	$celular_usuario = $dados['celular-usuario'];
	$sexo_usuario = $dados['sexo-usuario'];

	if ($sexo_usuario == 'M') {
		$avatar_usuario = 'avatar-masculino.png';
	} else {
		$avatar_usuario = 'avatar-feminino.png';
	}

	//Verificando se já tem alguém cadastrado com o mesmo email
	$query = "SELECT COUNT(*) as total FROM usuario WHERE email_usuario = '$email_usuario'";
	$resultado = mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	$row = mysqli_fetch_assoc($resultado);
	//Se for encontrado alguem com o mesmo email cadastrado, redireciona para pagina de cadastro com um aviso
	if ($row['total'] == 1) {
		header('Location: ../painel.php?pagina=usuario/cadastrar&msg-usuario=1');
		exit();
	}

	//verificando se já tem alguem cadastrado com o mesmo cpf
	$query = "SELECT COUNT(*) as total FROM usuario WHERE cpf_usuario = '$cpf_usuario'";
	$resultado = mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	$row = mysqli_fetch_assoc($resultado);
	//Se for encontrado alguem com o mesmo cpf cadastrado, redireciona para pagina de cadastro com um aviso
	if ($row['total'] == 1) {
		header('Location: ../painel.php?pagina=usuario/cadastrar&msg-usuario=2');
		exit();
	}

	$query = "INSERT INTO usuario (nome_usuario, sobrenome_usuario, email_usuario, senha_usuario, nivel_usuario, cpf_usuario, telefone_usuario, celular_usuario, sexo_usuario, status_usuario, data_cadastro_usuario, avatar_usuario)
	VALUES ('$nome_usuario', '$sobrenome_usuario', '$email_usuario', md5('$senha_usuario'), '$nivel_usuario', '$cpf_usuario', '$telefone_usuario', '$celular_usuario', '$sexo_usuario', '1', now(), '$avatar_usuario')";

	return mysqli_query($conexao, $query) or die (mysqli_error($conexao));

}

function consultarUsuario($id_usuario = null, $inicio = null, $quantidade_por_pagina = null) {
	//Conexão com Banco de Dados
	include_once 'model/conexao.php';

	$query = "SELECT *, case(nivel_usuario)
	when 1 then 'Administrador'
	when 2 then 'Funcionario'
	when 3 then 'Visitante'
	end as 'nome_nivel'
	 FROM usuario";

	if ($id_usuario) {
		$query .= " WHERE id_usuario = " . $id_usuario;
	} else {
		$query .= " ORDER BY id_usuario DESC LIMIT $inicio, $quantidade_por_pagina";
	}

	return mysqli_query($conexao, $query);
}


//função que altera o status do usuario
function atualizarStatus($id_usuario, $status_usuario) {
	session_start();

	// Caso o próprio usuário logado tente se bloquer, não será permitido
	if ($id_usuario == $_SESSION['id_usuario']) {
		header('Location: ../painel.php?pagina=usuario/listar&msg-usuario=7');
		exit();
	}

	//Conexão com Banco de Dados
	include '../model/conexao.php';

	//Criando query
	$query = "UPDATE usuario SET status_usuario = '$status_usuario' WHERE id_usuario = '$id_usuario'";

	//Executando a query e retornando o resultado
	return mysqli_query($conexao, $query);
}

function atualizarUsuario($dados, $id_usuario) {
	include_once '../model/conexao.php';

	//verificando se já tem alguem cadastrado com o mesmo email
	$email_usuario = $dados['email-usuario'];
	$query = "SELECT count(*) as total FROM usuario WHERE email_usuario = '$email_usuario' and id_usuario <> '$id_usuario'";

	$resultado = mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	$row = mysqli_fetch_assoc($resultado);

	//Se for encontrado alguem com o mesmo email cadastrado, redireciona para pagina de cadastro com um aviso
	if ($row['total'] == 1) {
		header('Location: ../painel.php?pagina=usuario/atualizar&msg-usuario=1&id-usuario=' . $id_usuario);
		exit();
	}

	//verificando se já tem alguem cadastrado com o mesmo cpf
	$cpf_usuario = $dados['cpf-usuario'];
	$query = "SELECT count(*) as total FROM usuario WHERE cpf_usuario = '$cpf_usuario' and id_usuario <> '$id_usuario'";

	$resultado = mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	$row = mysqli_fetch_assoc($resultado);
	
	//Se for encontrado alguem com o mesmo cpf cadastrado, redireciona para pagina de cadastro com um aviso
	if ($row['total'] == 1) {
		header('Location: ../painel.php?pagina=usuario/atualizar&msg-usuario=2&id-usuario=' . $id_usuario);
		exit();
	}

	$nome_usuario = $dados['nome-usuario'];
	$sobrenome_usuario = $dados['sobrenome-usuario'];
	$senha_usuario = $dados['senha-usuario'];
	$nivel_usuario = $dados['nivel-usuario'];
	$telefone_usuario = $dados['telefone-usuario'];
	$celular_usuario = $dados['celular-usuario'];
	$sexo_usuario = $dados['sexo-usuario'];

	$query = "UPDATE usuario SET 
	nome_usuario = '$nome_usuario', 
	sobrenome_usuario = '$sobrenome_usuario', 
	email_usuario = '$email_usuario', 
	nivel_usuario = '$nivel_usuario', 
	cpf_usuario = '$cpf_usuario', 
	telefone_usuario = '$telefone_usuario', 
	celular_usuario = '$celular_usuario', 
	sexo_usuario = '$sexo_usuario' 
	WHERE id_usuario = '$id_usuario'";

	return mysqli_query($conexao, $query) or die (mysqli_error($conexao));;
}

function validarSenha($dados){
	$erros = array();

	$senha_usuario = isset($dados['senha-usuario']) && trim($dados['senha-usuario']) ? trim($dados['senha-usuario']) : null;

	if (!$senha_usuario) {
		$erros[] = 'senha-usuario';
	} elseif (strlen($senha_usuario) < 8) {
		$erros[] = 'senha-invalida-usuario';
	}

	return array(
		'erros' => $erros,
		'dados' => array(
			'senha-usuario' => $senha_usuario,
		)
	);
}

function atualizarSenha($dados, $id_usuario){
	include '../model/conexao.php';

	$senha_usuario = $dados['senha-usuario'];

	$query = "UPDATE usuario SET senha_usuario = md5('$senha_usuario') WHERE id_usuario = '$id_usuario'";

	return mysqli_query($conexao, $query);
}

function consultarBensUsuariosDetalhes($id_usuario = null){
	include 'model/conexao.php';

	$query = "SELECT *, count(b.id_bem) as total FROM usuario u
	INNER JOIN bem b ON b.id_usuario = u.id_usuario  
	WHERE u.id_usuario = '$id_usuario'";
	
	$query = mysqli_query($conexao, $query);

	$query = mysqli_fetch_assoc($query);

	return $query['total'];
}
