<?php 

function validarSetor($dados) {
	$erros = array();

	$nome_setor = isset($dados['nome-setor']) && trim($dados['nome-setor']) ? trim($dados['nome-setor']) : null;	
	$categoria_setor = isset($dados['categoria-setor']) && trim($dados['categoria-setor']) ? trim($dados['categoria-setor']) : null;

	if (!$nome_setor) {
		$erros[] = 'nome-setor';
	}

	if (!$categoria_setor) {
		$erros[] = 'categoria-setor';
	}

	//Retornando array 'erros' e 'setor'
	 return array(
	 	'erros' => $erros,
	 	'setor' => array(
	 		'nome-setor' => $nome_setor,
	 		'categoria-setor' => $categoria_setor,
	 	)
	 );
}

function inserirSetor($dados) {
	//Conexão com Banco de Dados
	include_once '../model/conexao.php';

	$nome_setor = $dados['nome-setor'];	
	$categoria_setor = $dados['categoria-setor'];

	//verificando se já tem algum setor cadastrado com o mesmo nome
	$query = "SELECT COUNT(*) as total FROM setor WHERE nome_setor = '$nome_setor'";

	$resultado = mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	$row = mysqli_fetch_assoc($resultado);

	//Se for encontrado algum setor com o mesmo nome cadastrado, redireciona para pagina de cadastro com um aviso
	if ($row['total'] == 1) {
		header('Location: ../painel.php?pagina=setor/cadastrar&msg-setor=1');
		exit();
	}

	$query = "INSERT INTO setor (nome_setor, categoria_setor) 
	VALUES ('$nome_setor', '$categoria_setor')";

	return mysqli_query($conexao, $query) or die (mysqli_error($conexao));

}

function consultarSetor($id_setor = null, $inicio = null, $quantidade_por_pagina = null){
	//Conexão com Banco de Dados
	include_once 'model/conexao.php';

	$query = "SELECT * FROM setor";

	if ($id_setor) {
		$query .= ' WHERE id_setor = ' . $id_setor;
	} else {
		if ($inicio) {
			$query .= " ORDER BY id_setor DESC LIMIT $inicio, $quantidade_por_pagina";
		} else {
			$query .= " ORDER BY id_setor DESC LIMIT $quantidade_por_pagina";
		}
	}

	return mysqli_query($conexao, $query);
}

function filtroCategoriaSetor($categoria) {
	include_once 'model/conexao.php';

	$query = "SELECT * FROM setor WHERE categoria_setor = '$categoria'";

	return mysqli_query($conexao, $query);
}

function atualizarSetor($dados, $id_setor) {
	include '../model/conexao.php';

	$nome_setor = $dados['nome-setor'];	
	$categoria_setor = $dados['categoria-setor'];

	//verificando se já tem alguem cadastrado com o mesmo email
	$query = "SELECT COUNT(*) as total FROM setor WHERE nome_setor = '$nome_setor'";

	$resultado = mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	$row = mysqli_fetch_assoc($resultado);

	//Se for encontrado algum setor com o mesmo nome cadastrado, redireciona para pagina de cadastro com um aviso
	if ($row['total'] == 1) {
		header('Location: ../painel.php?pagina=setor/cadastrar&msg-setor=1');
		exit();
	}

	$query = "UPDATE setor SET nome_setor = '$nome_setor', categoria_setor = '$categoria_setor' WHERE id_setor = '$id_setor'";

	return mysqli_query($conexao, $query);
}
