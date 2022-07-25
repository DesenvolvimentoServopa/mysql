<?php

require_once('../conf/conexao.php');

switch ($_GET["fun"]) {


	//INSERT FILIAL
  case "novafilial":


    $cnpj = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_POST['cnpjFilial'])));
    $nome = $_POST['nomeFilial'];
    $nomeFluig = $_POST['nomeFilialFluig'];
    $consorcio = $_POST['checkConsorcio'];

    $querycnpj = "SELECT * FROM cad_filial WHERE cnpj = '$cnpj';";
    $resultcnpj = $conn->query($querycnpj);
		$rowcnpj = $resultcnpj->fetch_assoc();

    if (!isset($rowcnpj['ID_FILIAL'])) {
			$insert = "INSERT INTO cad_filial (cnpj,nome,empresaFluig,consorcio) VALUE ('$cnpj','$nome','$nomeFluig',$consorcio)";
    	$result = $conn->query($insert);
    	header('location: ../front/filial.php?msn=2');
		}else{
    	header('location: ../front/filial.php?msn=5');
		}

    $conn->close();

    break;


  //EDITAR FILIAL
	case 'editarfilial': 

		$idfilial = $_POST['idfilial'];
		$cnpj = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_POST['cnpjEdit'])));
  	$nome = $_POST['nomeEdit'];
  	$nomeFluig = $_POST['empFluigEdit'];
  	$consorcio = $_POST['checkConsorcioEdit'.$idfilial];

    $update = "UPDATE cad_filial SET cnpj = '$cnpj',
    nome = '$nome',
    empresaFluig = '$nomeFluig',
    consorcio = $consorcio WHERE ID_FILIAL = $idfilial";


    $result = $conn->query($update);

    header('location: ../front/filial.php?msn=3');

		$conn->close();

		   
    break;



  //EXCLUIR FILIAL
	case 'excluirfilial': 

		$idfilial = $_GET['id'];

    $queryDp = "SELECT * FROM cad_centrocusto WHERE ID_FILIAL = $idfilial AND deletar = 0;";
    $resultDp = $conn->query($queryDp);
		$row = $resultDp->fetch_assoc();

    if (isset($row['ID_CENTROCUSTO'])) {
    	header('location: ../front/filial.php?msn=4');
    	$conn->close();
    }else{
	    $delete = "DELETE FROM cad_filial WHERE ID_FILIAL = $idfilial";
			$result = $conn->query($delete);
			header('location: ../front/filial.php?msn=1');
			$conn->close();
    }

	  break;


  //LISTAR FILIAIS
	case 'listarFiliais': 

		$queryFiliais = "SELECT * FROM cad_filial;";

    	$result = $conn->query($queryFiliais);

    	while ( $row = $result->fetch_assoc() ) {

    		if ($row['consorcio'] == 1) {
				$consorcio = "Sim";
			}else{
				$consorcio = "Não";
			}

			$filiais[] = array(
			$row['ID_FILIAL'],
			preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $row['cnpj']),
			$row['nome'],
			$row['empresaFluig'],
			$consorcio,
			"<div style='display: inline-flex;'><a href='#' class='btn btn-info btn-circle btn-sm' data-toggle='modal' data-target='#modalEditFilial".$row['ID_FILIAL']."'><i class='fas fa-edit'></i></a><a style='margin-left: 10px;' href='#' class='btn btn-danger btn-circle btn-sm' data-toggle='modal' data-target='#modalDeleteFilial".$row['ID_FILIAL']."'><i class='fas fa-trash'></i></a></div>"."


              	<!-- Modal Edit Filial -->
              	<div class='modal fade' id='modalEditFilial".$row['ID_FILIAL']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
	                <div class='modal-dialog modal-dialog-centered' role='document'>
	                  <div class='modal-content'>
	                    <form id='editarfilial".$row['ID_FILIAL']."' method='POST' action='../fun/funFilial.php?fun=editarfilial'>
	                      <div class='modal-header'>
	                        <h5 class='modal-title' id='exampleModalLongTitle'>Editar Filial</h5>
	                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
	                          <span aria-hidden='true'>&times;</span>
	                        </button>
	                      </div>
	                      <div class='modal-body'>
	                        <div class='form-group'>
	                          <label for='cnpjEdit'>CNPJ</label>
	                          <input type='text' class='form-control' value='".$row['cnpj']."' name='cnpjEdit' id='cnpjEdit".$row['ID_FILIAL']."' maxlength='18' required>
	                        </div>
	                        <div class='form-group'>
	                          <label for='nomeEdit'>Nome</label>
	                          <input type='text' class='form-control' value='".$row['nome']."' name='nomeEdit' id='nomeEdit".$row['ID_FILIAL']."' required>
	                        </div>
	                        <div class='form-group'>
	                          <label for='empFluigEdit'>Empresa Fluig</label>
	                          <input type='text' class='form-control' value='".$row['empresaFluig']."' name='empFluigEdit' id='empFluigEdit".$row['ID_FILIAL']."' required>
	                        </div>
	                        <input type='hidden' class='form-control' value='".$row['ID_FILIAL']."'name='idfilial' id='idfilial".$row['ID_FILIAL']."'>
	                        <div class='form-group'>
		                      <label for='checkConsorcioEdit".$row['ID_FILIAL']."'>É consórcio?</label>
		                      <div class='form-check'>
		                        <input class='form-check-input' type='radio' name='checkConsorcioEdit".$row['ID_FILIAL']."' id='exampleRadios11' value='1'>
		                        <label class='form-check-label' for='exampleRadios11'>
		                          Sim
		                        </label>
		                      </div>
		                      <div class='form-check'>
		                        <input class='form-check-input' type='radio' name='checkConsorcioEdit".$row['ID_FILIAL']."' id='exampleRadios22' value='0'>
		                        <label class='form-check-label' for='exampleRadios22'>
		                          Não
		                        </label>
		                      </div>
	                    	</div>
	                      </div>
	                      <div class='modal-footer'>
	                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
	                        <input type='submit' class='btn btn-success' name='editFilial' value='Salvar' />
	                      </div>
	                    </form>
	                  </div>
	                </div>
	              </div>".

	              "<script>
	              $('input[name=checkConsorcioEdit".$row['ID_FILIAL']."][value=' + ".$row['consorcio']." + ']').prop('checked', true);


    $('#cnpjEdit".$row['ID_FILIAL']."').on('blur', function(e){

      $(this).val(
          $(this).val()
          .replace(/\D/g, '')
          .replace(/^(\d{2})(\d{3})?(\d{3})?(\d{4})?(\d{2})?/, '$1.$2.$3/$4-$5'));

      if (validarCNPJ($('#cnpjEdit".$row['ID_FILIAL']."').val()) == false && $('#cnpjEdit".$row['ID_FILIAL']."').val() !== '') {
        alert('CNPJ inválido!');
      }
      
    });

	              </script>".

	              "<!-- Modal Delete Filial-->
	              <div class='modal fade' id='modalDeleteFilial".$row['ID_FILIAL']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	                <div class='modal-dialog' role='document'>
	                  <div class='modal-content'>
	                    <form id='excluirfilial".$row['ID_FILIAL']."' method='POST' action='../fun/funFilial.php?fun=excluirfilial&id=" . $row['ID_FILIAL'] . "'>
	                      <div class='modal-header'>
	                        <h5 class='modal-title' id='exampleModalLabel'>Tem certeza que deseja remover esta Filial?</h5>
	                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
	                          <span aria-hidden='true'>&times;</span>
	                        </button>
	                      </div>
	                      <div class='modal-footer'>
	                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
	                        <button type='submit' class='btn btn-danger'>Remover Filial</button>
	                      </div>
	                    </form> 
	                  </div>
	                </div>
	              </div>");
	    }

		echo json_encode($filiais);

    break;



	//VALIDA FILIAL
  case "checkfilial":

		$cnpj = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_POST['cnpjFilial'])));
		$queryFiliais = "SELECT * FROM cad_filial WHERE cnpj = '$cnpj';";
		$result = $conn->query($queryFiliais);

		$row = $result->fetch_assoc();

		if (isset($row['cnpj'])) {
			echo "duplicado";
		}else{
			echo "ok";
		}

    $conn->close();

    break;
}

?>