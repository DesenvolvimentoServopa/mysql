<?php

session_start();
require_once('../conf/conexao.php');
include '../fun/funCheck.php';

if ($permission == 0) {
  header('Location: 403.php');
}

?>



<!doctype html>
<html lang="en">

<head>
    <title>Selecionar Usuário</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/A.style.css.pagespeed.cf._4JKBjJoK3.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="heading-section mb-5 pb-md-4"><br />ALTERAR USUÁRIOS</h2>
                </div>
            </div>
            <form id="workflow_user" method="GET" action="../fun/workflow_user.php">
                <div class='form-group'>
                    <label for='id_user'></label>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Usuários</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dtWorkflow" width="40%" cellspacing="0">
                                    <thead>
                                        <tbody>
                                            <td>
                                                <?php   
                                                    $_SESSION['id_workflow'] = $_GET['id_workflow'];
                                                    $_SESSION['CNPJ'] = $_GET['cnpj'];
                                                    $_SESSION['IDPORTAL'] = $_GET['idwf'];
                                                    $_SESSION['nome'] = $_GET['WF'];
                                                    

                                                    $id_workflow = $_GET["idwf"];
                                                    $cnpj_workflow = $_GET["cnpj"];
                                                    $nome = $_GET["WF"];
                                                    $IDPORTAL = $_GET["idwf"];
                                                    
                                                    
                                                    $sql = "SELECT nome, ID_USUARIO FROM cad_login WHERE deletar = 0 ORDER BY nome ASC";
                                                    $result = $conn->query($sql);
                                                    
                                                    while ($usuarioGeral = $result->fetch_assoc()) {                                                    
                                                        $queryUsuarioWork = "SELECT * FROM workflow_user WHERE id_user = ".$usuarioGeral['ID_USUARIO']." AND id_workflow = ".$id_workflow."";
                                                        $resultUsuarioWork = $conn->query($queryUsuarioWork);
                                                        $usuarioWork = $resultUsuarioWork->fetch_assoc();
                                                        
                                                        echo '<a href"#" class="custom-control custom-switch">';
                                                        echo '<p class class="list-group-item-text">
                                                        <input type="checkbox" class="custom-control-input" id="id_user'.$usuarioGeral['ID_USUARIO'].'" name="id_user[]""
                                                        value="'.$usuarioGeral['ID_USUARIO'].'"';
                                                        echo ( empty($usuarioWork['id_user'])) ? '' : 'checked';
                                                        echo '>
                                                        <label class="custom-control-label" for="id_user'.$usuarioGeral['ID_USUARIO'].'"> '.$usuarioGeral['nome']. '</p></input></label>';
                                                        echo '</a>';
                                                        }
                                                ?>
                                            </td>
                                        </tbody>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary" onclick="fechaJ()">Voltar</button>
                    <input type="submit" class="btn btn-success" name="userworkflow" ></input>
                </div>
            </div>
        </form>
    </section>
    <script>
    $('#cnpjWorkflow').keypress(function() {
        $(this).mask('00.000.000/0000-00');

    });
    </script>
    <script>
    function fechaJ() {
        window.close();
    }
    </script>
    <script type="text/javascript" language="javascript">
    function valida_form (){
    if(document.getElementById("id_user").value == ""){
    alert('Por favor, preencha o campo usuário!');
    document.getElementById("id_user").focus();
    return false
    }
    }
</script>

</body>

</html>