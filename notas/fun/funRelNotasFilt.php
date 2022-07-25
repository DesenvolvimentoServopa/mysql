<?php
//session_start();
require_once('../conf/conexao.php');

$userlogado = $_SESSION["iduser"];


$filial= $_GET['filial'];
$status= $_GET['status'];

$forn = "";
foreach ($_GET['forn'] as $selectedOption){
    $forn .= $selectedOption.",";
}
if (substr($forn, -1) == ",") {
    $forn = substr($forn, 0, -1);
}

if ($forn == 'todos') {
    $forn = '';
}

//datas FIM
if(empty($_GET['dataFim'])){
    $dataFim = date("d/m/Y");
}else{
    $str = str_replace("-", "/", $_GET['dataFim']);
    $dataFim = date('d/m/Y', strtotime($str));
}

//Data Inicio
if(empty($_GET['datain'])){
    $datain = "01/01/2021";
}else{
    $str = str_replace("-", "/", $_GET['datain']);
    $datain = date('d/m/Y', strtotime($str));
}

$queryNotas = "SELECT LAN.ID_LANCARNOTAS AS IDNOTA, FIL.nome AS FILIAL, FORN.nome_fornecedor AS FORNECEDOR, USU.nome AS USUARIO, LAN.CNPJ, LAN.numero_nota AS NUMERONOTA, LAN.serie_nota AS SERIENOTA, LAN.emissao AS DATAEMISSAO, LAN.vencimento AS DATAVENCIMENTO, LAN.valor_nota AS VALORNOTA, LAN.numero_fluig AS FLUIG, STR.nome AS STATUS FROM dbnotas.cad_lancarnotas LAN 
            INNER JOIN cad_filial FIL ON FIL.ID_FILIAL = LAN.ID_FILIAL
            INNER JOIN cad_login USU ON USU.ID_USUARIO = LAN.ID_USUARIO
            INNER JOIN cad_tipodespesa DESP ON DESP.ID_TIPODESPESA = LAN.ID_TIPODESPESA
            INNER JOIN cad_tipopagamento PGT ON PGT.ID_TIPOPAGAMENTO = LAN.ID_TIPOPAGAMENTO
            INNER JOIN cad_status STR ON LAN.status_desc = STR.id_status
            INNER JOIN cad_fornecedor FORN ON FORN.CPF_CNPJ = LAN.CNPJ WHERE LAN.ID_USUARIO = '".$userlogado."' AND STR_TO_DATE(LAN.emissao,'%d/%m/%Y') BETWEEN STR_TO_DATE('".$datain."','%d/%m/%Y') AND STR_TO_DATE('".$dataFim ."','%d/%m/%Y')";

            if($forn != ''){ 
                $queryNotas .= " AND FORN.id_fornecedor IN ('".$forn."')"; 
            }
            if($filial != NULL){ 
                $queryNotas .= " AND LAN.ID_FILIAL= '".$filial."'"; 
            }
            if($status != NULL){ 
                $queryNotas .= " AND LAN.status_desc= '".$status."'"; 
            }
$result = $conn->query($queryNotas);

?>