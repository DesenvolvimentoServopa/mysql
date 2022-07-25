<?php
session_start();
require_once('../bd/conexao.php');

$update = "UPDATE manager_profile SET color_header = '".$_GET['color']."' WHERE id_profile = ".$_SESSION["id"]."";

if(!$result = $conn->query($update)){
    printf('Erro[1]: %s\n', $conn->error);
}else{
    header('Location: validation.php?usuario='.$_SESSION["mail"] .'&senha='.$_SESSION["senha"].'');
}

$conn->close();

?>