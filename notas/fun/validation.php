<?php
session_start();
require_once('../conf/conexao.php');

$cpf = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_GET['cpf'])));
$nome = $_GET["nome"];

if (!isset($_GET["email"])) {
	$email = $_GET["usuario"];
}else{
	$email = $_GET["email"];
}

$senha = $_GET["senha"];

$queryUser = "SELECT * FROM cad_login WHERE CPF = '$cpf';";
$resultCheck = $conn->query($queryUser);
$rowCheck = $resultCheck->fetch_assoc();

if (isset($rowCheck['nome'])) {
	
    $update = "UPDATE cad_login SET nome = '$nome',
    login = '$email',
    senha = '$senha' WHERE CPF = '$cpf'";

    $result = $conn->query($update);

	$_SESSION["iduser"] = $rowCheck['ID_USUARIO'];
    $_SESSION["user"] = $nome;
    $_SESSION["email"] = $rowCheck['login'];
    $_SESSION["loginfluig"] = $rowCheck['usuario_fluig'];
    $_SESSION["admin"] = $_GET['admin'];

    if ($rowCheck['rateio_espelhado'] == 1) {

    	$_SESSION["userrateioespelho"] = $rowCheck['login_espelho'];

		$queryEspelho = "SELECT nome FROM cad_login WHERE ID_USUARIO = ".$rowCheck['login_espelho'];
		$resultEspelho = $conn->query($queryEspelho);
		$rowEspelho = $resultEspelho->fetch_assoc();
		$_SESSION["nomeuserrateioespelho"] = $rowEspelho['nome'];
    }else{
		$_SESSION["userrateioespelho"] = 0;
		$_SESSION["nomeuserrateioespelho"] = "";
    }

    $_SESSION["rateio_espelhado"] = $rowCheck['rateio_espelhado'];




	$conn->close();

	header('location: ../index.php');

}else{

	$insert = "INSERT INTO cad_login (nome,login,CPF,senha,admin) VALUE 
    ('$nome','$email','$cpf','$senha',0)";
    $result = $conn->query($insert);

    $queryTemp = "SELECT * FROM cad_login WHERE CPF = '$cpf';";
	$resultTemp = $conn->query($resultTemp);
	$rowTemp = $resultTemp->fetch_assoc();

    $_SESSION["iduser"] = $rowTemp['ID_USUARIO'];
    $_SESSION["user"] = $nome;
    $_SESSION["email"] = $rowTemp['login'];
    $_SESSION["loginfluig"] = $rowTemp['usuario_fluig'];

	$conn->close();

	header('location: ../index.php');

}

?>