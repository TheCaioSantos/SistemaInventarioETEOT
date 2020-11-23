<?php 
if (isset($_GET['pagina']) && $pagina = trim($_GET['pagina'])) {
	$filename = 'view/' . $pagina . '.php';
	//Verificando se a pagina chamada existe
	if (file_exists($filename)) {
		//verificação se o usuário está logado
		if (isset($_SESSION['id_usuario'])) {
			switch ($pagina) {
				case 'usuario/cadastrar':
				case 'usuario/atualizar':
				case 'usuario/detalhes':
					$nivel_usuario = array(1);
					break;
				case 'bem/cadastrar':
				case 'bem/atualizar':
				case 'setor/cadastrar':
				case 'setor/atualizar':
				case 'classificacao/cadastrar':
				case 'classificacao/atualizar':
				case 'local/cadastrar':
				case 'local/atualizar':
				case 'baixa/cadastrar':
				case 'baixa/atualizar':
				case 'baixa/detalhes':
					$nivel_usuario = array(1, 2);
					break;
				default:
					$nivel_usuario = array(1, 2, 3);
					break;
			}
			if (in_array($_SESSION['nivel_usuario'], $nivel_usuario)) {
				include_once $filename;
			} else {
				//Se não tiver nível necessário, o usuário é redirecionado para pagina '403.php'
				include_once 'view/erro/403.php';
			}
		} else {
			//Se não estiver logado, o usuário é redirecionado para pagina 'index.php'
			header('Location: index.php');
			exit();
		}
	} else {
		//Se o arquivo não existir, o usuário é redirecionado para pagina '404.php'
		include_once 'view/erro/404.php';
	}
} else {
	//Se nenhuma pagina for passada, o usuário é redirecionado para pagina 'inicio.php'
	include_once 'view/inicio.php';
}