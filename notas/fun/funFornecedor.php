<?php

require_once('../conf/conexao.php');

switch ($_GET["fun"]) {


	//INSERT FORNECEDOR
  case "novofornecedor":


		$cnpjcpf = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_POST['cpfcnpj'])));
		$nome = $_POST['nomeFornecedor'];

		$querycnpj = "SELECT * FROM cad_fornecedor WHERE CPF_CNPJ = '$cnpjcpf' AND deletar = 0;";
		$resultcnpj = $conn->query($querycnpj);
		$rowcnpj = $resultcnpj->fetch_assoc();

		if (!isset($rowcnpj['ID_FORNECEDOR'])) {
		  $insert = "INSERT INTO cad_fornecedor (CPF_CNPJ,nome_fornecedor,deletar) VALUE ('$cnpjcpf','$nome',0);";
		  $result = $conn->query($insert);


		  $queryfornecedor = "SELECT * FROM cad_fornecedor WHERE CPF_CNPJ = $cnpjcpf AND deletar = 0;";
			$resultfornecedor = $conn->query($queryfornecedor);
			$row = $resultfornecedor->fetch_assoc();

			$idf = $row['ID_FORNECEDOR'];

		  if(isset($_GET['view']) && $_GET['view'] == 'rateio'){
		  	header('location: ../front/rateioFornecedorNovo.php?idf='.$idf.'&nomefornec='.$nome.'&cnpj='.$_POST['cpfcnpj']);
		  }elseif(isset($_GET['view']) && $_GET['view'] == 'rateioedit'){
		  	header('location: ../front/rateioFornecedorEdit.php?idf='.$idf.'&nomefornec='.$nome.'&cnpj='.$_POST['cpfcnpj'].'&idrateiofornecedor='.$_GET['idrateiofornecedor']);
		  }elseif(isset($_GET['view']) && $_GET['view'] == 'nota'){
		  	header('location: ../front/lancarNota.php?idf='.$idf.'&nomefornec='.$nome.'&cnpj='.$_POST['cpfcnpj']);
		  }else{
		  	header('location: ../front/fornecedor.php?msn=2');
		  }

		  $conn->close();
		}else{
			header('location: ../front/fornecedor.php?msn=5');
		}

		break;


  //EDITAR FORNECEDOR
	case 'editarfornecedor': 

		$idfornecedor = $_POST['idfornecedor'];
		$cnpj = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_POST['cnpjEdit'])));
		$nome = $_POST['nomeEdit'];

		$update = "UPDATE cad_fornecedor SET CPF_CNPJ = '$cnpj',
		nome_fornecedor = '$nome'
		WHERE ID_FORNECEDOR = $idfornecedor";

		$result = $conn->query($update);

		header('location: ../front/fornecedor.php?msn=3');

		$conn->close();

		   
    break;

  //EXCLUIR FORNECEDOR
	case 'excluirfornecedor': 

		$idfornecedor = $_GET['id'];
		$update = "UPDATE cad_fornecedor 
		SET deletar = 1 WHERE ID_FORNECEDOR = $idfornecedor";
		$result = $conn->query($update);

		header('location: ../front/fornecedor.php?msn=1');

		$conn->close();

		break;

  //LISTAR FORNECEDORES
	case 'listarfornecedores': 

		$queryfornecedores = "SELECT * FROM cad_fornecedor WHERE deletar = 0;";
  	$result = $conn->query($queryfornecedores);
  	while ( $row = $result->fetch_assoc() ) {

  		if (strlen($row['CPF_CNPJ']) > 11) {
  			$cpfcnpj = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $row['CPF_CNPJ']);
  		}else{
  			$cpfcnpj = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $row['CPF_CNPJ']);
  		}

			$fornecedores[] = array(
			$row['ID_FORNECEDOR'],
			$cpfcnpj,
			$row['nome_fornecedor'],
			"<div style='display: inline-flex;'><a href='#' class='btn btn-info btn-circle btn-sm' data-toggle='modal' data-target='#modalEditFornecedor".$row['ID_FORNECEDOR']."'><i class='fas fa-edit'></i></a><a style='margin-left: 10px;' href='#' class='btn btn-danger btn-circle btn-sm' data-toggle='modal' data-target='#modalDeleteFornecedor".$row['ID_FORNECEDOR']."'><i class='fas fa-trash'></i></a></div>"."


              	<!-- Modal Edit Fornecedor -->
              	<div class='modal fade' id='modalEditFornecedor".$row['ID_FORNECEDOR']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
	                <div class='modal-dialog modal-dialog-centered' role='document'>
	                  <div class='modal-content'>
	                    <form id='editarfornecedor".$row['ID_FORNECEDOR']."' method='POST' action='../fun/funFornecedor.php?fun=editarfornecedor'>
	                      <div class='modal-header'>
	                        <h5 class='modal-title' id='exampleModalLongTitle'>Editar Fornecedor</h5>
	                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
	                          <span aria-hidden='true'>&times;</span>
	                        </button>
	                      </div>
	                      <div class='modal-body'>
	                        <div class='form-group'>
	                          <label for='cnpjEdit'>CNPJ</label>
	                          <input type='text' class='form-control' value='".$cpfcnpj."' name='cnpjEdit' id='cnpjEdit".$row['ID_FORNECEDOR']."' maxlength='18' required>
	                        </div>
	                        <div class='form-group'>
	                          <label for='nomeEdit'>Nome</label>
	                          <input type='text' class='form-control' value='".$row['nome_fornecedor']."' name='nomeEdit' id='nomeEdit".$row['ID_FORNECEDOR']."' required>
	                        </div>
	                        <input type='hidden' class='form-control' value='".$row['ID_FORNECEDOR']."'name='idfornecedor' id='idfornecedor".$row['ID_FORNECEDOR']."'>
	                      </div>
	                      <div class='modal-footer'>
	                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
	                        <input type='submit' class='btn btn-success' name='editFornecedor' value='Salvar' />
	                      </div>
	                    </form>
	                  </div>
	                </div>
	              </div>

<script>

    $('#cnpjEdit".$row['ID_FORNECEDOR']."').on('blur', function(e){


      if ($(this).val().length == 11) {
        $(this).val(
          $(this).val()
          .replace(/\D/g, '')
          .replace(/^(\d{3})(\d{3})?(\d{3})?(\d{2})?/, '$1.$2.$3-$4'));

      }else if ($(this).val().length >= 14) {
        $(this).val(
          $(this).val()
          .replace(/\D/g, '')
          .replace(/^(\d{2})(\d{3})?(\d{3})?(\d{4})?(\d{2})?/, '$1.$2.$3/$4-$5')); 


        if (validarCNPJ($('#cnpjEdit".$row['ID_FORNECEDOR']."').val()) == false && $('#cnpjEdit".$row['ID_FORNECEDOR']."').val() !== '') {
          alert('CNPJ inválido!');
        }

      }

    });

</script>
	              <!-- Modal Delete Fornecedor-->
	              <div class='modal fade' id='modalDeleteFornecedor".$row['ID_FORNECEDOR']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	                <div class='modal-dialog' role='document'>
	                  <div class='modal-content'>
	                    <form id='excluirfornecedor".$row['ID_FORNECEDOR']."' method='POST' action='../fun/funFornecedor.php?fun=excluirfornecedor&id=" . $row['ID_FORNECEDOR'] . "'>
	                      <div class='modal-header'>
	                        <h5 class='modal-title' id='exampleModalLabel'>Tem certeza que deseja remover este Fornecedor?</h5>
	                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
	                          <span aria-hidden='true'>&times;</span>
	                        </button>
	                      </div>
	                      <div class='modal-footer'>
	                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
	                        <button type='submit' class='btn btn-danger'>Remover Fornecedor</button>
	                      </div>
	                    </form> 
	                  </div>
	                </div>
	              </div>");
	  }

		echo json_encode($fornecedores);

    break;



	//VALIDA FORNECEDOR
	case "checkfornecedor":

		$cnpj = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_POST['cnpjFornecedor'])));
		$queryFornecedor = "SELECT * FROM cad_fornecedor WHERE CPF_CNPJ = '$cnpj' AND deletar = 0;";
		$result = $conn->query($queryFornecedor);

		$row = $result->fetch_assoc();

		if (isset($row['CPF_CNPJ'])) {
			echo "duplicado";
		}else{
			echo "ok";
		}

		$conn->close();

		break;
}

?>