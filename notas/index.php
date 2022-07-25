<?php

session_start();

require_once('conf/conexao.php');

if (!isset($_SESSION["iduser"])) {
  header("Location: ../../unico/front/sistemas.php");
  //$_SESSION["email"] = "-";
  //$_SESSION["loginfluig"] = "-";
  //$_SESSION["iduser"] = 1;
  //$_SESSION["user"] = "Admin";
}
$idStatus = $_GET['statusnota'] ;
$idusuario = $_SESSION["iduser"];

include 'fun/funCheck.php';

//FELIPE 11/11/2021 - Alterando a contagem para mostrar apenas no mês que estamos

$ano = date('Y');
$mes = date('m');
$lastDayMoth = date('t');

$sql1 = "SELECT count(*) AS A FROM cad_lancarnotas WHERE status_desc = 1 AND deletar = 0 AND ID_USUARIO = $idusuario AND date_create BETWEEN '$ano-$mes-01' AND '$ano-$mes-$lastDayMoth'";

$sql2 = "SELECT count(*) AS B FROM cad_lancarnotas WHERE status_desc = 3 AND deletar = 0 AND ID_USUARIO = $idusuario AND date_create BETWEEN '$ano-$mes-01' AND '$ano-$mes-$lastDayMoth'";

$sql3 = "SELECT count(*) AS C FROM cad_lancarnotas WHERE status_desc IN (2,10) AND deletar = 0 AND ID_USUARIO = $idusuario AND date_create BETWEEN '$ano-$mes-01' AND '$ano-$mes-$lastDayMoth'";

$sql4 = "SELECT count(*) as D FROM cad_lancarnotas WHERE status_desc IN (SELECT id as ID_STATUS FROM cad_status WHERE erro = 1 AND deletar = 0) AND deletar = 0 AND ID_USUARIO = $idusuario AND date_create BETWEEN '$ano-$mes-01' AND '$ano-$mes-$lastDayMoth'";

$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result4 = $conn->query($sql4);

$row1 = $result1->fetch_assoc();
$row2 = $result2->fetch_assoc();
$row3 = $result3->fetch_assoc();
$row4 = $result4->fetch_assoc();

$listerros = "";
$sqlErros = "SELECT id as ID_STATUS FROM cad_status WHERE erro = 1 and deletar = 0";
$resultErros = $conn->query($sqlErros);
while ($row = $resultErros->fetch_assoc()) {
  $listerros .= $row['ID_STATUS'].',';
}
$listerros = substr($listerros,0,-1);

$notaSumiu = "SELECT distinct
CL.valor_nota,
CL.emissao,
CL.CNPJ,
CL.vencimento,
CL.numero_fluig,
F.nome_fornecedor fornecedor,
CF.nome empresa,
CS.nome status,
CS.id id_status,
DB.ID_USUARIO
FROM
cad_lancarnotas AS CL
LEFT JOIN
cad_fornecedor F ON (CL.cnpj = F.CPF_CNPJ)
LEFT JOIN 
cad_filial CF ON (CL.id_filial = CF.ID_FILIAL)
LEFT JOIN
cad_status CS ON (CL.status_desc = CS.id) 
LEFT JOIN 
cad_login DB ON (DB.ID_USUARIO = DB.ID_USUARIO)
WHERE DB.ID_USUARIO = $idusuario AND CS.id IN ($idStatus) AND CL.deletar = 0";

$resultado = $conn->query($notaSumiu);

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

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <style type="text/css">
    #ui-id-1{
      z-index: 9999999;
    }
  </style>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <?php include 'front/navmenu.php'; ?>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <?php include 'front/header.php'; ?>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div id="boxRetorno1" class="col-lg-4 mb-2 my-3" style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 1){ echo 'none';}elseif($_GET['msn'] == 1){ echo 'block';} ?>;">
            <div class="card bg-danger text-white shadow">
              <div class="card-body">
                Excluida com Sucesso!
              </div>
            </div>
          </div>

          <div id="boxRetorno2" class="col-lg-4 mb-2 my-3" style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 2){ echo 'none';}elseif($_GET['msn'] == 2){ echo 'block';} ?>;">
            <div class="card bg-success text-white shadow">
              <div class="card-body">
                Nota lançada com Sucesso!
              </div>
            </div>
          </div>

          <div id="boxRetorno3" class="col-lg-4 mb-2 my-3" style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 3){ echo 'none';}elseif($_GET['msn'] == 3){ echo 'block';} ?>;">
            <div class="card bg-info text-white shadow">
              <div class="card-body">
                Editada com Sucesso!
              </div>
            </div>
          </div>

          <div id="boxRetorno4" class="col-lg-4 mb-2 my-3" style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 4){ echo 'none';}elseif($_GET['msn'] == 4){ echo 'block';} ?>;">
            <div class="card bg-success text-white shadow">
              <div class="card-body">
                Status alterado com Sucesso!
              </div>
            </div>
          </div>
         
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <!--a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a-->
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="index.php?statusnota=1" style="text-decoration: none;" id="filtro1">
                <div id="filtro1_div" class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Aguardando Lançamento</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                      </div>
                      <div class="col-auto">
                        <i style="color: #dddfeb;font-size: 30px;font-weight: bold;"><?php echo $row1['A']; ?></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="index.php?statusnota=3" style="text-decoration: none;" id="filtro2">
                <div id="filtro2_div" class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Notas Lançadas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                      </div>
                      <div class="col-auto">
                        <i style="color: #dddfeb;font-size: 30px;font-weight: bold;"><?php echo $row2['B']; ?></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="index.php?statusnota=2,10" style="text-decoration: none;" id="filtro3">
                <div id="filtro3_div" class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pendentes</div>
                        <div class="row no-gutters align-items-center">
                          <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"></div>
                          </div>
                          
                        </div>
                      </div>
                      <div class="col-auto">
                        <i style="color: #dddfeb;font-size: 30px;font-weight: bold;"><?php echo $row3['C']; ?></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="index.php?statusnota=<?php echo $listerros; ?>" style="text-decoration: none;" id="filtro4">
                <div id="filtro4_div" class="card border-left-danger shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Status Erro</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                      </div>
                      <div class="col-auto">
                        <i style="color: #dddfeb;font-size: 30px;font-weight: bold;"><?php echo $row4['D']; ?></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>

          <!-- Content Row -->

          <div class="row">          
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-7">
            <p class="mb-4 text-xs" style="display: <?=  $_GET['statusnota'] == 3 ? 'block' : 'none' ?>">
              <i class="fas fa-bullhorn"></i> Notas que foram lançadas entre os dias 01/<?= date('m/Y')?> até o momento!
            </p>

              <div class="card shadow mb-4">
                
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Notas Lançadas</h6>
                  

                </div>
                <!-- Card Body -->
                <div class="card-body">
                  
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dtDash" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Filial</th>
                          <th>CNPJ</th>
                          <th>Fornecedor</th>
                          <th>Valor Nota</th>
                          <th>Data Emissão</th>
                          <th>Vencimento</th>
                          <th>Usuário</th>
                          <th>Pagamento</th>
                          <th>Número Fluig</th>
                          <th>Status</th>
                          <th>Ação</th>
                        </tr>
                      </thead>
                      <tbody id="retorno">                        
                      </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>TI Grupo Servopa - Qualquer dúvida ligue no 110-2151</span>
          </div>
        </div>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
          <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deseja sair do sistema?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="fun/unset.php">Sair</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Check Perfil Fluig -->
        <!-- <div class="modal fade" id="modalPerfilFluig" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <form id="perfilfluig" method="POST" action="fun/funUsers.php?fun=perfilfluig">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Cadastro de Usuário no Fluig <p style="font-size: 13px;">Favor complete com os seus dados de acesso ao fluig para prosseguir.</p></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="loginFluig">Login Fluig</label>
                    <input type="text" class="form-control" id="loginFluig" name="loginFluig" required>
                  </div>
                  <div class="form-group">
                    <label for="passFluig">Senha Fluig</label>
                    <input type="password" class="form-control" id="passFluig" name="passFluig" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" class="btn btn-success" value="Salvar" />
                </div>
              </form>
            </div>
          </div>
        </div> -->


      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->


  <!-- Bootstrap core JavaScript-->
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src="vendor/jquery/jquery.min.js"></script>
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>


  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

   <!-- Segurança-->
   <script src="../js/seg.js"></script>


  <script type="text/javascript">

    $.post("fun/functions.php?function=funRetornaNotas&usuario=<?php echo $_SESSION["iduser"];?><?php if(isset($_GET["statusnota"])){ echo "&statusnota=".$_GET["statusnota"]; } ?>",
    {},
    function(data,status){
      if (data.search("Fatal error") < 1) {
        $("#retorno").html(data);
        $('#dtDash').DataTable( {
          language: {
              url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
          },
          "info": false,
          "paging": true
        });
      }
    });

    function alteraStatus($id) {
      $.post("fun/funLancNota.php?fun=alteraStatus",
      {
        idnota: $id
      },
      function(data,status){
        window.location.href='index.php?msn=4';
      });
    }

    <?php if(isset($_GET['statusnota'])){ ?>
    <?php   if($_GET['statusnota'] == '1' ){ ?>
      $("#filtro1_div").css('background-color','rgba(78, 115, 223, 0.45)');
      $(".fa-calendar").css('color','#4e73df');
    <?php   } ?>
    <?php   if($_GET['statusnota'] == '3' ){ ?>
      $("#filtro2_div").css('background-color','rgba(28, 200, 138, 0.45)');
      $(".fa-dollar-sign").css('color','#1cc88a');
    <?php   } ?>
    <?php   if($_GET['statusnota'] == '2,10' ){ ?>
      $("#filtro3_div").css('background-color','rgba(246, 194, 62, 0.45)');
      $(".fa-clipboard-list").css('color','#f6c23e');
    <?php   } ?>
    <?php   if($_GET['statusnota'] == '4,5,6,7,8,11,12' ){ ?>
      $("#filtro4_div").css('background-color','rgba(231, 74, 59, 0.45)');
      $(".fa-exclamation-triangle").css('color','#e74a3b');
    <?php   } ?>
    <?php } ?>

    function checkloginfluig() {
      $.post("fun/functions.php?function=funCheckAcessoFluig&email=<?php echo $_SESSION["email"];?>",
      {},
      function(data,status){
        if (data == 1) {
          $('#modalPerfilFluig').modal();
        }
      });
    }

    checkloginfluig();

    $("#modalPerfilFluig").on("hidden.bs.modal",function(){
      checkloginfluig();
    });


    $(function() {
      $( "#usuarioespelho" ).autocomplete({
        source: "fun/funSearch.php?fun=users",
        minLength: 3,
        autoFocus:true,
        select: function( event, ui ) {
          $( "#usuarioespelho" ).val( ui.item.label );
          $( "#IDusuarioespelho" ).val( ui.item.value );
          return false;
        }
      });
    });
  </script>
</body>

</html>
