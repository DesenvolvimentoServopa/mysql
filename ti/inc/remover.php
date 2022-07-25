<?php
session_start();
require_once('../bd/conexao.php');

//DATA DE HOJE
$dataHoje = date('d/m/Y');

//removendo Offfice

if(!empty($_GET['id_of'])){

    $update = "UPDATE manager_office SET id_equipamento = 0 WHERE id = '" . $_GET['id_of'] . "'";

    if (!$result = $conn->query($update)) {
        printf('ERRO[1]: %s\n', $conn->error);
    } else {
    
        $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                        VALUES ('" . $_GET['id_equip'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '14')";
    
        if (!$log = $conn->query($insertLog)) {
            printf('Erro[2]: %s\n', $conn->error);
        } else {
            header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equip'] . '');
        }
    }
}else{
    $update = "UPDATE manager_sistema_operacional SET id_equipamento = 0 WHERE id = '" . $_GET['id_so'] . "'";

    if (!$result = $conn->query($update)) {
        printf('ERRO[1]: %s\n', $conn->error);
    } else {
    
        $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                        VALUES ('" . $_GET['id_equip'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '16')";
    
        if (!$log = $conn->query($insertLog)) {
            printf('Erro[2]: %s\n', $conn->error);
        } else {
            header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equip'] . '');
        }
    }
}


$conn->close();
