<?php
session_start();

require_once('../bd/conexao.php');

$dataHoje = date('d/m/yy H:i:s');

$updateAtivar = "UPDATE manager_inventario_funcionario SET deletar = 0 WHERE id_funcionario = " . $_GET['id'] . "";

if (!$result = $conn->query($updateAtivar)) {

    printf('Erro[1]: %s\n', $conn->error);
    
} else {

    //salvando log
    $insertLog = "INSERT INTO manager_log (id_funcionario, data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_GET['id'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '12')";

    if (!$log = $conn->query($insertLog)) {
        printf('Erro[2]: %s\n', $conn->error);
    } else {

        header('location: pesquisaFuncionario.php?id=' . $_GET['id'] . '');
    }
}

$conn->close();

?>