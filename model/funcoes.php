<?php 

function paginacao($tabela, $pagina, $quantidade_por_pagina){
	include 'model/conexao.php';

	$query = "SELECT * FROM $tabela";
	$query = mysqli_query($conexao, $query);
	
	$numero_total = mysqli_num_rows($query);
	$numero_paginas = ceil($numero_total / $quantidade_por_pagina);

	for ($i = 1; $i <= $numero_paginas ; $i++) { 
		echo '<li class="page-item"><a class="page-link" href="?pagina=' . $pagina . '&page=' . $i . '">' . $i . '</a></li>';
	}

}
