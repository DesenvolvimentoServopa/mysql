﻿<?php
    //variaveis para conexao
    $servername = "10.100.1.66";
    $username = "blog";
    $password = "Servopa123#";
    $dbname = "blog";
    $port = "3306";

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$conn) {
    echo "Errorrrr: não foi possível conectar-se ao MySQL." . PHP_EOL . "<br />";
    echo "Depurando erro no: " . mysqli_connect_errno() . PHP_EOL . "<br />";
    echo "Depurando erro: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

//echo "Sucesso: Foi feita uma conexão adequada ao MySQL!<br />" . PHP_EOL;
//echo "Informações do Host: " . mysqli_get_host_info($conn) . PHP_EOL;
      
?>
