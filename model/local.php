<?php 

function validarLocal($dados) {
	$erros = array();

	$id_bem = isset($dados['id-bem']) && trim($dados['id-bem']) ? trim($dados['id-bem']) : null;	
	$id_setor = isset($dados['id-setor']) && trim($dados['id-setor']) ? trim($dados['id-setor']) : null;

	if (!$id_bem) {
		$erros[] = 'id-bem';
	}

	if (!$id_setor) {
		$erros[] = 'id-setor';
	}

	return array(
		'erros' => $erros,
		'local' => array(
			'id-bem' => $id_bem,
			'id-setor' => $id_setor,
		)
	);
}

function consultarLocal($id_local = null, $inicio = null, $quantidade_por_pagina = null){
	include_once 'model/conexao.php';

	$query = "SELECT * FROM local l 
	INNER JOIN bem b on b.id_bem = l.id_bem 
	INNER JOIN setor s on s.id_setor = l.id_setor";

	if ($id_local) {
		$query .= ' WHERE l.id_local = ' . $id_local;
	} else {
		$query .= " ORDER BY l.id_local DESC LIMIT $inicio, $quantidade_por_pagina";
	}
	
	return mysqli_query($conexao, $query);
}


function consultarBensLocal(){
	include 'model/conexao.php';
	$query = "SELECT * FROM bem WHERE id_bem NOT IN (SELECT id_bem FROM local) and situacao_bem = 1";

	return mysqli_query($conexao, $query);
}

function consultarSetoresLocal(){
	include 'model/conexao.php';
	$query = "SELECT * FROM setor";

	return mysqli_query($conexao, $query);
}

function inserirLocal($dados) {
	include_once '../model/conexao.php';

	$id_bem = $dados['id-bem'];	
	$id_setor = $dados['id-setor'];

	$query = "INSERT INTO local (data_inicio_local, id_setor, id_bem, status_local_local) 
	VALUES (now(), '$id_setor', '$id_bem', 1)";

	return mysqli_query($conexao, $query) or die (mysqli_error($conexao));
}


function transferirLocal($dados, $id_local){
	include_once '../model/conexao.php';

	$bem = $dados['id-bem'];	
	$setor = $dados['id-setor'];
	
	$query = "INSERT INTO local (data_inicio_local, id_setor, id_bem, status_local_local) 
	VALUES (now(), '$setor', '$bem', 1)";

	$query = mysqli_query($conexao, $query);


	$query = "UPDATE local SET data_fim_local = now(), status_local_local = 0 WHERE id_local = '$id_local'";

	return mysqli_query($conexao, $query);
}

function filtroSetorLocal($setor){
	include 'model/conexao.php';

	$query = "SELECT *,case(b.operacao_bem)
	when 1 then 'Compra'
	when 2 then 'Transferência'
	when 3 then 'Doação'
	end as 'nome_operacao', 
	case(b.situacao_bem) 
	when 1 then 'Ativo'
	when 2 then 'Processo de Baixa'
	when 3 then 'Morto'
	end as 'nome_situacao' FROM local l 
	INNER JOIN bem b on b.id_bem = l.id_bem 
	INNER JOIN setor s on s.id_setor = l.id_setor 
	WHERE s.id_setor = $setor and l.status_local_local = 1";

	return mysqli_query($conexao, $query);
}

function filtroInventarioLocal($inventario){
	include 'model/conexao.php';

	$query = "SELECT *,case(b.operacao_bem)
	when 1 then 'Compra'
	when 2 then 'Transferência'
	when 3 then 'Doação'
	end as 'nome_operacao', 
	case(b.situacao_bem) 
	when 1 then 'Ativo'
	when 2 then 'Processo de Baixa'
	when 3 then 'Morto'
	end as 'nome_situacao' FROM local l 
	INNER JOIN bem b on b.id_bem = l.id_bem 
	INNER JOIN setor s on s.id_setor = l.id_setor 
	WHERE b.numero_inventario_bem like '%$inventario%' ORDER BY l.data_inicio_local desc";

	return mysqli_query($conexao, $query);
}
