<?php
session_start();
require_once('../bd/conexao.php');

$dataHoje = date('d/m/yy H:i:s');

//EQUIPAMENTO
$updateEquip = "UPDATE manager_inventario_equipamento SET id_funcionario = '".$_POST['newfun']."', status = '".$_POST['status']."', liberado_rh = '0', termo = '1' WHERE id_equipamento = ".$_GET['id_equip']."";

if(!$resultUpdate = $conn->query($updateEquip)){
    printf('ERRO[1]: %s\n', $conn->error);
}

//FUNCIONARIO
$updateFun = "UPDATE manager_inventario_funcionario SET status = '3' WHERE id_equipamento = '".$_POST['newfun']."'";

if(!$resultUpdateFun = $conn->query($updateFun)){
    printf('ERRO[1]: %s\n', $conn->error);
}

//relatório
$insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_POST['newfun']. "','".$_GET['id_equip']."', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4')";

    if (!$log = $conn->query($insertLog)) {
        printf('Erro[2]: %s\n', $conn->error);
    } else {

        header('location: ../inc/pesquisaFuncionario.php?pagina=3&id='.$_POST['newfun'].'.php');
    }

?>