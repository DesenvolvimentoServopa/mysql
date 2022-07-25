<?php

session_start();

require_once('../conf/conexao.php');

include '../fun/funCheck.php';

if ($permission == 0) {
  header('Location: 403.php');
}

switch ($_GET['tipo']) {
  case '1': //Centro de Custo

    $queryDp = "SELECT CEN.ID_CENTROCUSTO as ID, CEN.descDpto AS nome, FIL.nome AS filial, FIL.ID_FILIAL 
    FROM cad_centrocusto CEN INNER JOIN cad_filial FIL ON FIL.ID_FILIAL = CEN.ID_FILIAL WHERE CEN.deletar = 0;";

    $result = $conn->query($queryDp);

    $nome = "Centro de Custo";
    $icone = "fas fa-users";
    break;

  case '2': //Tipo Despesa

    $queryDesp = "SELECT ID_TIPODESPESA as ID, nome FROM cad_tipodespesa WHERE deletar = 0;";

    $result = $conn->query($queryDesp);

    $nome = "Tipo de Despesa";
    $icone = "fas fa-users";
    break;

  case '3': //Tipo Pagamento

    $queryPgto = "SELECT ID_TIPOPAGAMENTO as ID, nome FROM cad_tipopagamento WHERE deletar = 0;";

    $result = $conn->query($queryPgto);

    $nome = "Tipo de Pagamento";
    $icone = "fas fa-users";
    break;

  case '4': //Periodicidade

    $queryDesp = "SELECT ID_PERIODICIDADE as ID, nome FROM cad_periodicidade WHERE deletar = 0;";

    $result = $conn->query($queryDesp);

    $nome = "Periodicidade";
    $icone = "fas fa-users";
    break;

  case '5': //Status

    $queryDesp = "SELECT ID_STATUS as ID, nome FROM cad_status WHERE deletar = 0;";

    $result = $conn->query($queryDesp);

    $nome = "Status Nota";
    $icone = "fas fa-users";
    break;

  case '6': //Bancos

    $queryDesp = "SELECT ID_BANCO as ID, nome FROM cad_banco WHERE deletar = 0;";

    $result = $conn->query($queryDesp);

    $nome = "Bancos";
    $icone = "fas fa-users";
    break;


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

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">



  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


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



          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary"><?= $nome; ?> Cadastrados</h6>
                  <a class="btn btn-success btn-pen-square btn-sm float-rigth" title="Adicionar" href="#" data-toggle="modal" data-target="#adicionar">
                    <i class="fas fa-plus"></i>
                  </a>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dtDropDowns" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nome</th>

                          <?php if($_GET['tipo'] == 1){ ?>
                          <th>Filial</th>
                          <?php } ?>

                          <th>Ação</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                          $contador = 2;
                          while ($row = $result->fetch_assoc()) {
                            if($_GET['tipo'] == 1){

                              $name = $row['nome'];

                              $colFilial = '<td>'. $row['filial']. '</td>';

                              $filialEdit = '<div class="form-group">
                              <label for="txtfilialEdit' . $row['ID'] . '">Filial</label> 
                              <input type="text" class="form-control" value="' . $row['filial'] . '" name="txtfilialEdit' . $row['ID'] . '" id="txtfilialEdit' . $row['ID'] . '" required>
                              <input type="hidden" class="form-control" value="' . $row['ID_FILIAL'] . '" name="filialEdit' . $row['ID'] . '" id="filialEdit' . $row['ID'] . '"></div>';

                              $autocomplete = "  <script type='text/javascript'>
    
                                            $(function() {
                                              $( '#txtfilialEdit".$row['ID']."' ).autocomplete({
                                                source: '../fun/funSearch.php?fun=filiais',
                                                minLength: 3,
                                                autoFocus:true,
                                                select: function( event, ui ) {
                                                  $( '#txtfilialEdit".$row['ID']."' ).val( ui.item.label );
                                                  $( '#filialEdit".$row['ID']."' ).val( ui.item.value );
                                                  return false;
                                                }
                                              });
                                            });

                                          </script>


                                            <style type='text/css'>
                                              #ui-id-".$contador."{
                                                z-index: 9999999;
                                              }
                                            </style>";
                            $contador++;

                            }else{
                              $name = $row['nome'];
                              $colFilial = "";
                              $filialEdit = "";
                              $autocomplete = "";
                            }





                            if($_GET['tipo'] == 5){

                              $campoerro = "<div class='form-group'>
                                              <label for='checkErro'>É status de erro?</label>
                                              <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='checkErro' id='checkErro11' value='1'>
                                                <label class='form-check-label' for='checkErro11'>
                                                  Sim
                                                </label>
                                              </div>
                                              <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='checkErro' id='checkErro22' value='0' checked>
                                                <label class='form-check-label' for='checkErro22'>
                                                  Não
                                                </label>
                                              </div>
                                            </div>";

                            }else{

                              $campoerro = "";

                            }

                            echo '
                                <tr>
                                  <td>' . $row['ID'] . '</td>
                                  <td>' . $row['nome'] . '</td>
                                  '.$colFilial.'
                                  <td>                    
                                    <a class="btn btn-info btn-pen-square btn-sm" title="Editar" href="#" data-toggle="modal" data-target="#editar' . $row['ID'] . '"><i class="fas fa-edit"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#modalDelete' . $row['ID'] . '" class="btn btn-danger btn-trash-square btn-sm" title="Excluir"><i class="fas fa-trash"></i></a>
                                  </td>
                                </tr>

                                <!-- Edit Modal-->
                                <div class="modal fade" id="editar' . $row['ID'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editando ' . $nome . '</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">×</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form id="editando" method="POST" action="../fun/funDropdowns.php?fun=editar&id=' . $row['ID'] . '&tipo=' . $_GET['tipo'] . '">

                                          <div class="form-group">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" value="' . $name . '" name="nome">
                                          </div>

                                          '. $campoerro . $filialEdit . $autocomplete . '

                                          <div class="modal-footer">
                                            <button class="btn btn-secondary" for"editando" type="button" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" for="editando" class="btn btn-primary">Editar</a>
                                          </div>                        
                                        </form>                        
                                      </div>
                                    </div>
                                  </div>
                                </div>



                                <!-- Modal Delete -->
                                <div class="modal fade" id="modalDelete' . $row['ID'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <form id="excluindo" method="POST" action="../fun/funDropdowns.php?fun=excluir&id=' . $row['ID'] . '&tipo=' . $_GET['tipo'] . '">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Tem certeza que deseja remover este item?</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                          <button type="submit" for="excluindo" class="btn btn-danger">Remover</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                                ';
                          }
                          ?>
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

      <?php include 'footer.php'; ?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->





  <!-- ADD Modal-->
  <div class="modal fade" id="adicionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Adicionando <?= $nome ?></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="add" method="POST" action="../fun/funDropdowns.php?fun=adicionar&tipo=<?= $_GET['tipo'] ?>">
            <div class="form-group">
              <label for="nome">Nome</label>
              <input type="text" class="form-control" id="nomeCC" name="nome" required>
            </div>
<?php if($_GET['tipo'] == 1){?>      
            <div class="form-group">
              <label for="txtFilial">Filial</label>
              <input type="text" class="form-control" name="txtFilial" id="txtFilial" required>
              <input type="hidden" class="form-control" name="filial" id="filial">
            </div>
<?php } ?>
<?php if($_GET['tipo'] == 5){?>
            <div class='form-group'>
              <label for='checkErro'>É status de erro?</label>
              <div class='form-check'>
                <input class='form-check-input' type='radio' name='checkErro' id='checkErro11' value='1'>
                <label class='form-check-label' for='checkErro11'>
                  Sim
                </label>
              </div>
              <div class='form-check'>
                <input class='form-check-input' type='radio' name='checkErro' id='checkErro22' value='0' checked>
                <label class='form-check-label' for='checkErro22'>
                  Não
                </label>
              </div>
            </div>
<?php } ?>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="salvar" for="add" class="btn btn-primary">Salvar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>





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
<?php if($_GET['tipo'] == 1){ ?>    
    $(function() {
      $( "#txtFilial" ).autocomplete({
        source: "../fun/funSearch.php?fun=filiais",
        minLength: 3,
        autoFocus:true,
        select: function( event, ui ) {
          $( "#txtFilial" ).val( ui.item.label );
          $( "#filial" ).val( ui.item.value );
          return false;
        }
      });
    });



    $("#txtFilial").on("blur", function(e){

      if ($("#nomeCC").val() != '' && $("#filial").val() != '') {
        $.post("../fun/functions.php?function=funCheckCCduplicado",
        {
          nomeCC: $("#nomeCC").val(),
          filial: $("#filial").val()

        },
        function(data,status){

          if (data == 1) {
            alert("Centro de Custo já cadastrado!");
            $("#nomeCC").val('');
          }

        });
      }

    });



    

<?php } ?>
  </script>

</body>

</html>
