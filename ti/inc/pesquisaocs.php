<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('../bd/conexao_ocs.php');
require_once('../bd/conexao.php');
require_once('pesquisas.php');
require_once('funcoes.php');

//montando a coleta dos dados
$query_ocs .= " WHERE AI.TAG LIKE '%" . $_POST['patimonioEquipamento'] . "%'";

$resultado_ocs = $conn_ocs->query($query_ocs);
$row_ocs = $resultado_ocs->fetch_assoc();

//tratando as informações do dominio(AD)
if ($row_ocs['dominio'] === 'servopa.local') {
    $possuidominio = 0; //possui dominio
} else {
    $possuidominio = 1; //não possui dominio
}

//salvando as sessões
if (!empty($row_ocs['patrimonio'])) {

    //verificar se esse patrimoio já está cadastrado no sistema
    $queryEquipamento .= " WHERE MIE.patrimonio = '" . $row_ocs['patrimonio'] . "'";

    $verificando = $conn->query($queryEquipamento);

    if (!empty($equipamento = $verificando->fetch_assoc())) {

        header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $equipamento['id_equipamento'] . '');

    } else {
        
        $_SESSION['hardware_id'] = $row_ocs['hardware_id'];
        $_SESSION['possuidominio'] = $possuidominio;
        $_SESSION['patrimonio'] = $row_ocs['patrimonio'];
        $_SESSION['hd'] = HD($row_ocs['hd']);
        $_SESSION['processador'] = $row_ocs['processador'];
        $_SESSION['memoria'] = RAM($row_ocs['memoria']);
        $_SESSION['hostname'] = $row_ocs['hostname'];
        $_SESSION['ip'] = $row_ocs['ip'];
        $_SESSION['serial_number'] = $row_ocs['serial_number'];
        $_SESSION['modelo'] = $row_ocs['modelo'];
        $_SESSION['tipo_equipamento'] = $row_ocs['tipo_equipamento'];
        $_SESSION['sistema_operacional'] = $row_ocs['sistema_operacional'];
        $_SESSION['chave_windows'] = $row_ocs['chave_windows'];
        $_SESSION['office'] = $row_ocs['office'];
        $_SESSION['chave_office'] = $row_ocs['chave_office'];

        header('location: ../front/novocpunote.php?pagina=5');
    }
} else {

    header('location: ../front/mensagens.php?msn=1&pagina=5');

}
/*------------------------------------------------FIM----------------------------------------------------------------*/

//FECHANDO AS CONEXÕES
$conn_ocs->close();
$conn->close();
