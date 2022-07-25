<?php
require_once('../conf/conexao.php');

switch ($_GET['fun']) {

	case 'adicionar':

		switch ($_GET['tipo']) {

		    case '1': //Centro de Custo

		    	$nomeDpto = $_POST['nome'];
		    	$filial = $_POST['filial'];

		        $insert = "INSERT INTO cad_centrocusto (descDpto,id_filial,deletar) 
		        VALUE ('$nomeDpto',$filial, 0)";
		        $result = $conn->query($insert);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=2');

				$conn->close();

		        break;

		    case '2': //Tipo Despesa

		    	$nome = $_POST['nome'];

		        $insert = "INSERT INTO cad_tipodespesa (nome,deletar) VALUE ('$nome',0)";
		        $result = $conn->query($insert);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=2');

				$conn->close();

		        break;

		    case '3': //Tipo Pagamento

		    	$nome = $_POST['nome'];

		        $insert = "INSERT INTO cad_tipopagamento (nome,deletar) VALUE ('$nome',0)";
		        $result = $conn->query($insert);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=2');

				$conn->close();

		        break;

		    case '4': //Periodicidade

		    	$nome = $_POST['nome'];

		        $insert = "INSERT INTO cad_periodicidade (nome,deletar) VALUE ('$nome',0)";
		        $result = $conn->query($insert);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=2');

				$conn->close();

		        break;

		    case '5': //Status

		    	$nome = $_POST['nome'];
		    	$erro = $_POST['checkErro'];

		        $insert = "INSERT INTO cad_status (nome,deletar,erro) VALUE ('$nome',0,$erro)";
		        $result = $conn->query($insert);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=2');

				$conn->close();

		        break;

		    case '6': //Bancos

		    	$nome = $_POST['nome'];

		        $insert = "INSERT INTO cad_banco (nome,deletar) VALUE ('$nome',0)";
		        $result = $conn->query($insert);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=2');

				$conn->close();

		        break;

		}

    	break;

	case 'editar': 

		switch ($_GET['tipo']) {

		    case '1': //Centro de Custo

				$idDpto = $_GET['id'];
				$nomeDpto = $_POST['nome'];
				$filial = $_POST['filialEdit'.$idDpto];

		        $update = "UPDATE cad_centrocusto 
		        SET descDpto = '$nomeDpto', ID_FILIAL = $filial WHERE ID_CENTROCUSTO = $idDpto";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=3');

				$conn->close();

		        break;

		    case '2': //Tipo Despesa

				$id = $_GET['id'];
				$nome = $_POST['nome'];

		        $update = "UPDATE cad_tipodespesa SET nome = '$nome' WHERE ID_TIPODESPESA = $id";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=3');

				$conn->close();

		        break;

		    case '3': //Tipo Pagamento

				$id = $_GET['id'];
				$nome = $_POST['nome'];

		        $update = "UPDATE cad_tipopagamento SET nome = '$nome' WHERE ID_TIPOPAGAMENTO = $id";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=3');

				$conn->close();

		        break;

		    case '4': //Periodicidade

				$id = $_GET['id'];
				$nome = $_POST['nome'];

		        $update = "UPDATE cad_periodicidade SET nome = '$nome' WHERE ID_PERIODICIDADE = $id";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=3');

				$conn->close();

		        break;

		    case '5': //Status

				$id = $_GET['id'];
				$nome = $_POST['nome'];
		    	$erro = $_POST['checkErro'];

		        $update = "UPDATE cad_status SET nome = '$nome', erro = $erro WHERE ID_STATUS = $id";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=3');

				$conn->close();

		        break;

		    case '6': //Status

				$id = $_GET['id'];
				$nome = $_POST['nome'];

		        $update = "UPDATE cad_banco SET nome = '$nome' WHERE ID_BANCO = $id";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=3');

				$conn->close();

		        break;		        

		}

    	break;

	case 'excluir': 

		switch ($_GET['tipo']) {

		    case '1': //Centro de Custo

				$idDpto = $_GET['id'];

		        $update = "UPDATE cad_centrocusto 
		        SET deletar = 1 WHERE ID_CENTROCUSTO = $idDpto";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=1');

				$conn->close();

		        break;

		    case '2': //Tipo Despesa

				$id = $_GET['id'];

		        $update = "UPDATE cad_tipodespesa 
		        SET deletar = 1 WHERE ID_TIPODESPESA = $id";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=1');

				$conn->close();

		        break;

		    case '3': //Tipo Pagamento

				$id = $_GET['id'];

		        $update = "UPDATE cad_tipopagamento 
		        SET deletar = 1 WHERE ID_TIPOPAGAMENTO = $id";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=1');

				$conn->close();

		        break;

		    case '4': //Periodicidade

				$id = $_GET['id'];

		        $update = "UPDATE cad_periodicidade SET deletar = 1 WHERE ID_PERIODICIDADE = $id";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=1');

				$conn->close();

		        break;

		    case '5': //Status

				$id = $_GET['id'];

		        $update = "UPDATE cad_status SET deletar = 1 WHERE ID_STATUS = $id";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=1');

				$conn->close();

		        break;

		    case '6': //Bancos

				$id = $_GET['id'];

		        $update = "UPDATE cad_banco SET deletar = 1 WHERE ID_BANCO = $id";

        		$result = $conn->query($update);

		        header('location: ../front/dropdownlist.php?tipo=' . $_GET['tipo'] . '&msn=1');

				$conn->close();

		        break;

		}

    	break;

}

?>