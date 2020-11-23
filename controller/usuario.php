<?php 
//Chamando arquivo que tem as funções de validar, consulta, editar, inserir
include_once '../model/usuario.php';

//Variável usada na parte de edição do usuario
$id_usuario = isset($_GET['id-usuario']) ? trim($_GET['id-usuario']) : null;

//perfil usuario
if (isset($_POST['perfil-id-usuario'])) {
	$id_usuario = $_POST['perfil-id-usuario'];
}


//Condicional usada para alterar o status do usuario Ativo/Bloqueado
if (isset($_GET['status-usuario'])) {
	$status_usuario = atualizarStatus($id_usuario, $_GET['status-usuario']);
	header('Location: ../painel.php?pagina=usuario/listar');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//Chamando função que valida os campos preenchidos
	//Essa função retorna os vetores 'erros' e 'usuario'
	$validacao = validarUsuario($_POST, $id_usuario);

	if (count($validacao['erros']) == 0) {
		if ($id_usuario) {
			$gravou = atualizarUsuario($validacao['dados'], $id_usuario);
		} else {
			$gravou = inserirUsuario($validacao['dados']);
		}
		if ($gravou) {
			if ($id_usuario) {
				if (isset($_POST['perfil-id-usuario'])) {
					header('Location: ../painel.php?pagina=usuario/perfil&msg-usuario=6');
				} else {
					header('Location: ../painel.php?pagina=usuario/atualizar&msg-usuario=6&id-usuario=' . $id_usuario);
				}
			} else {
				header('Location: ../painel.php?pagina=usuario/cadastrar&msg-usuario=3');
			}
			exit();
		} else {
			if ($id_usuario) {
				if (isset($_POST['perfil-id-usuario'])) {
					header('Location: ../painel.php?pagina=usuario/perfil&msg-usuario=5&id-usuario=' . $id_usuario);
				} else {
					header('Location: ../painel.php?pagina=usuario/atualizar&msg-usuario=5&id-usuario=' . $id_usuario);
				}
			} else{
				header('Location: ../painel.php?pagina=usuario/cadastrar&msg-usuario=4');
			}
			exit();
		}
	} else {
		//Passa por GET os erros na validação
		$parametrosErro = '';
		foreach ($validacao['erros'] as $i => $campo) {
			$parametrosErro .= '&erro' . $i . '=' . $campo;
		}

		if ($id_usuario) {
			if (isset($_POST['perfil-id-usuario'])) {
				header('Location: ../painel.php?pagina=usuario/perfil' . $parametrosErro);
			} else {
				header('Location: ../painel.php?pagina=usuario/atualizar' . $parametrosErro . '&id-usuario=' . $id_usuario);
			}
		} else{
			header('Location: ../painel.php?pagina=usuario/cadastrar' . $parametrosErro);
		}
		exit();
	}
} else {
	//Se o envio dos dados não for pelo método POST, o usuário é redirecionado para página de cadastro
	header('Location: ../painel.php?pagina=usuario/cadastrar');
	exit;
}