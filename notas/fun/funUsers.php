<?php
session_start();
require_once('../conf/conexao.php');

switch ($_GET['fun']) {




  //NOVO USER
	case 'novousuario':

  	$nome = $_POST['nome'];
  	$login = $_POST['login'];
  	$cpf = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_POST['cpf'])));
  	$pass = $_POST['pass'];
  	$loginFluig = $_POST['loginFluig'];
  	$passFluig = $_POST['passFluig'];
  	$is_admin = $_POST['tipoAcesso'];

    $insert = "INSERT INTO cad_login (nome,login,CPF,senha,senha_fluig,usuario_fluig,admin) VALUE 
    ('$nome','$login','$cpf','".md5($pass)."','".md5($passFluig)."','$loginFluig',$is_admin)";
    $result = $conn->query($insert);

    header('location: ../front/usuario.php?msn=2');

		$conn->close();

    break;




  //EDITAR USER
	case 'editar': 

	  $iduser = $_POST['iduser'];
  	$nome = $_POST['nomeEdit'.$iduser];
  	$login = $_POST['loginEdit'.$iduser];
  	$cpf = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_POST['cpfEdit'.$iduser])));
  	$pass = $_POST['passEdit'.$iduser];
  	$loginFluig = $_POST['loginFluigEdit'.$iduser];
  	$passFluig = $_POST['passFluigEdit'.$iduser];
  	$is_admin = $_POST['tipoAcessoEdit'.$iduser];

    if ($_POST['espelharRateio'.$iduser] != '') {
      $rateioespelhado = $_POST['espelharRateio'.$iduser];
    }else{
      $rateioespelhado = 0;
    }

    if ($_POST['IDusuarioespelho'.$iduser] != '') {
      $userespelho = $_POST['IDusuarioespelho'.$iduser];
    }else{
      $userespelho = 0;
    }

    $update = "UPDATE cad_login SET nome = '$nome',
    login = '$login',
    CPF = '$cpf',
    senha = '".md5($pass)."',
    senha_fluig = '".$passFluig."',
    usuario_fluig = '$loginFluig',
    admin = $is_admin,
    rateio_espelhado = $rateioespelhado,
    login_espelho = $userespelho
    WHERE ID_USUARIO = $iduser";

    $result = $conn->query($update);

    header('location: ../front/usuario.php?msn=3');

		$conn->close();

		   
    break;




  //EXCLUIR USER
	case 'excluir': 

		$iduser = $_GET['id'];

    $delete = "DELETE FROM cad_login WHERE ID_USUARIO = $iduser";
		$result = $conn->query($delete);

    header('location: ../front/usuario.php?msn=1');
		$conn->close();

    break;




  //LISTAR USERS
	case 'listar': 

		$queryUsers = "SELECT * FROM cad_login;";

    $result = $conn->query($queryUsers);

    while ( $row = $result->fetch_assoc() ) {

    	if ($row['admin'] == 1) {
    		$checked = "checked";
    	}else{
    		$checked = "";
    	}

      if($row["rateio_espelhado"] == 1){
        $checkedespelho = "checked";
      }else{
        $checkedespelho = "";
      }

      if($row["rateio_espelhado"] == 1){

        $iduserespelhado = $row['login_espelho'];

        $queryEspelho = "SELECT nome FROM cad_login WHERE ID_USUARIO = $iduserespelhado";
        $resultEspelho = $conn->query($queryEspelho);
        $rowEspelho = $resultEspelho->fetch_assoc();

        if (isset($rowEspelho['nome'])) {
          $userespelhado = $rowEspelho['nome'];
          $iduserespelhado = $row['login_espelho'];
        }else{
          $userespelhado = "";
          $iduserespelhado = "";
        }
      }else{

        $userespelhado = "";
        $iduserespelhado = "";
      }

      $users[] = array(
      $row['ID_USUARIO'],
      $row['nome'],
			$row['login'],
			preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $row['CPF']),
			$row['usuario_fluig'],
			"<a href='#' class='btn btn-info btn-circle btn-sm' data-toggle='modal' data-target='#modalEditUser".$row['ID_USUARIO']."'><i class='fas fa-edit'></i></a><a style='margin-left: 10px;' href='#' class='btn btn-danger btn-circle btn-sm' data-toggle='modal' data-target='#modalDeleteUser".$row['ID_USUARIO']."'><i class='fas fa-trash'></i></a>"."


              <!-- Modal Edit User -->
              <div class='modal fade' id='modalEditUser".$row['ID_USUARIO']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                  <div class='modal-content'>
                    <form id='editarusuario".$row['ID_USUARIO']."' method='POST' action='../fun/funUsers.php?fun=editar' style='font-size: 14px;'>
                      <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLongTitle'>Editar Usuário</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                      </div>
                      <div class='modal-body'>
                        <div class='form-group'>
                          <label for='nomeEdit'>Nome</label>
                          <input type='text' class='form-control' value='".$row['nome']."' name='nomeEdit".$row['ID_USUARIO']."' id='nomeEdit".$row['ID_USUARIO']."'>
                        </div>
                        <div class='form-group'>
                          <label for='loginEdit'>Login</label>
                          <input type='text' class='form-control' value='".$row['login']."' name='loginEdit".$row['ID_USUARIO']."' id='loginEdit".$row['ID_USUARIO']."'>
                        </div>
                        <div class='form-group'>
                          <label for='cpfEdit'>CPF</label>
                          <input type='text' class='form-control' value='".$row['CPF']."' name='cpfEdit".$row['ID_USUARIO']."' id='cpfEdit".$row['ID_USUARIO']."' maxlength='11'>
                        </div>
                        <div class='form-group'>
                          <label for='passEdit'>Senha</label>
                          <input type='password' class='form-control' name='passEdit".$row['ID_USUARIO']."' id='passEdit".$row['ID_USUARIO']."'>
                        </div>
                        <div class='form-group'>
                          <label for='loginFluigEdit'>Login Fluig</label>
                          <input type='text' class='form-control' value='".$row['usuario_fluig']."' name='loginFluigEdit".$row['ID_USUARIO']."' id='loginFluigEdit".$row['ID_USUARIO']."'>
                        </div>
                        <div class='form-group'>
                          <label for='passFluigEdit'>Senha Fluig</label>
                          <input type='password' class='form-control' name='passFluigEdit".$row['ID_USUARIO']."' id='passFluigEdit".$row['ID_USUARIO']."'>
                        </div>
                        <input type='hidden' class='form-control' value='".$row['ID_USUARIO']."'name='iduser'>
                        <div class='form-group'>
	                      <label for='tipoAcessoEdit'>Admin?</label>
	                      <div class='form-check'>
	                        <input class='form-check-input' type='radio' name='tipoAcessoEdit".$row['ID_USUARIO']."' id='exampleRadios11".$row['ID_USUARIO']."' value='1'>
	                        <label class='form-check-label' for='exampleRadios11'>
	                          Sim
	                        </label>
	                      </div>
	                      <div class='form-check'>
	                        <input class='form-check-input' type='radio' name='tipoAcessoEdit".$row['ID_USUARIO']."' id='exampleRadios22".$row['ID_USUARIO']."' value='0'>
	                        <label class='form-check-label' for='exampleRadios22'>
	                          Não
	                        </label>
	                      </div>
                        <br>
                        <div class='form-group'>
                          <label for='espelharRateio'>Deseja espelhar o rateio de outro usuário?</label>
                          <div class='form-check'>
                            <input class='form-check-input' type='radio' onchange='checkedRatEsp".$row['ID_USUARIO']."()' name='espelharRateio".$row['ID_USUARIO']."' id='espelharRateio1".$row['ID_USUARIO']."' value='1' ".$checkedespelho.">
                            <label class='form-check-label' for='espelharRateio1'>
                              Sim
                            </label>
                          </div>
                          <div class='form-check'>
                            <input class='form-check-input' type='radio' onchange='checkedRatEsp".$row['ID_USUARIO']."()' name='espelharRateio".$row['ID_USUARIO']."' id='espelharRateio2".$row['ID_USUARIO']."' value='0'>
                            <label class='form-check-label' for='espelharRateio2'>
                              Não
                            </label>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='usuarioespelho'>Usuário Espelho</label>
                          <input type='text' class='form-control' value='".$userespelhado."' name='usuarioespelho".$row['ID_USUARIO']."' id='usuarioespelho".$row['ID_USUARIO']."'>
                          <input type='hidden' class='form-control' value='".$iduserespelhado."' name='IDusuarioespelho".$row['ID_USUARIO']."' id='IDusuarioespelho".$row['ID_USUARIO']."'>
                        </div>
                    	</div>
                      </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                        <input type='submit' class='btn btn-success' name='editUser' value='Salvar' />
                      </div>
                    </form>
                  </div>
                </div>
              </div>".

              "<script>$('input[name=tipoAcessoEdit".$row['ID_USUARIO']."][value=' + ".$row['admin']." + ']').prop('checked', true);




                $('#cpfEdit".$row['ID_USUARIO']."').on('blur', function(e){

                  if($(this).val().length == 11){

                    $(this).val(
                      $(this).val()
                      .replace(/\D/g, '')
                      .replace(/^(\d{3})(\d{3})?(\d{3})?(\d{2})?/, '$1.$2.$3-$4'));

                    if (isValidCPF($('#cpfEdit".$row['ID_USUARIO']."').val()) == false ) {
                      alert('CPF inválido!');
                      $('#cpfEdit".$row['ID_USUARIO']."').val('');
                    }
                  }else if($(this).val().length < 11){
                      alert('CPF inválido!');
                      $('#cpfEdit".$row['ID_USUARIO']."').val('');
                  }

                });


                $('#cpfEdit".$row['ID_USUARIO']."').on('keyup', function(e){
                  $(this).val(
                      $(this).val()
                      .replace(/\D/g, ''));
                });

                $(function() {
                  $( '#usuarioespelho".$row['ID_USUARIO']."' ).autocomplete({
                    source: '../fun/funSearch.php?fun=users',
                    minLength: 3,
                    autoFocus:true,
                    select: function( event, ui ) {
                      $( '#usuarioespelho".$row['ID_USUARIO']."' ).val( ui.item.label );
                      $( '#IDusuarioespelho".$row['ID_USUARIO']."' ).val( ui.item.value );
                      return false;
                    }
                  });
                });

                function checkedRatEsp".$row['ID_USUARIO']."() {
                  if (document.getElementById('espelharRateio1".$row['ID_USUARIO']."').checked) {
                    document.getElementById('usuarioespelho".$row['ID_USUARIO']."').required = true;
                  }
                  if(document.getElementById('espelharRateio2".$row['ID_USUARIO']."').checked){
                    document.getElementById('usuarioespelho".$row['ID_USUARIO']."').required = false;
                  }
                }



              </script>".

              "<!-- Modal Delete User-->
              <div class='modal fade' id='modalDeleteUser".$row['ID_USUARIO']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                  <div class='modal-content'>
                    <form id='excluindo".$row['ID_USUARIO']."' method='POST' action='../fun/funUsers.php?fun=excluir&id=" . $row['ID_USUARIO'] . "'>
                      <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLabel'>Tem certeza que deseja remover este usuário?</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                      </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                        <button type='submit' class='btn btn-danger'>Remover Usuário</button>
                      </div>
                    </form> 
                  </div>
                </div>
              </div>");
    }

		echo json_encode($users);

    break;

  //EDITAR PERFIL
  case 'editarperfil': 

    $iduser = $_POST['iduser'];
    $nome = $_POST['nomeEdit'];
    $login = $_POST['loginEdit'];
    $loginFluig = $_POST['loginFluigEdit'];
    $passFluig = $_POST['passFluigEdit'];

    $url = $_POST['caminho'];

    $update = "UPDATE cad_login SET nome = '$nome',
    login = '$login',
    senha_fluig = '".$passFluig."',
    usuario_fluig = '$loginFluig'
    WHERE ID_USUARIO = $iduser";
    $result = $conn->query($update);


    $_SESSION["iduser"] = $iduser;
    $_SESSION["user"] = $nome;
    $_SESSION["email"] = $login;
    $_SESSION["loginfluig"] = $loginFluig;


    header('location: '.$url.'');

    $conn->close();

       
    break;


  //PERFIL FLUIG
  case 'perfilfluig': 

    $loginFluig = $_POST['loginFluig'];
    $passFluig = $_POST['passFluig'];

    $login = $_SESSION["email"];

    $update = "UPDATE cad_login SET
    senha_fluig = '".$passFluig."',
    usuario_fluig = '$loginFluig' WHERE login = '$login'";


    $result = $conn->query($update);

    header('location: ../index.php');

    $conn->close();

       
    break;
}

?>