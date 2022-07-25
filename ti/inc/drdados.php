<?php

require_once('../bd/google.php');

if(!empty($_GET['id'])){
    $update = "UPDATE google SET deleted = 1 WHERE cod_tabela = ".$_GET['id']."";

    if(!$result = $conn_db->query($update)){
        printf("Erro[1]: %s\n", $conn_db->error);
    }else{
        header('Location: ../front/pdados.php?pagina=4');
    }
}

$conn_db->close();

?>