<?php

require_once('../conf/conexao.php');

switch ($_GET["function"]) {
    case "funTipoDespesa":

        $queryTd = "SELECT ID_TIPODESPESA AS ID, nome FROM cad_tipodespesa WHERE deletar = 0;";

        $result = $conn->query($queryTd);

        while ( $row = $result->fetch_assoc() ) {
            $tpDespesas[] = array(
            'ID'    => $row['ID'],
            'nome'  => $row['nome'],
            );
        }

		echo json_encode($tpDespesas);

        break;

    case "funPeriodicidade":

        $queryD = "SELECT ID_PERIODICIDADE AS ID, nome FROM cad_periodicidade WHERE deletar = 0;";

        $result = $conn->query($queryD);

        while ( $row = $result->fetch_assoc() ) {
            $periodos[] = array(
            'ID'    => $row['ID'],
            'nome'  => $row['nome'],
            );
        }

        echo json_encode($periodos);

        break;

    case "funTipoPgto":

        $queryPgto = "SELECT ID_TIPOPAGAMENTO AS ID, nome FROM cad_tipopagamento WHERE deletar = 0;";

        $result = $conn->query($queryPgto);

        while ( $row = $result->fetch_assoc() ) {
            $tpPgto[] = array(
            'ID'    => $row['ID'],
            'nome'  => $row['nome'],
            );
        }

        echo json_encode($tpPgto);

        break;

    case "funRetornaCC":

        $idfilial = $_GET["idfilial"];

        $queryDp = "SELECT ID_CENTROCUSTO AS ID, descDpto AS nome FROM cad_centrocusto WHERE ID_FILIAL = $idfilial AND deletar = 0;";

        $result = $conn->query($queryDp);

        while ( $row = $result->fetch_assoc() ) {
            $dptos[] = array(
            'ID'    => $row['ID'],
            'nome'  => $row['nome'],
            );
        }

        echo json_encode($dptos);

        break;


    case "funCheckConsorcio":

        $idfilial = $_POST["idfilial"];

        $queryDp = "SELECT consorcio FROM cad_filial WHERE ID_FILIAL = $idfilial;";

        $result = $conn->query($queryDp);

        $row = $result->fetch_assoc();

        if ($row['consorcio'] == 1) {
            echo 1;
        }else{
            echo 0;
        }

        break;

    case "funCheckCCduplicado":

        $nomeCC = $_POST["nomeCC"];
        $filial = $_POST["filial"];

        $queryDp = "SELECT * FROM cad_centrocusto WHERE descDpto = '$nomeCC' AND ID_FILIAL = $filial AND deletar = 0;";

        $result = $conn->query($queryDp);

        $row = $result->fetch_assoc();

        if (isset($row['ID_CENTROCUSTO'])) {
            echo 1;
        }else{
            echo 0;
        }

        break;



    case "funRetornaFornecedor":

        $idfornecedor = $_POST["idfornecedor"];
        $idfilial = $_POST["idfilial"];
        $idusuario = $_POST["idusuario"];
	$tipo_serv = $_POST["tipo_serv"];

	if($tipo_serv == ''){
		$queryDp = "SELECT * FROM cad_fornecedor FORN LEFT JOIN cad_rateiofornecedor RAT ON RAT.ID_FORNECEDOR = FORN.ID_FORNECEDOR 
        	WHERE FORN.ID_FORNECEDOR = $idfornecedor AND RAT.ID_FILIAL = $idfilial AND RAT.ID_USUARIO = $idusuario";
	}else{
		$queryDp = "SELECT * FROM cad_fornecedor FORN LEFT JOIN cad_rateiofornecedor RAT ON RAT.ID_FORNECEDOR = FORN.ID_FORNECEDOR 
        	WHERE FORN.ID_FORNECEDOR = $idfornecedor AND RAT.ID_FILIAL = $idfilial AND RAT.ID_USUARIO = $idusuario AND RAT.tipo_serv = '$tipo_serv';";
	}

        $result = $conn->query($queryDp);

        $row = $result->fetch_assoc();

        if (isset($row['ID_RATEIOFORNECEDOR'])) {
            if ($row['ID_TIPOPAGAMENTO'] == 2) {

                $queryBanco = "SELECT * FROM cad_rateiobanco WHERE ID_RATEIOFORNECEDOR = ".$row['ID_RATEIOFORNECEDOR'];
                $resultBanco = $conn->query($queryBanco);
                $rowB = $resultBanco->fetch_assoc();

                $fornecedor[] = array(
                    'ID'                    => $row['ID_RATEIOFORNECEDOR'],
                    'USUARIO'               => $row['ID_USUARIO'],
                    'CNPJ'                  => $row['CPF_CNPJ'],
                    'PERIODICIDADE'         => $row['ID_PERIODICIDADE'],
                    'OBSERVACAO'            => $row['observacao'],
                    'TIPOPGTO'              => $row['ID_TIPOPAGAMENTO'],
                    'TIPODESPESA'           => $row['ID_TIPODESPESA'],
                    'AUDITORIA'             => $row['auditoria'],
                    'OBRA'                  => $row['obra'],
                    'CONFERENCIA'           => $row['necessita_conferencia'],
                    'RELSISCON'             => $row['relatorio_siscon'],
                    'MOTIVO'                => $row['motivo_siscon'],
                    'TELEFONE'              => $row['telefone'],

                    'VENCRATEIO'            => $row['vencimento'],
                    'VENCRATEIOTIPO'        => $row['vencimento_tipo'],

                    'BANCO'                 => $rowB['nome_banco'],
                    'AGENCIA'               => $rowB['agencia'],
                    'CONTA'                 => $rowB['conta'],
                    'DIGITO'                => $rowB['digito'],
                );

            }else{

                $fornecedor[] = array(
                    'ID'                    => $row['ID_RATEIOFORNECEDOR'],
                    'USUARIO'               => $row['ID_USUARIO'],
                    'CNPJ'                  => $row['CPF_CNPJ'],
                    'PERIODICIDADE'         => $row['ID_PERIODICIDADE'],
                    'OBSERVACAO'            => $row['observacao'],
                    'TIPOPGTO'              => $row['ID_TIPOPAGAMENTO'],
                    'TIPODESPESA'           => $row['ID_TIPODESPESA'],
                    'AUDITORIA'             => $row['auditoria'],
                    'OBRA'                  => $row['obra'],
                    'CONFERENCIA'           => $row['necessita_conferencia'],
                    'RELSISCON'             => $row['relatorio_siscon'],
                    'MOTIVO'                => $row['motivo_siscon'],
                    'VENCRATEIO'            => $row['vencimento'],
                    'VENCRATEIOTIPO'        => $row['vencimento_tipo'],
                    'TELEFONE'              => $row['telefone'],
                );
            }


            echo json_encode($fornecedor);

        }else{
            echo "erro";
        }

        break;






    case "funRetornaRateio":

        $idrateiofornecedor = $_POST["idrateiofornecedor"];
        $valor = $_POST["valor"];

        $queryRateio = "SELECT RAT.ID_RATEIOCENTROCUSTO AS ID, CEN.descDpto,RAT.percentual FROM cad_rateiocentrocusto RAT INNER JOIN cad_centrocusto CEN ON CEN.ID_CENTROCUSTO = RAT.ID_CENTROCUSTO 
            WHERE RAT.ID_RATEIOFORNECEDOR = $idrateiofornecedor";

        $result = $conn->query($queryRateio);

        $table = '';
        while ( $row = $result->fetch_assoc() ) {

            $input1 = "<input type='hidden' name='id' value='".$row['ID']."'>";
            $input3 = "<input type='hidden' name='valor' value='".$valor*($row['percentual']/100)."'>";

            $table .= '<tr>';
            $table .= '<td>'.$row['descDpto'].$input1.'</td>';
            $table .= '<td>'.$row['percentual'].'%'.'</td>';
            $table .= '<td>'.number_format($valor*($row['percentual']/100),2,",",".").$input3.'</td>';
            $table .= '</tr>';

        }

        echo $table;
        
        break;


    case "funRetornaNotas":

        
        $queryNotas = "SELECT 
                LAN.ID_LANCARNOTAS AS IDNOTA, 
                FIL.nome AS FILIAL, 
                FORN.nome_fornecedor AS FORNECEDOR, 
                USU.nome AS USUARIO, 
                DESP.nome AS TIPODESPESA, 
                PGT.nome AS TIPOPGTO, 
                LAN.CNPJ, 
                LAN.auditoria AS AUDITORIA, 
                LAN.obra AS OBRA, 
                LAN.observacao AS OBSERVACAO, 
                LAN.numero_nota AS NUMERONOTA, 
                LAN.serie_nota AS SERIENOTA, 
                LAN.emissao AS DATAEMISSAO, 
                LAN.vencimento AS DATAVENCIMENTO, 
                LAN.valor_nota AS VALORNOTA, 
                STA.nome AS STATUSDESC, 
                STA.id AS ID_STATUS, 
                LAN.numero_fluig
            FROM dbnotas.cad_lancarnotas LAN 
            INNER JOIN cad_filial FIL ON FIL.ID_FILIAL = LAN.ID_FILIAL
            INNER JOIN cad_login USU ON USU.ID_USUARIO = LAN.ID_USUARIO
            INNER JOIN cad_tipodespesa DESP ON DESP.ID_TIPODESPESA = LAN.ID_TIPODESPESA
            INNER JOIN cad_tipopagamento PGT ON PGT.ID_TIPOPAGAMENTO = LAN.ID_TIPOPAGAMENTO
            INNER JOIN cad_fornecedor FORN ON FORN.CPF_CNPJ = LAN.CNPJ AND FORN.deletar = 0
            LEFT JOIN cad_status STA ON STA.id = LAN.status_desc WHERE LAN.deletar = 0 ";


        if (isset($_GET['statusnota'])) {
            $queryNotas .= 'AND STA.id IN ('.$_GET['statusnota'] .') ';
        }else{
            $queryNotas .= 'AND STA.id IN (1) ';
        }

        if (isset($_GET['usuario'])) {
            $queryNotas .= ' AND USU.ID_USUARIO = '.$_GET['usuario'];
        }else{
            $queryNotas .= '';
        }

        //mostrar apenas no mes
        
        $ano = date('Y');
        $mes = date('m');
        $lastDayMoth = date('t');
        $queryNotas .= " AND LAN.date_create BETWEEN '$ano-$mes-01' AND '$ano-$mes-$lastDayMoth'";

        $result = $conn->query($queryNotas);
        $table = '';
        while ( $row = $result->fetch_assoc() ) {

            $anexos = "";
            $botaoanexo = "";
            $errodesc = "";
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


            
            //STATUS 
            $queryErros = "SELECT id AS ID_STATUS FROM cad_status WHERE erro = 1 and deletar = 0;";
            $resultErros = $conn->query($queryErros);
            $array_erros = array();

            while ( $rowErro = $resultErros->fetch_assoc() ) {
                array_push($array_erros, $rowErro['ID_STATUS']);
            }



            if (in_array($row['ID_STATUS'],$array_erros) != '') {
                $erro = "<div style='display: inline-flex;'><p style='color: red;margin-top: 5px;'>Erro</p>
                <a style='margin-left: 10px;' href='#' class='btn btn-danger btn-circle btn-sm' data-toggle='modal' data-target='#modalErroNota".$row['IDNOTA']."'>
                <i class='fas fa-exclamation'></i>
                </a></div>";
                $errodesc = $row['STATUSDESC'];
                $row['STATUSDESC'] = $erro;
            }




            if ($row['ID_STATUS'] == 3) {
                $checklancado = "style='background-color: #b0ffd380;color: #958796;'";
            }else{
                $checklancado = "";
            }



            //ANEXOS NOTA
            $queryAnexos = "SELECT DISTINCT ID_LANCARNOTA, url_nota FROM cad_anexos WHERE ID_LANCARNOTA = ".$row['IDNOTA'];
            $resultAnexos = $conn->query($queryAnexos);


            while ( $rowA = $resultAnexos->fetch_assoc() ) {

                $urlnota = substr($rowA['url_nota'], 1);

                $nomeanexo = explode('/', $rowA['url_nota']);

                if ($rowA['url_nota'] != '') {
                    $anexos .= "<li class='list-group-item'><a href='".$urlnota."' target='_blank' style='margin-right: 5px;font-size: 16px;'>".$nomeanexo[1]." - ".$nomeanexo[2]."</a></li>";

                    $botaoanexo = "<a style='margin-right: 10px;' href='#' class='btn btn-primary btn-circle btn-sm' data-toggle='modal' data-target='#modalAnexosNota".$row['IDNOTA']."'><i class='fas fa-paperclip' style='margin-top: 1px;'></i></a>";
                }else{
                    $anexos .= "";
                    $botaoanexo = "";
                }

            }

            if ($row['numero_fluig'] != '') {
                $linkfluig = "<a target='_blank' href='https://gruposervopa.fluig.com/portal/p/1/pageworkflowview?app_ecm_workflowview_detailsProcessInstanceID=".$row['numero_fluig']."'>".$row['numero_fluig']."</a>";
            }else{
                $linkfluig = "";
            }


            $table .= "<tr ".$checklancado.">";
            $table .= "<td>".$row['IDNOTA']."</td>";
            $table .= "<td>".$row['FILIAL']."</td>";
            $table .= "<td>".$cpfcnpj."</td>";
            $table .= "<td>".$row['FORNECEDOR']."</td>";
            $table .= "<td>".'R$ '.$row['VALORNOTA']."</td>";
            $table .= "<td>".$row['DATAEMISSAO']."</td>";
            $table .= "<td>".$row['DATAVENCIMENTO']."</td>";
            $table .= "<td>".$row['USUARIO']."</td>";
            $table .= "<td>".$row['TIPOPGTO']."</td>";
            $table .= "<td>".$linkfluig."</td>";
            $table .= "<td>".$row['STATUSDESC']."</td>";
            $table .= "<td><div style='display: inline-flex;'>
            ".$botaoanexo."
            <a href='front/lancarNotaEdit.php?idnota=".$row['IDNOTA']."' class='btn btn-info btn-circle btn-sm'><i class='fas fa-edit' style='margin-left: 1px;'></i></a>
            <a style='margin-left: 10px;' href='#' class='btn btn-danger btn-circle btn-sm' data-toggle='modal' data-target='#modalDeleteNota".$row['IDNOTA']."'><i class='fas fa-trash'></i></a>
            </div>

            <!-- Modal Delete Nota-->
            <div class='modal fade' id='modalDeleteNota".$row['IDNOTA']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <form id='excluirnota".$row['IDNOTA']."' method='POST' action='fun/funLancNota.php?fun=excluirnota&idnota=" . $row['IDNOTA'] . "'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>Tem certeza que deseja remover esta Nota?</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                            <button type='submit' class='btn btn-danger'>Remover Nota</button>
                          </div>
                        </form> 
                    </div>
                </div>
            </div>

            <!-- Modal Anexos Nota-->
            <div class='modal fade' id='modalAnexosNota".$row['IDNOTA']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>Anexos</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <ul class='list-group'>
                                ".$anexos."
                            </ul> 
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal ERRO Nota-->
            <div class='modal fade' id='modalErroNota".$row['IDNOTA']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>Descrição do Erro</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <p style='font-size: 16px;'>
                                ".$errodesc."
                            </p> 
                            <p style='font-size: 16px;'>
                                Este erro já foi resolvido?
                            </p>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' onclick='alteraStatus(".$row['IDNOTA'].")' class='btn btn-success' data-dismiss='modal'>Sim</button>
                            <button type='button' onclick=\"window.location.href='front/lancarNotaEdit.php?idnota=".$row['IDNOTA']."';\" class='btn btn-warning' data-dismiss='modal'>Não</button>
                        </div>
                    </div>
                </div>
            </div></td>";
            $table .= '</tr>';
        }

        echo $table;

        break;

    case "funRetornaRateioPercentual":

        $idrateiofornecedor = $_GET["idrateiofornecedor"];

        $queryRateio = "SELECT CEN.ID_CENTROCUSTO AS ID, CEN.descDpto,RAT.percentual FROM cad_rateiocentrocusto RAT INNER JOIN cad_centrocusto CEN ON CEN.ID_CENTROCUSTO = RAT.ID_CENTROCUSTO 
            WHERE RAT.ID_RATEIOFORNECEDOR = $idrateiofornecedor;";

        $result = $conn->query($queryRateio);

        $table = '';
        while ( $row = $result->fetch_assoc() ) {

            $table .= '<tr>';
            $table .= '<td>'.$row['ID'].'</td>';
            $table .= '<td>'.$row['descDpto'].'</td>';
            $table .= '<td>'.$row['percentual'].'%'.'</td>';
            $table .= '<td><a style="margin-left: 10px;" onclick="funDeletar('.$idrateiofornecedor.','.$row['ID'].')" class="btn btn-danger btn-sm"><i class="fas fa-trash" style="color: white;"></i></a></td>';
            $table .= '</tr>';

        }

        echo $table;
        
        break;






    case "funDeletaRateio":

        $idrateiofornecedor = $_POST["idrateiofornecedor"];
        $idcc = $_POST["idcc"];

        $queryDeleteRateio = "DELETE FROM cad_rateiocentrocusto
            WHERE ID_RATEIOFORNECEDOR = $idrateiofornecedor AND ID_CENTROCUSTO = $idcc;";

        $result = $conn->query($queryDeleteRateio);

        $queryPercentual = "SELECT sum(percentual) AS totalpercentual FROM cad_rateiocentrocusto WHERE ID_RATEIOFORNECEDOR = $idrateiofornecedor";
        $resultPercentual = $conn->query($queryPercentual);
        $rowPercentual = $resultPercentual->fetch_assoc();

        echo $rowPercentual['totalpercentual'];

        break;



    case "funInserirRateio":

        $idrateiofornecedor = $_POST["idrateiofornecedor"];
        $idcc = $_POST["idcc"];
        $percentual = $_POST["percentual"];


        $queryCheck = "SELECT * FROM cad_rateiocentrocusto 
        WHERE ID_RATEIOFORNECEDOR = $idrateiofornecedor AND ID_CENTROCUSTO = $idcc";
        $resultCheck = $conn->query($queryCheck);
        $row = $resultCheck->fetch_assoc();

        if (isset($row['ID_RATEIOFORNECEDOR'])) {

            echo 0;

        }else{

            $insertRateio = "INSERT INTO cad_rateiocentrocusto (
                ID_RATEIOFORNECEDOR,
                ID_CENTROCUSTO,
                percentual,
                deletar) 

                VALUES 

                ($idrateiofornecedor,$idcc,$percentual,0)";

            $result = $conn->query($insertRateio);


            $queryPercentual = "SELECT sum(percentual) AS totalpercentual FROM cad_rateiocentrocusto WHERE ID_RATEIOFORNECEDOR = $idrateiofornecedor";
            $resultPercentual = $conn->query($queryPercentual);
            $rowPercentual = $resultPercentual->fetch_assoc();

            echo $rowPercentual['totalpercentual'];

        }

        break;


    case "funCheckAcessoFluig":

        if (isset($_GET["email"])) {

            $email = $_GET["email"];

            $queryCheck = "SELECT * FROM cad_login WHERE login = '$email'";
            $resultCheck = $conn->query($queryCheck);
            $row = $resultCheck->fetch_assoc();

            if ($row['usuario_fluig'] != '') {

                echo 0;

            }else{

                echo 1;

            }
        }
        
        break;

}
