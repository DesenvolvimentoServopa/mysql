<?php
session_start();
require_once('../bd/conexao.php');

//DATA DE HOJE
$dataHoje = date('d/m/Y');

//id_equipamento

if(!empty($_POST['equip'])){
    $id_equipamento = $_POST['equip'];
}else{
    $id_equipamento = $_GET['id_equip'];
}

$update = "UPDATE manager_sistema_operacional SET id_equipamento = '".$id_equipamento."' WHERE id = '" . $_GET['id'] . "'";

if (!$result = $conn->query($update)) {
    printf('ERRO[1]: %s\n', $conn->error);
} else {

    $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                    VALUES ('" . $id_equipamento . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '17')";

    if (!$log = $conn->query($insertLog)) {
        printf('Erro[2]: %s\n', $conn->error);
    } else {
        header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $id_equipamento . '');
    }
}

$conn->close();