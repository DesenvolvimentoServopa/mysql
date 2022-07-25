<?php
    //variaveis para conexao
    $servername = "#";
    $username = "#";
    $password = "##";
    $dbname = "#";
    $port = "#";

$banco_blog = new mysqli($servername, $username, $password, $dbname, $port);

if ($banco_blog->connect_errno) {
    printf("Erro ao se conectar com o banco de dados: %s\n", $banco_blog->connect_error);
    exit;
}else{
    //echo "Sucesso: Foi feita uma conexão adequada ao MySQL!<br />" . PHP_EOL;
    //echo "Informações do Host: " . mysqli_get_host_info($conn) . PHP_EOL;
}
      
?>
