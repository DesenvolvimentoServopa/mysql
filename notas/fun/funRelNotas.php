<?php
session_start();
require_once('../conf/conexao.php');

$userlogado = $_SESSION["iduser"];

$queryNotas = "SELECT LAN.ID_LANCARNOTAS AS IDNOTA, FIL.nome AS FILIAL, FORN.nome_fornecedor AS FORNECEDOR, USU.nome AS USUARIO, DESP.nome AS TIPODESPESA, PGT.nome AS TIPOPGTO, LAN.CNPJ, LAN.auditoria AS AUDITORIA, LAN.obra AS OBRA, LAN.observacao AS OBSERVACAO, LAN.numero_nota AS NUMERONOTA, LAN.serie_nota AS SERIENOTA, LAN.emissao AS DATAEMISSAO, LAN.vencimento AS DATAVENCIMENTO, LAN.valor_nota AS VALORNOTA FROM dbnotas.cad_lancarnotas LAN 
            INNER JOIN cad_filial FIL ON FIL.ID_FILIAL = LAN.ID_FILIAL
            INNER JOIN cad_login USU ON USU.ID_USUARIO = LAN.ID_USUARIO
            INNER JOIN cad_tipodespesa DESP ON DESP.ID_TIPODESPESA = LAN.ID_TIPODESPESA
            INNER JOIN cad_tipopagamento PGT ON PGT.ID_TIPOPAGAMENTO = LAN.ID_TIPOPAGAMENTO
            INNER JOIN cad_fornecedor FORN ON FORN.CPF_CNPJ = LAN.CNPJ WHERE LAN.ID_USUARIO = $userlogado;";

$result = $conn->query($queryNotas);

while ( $row = $result->fetch_assoc() ) {

    if ($row['AUDITORIA'] == 1) {
        $audit = "Sim";
    }else{
        $audit = "Não";
    }

    if ($row['OBRA'] == 1) {
        $obra = "Sim";
    }else{
        $obra = "Não";
    }

    if (strlen($row['CNPJ']) > 11) {
        $cpfcnpj = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $row['CNPJ']);
    }else{
        $cpfcnpj = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $row['CNPJ']);
    }

    $notas[] = array(
    $row['IDNOTA'],
    $row['FILIAL'],
    $cpfcnpj,
    $row['FORNECEDOR'],
    'R$ '.number_format($row['VALORNOTA'],2,",","."),
    $row['DATAEMISSAO'],
    $row['DATAVENCIMENTO'],
    $row['USUARIO'],
    $row['TIPOPGTO']);
}

echo json_encode($notas);



?>