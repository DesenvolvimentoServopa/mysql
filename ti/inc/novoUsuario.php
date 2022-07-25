<?php
require_once('../bd/conexao.php');

//senha
$senha = md5($_POST['senha']);

//novo usuário
$insertUsuario = "INSERT INTO manager_profile (profile_name, 
    profile_mail, 
    profile_password, 
    profile_type, 
    emitir_check_list, 
    editar_historico, 
    editar_cadastro_funcionario, 
    ativar_cpf, 
    desativar_cpf) 
VALUES 
    ('".$_POST['nome']."', 
    '".$_POST['email']."', 
    '".$senha."', 
    '".$_POST['perfil']."', 
    '";
    $insertUsuario .= isset($_POST['EditarFuncionario']) ? '1' : '0'; 
    $insertUsuario .= "', '";
    $insertUsuario .= isset($_POST['EditarFuncionario']) ? '1' : '0';
    $insertUsuario .= "', '";
    $insertUsuario .= isset($_POST['EditarFuncionario']) ? '1' : '0';
    $insertUsuario .= "', '";
    $insertUsuario .= isset($_POST['EditarFuncionario']) ? '1' : '0';
    $insertUsuario .= "', '";
    $insertUsuario .= isset($_POST['EditarFuncionario']) ? '1' : '0';
    $insertUsuario .= "')";

echo $insertUsuario."<br>";

$resultUsuario = mysqli_query($conn, $insertUsuario);

header('location: ../front/novoUsuario.php?pagina=2&msn=1#senha');

$conn->close();

?>