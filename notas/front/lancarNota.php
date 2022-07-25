<?php

session_start();

require_once('../conf/conexao.php');

include '../fun/funCheck.php';

$acaomodalnovofornecedor = "../fun/funFornecedor.php?fun=novofornecedor&view=nota";

if (isset($_GET['idf'])) {
  $getIdFornec = $_GET['idf'];
  $getNomeFornec = $_GET['nomefornec'] . " - " . $_GET['cnpj'];
  $getCnpjFornec = $_GET['cnpj'];
} else {
  $getIdFornec = "";
  $getNomeFornec = "";
  $getCnpjFornec = "";
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

  <!-- Custom styles for this page -->
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Lançar Nota</h1>
          </div>
          <form method="post" enctype="multipart/form-data" id="formnovanota" action="../fun/funLancNota.php?fun=novanota">
            <div class="row">

              <div class="col-lg-12">
                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dados Principais</h6>
                  </div>
                  <div class="card-body">
                    <div class="form-row">
                      <div class="col">
                        <label for="userLanc">Usuário</label>
                        <input type="text" class="form-control" value="<?php echo $_SESSION["user"]; ?>" name="userLanc" id="userLanc">
                        <input type="hidden" class="form-control" value="<?php echo $_SESSION["iduser"]; ?>" name="IDuserLanc" id="IDuserLanc">
                        <br>
			<label for="userLanc">Tipo de Serviço/Rateio</label>
                        <input type="text" class="form-control" name="tipo_serv" id="tipo_serv">
                      </div>
                      <div class="col">
                        <label for="fornecedor">Fornecedor</label>
                        <input type="text" class="form-control" id="fornecedor" maxlength="18" name="fornecedor" value="<?php echo $getNomeFornec; ?>" required>
                        <p id="cnpjfornecedor" style="margin-top: 5px"><?php echo $getCnpjFornec; ?></p>
                        <input type="hidden" class="form-control" id="idfornecedor" value="<?php echo $getIdFornec; ?>" name="idfornecedor">
                        <input type="hidden" class="form-control" name="cnpjfornecedor2" id="cnpjfornecedor2">
                        <input type="hidden" class="form-control" name="idrateiofornecedor" id="idrateiofornecedor">
                      </div>
                      <div class="col">
                        <label for="txtFilialNota">Filial</label>
                        <input type="text" class="form-control" name="txtFilialNota" id="txtFilialNota" required>
                        <input type="hidden" class="form-control" name="filialNota" id="filialNota">
                        <p style="display: none;margin-top: 10px;text-align: center;" id="msgrateio">Não há rateio cadastrado para este fornecedor.</p>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dados da Nota</h6>
                  </div>
                  <div class="card-body">

                    <div class="form-row">
                      <div class="col">
                        <label for="numeroNota">Número</label>
                        <input type="text" class="form-control" id="numeroNota" name="numeroNota" required>
                        <br>
                        <label for="serieNota">Série</label>
                        <input type="text" class="form-control" id="serieNota" name="serieNota" required>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="1" id="carimbo" name="carimbo">
                          <label class="form-check-label" for="flexCheckChecked">
                            Carimbar NF pelo Robô
                          </label>
                        </div>
                      </div>  
                      <div class="col">
                        <label for="emissaoNota">Emissão</label>
                        <input type="date" class="form-control" id="emissaoNota" name="emissaoNota" required>
                        <br>
                        <label for="vencNota">Vencimento</label>
                        <input type="date" class="form-control" id="vencNota" name="vencNota" required>
                        <br>
                        <label for="valorNota">Valor</label>
                        <input type="text" class="form-control" id="valorNota" name="valorNota" onkeyup="formatarMoeda()" required>
                      </div>
                      <div class="col">
                        <label for="modeloNota">Modelo de Nota</label>
                        <input type="file" class="form-control-file" id="modeloNota" name="modeloNota">
                        <br>
                        <label for="modeloBol" style="margin-top: 10px;">Modelo de Boleto</label>
                        <input type="file" class="form-control-file" id="modeloBol" name="modeloBol">
                        <br>                        
                        <label for="outrosAnexos" style="margin-top: 10px;">Outros Anexos</label>
                        <input type="file" class="form-control-file" id="outrosAnexos" name="outrosAnexos">
                      </div>
                    </div>
                  </div>
                </div>
                <div id="dadosFornec">

                  <!-- Basic Card Example -->
                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Dados do Fornecedor</h6>
                    </div>
                    <div class="card-body">


                      <div class="form-row">
                        <div class="col">
                          <label for="tipoDespesa">Tipo de Despesa</label>
                          <select class="form-control" id="tipoDespesa" name="tipoDespesa" required></select>
                          <br>
                          <label for="periodicidade">Periodicidade</label>
                          <select class="form-control" id="periodicidade" name="periodicidade" required></select>
                          <br>
                          <label for="tipoPgto">Tipo do Pagamento</label>
                          <select class="form-control" id="tipoPgto" name="tipoPgto" required></select>
                          <br>
                          <div id="dep" style="display: none;">

                            <label for="txtBanco">Banco</label>
                            <input type="text" class="form-control" name="txtBanco" id="txtBanco">
                            <input type="hidden" class="form-control" name="banco" id="banco">
                            <br>
                            <label for="ag">Agência</label>
                            <input type="text" class="form-control" name="ag" id="ag">
                            <br>
                            <label for="conta">Conta</label>
                            <input type="text" class="form-control" name="conta" id="conta">
                            <br>
                            <label for="digito">Dígito</label>
                            <input type="text" class="form-control" name="digito" id="digito">

                          </div>
                        </div>
                        <div class="col">

                          <label for="obs">Observação</label>
                          <textarea class="form-control" rows="3" id="obs" name="obs" required></textarea>
                          <br>
                          <label for="telefone">Telefone <span style="color: red;">(caso seja fatura telefônica)</span></label>
                          <input type="text" class="form-control" name="telefone" id="telefone">
                          <br>
                          <div id="cons" style="display: none;">

                            <label for="relSiscon">Possui relatório no SISCON?</label>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="relSiscon" id="relSisconLanc001" value="1">
                              <label class="form-check-label" for="relSisconLanc001">
                                Sim
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="relSiscon" id="relSisconLanc002" value="0">
                              <label class="form-check-label" for="relSisconLanc002">
                                Não
                              </label>
                            </div>
                            <small class="form-text text-muted">Apenas se for do consórcio.</small>

                            <br>

                            <label for="motivoSiscon">Motivo</label>
                            <input type="text" class="form-control" id="motivoSiscon" name="motivoSiscon">
                            <small class="form-text text-muted">Apenas se for do consórcio.</small>
                          </div>



                        </div>
                        <div class="col">

                          <label for="nfDptoAudi">Notas Fiscais Do Departamento De Auditoria?</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="nfDptoAudi" id="nfDptoAudiLanc001" value="1">
                            <label class="form-check-label" for="nfDptoAudiLanc001">
                              Sim
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="nfDptoAudi" id="nfDptoAudiLanc002" value="0">
                            <label class="form-check-label" for="nfDptoAudiLanc002">
                              Não
                            </label>
                          </div>
                          <br>
                          <label for="nfObras">Notas Fiscais De Obras do Grupo Servopa?</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="nfObras" id="nfObrasLanc001" value="1">
                            <label class="form-check-label" for="nfObrasLanc001">
                              Sim
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="nfObras" id="nfObrasLanc002" value="0">
                            <label class="form-check-label" for="nfObrasLanc002">
                              Não
                            </label>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                </div>



              </div>


            </div>

            <div class="row" id="rateio">
              <div class="col-lg-12">

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rateio</h6>
                  </div>

                  <div class="table-responsive" style="padding-left: 100px;padding-right: 100px;margin-bottom: 20px;">
                    <table class="table table-bordered" id="dtRateioLanc" width="100%" cellspacing="0" style="margin-top: 20px;">
                      <thead>
                        <tr>
                          <th>Centro de Custo</th>
                          <th>% Rateio</th>
                          <th>Valor</th>
                        </tr>
                      </thead>
                      <tbody id="retorno">

                      </tbody>
                    </table>
                  </div>
                </div>

              </div>

            </div>

            <div class="row">
              <div class="col-lg-4"></div>
              <div class="col-lg-5" style="text-align: -webkit-center;display: inline-flex;">
                <input type="hidden" class="form-control" id="percMax" value="100" name="percMax">
                <button onclick="window.location.href='../index.php';" type="button" class="btn btn-secondary btn-icon-split" id="voltar" style="display: block;margin-right: 30px;">
                  <span class="icon text-white-50">
                    <i class="fas fa-chevron-left"></i>
                  </span>
                  <span style="padding-left: 10px;padding-right: 10px;">Voltar</span>
                </button>
                <button type="submit" class="btn btn-success btn-icon-split" id="cadNota" style="display: block;">
                  <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                  </span>
                  <span style="padding-left: 10px;padding-right: 10px;">Lançar Nota</span>
                </button>

              </div>

            </div>
          </form>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php include 'footer.php'; ?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <?php include 'modalNovoFornecedor.php'; ?>

  <!-- Bootstrap core JavaScript-->

  <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>



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

  <script src="../js/custom-autocomplete.js"></script>
  <script src="../js/custom-check-cnpj.js"></script>
  <script src="../js/functions.js"></script>

  <script type="text/javascript">
    funTipoDespesa('#tipoDespesa');
    funPeriodicidade('#periodicidade');
    funTipoPgto('#tipoPgto');

    <?php if ($_SESSION["rateio_espelhado"] == 1) { ?>

        $("#filialNota").on("blur", function(e) {
            if ($("#fornecedor").val() !== '' && $("#filialNota").val() !== '') {
                funRetornaFornecedor($("#idfornecedor").val(), $("#filialNota").val(), <?php echo $_SESSION["userrateioespelho"]; ?>,$("#tipo_serv").val());
            }
        });


        $("#tipo_serv").on("blur", function(e) {
            if ($("#fornecedor").val() !== '' && $("#filialNota").val() !== '') {
                funRetornaFornecedor($("#idfornecedor").val(), $("#filialNota").val(), <?php echo $_SESSION["userrateioespelho"]; ?>,$("#tipo_serv").val());
            }
        });

    <?php } else { ?>

        $("#filialNota").on("blur", function(e) {
            if ($("#fornecedor").val() !== '' && $("#filialNota").val() !== '') {
                funRetornaFornecedor($("#idfornecedor").val(), $("#filialNota").val(), $("#IDuserLanc").val(), $("#tipo_serv").val());
            }
        });

        $("#tipo_serv").on("blur", function(e) {
            if ($("#fornecedor").val() !== '' && $("#filialNota").val() !== '') {
                funRetornaFornecedor($("#idfornecedor").val(), $("#filialNota").val(), $("#IDuserLanc").val(),$("#tipo_serv").val());
            }
        });

    <?php } ?>

    $("#numeroNota").on("keyup", function(e) {
      $(this).val(
        $(this).val()
        .replace(/\D/g, ''));
    });

    $("#valorNota").on("blur", function(e) {
      if ($("#idrateiofornecedor").val() != '') {
        funRetornaRateioLanc();
      }
    });

    $("#valorNota").on("keyup", function(e) {
      $(this).val(
        $(this).val()
        .replace(/([a-zA-Z])|(\,)/g, ''));
    });


    $("#txtFilialNota").blur(function() {

      var $idfilial = $("#filialNota").val();

      $.post("../fun/functions.php?function=funCheckConsorcio", {
          idfilial: $idfilial
        },
        function(data, status) {
          if (data == 1) {
            $("#cons").css("display", "block");
          } else if (data == 0) {
            $("#cons").css("display", "none");
          }
        });

      <?php if ($_SESSION["rateio_espelhado"] == 1) { ?>

        if ($("#fornecedor").val() != '' && $("#filialNota").val() != '') {
          funRetornaFornecedor($("#idfornecedor").val(), $("#filialNota").val(), <?php echo $_SESSION["userrateioespelho"]; ?>,$("#tipo_serv").val());
        }

      <?php } else { ?>

        if ($("#fornecedor").val() != '' && $("#filialNota").val() != '') {
          funRetornaFornecedor($("#idfornecedor").val(), $("#filialNota").val(), $("#IDuserLanc").val(),$("#tipo_serv").val());
        }

      <?php } ?>



      if ($("#idrateiofornecedor").val() != '' && $("#valorNota").val() != '') {
        funRetornaRateioLanc();
      }

    });

    $("#numeroNota").blur(function() {

      var $numeroNota = $("#numeroNota").val();

      $.post("../fun/funLancNota.php?fun=funCheckNotaDuplicada", {
          numeroNota: $numeroNota
        },
        function(data, status) {
          if (data == 1) {
            alert("Esta nota já foi lançada!");
          }
        });

    });



    function formatarMoeda() {
      var elemento = document.getElementById('valorNota');
      var valor = elemento.value;

      valor = valor + '';
      valor = parseInt(valor.replace(/[\D]+/g, ''));
      valor = valor + '';
      valor = valor.replace(/([0-9]{2})$/g, ".$1");

      if (valor.length > 6) {
        valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1.$2");
      }

      elemento.value = valor;
      if (valor == 'NaN') elemento.value = '';

    }
  </script>

</body>

</html>