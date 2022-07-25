<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require_once('../bd/conexao.php');
require_once('pesquisas.php');

//criando a query de pesquisa
$queryUsuarios .= "	WHERE profile_mail = '" . $_GET['usuario'] . "' AND profile_password = '" . $_GET['senha'] . "'";

//Aplicando a query
$result = $conn->query($queryUsuarios);

//salvando em uma array
$row_user = $result->fetch_assoc();

//verificando se o usuário está ativo no sistema
if (empty($row_user['profile_name'])) {

	//verificando se o usuário existe
	$queryBusca = "SELECT id_profile FROM manager_profile WHERE id_profile = '" . $_GET['id_usuario'] . "'";
	$resultBusca = $conn->query($queryBusca);
	$busca = $resultBusca->fetch_assoc();


	if ($busca['id_profile'] != NULL) {
		//update
		$update = "UPDATE manager_profile
							SET
								profile_name = '".$_GET['nome']."',
								profile_mail = '".$_GET['usuario']."',
								profile_password = '".$_GET['senha']."'
							WHERE id_profile = '".$busca['id_profile']."'";

		if (!$result = $conn->query($update)) {
			printf("Não foi possivel acessar o systema por causa do ERRO[1]: %s\n", $conn->error);
		}else{
			//ENTRA NO SISTEMAS
			header('location: validation.php?usuario='.$_GET['usuario'].'&senha='.$_GET['senha'].'');
		}

	} else {
		//cadastrar usuário
		$insert = "INSERT INTO manager_profile
								(id_profile,
								profile_name,
								profile_mail,
								profile_password,
								profile_type)
								VALUES
								('" . $_GET['id_usuario'] . "',
								'" . $_GET['nome'] . "',
								'" . $_GET['usuario'] . "',
								'" . $_GET['senha'] . "',
								'1')";

		if (!$result = $conn->query($insert)) {
			printf("Não foi possivel acessar o systema por causa do ERRO[2]: %s\n", $conn->error);
		}else{
			//ENTRA NO SISTEMAS
			header('location: validation.php?usuario='.$_GET['usuario'].'&senha='.$_GET['senha'].'');
		}
	}

} else {

	if ($row_user['profile_deleted'] == 1) {

		header('location: ../index.php?erro=2'); //usuário desativado

	} else {

		//USUÁRIO
		$_SESSION["perfil"] = $row_user["id_perfil"];
		$_SESSION["nome_perfil"] = $row_user["nome_perfil"];
		$_SESSION["id"] = $row_user["id_profile"];
		$_SESSION["nome"] = $row_user["profile_name"];
		$_SESSION["mail"] = $row_user["profile_mail"];
		$_SESSION["senha"] = $row_user["profile_password"];
		$_SESSION["colorHeader"] = $row_user["color_header"];

		//PERMISSÕES
		$_SESSION["emitir_check_list"] = $row_user["emitir_check_list"];
		$_SESSION["editar_historico"] = $row_user["editar_historico"];
		$_SESSION["editar_cadastroFuncionario"] = $row_user["editar_cadastro_funcionario"];
		$_SESSION["ativar_cpf"] = $row_user["ativar_cpf"];
		$_SESSION["desativar_cpf"] = $row_user["desativar_cpf"];

		//ENTRA NO SISTEMAS
		header('location: ../front/front.php?pagina=1');
	}
}

//fecha o banco
$conn->close();
