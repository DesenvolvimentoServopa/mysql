<?php

session_start();
require_once('../conf/conexao.php');
include '../fun/funCheck.php';

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
    
    .boxRetorno1 {
      transition: all 5s linear;
    }

    .boxRetorno2 {
      transition: all 5s linear;
    }

    .boxRetorno3 {
      transition: all 5s linear;
    }

    .hidden {
      display: none;
    }

    .visuallyhidden {
      opacity: 0;
    }
<?php if($_SESSION["rateio_espelhado"] == 1){?>
    a.btn.btn-danger.btn-circle.btn-sm {
      display: none;
    }
<?php }?>
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


          <div id="boxRetorno1" class="col-lg-4 mb-2 my-3 boxRetorno1" style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 1){ echo 'none';}elseif($_GET['msn'] == 1){ echo 'block';} ?>;">
            <div class="card bg-danger text-white shadow">
              <div class="card-body">
                Excluido com Sucesso!
              </div>
            </div>
          </div>

          <div id="boxRetorno2" class="col-lg-4 mb-2 my-3 boxRetorno2" style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 2){ echo 'none';}elseif($_GET['msn'] == 2){ echo 'block';} ?>;">
            <div class="card bg-success text-white shadow">
              <div class="card-body">
                Criado com Sucesso!
              </div>
            </div>
          </div>

          <div id="boxRetorno3" class="col-lg-4 mb-2 my-3 boxRetorno3" style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 3){ echo 'none';}elseif($_GET['msn'] == 3){ echo 'block';} ?>;">
            <div class="card bg-info text-white shadow">
              <div class="card-body">
                Editado com Sucesso!
              </div>
            </div>
          </div>

          
          <div class="row" style="padding-bottom: 15px;">

            <div class="col-lg-9">

              <!-- Page Heading -->
              <h1 class="h3 mb-2 text-gray-800">Rateio Fornecedor</h1>

            </div>
<?php if($_SESSION["rateio_espelhado"] != 1){?>
            <div class="col-lg-3" style="text-align: -webkit-right;">

              <button onclick="location.href='rateioFornecedorNovo.php'" type="button" class="btn btn-success btn-icon-split" style="display: block;">

                <span class="icon text-white-50">
                  <i class="fas fa-check"></i>
                </span>
                <span style="padding-left: 10px;padding-right: 10px;">Novo Rateio</span>
              </button>

            </div>
<?php }?>
          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Listagem de Rateios Cadastrados</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dtRateioFornecedor" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Usuário</th>
                      <th>Filial</th>
                      <th>Fornecedor</th>   
                      <th>CNPJ</th>
                      <th>Periodicidade</th>
                      <th>Observação</th>
                      <th>Tipo de Pgto</th>
                      <th>Auditoria</th>
                      <th>Obras</th>
                      <th>Conferência</th>
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
  <script src="../vendor/jquery/jquery.min.js"></script>
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
    
    let box = document.getElementById('boxRetorno<?php if(isset($_GET['msn'])){ echo $_GET['msn'];} ?>');

    if (box.classList.contains('hidden')) {
      box.classList.remove('hidden');
      setTimeout(function () {
        box.classList.remove('visuallyhidden');
      }, 20);
    } else {
      box.classList.add('visuallyhidden');    
      box.addEventListener('transitionend', function(e) {
        box.classList.add('hidden');
        $("#boxRetorno<?php if(isset($_GET['msn'])){ echo $_GET['msn'];} ?>").css("display", "none");
      }, {
        capture: false,
        once: true,
        passive: false
      });
    }

  </script>


</body>

</html>