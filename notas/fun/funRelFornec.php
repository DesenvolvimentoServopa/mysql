<?php
session_start();
require_once('../conf/conexao.php');

$userlogado = $_GET["usuario"];

switch ($_GET['fun']) {



  //EDITAR FORNECEDOR
	case 'editar': 


		   
    break;




  //EXCLUIR FORNECEDOR
	case 'excluir': 



    break;




  //LISTAR FORNECEDORES
	case 'listar': 

    $userlogado = $_GET["usuario"];

		$queryFornecs = "SELECT RATFOR.ID_RATEIOFORNECEDOR AS ID,
 LOG.nome AS USUARIO,
 FN.CPF_CNPJ AS CNPJ,
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
      INNER JOIN dbnotas.cad_filial FIL ON FIL.ID_FILIAL = RATFOR.ID_FILIAL WHERE RATFOR.ID_USUARIO = $userlogado;";

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
			$cpfcnpj,
			$row['NOME'],
			$row['DESPESA'],
      $row['OBSERVACAO'],
      $row['TIPOPGTO'],
      $audit,
      $obra,
      $conffluig
			);
    }

		echo json_encode($fonecs);

    break;


  //LISTAR FORNECEDORES ADM
  case 'listarADM': 

    $queryFornecs = "SELECT RATFOR.ID_RATEIOFORNECEDOR AS ID,
 LOG.nome AS USUARIO,
 FN.CPF_CNPJ AS CNPJ,
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
      $cpfcnpj,
      $row['NOME'],
      $row['DESPESA'],
      $row['OBSERVACAO'],
      $row['TIPOPGTO'],
      $audit,
      $obra,
      $conffluig
      );
    }

    echo json_encode($fonecs);

    break;

}

?>