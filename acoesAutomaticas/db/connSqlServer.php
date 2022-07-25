<?php
     $serverName = "10.129.1.#\\SQLSERVOPA"; //serverName\instanceName

     $connectionInfo = array("Database"=>"#", "UID"=>"#", "PWD"=>"#");

     $conn = sqlsrv_connect($serverName, $connectionInfo);

     if(!$conn) {
          echo "Não foi possível estabelecer a conexão com o banco ".$serverName.".<br />";
          die( print_r(sqlsrv_errors(), true));
          exit;
     }

?>