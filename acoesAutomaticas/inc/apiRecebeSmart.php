<?php

$url = "http://10.100.1.216/smartshare/inc/smartApi.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
$resultado = json_decode(curl_exec($ch));

var_dump($resultado); 

/* foreach ($resultado->empresaSmart as $empSmart) {

    if ($verificar['nome'] == null) {
        $ajusteNomes = str_replace("'", " ", $empSmart->nome);
        $insert = "INSERT INTO cad_usuario_api (nome, cpf, ativo, sistema)
            VALUES ('" . $ajusteNomes . "', 
                    '" . $empSmart->cpf . "', 
                    '" . $empSmart->ativo . "', 
                    '" . $empSmart->sistema . "');";
    }

} */

?>
