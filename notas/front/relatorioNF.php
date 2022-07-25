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

  <link href="../vendor/multiselect/css/bootstrap-multiselect.min.css" rel="stylesheet">


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
        
        <div class="container-fluid">
        <!-- /.container-fluid -->
  <form action="../front/relatorioresultado.php" method="GET" autocomplete="off">

<!--Fornecedor-->
<h1 class="h6 mb-2 text-gray-800">
  <i class="fas fa-angle-double-right"></i> Fornecedor:
</h1>

<div class="col-md-4 py-4 input-group">
  <select name="forn[]" class="form-control" id="forn" multiple="multiple">
    <option value="todos">Todos</option>
                      <?php
                          $queryForn = "SELECT id_fornecedor, nome_fornecedor FROM cad_fornecedor WHERE deletar = 0";
                          $resultForn = $conn->query($queryForn);
                            
                      while($forn = $resultForn->fetch_assoc()){
                        echo '<option value="'.$forn['id_fornecedor'].'">'.$forn['nome_fornecedor'].'</option>';
                      }
                      ?>
                      </select>
      </div>
<!--FILIAL-->
<h1 class="h6 mb-2 text-gray-800">
  <i class="fas fa-angle-double-right"></i> Filial:
</h1>

<div class="col-md-4 py-4 input-group">
  <select name="filial" class="form-control" type="text" id="filial">
    <option value="">----------</option>
    <?php
                          $queryFilial = "SELECT id_filial, nome FROM cad_filial";
                          $resultFilial = $conn->query($queryFilial);
                            
                      while($filial = $resultFilial->fetch_assoc()){
                        echo '<option value="'.$filial['id_filial'].'">'.$filial['nome'].'</option>';
                      }
                      ?>
                      </select>
</div>
     
<!--Status-->
<h1 class="h6 mb-2 text-gray-800">
  <i class="fas fa-angle-double-right"></i> Status:
</h1>

<div class="col-md-4 py-4 input-group">
  <select name="status" class="form-control" type="text" id="status">
    <option value="">----------</option>
                      <?php
                          $queryStatus = "SELECT id_status, nome FROM cad_status WHERE deletar = 0";
                          $resultStatus = $conn->query($queryStatus);
                            
                      while($status = $resultStatus->fetch_assoc()){
                        echo '<option value="'.$status['id_status'].'">'.$status['nome'].'</option>';
                      }
                      ?>
                      </select>
      </div>
      <!--Data Inicio-->
      <h1 class="h6 mb-2 text-gray-800">
  <i class="fas fa-angle-double-right"></i> Data Inicio:
</h1>

<div class="col-md-4 py-4 input-group">
<input type="date" class="form-control" id="datain" name="datain">
                      </select>
      </div>
            <!--Data Fim-->
<h1 class="h6 mb-2 text-gray-800">
  <i class="fas fa-angle-double-right"></i> Data Final:
</h1>

<div class="col-md-4 py-4 input-group">
<input type="date" class="form-control" id="dataFim" name="dataFim">
                      </select>
      </div>
<hr>
<button type="submit" class="btn btn-success btn-icon-split textCenterTela mb-5">
  <span class="icon text-white-50">
    <i class="fas fa-search"></i>
  </span>
  <span class="text">Gerar Relatório</span>
</button>

</form>
</div>

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

  <script src="../vendor/multiselect/js/bootstrap-multiselect.min.js"></script>


  <script type="text/javascript">
    

  $(function(){
    $('#forn').multiselect({
      nonSelectedText: 'Nenhum selecionado',
      numberDisplayed: 1
    });
  });


  </script>

</body>

</html>
