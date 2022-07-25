<?php
/* ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1); */

/* 
ESSE ARQUIVO É INICIADO ATRAVES DE UM PROCESSO AUTOMATIZADO QUE TEM O NOME DE (LENDO NOTA) 

RESPONSAVEL PELA CRIAÇÃO (FELIPE SILVEIRA LARA)

QUALQUER QUER DUVIDA SOBRE A EXECUÇÃO POR GENTELIZA VALIDAR NA DOCUMENTAÇÃO OU ENTRE EM CONTATO COM O TIME DE DESENVOLVIMENTO
*/

require_once('../conf/conexao.php');
require_once('../conf/psw.php');

//COLETANDO O TOKEN PARA A CHAMADA DO WF - ELE DURA 15 MINUTOS

$data = array("username" => $useAut, "password" => $pswAut);

$ch = curl_init($getAut);

//CONFIGURAÇÔES
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));


//EXECUTANDO
$resultToken = json_decode(curl_exec($ch));

//FECHANDO A CHAMADA
curl_close($ch);

$token = $resultToken->sessionToken;

//pegando os CNPJ para a chamada do WF correto

$distinct = "SELECT distinct cnpj FROM tmp_nota";
$resultDistinct = $conn->query($distinct);


while ($rowdistinct = $resultDistinct->fetch_assoc()) {


    //COLETANDO O ID DO WF
    $query = "SELECT nome FROM cad_workflow where CNPJ = '" . $rowdistinct['cnpj'] . "'";
    $resultQuery = $conn->query($query);
    $rowQuery = $resultQuery->fetch_assoc();

    //CHAMANDO O WF

    $dataWF = array(
        "orgCode" => "PREMIERIT",
        "workflowName" => $rowQuery['nome'],
        "userId" => $useAut,
        "source" => "AutomationEdge Demo",
        "sourceId" => null,
        "responseMailSubject" => null
    );

    $wf = curl_init('https://ondemand.automationedge.com/aeengine/rest/execute');

    $data_string = json_encode($dataWF);

    //CONFIGURAÇÔES
    curl_setopt($wf, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($wf, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($wf, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($wf, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($wf, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($wf, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt(
        $wf,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string),
            'X-session-token: ' . $token
        )
    );


    //EXECUTANDO
    $workflow = curl_exec($wf);
    $str = json_decode($workflow);
    

    //MENSAGEM    
    echo "<div id='msn'>";
    echo empty($msn = $str->success) ? "Erro: Não foi possivel chamar o WF<br/> Nome WF: ".$rowQuery['nome']."" : "Sucesso";
    echo "</div>";

    //FECHANDO A API
    curl_close($wf);
}
