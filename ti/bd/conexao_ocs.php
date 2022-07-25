<?php
  //variaveis para conexao
  $servernameOcs = "#";
  $userOcs = "#";
  $passwordOcs = "#";
  $dbnameOcs = "#";

  //Estilo orientado a objetos
  $conn_ocs = mysqli_connect($servernameOcs,$userOcs,$passwordOcs ,$dbnameOcs) or die("Error " . mysqli_error($conn_ocs)); 

?>
