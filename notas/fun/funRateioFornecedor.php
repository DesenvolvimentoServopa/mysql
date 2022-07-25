<?php
session_start();
require_once('../conf/conexao.php');


switch ($_GET["fun"]) {


	//INSERT RATEIO FORNECEDOR
    case "novoRateioFornecedor":


		//DADOS PRINCIPAIS
		$idusuario = $_POST['IDuserLanc'];
		$idfornecedor = $_POST['idfornecedor'];
		$filial = $_POST['filial'];
		$periodicidade = $_POST['periodicidade'];
		$tipodespesa = $_POST['tipoDespesa'];
		$obs = $_POST['obs'];
		$tipo_serv = $_POST['tipo_serv'];

		//DADOS PGTO
		$tipoPgto = $_POST['tipoPgto'];
		$banco = $_POST['banco'];
		$ag = $_POST['ag'];
		$conta = $_POST['conta'];
		$digito = $_POST['digito'];

		//CHECKS
		$nfDptoAudi = $_POST['nfDptoAudi'];
		$nfObras = $_POST['nfObras'];
		$conferencia = $_POST['conferencia'];

		//CONSORCIO
		$motivoSiscon = $_POST['motivoSiscon'];

		if (!isset($_POST['relSiscon'])) {
			$relSiscon = 'NULL';
		}else{
			$relSiscon = $_POST['relSiscon'];
		}

		if ($_POST['vencRateio'] == '') {
			$vencRateio = 'NULL';
		}else{
			$vencRateio = $_POST['vencRateio'];
		}

		if (!isset($_POST['vencRateioTipo'])) {
			$vencRateioTipo = 'NULL';
		}else{
			$vencRateioTipo = $_POST['vencRateioTipo'];
		}

		$telefone = $_POST['telefone'];

		$insert = "INSERT INTO cad_rateiofornecedor (
		ID_USUARIO,
		ID_FILIAL,
		ID_FORNECEDOR,
		ID_TIPOPAGAMENTO,
		ID_PERIODICIDADE,
		ID_TIPODESPESA,
		auditoria,
		obra,
		necessita_conferencia,
		relatorio_siscon,
		motivo_siscon,
		observacao,
		vencimento,
		vencimento_tipo,
		telefone,
   		tipo_serv) 

		VALUES 

		($idusuario,$filial,$idfornecedor,$tipoPgto,$periodicidade,$tipodespesa,$nfDptoAudi,$nfObras,$conferencia,$relSiscon,
			'$motivoSiscon','$obs', $vencRateio, $vencRateioTipo,'$telefone','$tipo_serv')";
		$result = $conn->query($insert);
		//echo $insert;

		//SELECT buscando o ultimo rateiofornecedor inserido pelo usuario x
		$queryUlt = "SELECT ID_RATEIOFORNECEDOR FROM cad_rateiofornecedor 
		WHERE ID_USUARIO = $idusuario ORDER BY ID_RATEIOFORNECEDOR DESC";
		$result = $conn->query($queryUlt);
		$row = $result->fetch_assoc();
		$idrateiofornecedor = $row['ID_RATEIOFORNECEDOR'];

		//INSERT DADOS BANCARIOS
		if ($tipoPgto == 2) {

			$insertBanco = "INSERT INTO cad_rateiobanco (
			ID_RATEIOFORNECEDOR,
			nome_banco,
			agencia,
			conta,
			digito) 

			VALUES 

			($idrateiofornecedor,'$banco','$ag','$conta','$digito')";

			$result = $conn->query($insertBanco);

			//echo $insertBanco;

		}

		$conn->close();

		echo $idrateiofornecedor;

        break;









  	//EDITAR RATEIO FORNECEDOR
	case 'editarRateioFornecedor': 


		$IDR = $_POST['idrateiofornecedor'];

		//DADOS PRINCIPAIS
		$idusuario = $_POST['idusuario'];
		$idfornecedor = $_POST['idfornecedor'];
		$filial = $_POST['filial'];
		$periodicidade = $_POST['periodicidade'];
		$tipoDespesa = $_POST['tipodespesa'];
		$obs = $_POST['obs'];
		$tipo_serv = $_POST['tipo_serv'];

		//DADOS PGTO
		$tipoPgto = $_POST['tipoPgto'];
		$banco = $_POST['banco'];
		$ag = $_POST['ag'];
		$conta = $_POST['conta'];
		$digito = $_POST['digito'];

		//CHECKS
		$nfDptoAudi = $_POST['nfDptoAudi'];
		$nfObras = $_POST['nfObras'];
		$conferencia = $_POST['conferencia'];

		//CONSORCIO
		$motivoSiscon = $_POST['motivoSiscon'];

		if (!isset($_POST['relSiscon'])) {
			$relSiscon = 'NULL';
		}else{
			$relSiscon = $_POST['relSiscon'];
		}

		if ($_POST['vencRateio'] == '') {
			$vencRateio = 'NULL';
		}else{
			$vencRateio = $_POST['vencRateio'];
		}

		if (!isset($_POST['vencRateioTipo'])) {
			$vencRateioTipo = 'NULL';
		}else{
			$vencRateioTipo = $_POST['vencRateioTipo'];
		}

		$telefone = $_POST['telefone'];


		//UPDATE
		$update = "UPDATE cad_rateiofornecedor
		SET
		ID_USUARIO = $idusuario,
		ID_FILIAL = $filial,
		ID_FORNECEDOR = $idfornecedor,
		ID_TIPOPAGAMENTO = $tipoPgto,
		ID_PERIODICIDADE = $periodicidade,
		ID_TIPODESPESA = $tipoDespesa,
		auditoria = $nfDptoAudi,
		obra = $nfObras,
		necessita_conferencia = $conferencia,
		relatorio_siscon = $relSiscon,
		motivo_siscon = '$motivoSiscon',
		observacao = '$obs',
		vencimento = $vencRateio,
		vencimento_tipo = $vencRateioTipo,
		telefone = '$telefone',
		tipo_serv = '$tipo_serv'
		WHERE ID_RATEIOFORNECEDOR = $IDR;";

		$result = $conn->query($update);


		//INSERT DADOS BANCARIOS
		if ($tipoPgto == 2) {


			$queryCheck = "SELECT ID_RATEIOFORNECEDOR FROM cad_rateiobanco WHERE ID_RATEIOFORNECEDOR = $IDR";
			$resultCheck = $conn->query($queryCheck);
			$row = $resultCheck->fetch_assoc();

			if (isset($row['ID_RATEIOFORNECEDOR'])) {


				$updateBanco = "UPDATE cad_rateiobanco
				SET
				nome_banco = '$banco',
				agencia = '$ag',
				conta = '$conta',
				digito = '$digito'
				WHERE ID_RATEIOFORNECEDOR = $IDR;";

				$result = $conn->query($updateBanco);

			}else{

				$insertBanco = "INSERT INTO cad_rateiobanco (
				ID_RATEIOFORNECEDOR,
				nome_banco,
				agencia,
				conta,
				digito) 

				VALUES 

				($IDR,'$banco','$ag','$conta','$digito')";

				$result = $conn->query($insertBanco);

			}
		}

    	break;












  	//EXCLUIR RATEIO FORNECEDOR
	case 'excluirRateioFornecedor': 


		$id = $_GET['id'];


		$delete1 = "DELETE FROM cad_rateiocentrocusto WHERE ID_RATEIOFORNECEDOR = $id";
		$result = $conn->query($delete1);


       	$queryUlt = "SELECT ID_TIPOPAGAMENTO FROM cad_rateiofornecedor WHERE ID_RATEIOFORNECEDOR = $id";
		$result = $conn->query($queryUlt);
		$row = $result->fetch_assoc();
		$tipopgto = $row['ID_TIPOPAGAMENTO'];


        if ($tipopgto == 2) {
		    $delete2 = "DELETE FROM cad_rateiobanco WHERE ID_RATEIOFORNECEDOR = $id";
			$result = $conn->query($delete2);
        }

        $delete3 = "DELETE FROM cad_rateiofornecedor WHERE ID_RATEIOFORNECEDOR = $id";
		$result = $conn->query($delete3);

		$conn->close();

		header('location: ../front/rateioFornecedor.php?msn=1');

	    break;











  	//LISTAR RATEIO FORNECEDOR
	case 'listarRateioFornecedor': 

		$queryFornecs = "SELECT RATFOR.ID_RATEIOFORNECEDOR AS ID,
			LOG.nome AS USUARIO,
			FN.CPF_CNPJ AS CNPJ,
			FIL.nome as FILIAL,
			FN.nome_fornecedor AS NOME,
			DESP.nome AS DESPESA,
			RATFOR.observacao AS OBSERVACAO,
			PGT.nome AS TIPOPGTO,
			RATFOR.auditoria AS AUDITORIA,
			RATFOR.obra AS OBRA,
			RATFOR.necessita_conferencia AS CONFERENCIA 
			FROM dbnotas.cad_rateiofornecedor RATFOR 
			INNER JOIN dbnotas.cad_login LOG ON LOG.ID_USUARIO = RATFOR.ID_USUARIO
			INNER JOIN dbnotas.cad_periodicidade DESP ON DESP.ID_PERIODICIDADE = RATFOR.ID_PERIODICIDADE
			INNER JOIN dbnotas.cad_tipopagamento PGT ON PGT.ID_TIPOPAGAMENTO = RATFOR.ID_TIPOPAGAMENTO
			INNER JOIN dbnotas.cad_fornecedor FN ON FN.ID_FORNECEDOR = RATFOR.ID_FORNECEDOR
			INNER JOIN dbnotas.cad_filial FIL ON FIL.ID_FILIAL = RATFOR.ID_FILIAL;";

	    $result = $conn->query($queryFornecs);

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

	      if ($row['CONFERENCIA'] == 1) {
	        $conffluig = "Sim";
	      }else{
	        $conffluig = "Não";
	      }

	      if (strlen($row['CNPJ']) > 11) {
	        $cpfcnpj = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $row['CNPJ']);
	      }else{
	        $cpfcnpj = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $row['CNPJ']);
	      }

	      $fonecs[] = array(
	      $row['ID'],
	      $row['USUARIO'],
	      $row['FILIAL'],
	      $row['NOME'],
	      $cpfcnpj,
	      $row['DESPESA'],
	      $row['OBSERVACAO'],
	      $row['TIPOPGTO'],
	      $audit,
	      $obra,
	      $conffluig,
	      "<div style='display: inline-flex;'><a href='rateioFornecedorEdit.php?idrateiofornecedor=".$row['ID']."' class='btn btn-info btn-circle btn-sm'><i class='fas fa-edit'></i></a>
	      <a style='margin-left: 10px;' href='#' class='btn btn-danger btn-circle btn-sm' data-toggle='modal' data-target='#modalDeleteRateioFornecedor".$row['ID']."'><i class='fas fa-trash'></i></a></div>


	              <!-- Modal Delete Rateio Fornecedor-->
	              <div class='modal fade' id='modalDeleteRateioFornecedor".$row['ID']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	                <div class='modal-dialog' role='document'>
	                  <div class='modal-content'>
	                    <form id='excluirRateioFornecedor".$row['ID']."' method='POST' action='../fun/funRateioFornecedor.php?fun=excluirRateioFornecedor&id=" . $row['ID'] . "'>
	                      <div class='modal-header'>
	                        <h5 class='modal-title' id='exampleModalLabel'>Tem certeza que deseja remover este Rateio Fornecedor?</h5>
	                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
	                          <span aria-hidden='true'>&times;</span>
	                        </button>
	                      </div>
	                      <div class='modal-footer'>
	                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
	                        <button type='submit' class='btn btn-danger'>Remover Rateio Fornecedor</button>
	                      </div>
	                    </form> 
	                  </div>
	                </div>
	              </div>"
	      );
	    }

	    echo json_encode($fonecs);

    	break;






	//VALIDA RATEIO FORNECEDOR
    case "checkduplicidade":

		$idfornecedor = $_POST['idfornecedor'];
		$filial = $_POST['idfilial'];
		$tipo_serv = $_POST['tipo_serv'];

		$query = "SELECT * FROM cad_rateiofornecedor WHERE ID_FORNECEDOR = $idfornecedor AND ID_FILIAL = $filial AND tipo_serv = '$tipo_serv' ;";
    	$result = $conn->query($query);

    	$row = $result->fetch_assoc();

    	if (isset($row['ID_RATEIOFORNECEDOR'])) {
    		echo "duplicado";
    	}else{
    		echo "ok";
    	}

        $conn->close();

        break;



}


?>