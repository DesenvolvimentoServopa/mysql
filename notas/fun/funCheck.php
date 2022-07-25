<?php

$iduser = $_SESSION["iduser"];

$queryUsers = "SELECT * FROM cad_login WHERE ID_USUARIO = $iduser;";
$resultCheck = $conn->query($queryUsers);

$rowCheck = $resultCheck->fetch_assoc();

if ($rowCheck['admin'] == 1) {
	$permission = 1;
}else{
	$permission = 0;
}

?>