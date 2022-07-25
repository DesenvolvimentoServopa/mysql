<?php

session_start();

require_once('../bd/conexao.php');

$dataHoje = date('d/m/yy H:i:s');

//editando funcionario
$updateFuncionario = "UPDATE manager_inventario_funcionario SET

cpf = '".$_POST['cpf']."', 
nome = '".$_POST['nome']."', 
funcao = '".$_POST['funcao']."', 
departamento = '".$_POST['departamento']."', 
empresa = '".$_POST['empresa']."', 
status = '".$_POST['status']."' 

WHERE id_funcionario = '".$_GET['id']."'";

if(!$update = $conn->query($updateFuncionario)){
    printf('Erro[1]: %s\n', $conn->error);
}else{

    //salvando log
    $insertLog = "INSERT INTO manager_log (id_funcionario, data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_GET['id'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '0')";

    if (!$log = $conn->query($insertLog)) {
        printf('Erro[2]: %s\n', $conn->error);
    } else {

        header('location: pesquisaFuncionario.php?id=' . $_GET['id'] . '');
    }

}

$conn->close();