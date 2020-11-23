<?php 

function validarClassificacao($dados){
	$erros = array();

	//verificando se estar preenchido
	$numero_titulo_codigo_classificacao = isset($dados['numero-titulo-codigo-classificacao']) && trim($dados['numero-titulo-codigo-classificacao']) ? trim($dados['numero-titulo-codigo-classificacao']) : null;	
	$titulo_codigo_classificacao = isset($dados['titulo-codigo-classificacao']) && trim($dados['titulo-codigo-classificacao']) ? trim($dados['titulo-codigo-classificacao']) : null;
	$numero_subtitulo_codigo_classificacao = isset($dados['numero-subtitulo-codigo-classificacao']) && trim($dados['numero-subtitulo-codigo-classificacao']) ? trim($dados['numero-subtitulo-codigo-classificacao']) : null;
	$subtitulo_codigo_classificacao = isset($dados['subtitulo-codigo-classificacao']) && trim($dados['subtitulo-codigo-classificacao']) ? trim($dados['subtitulo-codigo-classificacao']) : null;

	if (!$numero_titulo_codigo_classificacao) {
		$erros[] = 'numero-titulo-codigo-classificacao';
	}

	if (!$titulo_codigo_classificacao) {
		$erros[] = 'titulo-codigo-classificacao';
	}

	if (!$numero_subtitulo_codigo_classificacao) {
		$erros[] = 'numero-subtitulo-codigo-classificacao';
	}

	if (!$subtitulo_codigo_classificacao) {
		$erros[] = 'subtitulo-codigo-classificacao';
	}

	return array(
	 	'erros' => $erros,
	 	'classificacao' => array(
	 		'numero-titulo-codigo-classificacao' => $numero_titulo_codigo_classificacao,
	 		'titulo-codigo-classificacao' => $titulo_codigo_classificacao,
	 		'numero-subtitulo-codigo-classificacao' => $numero_subtitulo_codigo_classificacao,
	 		'subtitulo-codigo-classificacao' => $subtitulo_codigo_classificacao,
	 	)
	 );
}

function inserirClassificacao($dados) {
	//Conexão com Banco de Dados
	include_once '../model/conexao.php';

	$numero_titulo_codigo_classificacao = $dados['numero-titulo-codigo-classificacao'];	
	$titulo_codigo_classificacao = $dados['titulo-codigo-classificacao'];
	$numero_subtitulo_codigo_classificacao = $dados['numero-subtitulo-codigo-classificacao'];
	$subtitulo_codigo_classificacao = $dados['subtitulo-codigo-classificacao'];

	$query = "INSERT INTO codigo_classificacao (numero_titulo_codigo_classificacao, titulo_codigo_classificacao, numero_subtitulo_codigo_classificacao, subtitulo_codigo_classificacao) 
	VALUES ('$numero_titulo_codigo_classificacao', '$titulo_codigo_classificacao', '$numero_subtitulo_codigo_classificacao', '$subtitulo_codigo_classificacao')";

	return mysqli_query($conexao, $query) or die (mysqli_error($conexao));
}

function consultarClassificacao($id_codigo_classificacao = null, $inicio = null, $quantidade_por_pagina = null) {
	//Conexão com Banco de Dados
	include_once 'model/conexao.php';
	$query = "SELECT * FROM codigo_classificacao cc";
	if ($id_codigo_classificacao) {
		$query .= ' WHERE cc.id_codigo_classificacao =' . $id_codigo_classificacao;
	}

	if (!$id_codigo_classificacao) {
		if ($inicio) {
			$query .= " ORDER BY cc.id_codigo_classificacao DESC LIMIT $inicio, $quantidade_por_pagina";
		} else {
			$query .= " ORDER BY cc.id_codigo_classificacao DESC LIMIT $quantidade_por_pagina";
		}
	}

	return mysqli_query($conexao, $query);
}


function filtroTituloBem($titulo) {
	include_once 'model/conexao.php';

	$query = "SELECT * FROM codigo_classificacao WHERE titulo_codigo_classificacao LIKE '%$titulo%'";

	return mysqli_query($conexao, $query);
}

function atualizarClassificacao($dados, $id_codigo_classificacao) {
	include '../model/conexao.php';

	$numero_titulo_codigo_classificacao = $dados['numero-titulo-codigo-classificacao'];	
	$titulo_codigo_classificacao = $dados['titulo-codigo-classificacao'];
	$numero_subtitulo_codigo_classificacao = $dados['numero-subtitulo-codigo-classificacao'];
	$subtitulo_codigo_classificacao = $dados['subtitulo-codigo-classificacao'];

	$query = "UPDATE codigo_classificacao SET numero_titulo_codigo_classificacao = '$numero_titulo_codigo_classificacao', titulo_codigo_classificacao = '$titulo_codigo_classificacao', numero_subtitulo_codigo_classificacao = '$numero_subtitulo_codigo_classificacao', subtitulo_codigo_classificacao = '$subtitulo_codigo_classificacao' WHERE id_codigo_classificacao = '$id_codigo_classificacao'";

	return mysqli_query($conexao, $query);
}
