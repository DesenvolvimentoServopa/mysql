<?php
session_start();

require_once('../conf/conexao.php');

switch ($_GET["fun"]) {
	
	//INSERT WORKFLOW
    case "novoworkflow":

		
        $cnpj = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_POST['cnpjWorkflow'])));
        $nome = $_POST['nomeWorkflow'];
        $id_workflow = $_POST['idWorkflow'];
		
		
		$query = "INSERT INTO cad_workflow (CNPJ,nome,id_workflow,id_user) VALUE ('$cnpj','$nome','$id_workflow','$ID');";
			$result = $conn->query($query);
			$query = "SELECT * FROM cad_workflow ORDER BY ID DESC ";
			$result = $conn->query($query);
			$row = $result->fetch_assoc();
			$ultimo_id = $row['ID'];

		foreach($_POST['id_user'] AS $ID){
			
			 $query = "INSERT INTO workflow_user (id_user, id_workflow) VALUES ('$ID','$ultimo_id'); ";
			 $result = $conn->query($query);
			
		}
		
         header('location: ../front/workflow.php?msn=2');
         $conn->close();

         break;
	

  	//EDITAR WORKFLOW
	case 'editarworkflow': 

		$idw = $_GET['idw'];
		$cnpj = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_POST['cnpjEdit'])));
	  	$nome = $_POST['workflowEdit'];
	  	$id_workflow = $_POST['id_workflow'];

		
		$update = "UPDATE cad_workflow SET CNPJ = '$cnpj', nome = '$nome', id_workflow = '$id_workflow' WHERE id = $idw";
	    $result = $conn->query($update);
		
		
		

	    header('location: ../front/workflow.php?msn=3');

		$conn->close();

		   
    	break;

  	//EXCLUIR WORKFLOW
	case 'excluirworkflow': 

		$idw = $_GET['id'];
		$id_user = $_GET['id_user'];
		$id_workflow = $_GET['idwf'];
		


	    $delete = "DELETE FROM cad_workflow WHERE id_workflow = $id_workflow";
		$result = $conn->query($delete);
		$delete = "DELETE FROM workflow_user WHERE id_workflow = $idw";
		$result = $conn->query($delete);
		header('location: ../front/workflow.php?msn=1');
		$conn->close();

	    break;

		
		//LISTAR WORKFLOWS
	case 'listarworkflows':
		
		$idusuario = $_SESSION['iduser'];
		
		

		$queryWorkflows = "SELECT DISTINCT
		cw.id AS ID, 
		cw.CNPJ, 
		cw.nome AS workflow, 
		cw.id_workflow AS IDWFDOPORTAL
		FROM cad_workflow cw
		LEFT JOIN cad_login cl ON (cw.id = cl.ID_USUARIO)
        LEFT JOIN workflow_user wu ON (wu.id_workflow = cw.id)"; 
				
		if($_SESSION["admin"] == 0){
			$queryWorkflows.= "WHERE wu.id_user = ".$_SESSION["iduser"]." ;";
			
		}
			
    	$result = $conn->query($queryWorkflows);
		

		//me exclua
		$cont = 0;


    	while ( $row = $result->fetch_assoc() ) {

			
			$workflows[] = array(
			$row['ID'],
			preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $row['CNPJ']),
			$row['IDWFDOPORTAL'],
			$row['workflow'],
			
			"<div style='display: inline-flex;'>
				<a href='#' class='btn btn-info btn-circle btn-sm' data-toggle='modal' data-target='#modalEditWorkflow".$row['ID']."'>
					<i class='fas fa-edit'></i>
				</a>
				<a style='margin-left: 10px;' href='#' class='btn btn-danger btn-circle btn-sm' data-toggle='modal' data-target='#modalDeleteWorkflow".$row['ID']."'>
				<i class='fas fa-trash'></i>
				</a>
			</div>".		
			
			"<!-- Modal Edit Workflow -->
              	<div class='modal fade' id='modalEditWorkflow".$row['ID']."' tabindex='-1' role='dialog' 
				  aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
	                <div class='modal-dialog modal-dialog-centered' role='document'>
	                  <div class='modal-content'>
	                    <form id='editarworkflow".$row['ID']."' method='POST' action='../fun/funWorkflow.php?fun=editarworkflow&idw=".$row['ID']."&idwf1=".$row['IDWFDOPORTAL']."'>
	                      <div class='modal-header'>
	                        <h5 class='modal-title' id='exampleModalLongTitle'>Editar Workflow</h5>
	                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
	                          <span aria-hidden='true'>&times;</span>
	                        </button>
	                      </div>
	                      <div class='modal-body'>
	                        <div class='form-group'>
	                          <label for='cnpjEdit'>CNPJ</label>
	                          <input type='text' class='form-control' onkeypress='$(this).mask('00.000.000/0000-00')' value='".$row['CNPJ']."' name='cnpjEdit' id='cnpjEdit".$row['ID']."' maxlength='18'>
	                        </div>
	                        <div class='form-group'>
	                          <label for='workflowEdit'>Nome Workflow</label>
	                          <input type='text' class='form-control' value='".$row['workflow']."' name='workflowEdit' id='workflowEdit".$row['ID']."'>
	                        </div>
	                        <div class='form-group'>
	                          <label for='id_workflow'>ID WF DO PORTAL</label>
	                          <input type='text' class='form-control' value='".$row['IDWFDOPORTAL']."' name='id_workflow' id='id_workflow".$row['ID']."'>
	                        </div>
	                        <input type='hidden' class='form-control' value='".$row['ID']."'name='idw' id='idw".$row['ID']."'><br>
							
								<a href='#'><button onclick = 'abreJ".$row['ID']."()' type='button' class='btn btn-primary'>Alterar Usuário</button></a>
								<div class='modal-footer'>
											<button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
											<input type='submit' class='btn btn-success' name='newWorkflow' value='Salvar' />
										</div>
								</div>
							</div>
	                    </form>
	                  </div>
	                </div>
	        	</div>".


	              "<!-- Modal Delete Workflow-->
	              <div class='modal fade' id='modalDeleteWorkflow".$row['ID']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	                <div class='modal-dialog modal-dialog-centered' role='document'>
	                  <div class='modal-content'>
	                    <form id='excluirworkflow".$row['ID']."&".$row['IDWFDOPORTAL']."' method='POST' action='../fun/funWorkflow.php?fun=excluirworkflow&id=".$row['ID']."&idwf=".$row['IDWFDOPORTAL']."'>
	                      <div class='modal-header'>
	                        <h5 class='modal-title' id='exampleModalLabel'>Tem certeza que deseja remover este Workflow?</h5>
	                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
	                          <span aria-hidden='true'>&times;</span>
	                        </button>
	                      </div>
	                      <div class='modal-footer'>
	                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
	                        <button type='submit' class='btn btn-danger'>Remover Workflow</button>
	                      </div>
	                    </form> 
	                  </div>
	                </div>
				  </did>" .

							

				  "<script>
					
				  $('#cnpjEdit".$row['ID']."').on('keyup', function(e){
					 $(this).val(
						 $(this).val()
						 .replace(/\D/g, '')
						 .replace(/^(\d{2})(\d{3})?(\d{3})?(\d{4})?(\d{2})?/, '$1.$2.$3/$4-$5'));
					 });

					 function abreJ".$row['ID']."(){
						var minhaJanela = window.open('../front/User_confirm.php?id_workflow=".$row['IDWFDOPORTAL']."&cnpj=".$row['CNPJ']."&WF=".$row['workflow']."&idwf=".$row['ID']."','_blank','width=600, height=600, left=300');
			
					};

					$('#cnpjEdit').keypress(function() {
						$(this).mask('00.000.000/0000-00');
					
					});

					 
				</script>"
				
		);
	}

		echo json_encode($workflows);

    	break;
}

?>