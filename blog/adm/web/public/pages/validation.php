<?php
//aplicando para usar varialve em outro arquivo
session_start();

//montando as sessões para ser usados em outras telas
$_SESSION["id"] = $_GET["id_usuario"];
$_SESSION["nome"] = $_GET["usuario"];
$_SESSION["exibicao"] = $_GET["nome"];
$_SESSION["email"] = $_GET["email"];	

header('location: index.php?msn=1');

?>