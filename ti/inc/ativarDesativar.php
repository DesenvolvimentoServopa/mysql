<?php
require_once('../bd/conexao.php');

if($_GET['cod'] == 1){//desativa
    $updateDesativa = "UPDATE manager_profile SET profile_deleted = 1 WHERE id_profile = ".$_GET['id_usuario']."";
    if(!$resultDesativar = $conn->query($updateDesativa)){
        printf('Erro[1]: %s\n', $conn->error);
        exit;
    }else{
        header('location: ../front/configUsers.php?pagina=2');
    }
}


if($_GET['cod'] == 0){//ativa
    $updateAtivar = "UPDATE manager_profile SET profile_deleted = 0 WHERE id_profile = ".$_GET['id_usuario']."";
    if(!$resultAtivar = $conn->query($updateAtivar)){
        printf('Erro[1]: %s\n', $conn->error);
        exit;
    }else{
        header('location: ../front/configUsers.php?pagina=2');
    }
}

$conn->close();

?>