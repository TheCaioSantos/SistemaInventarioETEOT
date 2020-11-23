<?php 

function RelatorioSetorLocal($setor){
	include '../model/conexao.php';

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
	WHERE s.id_setor = $setor and b.situacao_bem = 1 and l.status_local_local = 1";

	return mysqli_query($conexao, $query);
}
