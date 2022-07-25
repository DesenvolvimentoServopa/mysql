<?php
session_start();
require_once('../bd/conexao.php');


$dataHoje = date('d/m/yy H:i:s');

//excluindo o equipamento
$update = "UPDATE manager_inventario_equipamento SET deletar = 1, status = 11 WHERE id_equipamento = ".$_GET['id']."";

if(!$result = $conn->query($update)){
    printf("Erro[1]: %s\n", $conn->error);
}


//salvando log
$insertLog = "INSERT INTO manager_log (id_equipamento, data_alteracao, usuario, tipo_alteracao) VALUES ('".$_GET['id']."', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '11')";

if (!$log = $conn->query($insertLog)) {
    printf('Erro[2]: %s\n', $conn->error);
}else{
    header('Location: ../front/listequipamentos.php?pagina=5');
}


$conn->close();

?>