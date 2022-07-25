<?php

require_once('../conf/conexao.php');

switch ($_GET['fun']) {

  	//BUSCA USUARIOS
	case 'users':

		$busca = $_GET['term'];

		$queryUsers = "SELECT * FROM cad_login WHERE nome like '%$busca%'";
		$result = $conn->query($queryUsers);

		while ( $row = $result->fetch_assoc() ) {
		    $tpUsers[] = array(
		    'value'    => $row['ID_USUARIO'],
		    'label'  => $row['nome'],
		    );
		}

		echo json_encode( $tpUsers );

    	break;

  	//BUSCA FORNECEDORES
	case 'fornecedores': 

		$busca = $_GET['term'];

		if (is_numeric($busca)==1) {
			$queryFornecedores = "SELECT * FROM cad_fornecedor WHERE CPF_CNPJ like '%$busca%' AND deletar = 0";
		}else{
			$queryFornecedores = "SELECT * FROM cad_fornecedor WHERE nome_fornecedor like '%$busca%' AND deletar = 0";
		}

		$result = $conn->query($queryFornecedores);

		$rowcount = mysqli_num_rows($result);

		if ($rowcount > 0) {
			while ( $row = $result->fetch_assoc() ) {

				if (strlen($row['CPF_CNPJ']) > 11) {
					$cpfcnpj = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $row['CPF_CNPJ']);
				}else{
					$cpfcnpj = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $row['CPF_CNPJ']);
				}
				
			    $fornecedores[] = array(
			    'value'    => $row['ID_FORNECEDOR'],
			    'label'  => $row['nome_fornecedor'].' - '.$cpfcnpj,
			    'desc'  => $cpfcnpj,
			    );
			}
		}else{
			$fornecedores[] = array(
		    'value'    => '000',
		    'label'  => 'Não encontrado - Clique aqui',
		    'desc'  => '-',
		    );
		}

		echo json_encode($fornecedores);

    	break;

  	//BUSCA BANCOS
	case 'bancos': 

		$busca = $_GET['term'];

		$queryBancos = "SELECT * FROM cad_banco WHERE nome like '%$busca%'";
		$result = $conn->query($queryBancos);

		while ( $row = $result->fetch_assoc() ) {

		    $bancos[] = array(
		    'value'    => $row['nome'],
		    'label'  => $row['nome'],
		    );
		}

		echo json_encode($bancos);

    	break;

    //BUSCA FILIAIS
    case "filiais":

    	$busca = $_GET['term'];

        $queryFl = "SELECT * FROM cad_filial WHERE nome like '%$busca%'";

        $result = $conn->query($queryFl);

        while ( $row = $result->fetch_assoc() ) {
            $filiais[] = array(
            'value'    => $row['ID_FILIAL'],
            'label'  => $row['nome'],
            );
        }

        echo json_encode($filiais);

        break;

}

?>