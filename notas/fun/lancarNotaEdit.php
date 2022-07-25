<?php

session_start();

require_once('../conf/conexao.php');

include '../fun/funCheck.php';

$idnota = $_GET['idnota'];


$queryNota = "SELECT LAN.*, RAT.ID_RATEIOFORNECEDOR AS RATEIOFORNECEDOR, BAN.*, LOG.nome AS USUARIO, FORN.nome_fornecedor as NOMEFORNECEDOR, FORN.ID_FORNECEDOR, FIL.nome AS NOMEFILIAL, LAN.carimbar AS carimbo 
        FROM cad_lancarnotas LAN 
        INNER JOIN cad_fornecedor FORN ON FORN.CPF_CNPJ = LAN.CNPJ
        LEFT JOIN cad_rateiofornecedor RAT ON RAT.ID_FORNECEDOR = FORN.ID_FORNECEDOR AND RAT.ID_FILIAL = LAN.ID_FILIAL
        LEFT JOIN cad_rateiobanco BAN ON BAN.ID_RATEIOFORNECEDOR = RAT.ID_RATEIOFORNECEDOR
        INNER JOIN cad_login LOG ON LOG.ID_USUARIO = LAN.ID_USUARIO
        INNER JOIN cad_filial FIL ON FIL.ID_FILIAL = LAN.ID_FILIAL
        WHERE LAN.ID_LANCARNOTAS = $idnota;";

echo $queryNota;

$result = $conn->query($queryNota);

$row = $result->fetch_assoc();

if (strlen($row['CNPJ']) > 11) {
  $cpfcnpj = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $row['CNPJ']);
} else {
  $cpfcnpj = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $row['CNPJ']);
}

$vencNota = date_create_from_format("d/m/Y", $row['vencimento'])->format("Y-m-d");
$emissaoNota = date_create_from_format("d/m/Y", $row['emissao'])->format("Y-m-d");


$queryPgto = "SELECT ID_TIPOPAGAMENTO AS ID, nome FROM cad_tipopagamento WHERE deletar = 0;";
$resultPgto = $conn->query($queryPgto);

$queryPerio = "SELECT ID_PERIODICIDADE AS ID, nome FROM cad_periodicidade WHERE deletar = 0;";
$resultPerio = $conn->query($queryPerio);

$queryTd = "SELECT ID_TIPODESPESA AS ID, nome FROM cad_tipodespesa WHERE deletar = 0;";
$resultTd = $conn->query($queryTd);

if ($row['ID_TIPOPAGAMENTO'] == 2) {

  $checktipopgto = 'block';

  $queryBanco = "SELECT * FROM cad_rateiobanco WHERE ID_RATEIOFORNECEDOR = " . $row['ID_RATEIOFORNECEDOR'];
  $resultBanco = $conn->query($queryBanco);
  $rowB = $resultBanco->fetch_assoc();
} else {
  $checktipopgto = 'none';

  $rowB['nome_banco'] = "";
  $rowB['agencia'] = "";
  $rowB['conta'] = "";
  $rowB['digito'] = "";
}

if ($row['relatorio_siscon'] != '') {
  $checkconsorcio = 'block';
} else {
  $checkconsorcio = 'none';
}

if (isset($_GET['idf'])) {
  $row['ID_FORNECEDOR'] = $_GET['idf'];
  $row['nome_fornecedor'] = $_GET['nomefornec'] . " - " . $_GET['cnpj'];
  $cpfcnpj = $_GET['cnpj'];
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

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

          <div class="col-lg-4 mb-2 my-3" style="display: <?php if (!isset($_GET['msn']) || $_GET['msn'] != 3) {
                                                            echo 'none';
                                                          } elseif ($_GET['msn'] == 3) {
                                                            echo 'block';
                                                          } ?>;">
            <div class="card bg-info text-white shadow">
              <div class="card-body">
                Editado com Sucesso!
              </div>
            </div>
          </div>

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Nota <?= $idnota; ?></h1>
          </div>

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
                      <input type="text" class="form-control" value="<?= $row['USUARIO']; ?>" id="userLanc">
                      <input type="hidden" class="form-control" value="<?= $row['ID_USUARIO']; ?>" id="IDuserLanc">
                      <br>
                      <label for="userLanc">Tipo de Serviço/Rateio</label>
                      <input type="text" class="form-control" name="tipo_serv" id="tipo_serv" value="<?= $row['tipo_serv']; ?>">

                    </div>
                    <div class="col">
                      <label for="fornecedor">Fornecedor</label>
                      <input type="text" class="form-control" id="fornecedor" value="<?= $row['NOMEFORNECEDOR']; ?>" maxlength="18">
                      <p id="cnpjfornecedor" style="margin-top: 5px"><?= $cpfcnpj; ?></p>
                      <input type="hidden" class="form-control" id="idfornecedor" value="<?= $row['ID_FORNECEDOR']; ?>">
                      <input type="hidden" class="form-control" id="idrateiofornecedor" value="<?= $row['RATEIOFORNECEDOR']; ?>">
                    </div>
                    <div class="col">
                      <label for="txtFilialNota">Filial</label>
                      <input type="text" class="form-control" name="txtFilialNota" id="txtFilialNota" value="<?= $row['NOMEFILIAL']; ?>" required>
                      <input type="hidden" class="form-control" name="filialNota" id="filialNota" value="<?= $row['ID_FILIAL']; ?>">
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

                      <label for="numeroNotaEdit">Número</label>
                      <input type="text" class="form-control" id="numeroNotaEdit" value="<?= $row['numero_nota']; ?>">
                      <br>
                      <label for="serieNotaEdit">Série</label>
                      <input type="text" class="form-control" id="serieNotaEdit" value="<?= $row['serie_nota']; ?>">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="carimbo" name="carimbo" <?= ($row['carimbo'] == 1) ? 'checked' : '' ?>>

                        <label class="form-check-label" for="carimbo">
                          Carimbar NF pelo Robô
                        </label>
                      </div>

                    </div>

                    <div class="col">




                      <label for="emissaoNotaEdit">Emissão</label>
                      <input type="date" class="form-control" id="emissaoNotaEdit" value="<?= $emissaoNota; ?>">
                      <br>
                      <label for="vencNotaEdit">Vencimento</label>
                      <input type="date" class="form-control" id="vencNotaEdit" value="<?= $vencNota; ?>">
                      <br>
                      <label for="valorNotaEdit">Valor</label>
                      <input type="text" class="form-control" id="valorNotaEdit" onkeyup="formatarMoeda()" value="<?= $row['valor_nota']; ?>">

                    </div>
                    <div class="col">

                      <form method="post" enctype="multipart/form-data" id="formAnexos" action="../fun/upload.php">
                        <label for="modeloNota">Modelo de Nota</label>
                        <input type="file" class="form-control-file" id="modeloNota" name="modeloNota">
                        <br>
                        <label for="modeloBol" style="margin-top: 10px;">Modelo de Boleto</label>
                        <input type="file" class="form-control-file" id="modeloBol" name="modeloBol">
                        <br>
                        <label for="outrosAnexos" style="margin-top: 10px;">Outros Anexos</label>
                        <input type="file" class="form-control-file" id="outrosAnexos" name="outrosAnexos">
                      </form>

                    </div>
                  </div>
                </div>
              </div>


              <!-- Basic Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Dados do Fornecedor</h6>
                </div>
                <div class="card-body">


                  <div class="form-row">
                    <div class="col">

                      <label for="tipoDespesaEdit">Tipo de Despesa</label>
                      <select class="form-control" id="tipoDespesaEdit">

                        <?php while ($rowTd = $resultTd->fetch_assoc()) { ?>
                          <?php if ($row['ID_TIPODESPESA'] == $rowTd['ID']) { ?>
                            <option selected value="<?= $rowTd['ID']; ?>"><?= $rowTd['nome']; ?></option>
                          <?php } else { ?>
                            <option value="<?= $rowTd['ID']; ?>"><?= $rowTd['nome']; ?></option>
                          <?php } ?>
                        <?php } ?>

                      </select>
                      <br>
                      <label for="periodicidadeEdit">Periodicidade</label>
                      <select class="form-control" id="periodicidadeEdit">

                        <?php while ($rowPerio = $resultPerio->fetch_assoc()) { ?>
                          <?php if ($row['ID_PERIODICIDADE'] == $rowPerio['ID']) { ?>
                            <option selected value="<?= $rowPerio['ID']; ?>"><?= $rowPerio['nome']; ?></option>
                          <?php } else { ?>
                            <option value="<?= $rowPerio['ID']; ?>"><?= $rowPerio['nome']; ?></option>
                          <?php } ?>
                        <?php } ?>

                      </select>
                      <br>
                      <label for="tipoPgtoEdit">Tipo do Pagamento</label>
                      <select class="form-control" id="tipoPgtoEdit">

                        <?php while ($rowPgto = $resultPgto->fetch_assoc()) { ?>
                          <?php if ($row['ID_TIPOPAGAMENTO'] == $rowPgto['ID']) { ?>
                            <option selected value="<?= $rowPgto['ID']; ?>"><?= $rowPgto['nome']; ?></option>
                          <?php } else { ?>
                            <option value="<?= $rowPgto['ID']; ?>"><?= $rowPgto['nome']; ?></option>
                          <?php } ?>
                        <?php } ?>

                      </select>
                      <br>
                      <div id="dep" style="display: <?= $checktipopgto; ?>;">

                        <div class="form-group">
                          <label for="txtBanco">Banco</label>
                          <input type="text" class="form-control" name="txtBanco" value="<?= $rowB['nome_banco']; ?>" id="txtBanco">
                          <input type="hidden" class="form-control" name="banco" value="<?= $rowB['nome_banco']; ?>" id="banco">
                        </div>

                        <div class="form-group">
                          <label for="agEdit">Agência</label>
                          <input type="text" class="form-control" id="agEdit" value="<?= $rowB['agencia']; ?>">
                        </div>

                        <div class="form-group">
                          <label for="contaEdit">Conta</label>
                          <input type="text" class="form-control" id="contaEdit" value="<?= $rowB['conta']; ?>">
                        </div>

                        <div class="form-group">
                          <label for="digitoEdit">Dígito</label>
                          <input type="text" class="form-control" id="digitoEdit" value="<?= $rowB['digito']; ?>">
                        </div>

                      </div>

                    </div>
                    <div class="col">

                      <label for="obsEdit">Observação</label>
                      <textarea class="form-control" rows="3" id="obsEdit"><?= $row['observacao']; ?></textarea>
                      <br>
                      <label for="telefone">Telefone <span style="color: red;">(caso seja fatura telefônica)</span></label>
                      <input type="text" class="form-control" value="<?= $row['telefone']; ?>" name="telefone" id="telefone">
                      <br>
                      <div id="cons" style="display: <?= $checkconsorcio; ?>;">

                        <div class="form-group">
                          <label for="relSisconEdit">Possui relatório no SISCON?</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="relSisconEdit" id="relSisconEdit001" value="1">
                            <label class="form-check-label" for="relSisconEdit001">
                              Sim
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="relSisconEdit" id="relSisconEdit002" value="0">
                            <label class="form-check-label" for="relSisconEdit002">
                              Não
                            </label>
                          </div>
                          <small class="form-text text-muted">Apenas se for do consórcio.</small>
                        </div>

                        <div class="form-group">
                          <label for="motivoSisconEdit">Motivo</label>
                          <input type="text" class="form-control" id="motivoSisconEdit" value="<?= $row['motivo_siscon']; ?>">
                          <small class="form-text text-muted">Apenas se for do consórcio.</small>
                        </div>

                      </div>

                    </div>
                    <div class="col">

                      <label for="nfDptoAudiEdit">Notas Fiscais Do Departamento De Auditoria?</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="nfDptoAudiEdit" id="nfDptoAudiEdit001" value="1">
                        <label class="form-check-label" for="nfDptoAudiEdit001">
                          Sim
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="nfDptoAudiEdit" id="nfDptoAudiEdit002" value="0">
                        <label class="form-check-label" for="nfDptoAudiEdit002">
                          Não
                        </label>
                      </div>
                      <br>
                      <label for="nfObrasEdit">Notas Fiscais De Obras do Grupo Servopa?</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="nfObrasEdit" id="nfObrasEdit001" value="1">
                        <label class="form-check-label" for="nfObrasEdit001">
                          Sim
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="nfObrasEdit" id="nfObrasEdit002" value="0">
                        <label class="form-check-label" for="nfObrasEdit002">
                          Não
                        </label>
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
                  <table class="table table-bordered" id="dtRateioEdit" width="100%" cellspacing="0" style="margin-top: 20px;">
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
              <button type="submit" class="btn btn-success btn-icon-split" id="editNota" style="display: block;">
                <span class="icon text-white-50">
                  <i class="fas fa-check"></i>
                </span>
                <span style="padding-left: 10px;padding-right: 10px;">Salvar</span>
              </button>

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
  <script src="../js/functions.js"></script>

  <script type="text/javascript">
    $('input[name=nfDptoAudiEdit][value=' + <?= $row['auditoria']; ?> + ']').prop('checked', true);
    $('input[name=nfObrasEdit][value=' + <?= $row['obra']; ?> + ']').prop('checked', true);
    $('input[name=relSisconEdit][value=' + <?= $row['relatorio_siscon']; ?> + ']').prop('checked', true);

    funCheckConsorcioEdit();

    funRetornaRateioEdit();

    if ($.fn.dataTable.isDataTable('#dtRateioEdit')) {
      table = $('#dtRateioEdit').DataTable();
    } else {
      table = $('#dtRateioEdit').DataTable({
        retrieve: true,
        paging: false
      });
    }
    table.destroy();

    $("#numeroNotaEdit").on("keyup", function(e) {
      $(this).val(
        $(this).val()
        .replace(/\D/g, ''));
    });

    $("#valorNotaEdit").on("blur", function(e) {
      if ($("#idrateiofornecedor").val() != '') {
        funRetornaRateioEdit();
      }
    });

    $("#editNota").click(function() {
      editNota(<?= $idnota; ?>)
    });

    $("#valorNotaEdit").on("keyup", function(e) {
      $(this).val(
        $(this).val()
        .replace(/([a-zA-Z])|(\,)/g, ''));
    });


    $("#tipoPgtoEdit").change(function() {
      if ($("#tipoPgtoEdit").val() == '2') {
        $("#dep").css("display", "block");
      } else {
        $("#dep").css("display", "none");
      }
    });


    function formatarMoeda() {
      var elemento = document.getElementById('valorNotaEdit');
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