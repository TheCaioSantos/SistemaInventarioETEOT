<?php 
function consultarBensAtivo() {
	include 'model/conexao.php';

	$query = "SELECT * FROM bem WHERE situacao_bem = 1";
	return mysqli_query($conexao, $query);
}

function validarBaixa($dados) {
	$erros = array();

	$numero_processo_baixa = isset($dados['numero-processo-baixa']) && trim($dados['numero-processo-baixa']) ? trim($dados['numero-processo-baixa']) : null;	
	$data_processo_baixa = isset($dados['data-processo-baixa']) && trim($dados['data-processo-baixa']) ? trim($dados['data-processo-baixa']) : null;
	$motivo_baixa = isset($dados['motivo-baixa']) && trim($dados['motivo-baixa']) ? trim($dados['motivo-baixa']) : null;
	$id_bem_baixa = isset($dados['id-bem-baixa']) && trim($dados['id-bem-baixa']) ? trim($dados['id-bem-baixa']) : null;

	if (!$numero_processo_baixa) {
		$erros[] = 'numero-processo-baixa';
	}

	if (!$data_processo_baixa) {
		$erros[] = 'data-processo-baixa';
	}

	if (!$motivo_baixa) {
		$erros[] = 'motivo-baixa';
	}

	if (!$id_bem_baixa) {
		$erros[] = 'id-bem-baixa';
	}

	//Retornando array 'erros' e 'setor'
	 return array(
	 	'erros' => $erros,
	 	'baixa' => array(
	 		'numero-processo-baixa' => $numero_processo_baixa,
	 		'data-processo-baixa' => $data_processo_baixa,
	 		'motivo-baixa' => $motivo_baixa,
	 		'id-bem-baixa' => $id_bem_baixa,
	 	)
	 );
}

function inserirBaixa($dados) {
	session_start();

	include_once '../model/conexao.php';

	$numero_processo_baixa = $dados['numero-processo-baixa'];
	$data_processo_baixa = $dados['data-processo-baixa'];
	$motivo_baixa = $dados['motivo-baixa'];
	$id_bem_baixa = $dados['id-bem-baixa'];
	$id_usuario = $_SESSION['id_usuario'];

	$query = "UPDATE bem SET situacao_bem = '2' where id_bem = $id_bem_baixa";

	$query = mysqli_query($conexao, $query);

	$query = "INSERT INTO processo_baixa (numero_processo_baixa, data_processo_baixa) 
	VALUES ('$numero_processo_baixa', '$data_processo_baixa')";

	$query = mysqli_query($conexao, $query);

	$id_processo_de_baixa = mysqli_insert_id($conexao);

	$query = "INSERT INTO saida (motivo_saida, id_processo_baixa, id_bem, id_usuario) 
	VALUES ('$motivo_baixa', '$id_processo_de_baixa', '$id_bem_baixa', '$id_usuario')";

	return mysqli_query($conexao, $query);
}

function consultarBaixa($id_saida = null,$inicio = null, $quantidade_por_pagina = null) {
	//Conexão com Banco de Dados
	include_once 'model/conexao.php';

	$query = "SELECT s.*, p.*, b.*, u.nome_usuario FROM saida s 
	INNER JOIN processo_baixa p on s.id_processo_baixa = p.id_processo_baixa
	INNER JOIN bem b ON s.id_bem = b.id_bem
	INNER JOIN usuario u ON s.id_usuario = u.id_usuario";

	if ($id_saida) {
		$query .= " WHERE id_saida = " . $id_saida;
	} else {
		$query .= " ORDER BY s.id_saida DESC LIMIT $inicio, $quantidade_por_pagina";
	}

	return mysqli_query($conexao, $query);
}


function morto($id_saida, $id_bem) {
	//Conexão com Banco de Dados
	include_once '../model/conexao.php';

	$query = "UPDATE bem SET situacao_bem = '3' where id_bem = $id_bem";

	$query = mysqli_query($conexao, $query);

	$query = "UPDATE saida SET data_saida = now() where id_saida = $id_saida";

	return mysqli_query($conexao, $query);

}

function filtroNumeroProcessoBaixa($numero_processo_baixa) {
	//Conexão com Banco de Dados
	include_once 'model/conexao.php';

	$query = "SELECT s.*, p.*, b.*, u.nome_usuario FROM saida s 
	INNER JOIN processo_baixa p on s.id_processo_baixa = p.id_processo_baixa
	INNER JOIN bem b ON s.id_bem = b.id_bem
	INNER JOIN usuario u ON s.id_usuario = u.id_usuario WHERE p.numero_processo_baixa = $numero_processo_baixa";

	return mysqli_query($conexao, $query);
}
