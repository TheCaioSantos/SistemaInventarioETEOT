<?php 

function consultarTituloCodigoDeClassificacao(){
	require 'model/conexao.php';

	$query = "SELECT * FROM codigo_classificacao GROUP BY numero_titulo_codigo_classificacao ORDER BY titulo_codigo_classificacao asc";

	return mysqli_query($conexao, $query);
}

function consultarSubtituloCodigoDeClassificacao($cod){

    require_once '../model/conexao.php';

    $query = "SELECT * FROM codigo_classificacao WHERE numero_titulo_codigo_classificacao = '" . $cod . "'";
    $cod_class = mysqli_query($conexao, $query);
    $todos = mysqli_fetch_all($cod_class);

    return $todos;
}

function consultarSubtituloCodigoDeClassificacaoEditar($cod){

    require 'model/conexao.php';

    $query = "SELECT * FROM codigo_classificacao WHERE numero_titulo_codigo_classificacao = '" . $cod . "'";

    return mysqli_query($conexao, $query);
}

function validarBem($dados) {
	$erros = array();

	$id_codigo_classificacao = isset($dados['subtitulo-codigo-classificacao']) && trim($dados['subtitulo-codigo-classificacao']) ? trim($dados['subtitulo-codigo-classificacao']) : null;
	$numero_inventario_bem = isset($dados['numero-inventario-bem']) && trim($dados['numero-inventario-bem']) ? trim($dados['numero-inventario-bem']) : null;
	$identificacao_bem = isset($dados['identificacao-bem']) && trim($dados['identificacao-bem']) ? trim($dados['identificacao-bem']) : null;
	$operacao_bem = isset($dados['operacao-bem']) && trim($dados['operacao-bem']) ? trim($dados['operacao-bem']) : null;
	$conservacao_historico = isset($dados['conservacao-historico']) && trim($dados['conservacao-historico']) ? trim($dados['conservacao-historico']) : null;
	$historico_bem_historico = isset($dados['historico-bem-historico']) && trim($dados['historico-bem-historico']) ? trim($dados['historico-bem-historico']) : null;
	$historico_operacao_historico = isset($dados['historico-operacao-historico']) && trim($dados['historico-operacao-historico']) ? trim($dados['historico-operacao-historico']) : null;
	$observacao_bem = isset($dados['observacao-bem']) && trim($dados['observacao-bem']) ? trim($dados['observacao-bem']) : null;
	$valor_entrada = isset($dados['valor-entrada']) && trim($dados['valor-entrada']) ? trim($dados['valor-entrada']) : null;
	$valor_transferencia = isset($dados['valor-transferencia']) && trim($dados['valor-transferencia']) ? trim($dados['valor-transferencia']) : null;
	$valor_doacao = isset($dados['valor-doacao']) && trim($dados['valor-doacao']) ? trim($dados['valor-doacao']) : null;
	$nome_instituicao = isset($dados['nome-instituicao']) && trim($dados['nome-instituicao']) ? trim($dados['nome-instituicao']) : null;
	$numero_recibo = isset($dados['numero-recibo']) && trim($dados['numero-recibo']) ? trim($dados['numero-recibo']) : null;
	$data_recibo = isset($dados['data-recibo']) && trim($dados['data-recibo']) ? trim($dados['data-recibo']) : null;
	$data_transferencia = isset($dados['data-entrada-transferencia']) && trim($dados['data-entrada-transferencia']) ? trim($dados['data-entrada-transferencia']) : null;
	$data_doacao = isset($dados['data-doacao']) && trim($dados['data-doacao']) ? trim($dados['data-doacao']) : null;
	$telefone_instituicao = isset($dados['telefone-instituicao']) && trim($dados['telefone-instituicao']) ? trim($dados['telefone-instituicao']) : null;
	$cnpj_instituicao = isset($dados['cnpj-instituicao']) && trim($dados['cnpj-instituicao']) ? trim($dados['cnpj-instituicao']) : null;

	if (!$id_codigo_classificacao) {
		$erros[] = 'id-codigo-classificacao';
	}

	if (!$numero_inventario_bem) {
		$erros[] = 'numero-inventario-bem';
	}

	if (!$identificacao_bem) {
		$erros[] = 'identificacao-bem';
	}

	if (!$operacao_bem) {
		$erros[] = 'operacao-bem';
	}

	return array(
	 	'erros' => $erros,
	 	'bem' => array(
	 		'id-codigo-classificacao' => $id_codigo_classificacao,
	 		'numero-inventario-bem' => $numero_inventario_bem,
	 		'identificacao-bem' => $identificacao_bem,
	 		'operacao-bem' => $operacao_bem,
	 		'conservacao-historico' => $conservacao_historico,
	 		'historico-bem-historico' => $historico_bem_historico,
	 		'historico-operacao-historico' => $historico_operacao_historico,
	 		'observacao-bem' => $observacao_bem,
	 		'valor-entrada' => $valor_entrada,
	 		'valor-transferencia' => $valor_transferencia,
	 		'valor-doacao' => $valor_doacao,
	 		'nome-instituicao' => $nome_instituicao,
	 		'numero-recibo' => $numero_recibo,
	 		'data-recibo' => $data_recibo,
	 		'data-transferencia' => $data_transferencia,
	 		'data-doacao' => $data_doacao,
	 		'telefone-instituicao' => $telefone_instituicao,
	 		'cnpj-instituicao' => $cnpj_instituicao,
	 	)
	 );


}


function inserirBem($dados) {
	session_start();

	include_once '../model/conexao.php';

	$id_codigo_classificacao = $dados['id-codigo-classificacao'];
	$numero_inventario_bem = $dados['numero-inventario-bem'];
	$identificacao_bem = $dados['identificacao-bem'];
	$operacao_bem = $dados['operacao-bem'];
	$conservacao_historico = $dados['conservacao-historico'];
	$historico_bem_historico = $dados['historico-bem-historico'];
	$historico_operacao_historico = $dados['historico-operacao-historico'];
	$observacao_bem = $dados['observacao-bem'];
	$valor_entrada = $dados['valor-entrada'];
	$valor_transferencia = $dados['valor-transferencia'];
	$valor_doacao = $dados['valor-doacao'];
	$nome_instituicao = $dados['nome-instituicao'];
	$numero_recibo = $dados['numero-recibo'];
	$data_recibo = $dados['data-recibo'];
	$data_transferencia = $dados['data-transferencia'];
	$data_doacao = $dados['data-doacao'];
	$telefone_instituicao = $dados['telefone-instituicao'];
	$cnpj_instituicao = $dados['cnpj-instituicao'];
	$id_usuario = $_SESSION['id_usuario'];

	$query = "SELECT count(*) as total from bem WHERE numero_inventario_bem = '$numero_inventario_bem'";

	$resultado = mysqli_query($conexao, $query);
	$row = mysqli_fetch_assoc($resultado);

	//Se for encontrado algum bem com o mesmo numero cadastrado, redireciona para página de cadastro com um aviso
	if ($row['total'] == 1) {
		header('Location: ../painel.php?pagina=bem/cadastrar&msg-bem=1');
		exit();
	}

	$query = "INSERT INTO historico (historico_bem_historico, conservacao_historico, historico_operacao_historico) 
	VALUES ('$historico_bem_historico', '$conservacao_historico', '$historico_operacao_historico')"; 

	$query = mysqli_query($conexao, $query);

	$id_historico = mysqli_insert_id($conexao);

	//Por padrão todos os bens serão cadastrados como ativos
	$query = "INSERT INTO bem (numero_inventario_bem, identificacao_bem, operacao_bem, situacao_bem, observacao_bem, data_cadastro_bem, id_usuario, id_historico, id_codigo_classificacao) 
	VALUES ('$numero_inventario_bem', '$identificacao_bem', '$operacao_bem', '1', '$observacao_bem', now(), '$id_usuario', '$id_historico', '$id_codigo_classificacao')";


	$query = mysqli_query($conexao, $query);

	$id_bem = mysqli_insert_id($conexao);

	if ($operacao_bem == 1) {
		$query = "INSERT INTO recibo (numero_recibo, data_recibo)
		VALUES ('$numero_recibo', '$data_recibo')";

		$query = mysqli_query($conexao, $query);

		$id_recibo = mysqli_insert_id($conexao);

		// Quantidade sempre será '1', já que cada bem possui um número de inventário próprio
		$query = "INSERT INTO entrada (quantidade_compra_entrada, valor_entrada, id_bem, id_recibo)
		VALUES ('1', '$valor_entrada', '$id_bem', '$id_recibo')";

		$query = mysqli_query($conexao, $query);

	} elseif ($operacao_bem == 2) {
		$query = "INSERT INTO instituicao (nome_instituicao, telefone_instituicao, cnpj_instituicao)
		VALUES ('$nome_instituicao' , '$telefone_instituicao',  '$cnpj_instituicao')";

		$query = mysqli_query($conexao, $query);

		$id_instituicao = mysqli_insert_id($conexao);

		$query = "INSERT INTO transferencia (valor_transferencia, data_entrada_transferencia, id_instituicao, id_bem)
		VALUES ('$valor_transferencia', '$data_transferencia', '$id_instituicao', '$id_bem')";

		$query = mysqli_query($conexao, $query);

	} elseif ($operacao_bem == 3) {
		$query = "INSERT INTO instituicao (nome_instituicao, telefone_instituicao, cnpj_instituicao)
		VALUES ('$nome_instituicao' , '$telefone_instituicao',  '$cnpj_instituicao')";

		$query = mysqli_query($conexao, $query);

		$id_instituicao = mysqli_insert_id($conexao);

		$query = "INSERT INTO doacao (valor_doacao, data_entrada_doacao, id_bem, id_instituicao)
		VALUES ('$valor_doacao', '$data_doacao', '$id_bem', '$id_instituicao')";

		$query = mysqli_query($conexao, $query);

	}

	$query = "SELECT quantidade_codigo_classificacao FROM codigo_classificacao WHERE id_codigo_classificacao = '$id_codigo_classificacao'";
	$query = mysqli_query($conexao, $query);
	$query = mysqli_fetch_assoc($query);

	if ($query['quantidade_codigo_classificacao'] == null) {
		$quantidade = 0;
	} else {
		$quantidade = $query['quantidade_codigo_classificacao'];
	}

	$quantidade += 1;

	$query = "UPDATE codigo_classificacao SET quantidade_codigo_classificacao = '$quantidade' WHERE id_codigo_classificacao = '$id_codigo_classificacao'";

	return mysqli_query($conexao, $query);
}



function consultarBem($id_bem = null, $inicio = null, $quantidade_por_pagina = null) {
	//Conexão com Banco de Dados
	include_once 'model/conexao.php';

	$query = "SELECT b.*,case(b.operacao_bem)
	when 1 then 'Compra'
	when 2 then 'Transferência'
	when 3 then 'Doação'
	end as 'nome_operacao', 
	case(b.situacao_bem) 
	when 1 then 'Ativo'
	when 2 then 'Processo de Baixa'
	when 3 then 'Morto'
	end as 'nome_situacao',
	 u.nome_usuario, cc.*, h.* FROM bem b
	INNER JOIN usuario u on b.id_usuario = u.id_usuario 
	INNER JOIN codigo_classificacao cc on b.id_codigo_classificacao = cc.id_codigo_classificacao
	INNER JOIN historico h on b.id_historico = h.id_historico";

	if ($id_bem) {
		$query .= " WHERE b.id_bem = '$id_bem'";
	} else {
		if ($inicio) {
			$query .= " ORDER BY b.id_bem DESC LIMIT $inicio, $quantidade_por_pagina";
		} else {
			$query .= " ORDER BY b.id_bem DESC LIMIT $quantidade_por_pagina";
		}
	}
	
	return mysqli_query($conexao, $query);
}


function filtroIdentificacaoBem($identificacao) {
	include_once 'model/conexao.php';

	$query = "SELECT *,case(b.operacao_bem)
	when 1 then 'Compra'
	when 2 then 'Transferência'
	when 3 then 'Doação'
	end as 'nome_operacao', 
	case(b.situacao_bem) 
	when 1 then 'Ativo'
	when 2 then 'Processo de Baixa'
	when 3 then 'Morto'
	end as 'nome_situacao' 
	FROM bem b
	INNER JOIN usuario u on b.id_usuario = u.id_usuario 
	WHERE b.identificacao_bem LIKE '%$identificacao%'";

	return mysqli_query($conexao, $query);
}

function filtroSituacaoBem($situacao) {
	include_once 'model/conexao.php';

	$query = "SELECT *,case(b.operacao_bem)
	when 1 then 'Compra'
	when 2 then 'Transferência'
	when 3 then 'Doação'
	end as 'nome_operacao', 
	case(b.situacao_bem) 
	when 1 then 'Ativo'
	when 2 then 'Processo de Baixa'
	when 3 then 'Morto'
	end as 'nome_situacao' 
	FROM bem b
	INNER JOIN usuario u on b.id_usuario = u.id_usuario 
	WHERE b.situacao_bem = $situacao";

	return mysqli_query($conexao, $query);
}

function filtroOperacaoBem($operacao) {
	include_once 'model/conexao.php';

	$query = "SELECT *,case(b.operacao_bem)
	when 1 then 'Compra'
	when 2 then 'Transferência'
	when 3 then 'Doação'
	end as 'nome_operacao', 
	case(b.situacao_bem) 
	when 1 then 'Ativo'
	when 2 then 'Processo de Baixa'
	when 3 then 'Morto'
	end as 'nome_situacao' 
	FROM bem b
	INNER JOIN usuario u on b.id_usuario = u.id_usuario 
	WHERE b.operacao_bem = $operacao";

	return mysqli_query($conexao, $query);
}

function consultarBemCompra($id_bem = null) {
	include_once 'model/conexao.php';

	$query = "SELECT b.*,case(b.operacao_bem)
	when 1 then 'Compra'
	when 2 then 'Transferência'
	when 3 then 'Doação'
	end as 'nome_operacao', 
	case(b.situacao_bem) 
	when 1 then 'Ativo'
	when 2 then 'Processo de Baixa'
	when 3 then 'Morto'
	end as 'nome_situacao',
	u.nome_usuario, r.*, cc.*, h.*, e.* FROM bem b
	INNER JOIN usuario u on b.id_usuario = u.id_usuario 
	INNER JOIN entrada e on b.id_bem = e.id_bem
	INNER JOIN recibo r on e.id_recibo = r.id_recibo
	INNER JOIN codigo_classificacao cc on b.id_codigo_classificacao = cc.id_codigo_classificacao
	INNER JOIN historico h on b.id_historico = h.id_historico
";
	// $query = "SELECT * FROM bem";
	if ($id_bem) {

		$query .= " WHERE b.id_bem = '$id_bem'";
	}
	return mysqli_query($conexao, $query);
}

function consultarBemDoacao($id_bem = null) {
	include_once 'model/conexao.php';

	$query = "SELECT b.*,case(b.operacao_bem)
	when 1 then 'Compra'
	when 2 then 'Transferência'
	when 3 then 'Doação'
	end as 'nome_operacao', 
	case(b.situacao_bem) 
	when 1 then 'Ativo'
	when 2 then 'Processo de Baixa'
	when 3 then 'Morto'
	end as 'nome_situacao',
	u.nome_usuario, cc.*, h.*, d.*, i.* FROM bem b
	INNER JOIN usuario u on b.id_usuario = u.id_usuario 
	INNER JOIN codigo_classificacao cc on b.id_codigo_classificacao = cc.id_codigo_classificacao
	INNER JOIN historico h on b.id_historico = h.id_historico
	INNER JOIN doacao d on b.id_bem = d.id_bem
	INNER JOIN instituicao i on d.id_instituicao = i.id_instituicao";
	// $query = "SELECT * FROM bem";
	if ($id_bem) {

		$query .= " WHERE b.id_bem = '$id_bem'";
	}
	return mysqli_query($conexao, $query);
}

function consultarBemTransferencia($id_bem = null) {
	include_once 'model/conexao.php';

	$query = "SELECT b.*,case(b.operacao_bem)
	when 1 then 'Compra'
	when 2 then 'Transferência'
	when 3 then 'Doação'
	end as 'nome_operacao', 
	case(b.situacao_bem) 
	when 1 then 'Ativo'
	when 2 then 'Processo de Baixa'
	when 3 then 'Morto'
	end as 'nome_situacao',
	u.nome_usuario, cc.*, h.*, t.*, i.* FROM bem b
	INNER JOIN usuario u on b.id_usuario = u.id_usuario 
	INNER JOIN codigo_classificacao cc on b.id_codigo_classificacao = cc.id_codigo_classificacao
	INNER JOIN historico h on b.id_historico = h.id_historico
	INNER JOIN transferencia t on b.id_bem = t.id_bem
	INNER JOIN instituicao i on t.id_instituicao = i.id_instituicao";
	// $query = "SELECT * FROM bem";
	if ($id_bem) {

		$query .= " WHERE b.id_bem = '$id_bem'";
	}
	return mysqli_query($conexao, $query);
}



function atualizarBem($dados, $id_bem) {
	session_start();

	include_once '../model/conexao.php';

	$id_codigo_classificacao = $dados['id-codigo-classificacao'];
	$numero_inventario_bem = $dados['numero-inventario-bem'];
	$identificacao_bem = $dados['identificacao-bem'];
	$operacao_bem = $dados['operacao-bem'];
	$conservacao_historico = $dados['conservacao-historico'];
	$historico_bem_historico = $dados['historico-bem-historico'];
	$historico_operacao_historico = $dados['historico-operacao-historico'];
	$observacao_bem = $dados['observacao-bem'];
	$valor_entrada = $dados['valor-entrada'];
	$valor_transferencia = $dados['valor-transferencia'];
	$valor_doacao = $dados['valor-doacao'];
	$nome_instituicao = $dados['nome-instituicao'];
	$numero_recibo = $dados['numero-recibo'];
	$data_recibo = $dados['data-recibo'];
	$data_transferencia = $dados['data-transferencia'];
	$data_doacao = $dados['data-doacao'];
	$telefone_instituicao = $dados['telefone-instituicao'];
	$cnpj_instituicao = $dados['cnpj-instituicao'];
	$id_usuario = $_SESSION['id_usuario'];


	$query = "SELECT COUNT(*) as total FROM bem WHERE numero_inventario_bem = '$numero_inventario_bem' and id_bem <> '$id_bem'";

	$resultado = mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	$row = mysqli_fetch_assoc($resultado);

	//Se for encontrado algum bem com o mesmo nr cadastrado, redireciona para pagina de cadastro com um aviso
	if ($row['total'] == 1) {
		header('Location: ../painel.php?pagina=bem/atualizar&msg-bem=1&id_bem=' . $id_bem . '&operacao=' . $operacao_bem);
		exit();
	}


	$query = "UPDATE historico h
	INNER JOIN bem b on b.id_historico = h.id_historico
	SET historico_bem_historico = '$historico_bem_historico', conservacao_historico = '$conservacao_historico', historico_operacao_historico = '$historico_operacao_historico'
	WHERE b.id_bem = '$id_bem'";

	$query = mysqli_query($conexao, $query) or die (mysqli_error($conexao));

	$query = "UPDATE bem SET numero_inventario_bem = '$numero_inventario_bem', identificacao_bem = '$identificacao_bem', operacao_bem = '$operacao_bem', observacao_bem = '$observacao_bem' WHERE id_bem = '$id_bem'";

	$query = mysqli_query($conexao, $query) or die (mysqli_error($conexao));


	if ($operacao_bem == 1) {
		$query = "UPDATE recibo r 
		INNER JOIN entrada e on e.id_recibo = r.id_recibo 
		INNER JOIN bem b on b.id_bem = e.id_bem 
		SET numero_recibo = '$numero_recibo', data_recibo = '$data_recibo'
		WHERE b.id_bem = '$id_bem'";

		$query = mysqli_query($conexao, $query) or die (mysqli_error($conexao));

		$query = "SELECT * FROM recibo r 
		INNER JOIN entrada e on e.id_recibo = r.id_recibo 
		INNER JOIN bem b on b.id_bem = e.id_bem 
		WHERE b.id_bem = '$id_bem'";

		$query = mysqli_query($conexao, $query);

		$query = mysqli_fetch_assoc($query);

		$id_recibo = $query['id_recibo'];

		$query = "UPDATE entrada SET valor_entrada = '$valor_entrada', id_bem = '$id_bem', id_recibo = '$id_recibo'";

		return mysqli_query($conexao, $query) or die (mysqli_error($conexao));

	} elseif ($operacao_bem == 2) {
		$query = "UPDATE instituicao i 
		INNER JOIN transferencia t on t.id_instituicao = i.id_instituicao
		INNER JOIN bem b on b.id_bem = t.id_bem
		SET nome_instituicao = '$nome_instituicao', telefone_instituicao = '$telefone_instituicao', cnpj_instituicao = '$cnpj_instituicao'
		WHERE b.id_bem = '$id_bem'";

		$query = mysqli_query($conexao, $query) or die (mysqli_error($conexao));

		$query = "SELECT * FROM instituicao i 
		INNER JOIN transferencia t on t.id_instituicao = i.id_instituicao 
		INNER JOIN bem b on b.id_bem = t.id_bem 
		WHERE b.id_bem = '$id_bem'";

		$query = mysqli_query($conexao, $query) or die (mysqli_error($conexao));

		$query = mysqli_fetch_assoc($query);

		$id_instituicao = $query['id_instituicao'];

		$query = "UPDATE transferencia SET valor_transferencia = '$valor_transferencia', data_entrada_transferencia = '$data_transferencia', id_instituicao = '$id_instituicao', id_bem = $id_bem";

		return mysqli_query($conexao, $query) or die (mysqli_error($conexao));

	} elseif ($operacao_bem == 3) {

		$query = "UPDATE instituicao i 
		INNER JOIN doacao d on d.id_instituicao = i.id_instituicao 
		INNER JOIN bem b on b.id_bem = d.id_bem 
		SET nome_instituicao = '$nome_instituicao', telefone_instituicao = '$telefone_instituicao', cnpj_instituicao = '$cnpj_instituicao'
		WHERE b.id_bem = '$id_bem'";

		$query = mysqli_query($conexao, $query) or die (mysqli_error($conexao));

		$query = "SELECT * FROM instituicao i 
		INNER JOIN doacao d on d.id_instituicao = i.id_instituicao 
		INNER JOIN bem b on b.id_bem = d.id_bem 
		WHERE b.id_bem = '$id_bem'";

		$query = mysqli_query($conexao, $query) or die (mysqli_error($conexao));

		$query = mysqli_fetch_assoc($query);

		$id_instituicao = $query['id_instituicao'];

		$query = "UPDATE doacao SET valor_doacao = '$valor_doacao', data_entrada_doacao = '$data_doacao', id_bem = '$id_bem', id_instituicao = '$id_instituicao'";

		return mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	}
}

function consultarBensUltimos()
{
	include 'model/conexao.php';

	$query = "SELECT b.*,case(b.operacao_bem)
	when 1 then 'Compra'
	when 2 then 'Transferência'
	when 3 then 'Doação'
	end as 'nome_operacao', 
	case(b.situacao_bem) 
	when 1 then 'Ativo'
	when 2 then 'Processo de Baixa'
	when 3 then 'Morto'
	end as 'nome_situacao',
	u.nome_usuario, cc.*, h.* FROM bem b, usuario u, codigo_classificacao cc, historico h
	WHERE b.id_usuario = u.id_usuario 
	AND b.id_codigo_classificacao = cc.id_codigo_classificacao
	AND b.id_historico = h.id_historico
	ORDER BY data_cadastro_bem DESC LIMIT 5";
	
	return mysqli_query($conexao, $query);
}

function consultarBensUsuarios(){
	include 'model/conexao.php';

	$query = "SELECT *, count(b.id_bem) as total, case(nivel_usuario)
	when 1 then 'Administrador'
	when 2 then 'Funcionario'
	when 3 then 'Visitante'
	end as 'nome_nivel'
	FROM usuario u
	INNER JOIN bem b ON b.id_usuario = u.id_usuario 
	group by nome_usuario 
	order by total desc
	limit 5";
	
	return mysqli_query($conexao, $query);
}

function consultarBensSituacao() {
	include_once 'model/conexao.php';

	$situacao = array();

	$query = "SELECT COUNT(*) AS total FROM bem";
	$query = mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	$query = mysqli_fetch_assoc($query);
	$situacao[] = $query['total'];

	$query = "SELECT COUNT(*) AS ativo FROM bem WHERE situacao_bem = 1";
	$query = mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	$query = mysqli_fetch_assoc($query);
	$situacao[] = $query['ativo'];

	$query = "SELECT COUNT(*) AS baixa FROM bem WHERE situacao_bem = 2";
	$query = mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	$query = mysqli_fetch_assoc($query);
	$situacao[] = $query['baixa'];

	$query = "SELECT COUNT(*) AS morto FROM bem WHERE situacao_bem = 3";
	$query = mysqli_query($conexao, $query) or die (mysqli_error($conexao));
	$query = mysqli_fetch_assoc($query);
	$situacao[] = $query['morto'];

	return $situacao;
}
