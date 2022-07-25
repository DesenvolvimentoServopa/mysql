<?php

session_start();

require_once('../conf/conexao.php');

include '../fun/funCheck.php';

$idrateiofornecedor = $_GET['idrateiofornecedor'];

$queryDp = "SELECT RAT.*,FORN.*,USU.*, FIL.ID_FILIAL AS FILIAL, FIL.nome AS NOMEFILIAL FROM cad_rateiofornecedor RAT 
          INNER JOIN cad_fornecedor FORN ON FORN.ID_FORNECEDOR = RAT.ID_FORNECEDOR
          INNER JOIN cad_login USU ON USU.ID_USUARIO = RAT.ID_USUARIO
          INNER JOIN cad_filial FIL ON FIL.ID_FILIAL = RAT.ID_FILIAL
          WHERE RAT.ID_RATEIOFORNECEDOR = $idrateiofornecedor;";

$result = $conn->query($queryDp);
$row = $result->fetch_assoc();

if (strlen($row['CPF_CNPJ']) > 11) {
  $cpfcnpj = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $row['CPF_CNPJ']);
}else{
  $cpfcnpj = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $row['CPF_CNPJ']);
}

$queryPerio = "SELECT ID_PERIODICIDADE AS ID, nome FROM cad_periodicidade WHERE deletar = 0;";
$resultPerio = $conn->query($queryPerio);

$queryTd = "SELECT ID_TIPODESPESA AS ID, nome FROM cad_tipodespesa WHERE deletar = 0;";
$resultTd = $conn->query($queryTd);

$queryPgto = "SELECT ID_TIPOPAGAMENTO AS ID, nome FROM cad_tipopagamento WHERE deletar = 0;";
$resultPgto = $conn->query($queryPgto);

if ($row['ID_TIPOPAGAMENTO'] == 2) {

  $checktipopgto = 'block';

  $queryBanco = "SELECT * FROM cad_rateiobanco WHERE ID_RATEIOFORNECEDOR = ".$row['ID_RATEIOFORNECEDOR'];
  $resultBanco = $conn->query($queryBanco);
  $rowB = $resultBanco->fetch_assoc();

}else{
  $checktipopgto = 'none';

  $rowB['nome_banco'] = "";
  $rowB['agencia'] = "";
  $rowB['conta'] = "";
  $rowB['digito'] = "";
}

if ($row['relatorio_siscon'] != '') {
  $checkconsorcio = 'block';
}else{
  $checkconsorcio = 'none';
}

if (isset($_GET['idf'])) {
  $row['ID_FORNECEDOR'] = $_GET['idf'];
  $row['nome_fornecedor'] = $_GET['nomefornec']." - ".$_GET['cnpj'];
  $cpfcnpj = $_GET['cnpj'];
}

$acaomodalnovofornecedor = "../fun/funFornecedor.php?fun=novofornecedor&view=rateioedit&idrateiofornecedor=".$idrateiofornecedor;

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

  <style type="text/css">
<?php if($_SESSION["rateio_espelhado"] == 1){?>
    a.btn.btn-danger.btn-sm {
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

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">Rateio Fornecedor <?php echo $idrateiofornecedor; ?></h1>
            </div>

            <div class="row setdisabled">


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
                        <input type="text" class="form-control" value="<?php echo $row['nome']; ?>" id="userLanc">
                        <input type="hidden" class="form-control" value="<?php echo $row['ID_USUARIO']; ?>" id="IDuserLanc">
                        <br>
			<label for="userLanc">Tipo de Serviço/Rateio</label>
                        <input type="text" class="form-control" value="<?php echo $row['tipo_serv']; ?>" name="tipo_serv" id="tipo_serv">

                      </div>
                      <div class="col">
                        <label for="fornecedor">Fornecedor</label>
                        <input type="text" class="form-control" id="fornecedor" value="<?php echo $row['nome_fornecedor']; ?>" maxlength="18">
                        <p id="cnpjfornecedor" style="margin-top: 5px"><?php echo $cpfcnpj; ?></p>
                        <input type="hidden" class="form-control" id="idfornecedor" value="<?php echo $row['ID_FORNECEDOR']; ?>">
                      </div>
                      <div class="col">
                        <label for="txtFilial">Filial</label>
                        <input type="text" class="form-control" name="txtFilial" id="txtFilial" value="<?php echo $row['NOMEFILIAL']; ?>" required>
                        <input type="hidden" class="form-control" name="filial" id="filial" value="<?php echo $row['FILIAL']; ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dados do Pagamento</h6>
                  </div>
                  <div class="card-body">

                    <div class="form-row">
                      <div class="col-3">
                        <label for="tipoPgto">Tipo do Pagamento</label>
                        <select class="form-control" id="tipoPgto">
                          
                          <?php while($rowPgto = $resultPgto->fetch_assoc()) {?>
                            <?php if ($row['ID_TIPOPAGAMENTO'] == $rowPgto['ID']) {?>
                            <option selected value="<?php echo $rowPgto['ID']; ?>"><?php echo $rowPgto['nome']; ?></option>
                            <?php }else{ ?>
                            <option value="<?php echo $rowPgto['ID']; ?>"><?php echo $rowPgto['nome']; ?></option>
                            <?php } ?>
                          <?php } ?>

                        </select>
                      </div>
                    </div>

                    <div id="dep" style="display: <?php echo $checktipopgto; ?>;">
                      <div class="form-row">
                        <div class="col-5">
                          <label for="txtBanco">Banco</label>
                          <input type="text" class="form-control" name="txtBanco" id="txtBanco" value="<?php echo $rowB['nome_banco']; ?>">
                          <input type="hidden" class="form-control" name="banco" id="banco" value="<?php echo $rowB['nome_banco']; ?>">
                        </div>
                        <div class="col-3">
                          <label for="ag">Agência</label>
                          <input type="text" class="form-control" id="ag" value="<?php echo $rowB['agencia']; ?>">
                        </div>
                        <div class="col-2">
                          <label for="conta">Conta</label>
                          <input type="text" class="form-control" id="conta" value="<?php echo $rowB['conta']; ?>">
                        </div>
                        <div class="col-2">
                          <label for="digito">Dígito</label>
                          <input type="text" class="form-control" id="digito" value="<?php echo $rowB['digito']; ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dados da Despesa</h6>
                  </div>
                  <div class="card-body">


                    <div class="form-row">
                      <div class="col">
                        <label for="tipoDespesa">Tipo de Despesa</label>
                        <select class="form-control" id="tipoDespesa">
                          <?php while($rowTd = $resultTd->fetch_assoc()) {?>
                            <?php if ($row['ID_TIPODESPESA'] == $rowTd['ID']) {?>
                            <option selected value="<?php echo $rowTd['ID']; ?>"><?php echo $rowTd['nome']; ?></option>
                            <?php }else{ ?>
                            <option value="<?php echo $rowTd['ID']; ?>"><?php echo $rowTd['nome']; ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                        <br>
                        <label for="periodicidade">Periodicidade</label>
                        <select class="form-control" id="periodicidade">
                          <?php while($rowPerio = $resultPerio->fetch_assoc()) {?>
                            <?php if ($row['ID_PERIODICIDADE'] == $rowPerio['ID']) {?>
                            <option selected value="<?php echo $rowPerio['ID']; ?>"><?php echo $rowPerio['nome']; ?></option>
                            <?php }else{ ?>
                            <option value="<?php echo $rowPerio['ID']; ?>"><?php echo $rowPerio['nome']; ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                        <br>
                        <div class="form-group">
                          <label for="vencRateio">Indicar o Vencimento <span style="color: red; font-size: 10px">(caso não venha descrito na nota)</span></label>
                          <input type="text" class="form-control" id="vencRateio" maxlength="3" value="<?php echo $row['vencimento']; ?>">
                        </div>

                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="vencRateioTipo" id="vencRateioTipo001" value="1">
                            <label class="form-check-label" for="vencRateioTipo001">
                              Dia fixo de vencimento.<span style="color: red; font-size: 10px">(Ex: 12/08/2021)</span>
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="vencRateioTipo" id="vencRateioTipo002" value="0">
                            <label class="form-check-label" for="vencRateioTipo002">
                              Número de dias a vencer após o faturamento.<span style="color: red; font-size: 10px"><br />( Ex: 10 ) esse número representa a QUANTIDADE DE DIAS que iremos SOMAR</span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <label for="obs">Observação</label>
                        <textarea class="form-control" rows="3" id="obs"><?php echo $row['observacao']; ?></textarea>
                        <br>
                        <label for="telefone">Telefone <span style="color: red; font-size: 10px">(caso seja fatura telefônica)</span></label>
                        <input type="text" class="form-control" value="<?php echo $row['telefone']; ?>" name="telefone" id="telefone">
                        <br>
                        <div class="form-group">
                          <label for="conferencia">Necessita conferência antes do envio para o fluig?</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="conferencia" id="conferencia001" value="1">
                            <label class="form-check-label" for="conferencia001">
                              Sim
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="conferencia" id="conferencia002" value="0">
                            <label class="form-check-label" for="conferencia002">
                              Não
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="nfDptoAudi">Notas Fiscais Do Departamento De Auditoria?</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="nfDptoAudi" id="nfDptoAudi001" value="1">
                            <label class="form-check-label" for="nfDptoAudi001">
                              Sim
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="nfDptoAudi" id="nfDptoAudi002" value="0">
                            <label class="form-check-label" for="nfDptoAudi002">
                              Não
                            </label>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label for="nfObras">Notas Fiscais De Obras do Grupo Servopa?</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="nfObras" id="nfObras001" value="1">
                            <label class="form-check-label" for="nfObras001">
                              Sim
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="nfObras" id="nfObras002" value="0">
                            <label class="form-check-label" for="nfObras002">
                              Não
                            </label>
                          </div>
                        </div>
                        <div id="cons" style="display: <?php echo $checkconsorcio; ?>;">

                          <div class="form-group">
                            <label for="relSiscon">Possui relatório no SISCON?</label>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="relSiscon" id="relSiscon001" value="1">
                              <label class="form-check-label" for="relSiscon001">
                                Sim
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="relSiscon" id="relSiscon002" value="0">
                              <label class="form-check-label" for="relSiscon002">
                                Não
                              </label>
                            </div>
                            <small class="form-text text-muted">Apenas se for do consórcio.</small>
                          </div>

                          <div class="form-group">
                            <label for="motivoSiscon">Motivo</label>
                            <input type="text" class="form-control" id="motivoSiscon" value="<?php echo $row['motivo_siscon']; ?>">
                            <small class="form-text text-muted">Apenas se for do consórcio.</small>
                          </div>

                        </div>

                      </div>
                    </div>

                  </div>
                </div>


              </div>


            </div>

            <div class="row setdisabled">
              <div class="col-lg-12">

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Centro de Custo</h6>
                  </div>
                  <div class="card-body" style="padding-left: 100px;">
                      <div class="form-group">
                        <div class="form-row">
                          <div class="col">
                            <label for="selectCC">Centro de Custo</label>
                            <select class="form-control" id="selectCC" name="selectCC"></select>
                          </div>
                          <div class="col">
                            <label for="percRat">% Rateio</label>
                            <input type="text" class="form-control" id="percRat" name="percRat" maxlength="6">
                          </div>
                          <div class="col">
                            <label style="display: block;">-</label>
                            <input type="button" id="newRat" value="+" class="btn btn-success">
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="table-responsive" style="padding-left: 100px;padding-right: 100px;margin-bottom: 20px;">
                    <table class="table table-bordered" id="dtRateio" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Centro de Custo</th>
                          <th>% Rateio</th>
                          <th>-</th>
                        </tr>
                      </thead>
                      <tbody id="retornoRATEIO">
                      
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>

            </div>


            <div class="row">
<?php if($_SESSION["rateio_espelhado"] != 1){?>
              <div class="col-lg-4"></div>
<?php }else{?>
              <div class="col-lg-5"></div>
<?php }?>
              <div class="col-lg-5" style="text-align: -webkit-center;display: inline-flex;">
                <input type="hidden" class="form-control" id="percMax" value="100.00" name="percMax">

                <button onclick="window.location.href='rateioFornecedor.php';" type="button" class="btn btn-secondary btn-icon-split" id="voltar" style="display: block;margin-right: 30px;">
                  <span class="icon text-white-50">
                    <i class="fas fa-chevron-left"></i>
                  </span>
                  <span style="padding-left: 10px;padding-right: 10px;">Voltar</span>
                </button>
                <?php if($_SESSION["rateio_espelhado"] != 1){?>
                <button type="submit" class="btn btn-success btn-icon-split" id="cadForn" style="display: block;">
                  <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                  </span>
                  <span style="padding-left: 10px;padding-right: 10px;">Salvar</span>
                </button>
                <?php }?>


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

  <?php include 'modalNovoFornecedor.php'; ?>

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

  <script src="../js/custom-autocomplete.js"></script>
  <script src="../js/custom-check-cnpj.js"></script>
  <script src="../js/functions.js"></script>

  <script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>

  <script type="text/javascript">

    $('input[name=nfDptoAudi][value=' + <?php echo $row['auditoria']; ?> + ']').prop('checked', true);
    $('input[name=nfObras][value=' + <?php echo $row['obra']; ?> + ']').prop('checked', true);
    $('input[name=conferencia][value=' + <?php echo $row['necessita_conferencia']; ?> + ']').prop('checked', true);
    $('input[name=relSiscon][value=' + <?php echo $row['relatorio_siscon']; ?> + ']').prop('checked', true);
    $('input[name=vencRateioTipo][value=' + <?php echo $row['vencimento_tipo']; ?> + ']').prop('checked', true);

    retornaCentroC();

    $("#txtFilial").on("blur", function(e){
      if($("#fornecedor").val() !== '' && $("#filial").val() !== '') {
        funCheckDuplicidade($("#idfornecedor").val(),$("#filial").val());
      }
    });

    function funCheckDuplicidade($idfornecedor,$idfilial) {
      $.post("../fun/funRateioFornecedor.php?fun=checkduplicidade",
      {
        idfornecedor: $idfornecedor,
        idfilial: $idfilial,
      },
      function(data,status){
        if(data == 'duplicado'){
          alert("Cadastro para esse fornecedor e filial já existe!");
        }
      });
    }

    funRetornaRateioPercentual(<?php echo $idrateiofornecedor; ?>);

    $("#newRat").click(function(){

      var retorno = $('#selectCC').val().split("_");

      $.post("../fun/functions.php?function=funInserirRateio",
      {
        idrateiofornecedor: <?php echo $idrateiofornecedor; ?>,
        idcc: retorno[0],
        percentual: $('#percRat').val().replace(',', '.')
      },
      function(data,status){

        if(data == '0'){
          alert("Não é permitido mais de um rateio no mesmo centro de custo!");
        }else{
          funRetornaRateioPercentual(<?php echo $idrateiofornecedor; ?>);
        }

      });

    });

    function funDeletar($idrat,$idcc) {
      
      $.post("../fun/functions.php?function=funDeletaRateio",
      {
        idrateiofornecedor: $idrat,
        idcc: $idcc,
      },
      function(data,status){

        funRetornaRateioPercentual(<?php echo $idrateiofornecedor; ?>);

      });

    }

    $("#percRat").on("keyup", function(e){
      $(this).val(
          $(this).val()
          .replace(/([a-zA-Z])|(\,)/g, ''));
    });

    function funSoma(total, num) {
      total = parseFloat(total);
      num = parseFloat(num);
      return total + num;
    }

    $("#cadForn").click(function(){
      editRateioFornecedor(<?php echo $idrateiofornecedor; ?>);
    });

<?php if($_SESSION["rateio_espelhado"] == 1){?>
    $('.setdisabled :input').prop('disabled', 'disabled');
<?php }?>

  </script>

</body>

</html>
