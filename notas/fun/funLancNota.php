<?php
session_start();
require_once('../conf/conexao.php');


switch ($_GET["fun"]) {


	/////////////////////////////////////////         INSERT NOTA          ///////////////////////////////////

    case "novanota":


		//DADOS PRINCIPAIS
		$idusuario = $_POST['IDuserLanc'];
		$cnpjfornecedor = $_POST['cnpjfornecedor2'];
		$idfornecedor = $_POST['idfornecedor'];
		$idrateiofornecedor = $_POST['idrateiofornecedor'];
		$filialLanc = $_POST['filialNota'];
		$periodicidadeLanc = $_POST['periodicidade'];
		$obsLanc = $_POST['obs'];
		$tipoDespesaLanc = $_POST['tipoDespesa'];
		$carimbo = $_POST['carimbo'];//Bruno nº chamado
		$tipo_serv = $_POST['tipo_serv'];
		$dataCriacao = date('Y-m-d');//Felipe, 11/11/2021


		//DADOS PGTO
		$tipoPgtoLanc = $_POST['tipoPgto'];
		$banco = $_POST['banco'];
		$ag = $_POST['ag'];
		$conta = $_POST['conta'];
		$digito = $_POST['digito'];

		//CHECKS
		$nfDptoAudiLanc = $_POST['nfDptoAudi'];
		$nfObrasLanc = $_POST['nfObras'];

		//CONSORCIO
		$motivoSisconLanc = $_POST['motivoSiscon'];

		if (!isset($_POST['relSiscon'])) {
			$relSisconLanc = 'NULL';
		}else{
			$relSisconLanc = $_POST['relSiscon'];
		}

		//RATEIO
		$rateio = $_SESSION["dadosrateio"];

		//NOTA
		$numeroNota = $_POST['numeroNota'];
		$serieNota = $_POST['serieNota'];
		$emissaoNota = $_POST['emissaoNota'];
		$vencNota = $_POST['vencNota'];
		$valorNota = $_POST['valorNota'];



		if ($vencNota == '') {
			$vencNota = '00/00/0000';
		}else{
			$vencimento=date_create($vencNota);
			$vencNota = date_format($vencimento,"d/m/Y");
		}


		$emissao=date_create($emissaoNota);
		$emissaoNota = date_format($emissao,"d/m/Y");



		//NOS CASOS DE NOTA AVULSA
		$queryFORN = "SELECT CPF_CNPJ FROM cad_fornecedor WHERE ID_FORNECEDOR = $idfornecedor";
		$resultFORN = $conn->query($queryFORN);
		$rowFORN = $resultFORN->fetch_assoc();
		$cnpjfornecedorAvulsa = $rowFORN['CPF_CNPJ'];


		if ($cnpjfornecedor == '') {
			$cnpjfornecedor = $cnpjfornecedorAvulsa;
		}

		if ($carimbo == '') {
			$carimbo = 0;
		}


		$telefone = $_POST['telefone'];

		//Bruno nº chamado adicionado o carimbo
		$insert = "INSERT INTO cad_lancarnotas (
		ID_FILIAL,
		ID_USUARIO,
		ID_TIPODESPESA,
		ID_TIPOPAGAMENTO,
		ID_PERIODICIDADE,
		CNPJ,
		auditoria,
		obra,
		relatorio_siscon,
		motivo_siscon,
		observacao,
		numero_nota,
		serie_nota,
		emissao,
		vencimento,
		valor_nota,
		telefone,
		status_desc,
		carimbar,
		date_create,
        tipo_serv) 

		VALUES 

		($filialLanc,$idusuario,$tipoDespesaLanc,$tipoPgtoLanc,$periodicidadeLanc,'$cnpjfornecedor',$nfDptoAudiLanc,
		$nfObrasLanc,$relSisconLanc,'$motivoSisconLanc','$obsLanc','$numeroNota','$serieNota','$emissaoNota','$vencNota',$valorNota,'$telefone',1,$carimbo,'$dataCriacao', '$tipo_serv')";//Bruno nº chamado 
		$result = $conn->query($insert);
		//echo $insert;
		//exit();

		//SELECT buscando a ultima nota inserida pelo usuario x
		$queryUlt = "SELECT ID_LANCARNOTAS FROM cad_lancarnotas WHERE ID_USUARIO = $idusuario ORDER BY ID_LANCARNOTAS DESC";
		$result = $conn->query($queryUlt);
		$row = $result->fetch_assoc();
		$idlancnota = $row['ID_LANCARNOTAS'];

		//INSERT DADOS BANCARIOS
		if ($tipoPgtoLanc == 2) {


			$queryCheck = "SELECT ID_RATEIOFORNECEDOR FROM cad_rateiobanco WHERE ID_RATEIOFORNECEDOR = $idrateiofornecedor";
			$resultCheck = $conn->query($queryCheck);
			$row = $resultCheck->fetch_assoc();

			if (isset($row['ID_RATEIOFORNECEDOR'])) {


				$updateBanco = "UPDATE cad_rateiobanco
				SET
				nome_banco = '$banco',
				agencia = '$ag',
				conta = '$conta',
				digito = '$digito'
				WHERE ID_RATEIOFORNECEDOR = $idrateiofornecedor;";

				$result = $conn->query($updateBanco);

			}else{

				$insertBanco = "INSERT INTO cad_rateiobanco (
				ID_RATEIOFORNECEDOR,
				nome_banco,
				agencia,
				conta,
				digito) 

				VALUES 

				($idrateiofornecedor,'$banco','$ag','$conta','$digito')";

				$result = $conn->query($insertBanco);

			}

		}


		//INSERT RATEIOS
		if ($idrateiofornecedor != '') {

			foreach ($rateio as $key => $value) {

				$queryUlt = "SELECT ID_CENTROCUSTO, percentual FROM cad_rateiocentrocusto WHERE ID_RATEIOCENTROCUSTO = $key";
				$result = $conn->query($queryUlt);
				$row = $result->fetch_assoc();

				$id_CC = $row['ID_CENTROCUSTO'];
				$percentual = $row['percentual'];
				$valorRateio = $value;


				$insertRateioNota = "INSERT INTO cad_lancarnotas_centrocusto
				(ID_LANCARNOTAS,
				ID_CENTROCUSTO,
				valor,
				percentual)
				VALUES
				($idlancnota,
				$id_CC,
				$valorRateio,
				$percentual);";

				//echo $insertRateioNota;

				$result = $conn->query($insertRateioNota);
			    
			}

		}

		$nomearquivo = $idlancnota.'_'.$cnpjfornecedor;

		include 'upload.php';
		sleep(3);
		header('location: ../index.php?msn=2');

        break;






  	////////////////////////////////////////////      EDITAR NOTA    ///////////////////////////////////////

	case 'editarnota': 

		$IDnota = $_POST['idnota'];

		//DADOS PRINCIPAIS
		$idusuario = $_POST['idusuario'];
		$cnpjfornecedor = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_POST['cnpjfornecedor'])));
		$idrateiofornecedor = $_POST['idrateiofornecedor'];
		$filialEdit = $_POST['filialEdit'];
		$periodicidadeEdit = $_POST['periodicidadeEdit'];
		$obsEdit = $_POST['obsEdit'];
		$tipoDespesaEdit = $_POST['tipoDespesaEdit'];
		$tipo_serv = $_POST['tipo_serv'];

		//DADOS PGTO
		$tipoPgtoEdit = $_POST['tipoPgtoEdit'];
		$banco = $_POST['bancoEdit'];
		$ag = $_POST['agEdit'];
		$conta = $_POST['contaEdit'];
		$digito = $_POST['digitoEdit'];

		//CHECKS
		$nfDptoAudiEdit = $_POST['nfDptoAudiEdit'];
		$nfObrasEdit = $_POST['nfObrasEdit'];

		//CONSORCIO
		$motivoSisconEdit = $_POST['motivoSisconEdit'];

		if (!isset($_POST['relSisconEdit'])) {
			$relSisconEdit = 'NULL';
		}else{
			$relSisconEdit = $_POST['relSisconEdit'];
		}

		//NOTA
		$numeroNota = $_POST['numeroNotaEdit'];
		$serieNota = $_POST['serieNotaEdit'];
		$emissaoNota = $_POST['emissaoNotaEdit'];
		$vencNota = $_POST['vencNotaEdit'];
		$valorNota = $_POST['valorNotaEdit'];
	

		//RATEIO
		$rateio = $_POST['dados'];

		$emissao=date_create($emissaoNota);
		$emissaoNota = date_format($emissao,"d/m/Y");


		if ($vencNota == '') {
			$vencNota = '00/00/0000';
		}else{
			$vencimento=date_create($vencNota);
			$vencNota = date_format($vencimento,"d/m/Y");
		}

		$telefone = $_POST['telefone'];
		$carimbo = $_POST['carimbo'];


		// UPDATE NOTA
		$update = "UPDATE cad_lancarnotas
		SET
		ID_USUARIO = $idusuario,
		CNPJ = '$cnpjfornecedor',
		ID_FILIAL = $filialEdit,
		ID_TIPODESPESA = $tipoDespesaEdit,
		ID_TIPOPAGAMENTO = $tipoPgtoEdit,
		ID_PERIODICIDADE = $periodicidadeEdit,
		auditoria = $nfDptoAudiEdit,
		obra = $nfObrasEdit,
		relatorio_siscon = $relSisconEdit,
		motivo_siscon = '$motivoSisconEdit',
		observacao = '$obsEdit',
		numero_nota = '$numeroNota',
		serie_nota = '$serieNota',
		emissao = '$emissaoNota',
		vencimento = '$vencNota',
		valor_nota = $valorNota,
		telefone = '$telefone',
		carimbar = $carimbo,
		tipo_serv = '$tipo_serv'

		WHERE ID_LANCARNOTAS = $IDnota;";

		$result = $conn->query($update);

		//echo $update;
		//exit();


		//INSERT DADOS BANCARIOS
		if ($tipoPgtoEdit == 2) {


			$queryCheck = "SELECT ID_RATEIOFORNECEDOR FROM cad_rateiobanco WHERE ID_RATEIOFORNECEDOR = $idrateiofornecedor";
			$resultCheck = $conn->query($queryCheck);
			$row = $resultCheck->fetch_assoc();

			if (isset($row['ID_RATEIOFORNECEDOR'])) {


				$updateBanco = "UPDATE cad_rateiobanco
				SET
				nome_banco = '$banco',
				agencia = '$ag',
				conta = '$conta',
				digito = '$digito'
				WHERE ID_RATEIOFORNECEDOR = $idrateiofornecedor;";

				$result = $conn->query($updateBanco);

			}else{

				$insertBanco = "INSERT INTO cad_rateiobanco (
				ID_RATEIOFORNECEDOR,
				nome_banco,
				agencia,
				conta,
				digito) 

				VALUES 

				($idrateiofornecedor,'$banco','$ag','$conta','$digito')";

				$result = $conn->query($insertBanco);

			}
		}


		$checkValor = "SELECT SUM(valor) AS VALORNOTA_CC FROM cad_lancarnotas_centrocusto WHERE ID_LANCARNOTAS = $IDnota";
		$result2 = $conn->query($checkValor);
		$row2 = $result2->fetch_assoc();


		if ($row2['VALORNOTA_CC'] != $valorNota) {

			$queryDelete = "DELETE FROM cad_lancarnotas_centrocusto WHERE ID_LANCARNOTAS = $IDnota";
			$resultDelete = $conn->query($queryDelete);

			//UPDATE RATEIOS
			foreach ($rateio as $key => $value) {

				$queryUlt = "SELECT ID_CENTROCUSTO, percentual FROM cad_rateiocentrocusto WHERE ID_RATEIOCENTROCUSTO = $key";
				$result = $conn->query($queryUlt);
				$row = $result->fetch_assoc();

				$id_CC = $row['ID_CENTROCUSTO'];
				$percentual = $row['percentual'];
				$valorRateio = $value;


				$insertRateioNota = "INSERT INTO cad_lancarnotas_centrocusto
				(ID_LANCARNOTAS,
				ID_CENTROCUSTO,
				valor,
				percentual)
				VALUES
				($IDnota,
				$id_CC,
				$valorRateio,
				$percentual);";

				//echo $insertRateioNota;

				$result = $conn->query($insertRateioNota);
		    
			}

		}

		$conn->close();

		echo $IDnota.'_'.$cnpjfornecedor;
		   
    	break;






  	////////////////////////////////////////////      EXCLUIR NOTA    ///////////////////////////////////////







    case "excluirnota":

		$idnota = $_GET['idnota'];

		$delete1 = "DELETE FROM cad_lancarnotas_centrocusto WHERE ID_LANCARNOTAS = $idnota";
		$result = $conn->query($delete1);

		$update = "UPDATE cad_lancarnotas
		SET
		deletar = 1
		WHERE ID_LANCARNOTAS = $idnota;";

		$result = $conn->query($update);

		$conn->close();

		header('location: ../index.php?msn=1');

        break;



    case "alteraStatus":

		$idnota = $_POST['idnota'];

		$update = "UPDATE cad_lancarnotas
		SET
		status_desc = 1
		WHERE ID_LANCARNOTAS = $idnota;";

		$result = $conn->query($update);

		$conn->close();

        break;


    case "funCheckNotaDuplicada":

		$numeroNota = $_POST['numeroNota'];

		$query = "SELECT * FROM cad_lancarnotas WHERE numero_nota = $numeroNota AND deletar = 0;";

        $result = $conn->query($query);

        $row = $result->fetch_assoc();

        if (isset($row['ID_LANCARNOTAS'])) {
            echo 1;
        }else{
            echo 0;
        }
		$conn->close();

        break;

    case "armazenaRateioSessao":

		$_SESSION["dadosrateio"] = $_POST['dadosrateio'];

        break;

}


?>