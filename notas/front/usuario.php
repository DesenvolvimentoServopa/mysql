<?php

session_start();

require_once('../conf/conexao.php');
include '../fun/funCheck.php';

if ($permission == 0) {
  header('Location: 403.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Lançamento de Notas</title>

  <!-- Custom fonts for this template -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <style type="text/css">
    .ui-widget {
      z-index: 99999999!important;
    }
  </style>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <?php include 'navmenu.php'; ?>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <?php include 'header.php'; ?>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">


          <div class="col-lg-4 mb-2 my-3" style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 1){ echo 'none';}elseif($_GET['msn'] == 1){ echo 'block';} ?>;">
            <div class="card bg-danger text-white shadow">
              <div class="card-body">
                Excluido com Sucesso!
              </div>
            </div>
          </div>

          <div class="col-lg-4 mb-2 my-3" style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 2){ echo 'none';}elseif($_GET['msn'] == 2){ echo 'block';} ?>;">
            <div class="card bg-success text-white shadow">
              <div class="card-body">
                Criado com Sucesso!
              </div>
            </div>
          </div>

          <div class="col-lg-4 mb-2 my-3" style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 3){ echo 'none';}elseif($_GET['msn'] == 3){ echo 'block';} ?>;">
            <div class="card bg-info text-white shadow">
              <div class="card-body">
                Editado com Sucesso!
              </div>
            </div>
          </div>
          
          <div class="row" style="padding-bottom: 15px;">

            <div class="col-lg-9">

              <!-- Page Heading -->
              <h1 class="h3 mb-2 text-gray-800">Usuários</h1>

            </div>

            <!--div class="col-lg-3" style="text-align: -webkit-right;">

              <button type="button" data-toggle="modal" data-target="#modalNewUser" class="btn btn-success btn-icon-split" style="display: block;">
                <span class="icon text-white-50">
                  <i class="fas fa-check"></i>
                </span>
                <span style="padding-left: 10px;padding-right: 10px;">Novo Usuário</span>
              </button>

            </div-->

          </div>

          <!-- Modal -->
          <div class="modal fade" id="modalNewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form id="novousuario" method="POST" action="../fun/funUsers.php?fun=novousuario" style="font-size: 14px;">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cadastro de Novo Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="nome">Nome</label>
                      <input type="text" class="form-control" id="nome" name="nome">
                    </div>
                    <div class="form-group">
                      <label for="login">Login</label>
                      <input type="text" class="form-control" id="login" name="login">
                    </div>
                    <div class="form-group">
                      <label for="cpf">CPF</label>
                      <input type="text" class="form-control" id="cpf" name="cpf" maxlength="11">
                    </div>
                    <div class="form-group">
                      <label for="pass">Senha</label>
                      <input type="password" class="form-control" id="pass" name="pass">
                    </div>
                    <div class="form-group">
                      <label for="loginFluig">Login Fluig</label>
                      <input type="text" class="form-control" id="loginFluig" name="loginFluig">
                    </div>
                    <div class="form-group">
                      <label for="passFluig">Senha Fluig</label>
                      <input type="password" class="form-control" id="passFluig" name="passFluig">
                    </div>
                    <div class="form-group">
                      <label for="tipoAcesso">Admin?</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipoAcesso" id="exampleRadios11" value="1">
                        <label class="form-check-label" for="exampleRadios11">
                          Sim
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipoAcesso" id="exampleRadios22" value="0">
                        <label class="form-check-label" for="exampleRadios22">
                          Não
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-success" name="newUser" value="Salvar" />
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Listagem de Usuários Cadastrados</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dtUsuario" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Login</th>
                      <th>CPF</th>
                      <th>Login Fluig</th>
                      <th>Ação</th>
                    </tr>
                  </thead>
                </table>
              </div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php include 'footer.php'; ?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Bootstrap core JavaScript-->
  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../js/demo/datatables-demo.js"></script>

  <script type="text/javascript">


    $("#cpf").on("blur", function(e){

      if($(this).val().length == 11){

        $(this).val(
          $(this).val()
          .replace(/\D/g, '')
          .replace(/^(\d{3})(\d{3})?(\d{3})?(\d{2})?/, "$1.$2.$3-$4"));

        if (isValidCPF($("#cpf").val()) == false ) {
          alert("CPF inválido!");
          $("#cpf").val("");
        }
      }else if($(this).val().length < 11){
          alert("CPF inválido!");
          $("#cpf").val("");
      }

    });



    $('#cpf').on('keyup', function(e){
      $(this).val(
          $(this).val()
          .replace(/\D/g, ''));
    });

    
    function isValidCPF(cpf) {
      if (typeof cpf !== "string") return false
      cpf = cpf.replace(/[\s.-]*/igm, '')
      if (
          !cpf ||
          cpf.length != 11 ||
          cpf == "00000000000" ||
          cpf == "11111111111" ||
          cpf == "22222222222" ||
          cpf == "33333333333" ||
          cpf == "44444444444" ||
          cpf == "55555555555" ||
          cpf == "66666666666" ||
          cpf == "77777777777" ||
          cpf == "88888888888" ||
          cpf == "99999999999" 
      ) {
          return false
      }
      var soma = 0
      var resto
      for (var i = 1; i <= 9; i++) 
          soma = soma + parseInt(cpf.substring(i-1, i)) * (11 - i)
      resto = (soma * 10) % 11
      if ((resto == 10) || (resto == 11))  resto = 0
      if (resto != parseInt(cpf.substring(9, 10)) ) return false
      soma = 0
      for (var i = 1; i <= 10; i++) 
          soma = soma + parseInt(cpf.substring(i-1, i)) * (12 - i)
      resto = (soma * 10) % 11
      if ((resto == 10) || (resto == 11))  resto = 0
      if (resto != parseInt(cpf.substring(10, 11) ) ) return false
      return true
    }

  </script>

</body>

</html>
