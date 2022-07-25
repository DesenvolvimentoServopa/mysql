<?php
require_once('querysApi.php');

$url = "http://10.100.1.216/unico_api/sisrev/api_apollo.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
$resultado = json_decode(curl_exec($ch));

/* var_dump($resultado); */

foreach ($resultado->usuariosApollo as $usuarioApollo) {

    $queryVerificar = "SELECT nome FROM cad_usuario_api where cpf = '$usuarioApollo->cpf'";
    $resultadoVerificar = $conn->query($queryVerificar);
    $verificar = $resultadoVerificar->fetch_assoc();

    if ($verificar['nome'] == null) {
        $ajusteNomes = str_replace("'", " ", $usuarioApollo->nome);
        $insert = "INSERT INTO cad_usuario_api (nome, cpf, ativo, sistema)
            VALUES ('" . $ajusteNomes . "', 
                    '" . $usuarioApollo->cpf . "', 
                    '" . $usuarioApollo->ativo . "', 
                    '" . $usuarioApollo->sistema . "');";

        if (!$execInsert = $conn->query($insert)) {
            echo "Error: " . $insert . "<br>" . $conn->error;
        } 

    }

}

curl_close($ch);
$conn->close();

echo '<script>window.location.href = "importarUsuariosApi.php?acao=2";</script>';

?>
