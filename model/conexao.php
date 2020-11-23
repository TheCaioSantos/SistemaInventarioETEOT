<?php 

$conexao = mysqli_connect('localhost', 'root', '', 'sistemaeteot') or die (mysql_error("Erro: "));

mysqli_query($conexao, "SET NAMES 'utf8'");
mysqli_query($conexao, 'SET character_set_connection=utf8');
mysqli_query($conexao, 'SET character_set_client=utf8');
mysqli_query($conexao, 'SET character_set_results=utf8');
