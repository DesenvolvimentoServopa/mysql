<?php

session_start();

require_once('../conf/conexao.php');

include '../fun/funCheck.php';

$acaomodalnovofornecedor = "../fun/funFornecedor.php?fun=novofornecedor&view=rateio";

if (isset($_GET['idf'])) {
  $getIdFornec = $_GET['idf'];
  $getNomeFornec = $_GET['nomefornec']." - ".$_GET['cnpj'];
  $getCnpjFornec = $_GET['cnpj'];
}else{
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
              <h1 class="h3 mb-0 text-gray-800">Cadastro de Rateio Fornecedor</h1>
            </div>
            <form id="novorateiofornecedor" method="POST" action="../fun/funRateioFornecedor.php?fun=novoRateioFornecedor">
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
                        <input type="text" class="form-control" name="userLanc" value="<?php echo $_SESSION["user"]; ?>" id="userLanc" required>
                        <input type="hidden" class="form-control" name="IDuserLanc" value="<?php echo $_SESSION["iduser"]; ?>" id="IDuserLanc">
                        <br>
			<label for="userLanc">Tipo de Serviço/Rateio</label>
                        <input type="text" class="form-control" name="tipo_serv" id="tipo_serv">
			
                      </div>
                      <div class="col">
                        <label for="fornecedor">Fornecedor</label>
                        <input type="text" class="form-control" id="fornecedor" maxlength="18" value="<?php echo $getNomeFornec; ?>" name="fornecedor" required>
                        <p id="cnpjfornecedor" style="display: none;margin-top: 5px"><?php echo $getCnpjFornec; ?></p>
                        <input type="hidden" class="form-control" id="idfornecedor" value="<?php echo $getIdFornec; ?>" name="idfornecedor">
                      </div>
                      <div class="col">
                        <label for="txtFilial">Filial</label>
                        <input type="text" class="form-control" name="txtFilial" id="txtFilial" required>
                        <input type="hidden" class="form-control" name="filial" id="filial">
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
                        <select class="form-control" id="tipoPgto" name="tipoPgto" required></select>
                      </div>
                    </div>
                    <br>
                    <div id="dep" style="display: none;">
                      <div class="form-row">
                        <div class="col-5">
                          <label for="txtBanco">Banco</label>
                          <input type="text" class="form-control" name="txtBanco" id="txtBanco">
                          <input type="hidden" class="form-control" name="banco" id="banco">
                        </div>
                        <div class="col-3">
                          <label for="ag">Agência</label>
                          <input type="text" class="form-control" name="ag" id="ag">
                        </div>
                        <div class="col-2">
                          <label for="conta">Conta</label>
                          <input type="text" class="form-control" name="conta" id="conta">
                        </div>
                        <div class="col-2">
                          <label for="digito">Dígito</label>
                          <input type="text" class="form-control" name="digito" id="digito">
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
                        <select class="form-control" id="tipoDespesa" name="tipoDespesa" required></select>
                        <br>
                        <label for="periodicidade">Periodicidade</label>
                        <select class="form-control" id="periodicidade" name="periodicidade" required></select>
                        <br>
                        <div class="form-group">
                          <label for="vencRateio">Indicar o Vencimento, <span style="color: red;">caso não venha descrito na nota</span>:</label>
                          <input type="text" class="form-control" id="vencRateio" name="vencRateio" maxlength="3">
                        </div>

                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="vencRateioTipo" id="vencRateioTipo001" value="1">
                            <label class="form-check-label" for="vencRateioTipo001">
                              Dia fixo de vencimento.
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="vencRateioTipo" id="vencRateioTipo002" value="0">
                            <label class="form-check-label" for="vencRateioTipo002">
                              Número de dias a vencer após o faturamento.
                            </label>
                          </div>
                        </div>

                      </div>
                      <div class="col">
                        <label for="obs">Observação</label>
                        <textarea class="form-control" rows="3" id="obs" name="obs" required></textarea>
                        <br>
                        <label for="telefone">Telefone <span style="color: red;">(caso seja fatura telefônica)</span></label>
                        <input type="text" class="form-control" name="telefone" id="telefone">
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
                            <input class="form-check-input" type="radio" name="conferencia" id="conferencia002" value="0" checked>
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
                            <input class="form-check-input" type="radio" name="nfDptoAudi" id="nfDptoAudi002" value="0" checked>
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
                            <input class="form-check-input" type="radio" name="nfObras" id="nfObras002" value="0" checked>
                            <label class="form-check-label" for="nfObras002">
                              Não
                            </label>
                          </div>
                        </div>

                        <div id="cons" style="display: none;">

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
                            <input type="text" class="form-control" id="motivoSiscon" name="motivoSiscon">
                            <small class="form-text text-muted">Apenas se for do consórcio.</small>
                          </div>

                        </div>

                      </div>
                    </div>

                  </div>
                </div>

              </div>

            </div>

            <div id="botaoprecadastro" class="col-lg-12" style="text-align: -webkit-center;margin-bottom: 20px;">
              <div class="col-lg-2">
                <button type="submit" class="btn btn-success btn-icon-split" id="precadForn" style="display: block;text-decoration: none;">
                  <span class="icon text-white-50"> <i class="fas fa-check"></i></span>
                  <span style="padding-left: 10px;padding-right: 10px;">Salvar</span>
                </button>
              </div>
            </div>
            </form>

            <div id="RATEIOCENTROCUSTO" style="display:none;">

              <div class="row">
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
                <div class="col-lg-5">
                  <button onclick="window.location.href='rateioFornecedor.php';" type="button" class="btn btn-secondary btn-icon-split" id="voltar" style="display: block;">
                    <span class="icon text-white-50">
                      <i class="fas fa-chevron-left"></i>
                    </span>
                    <span style="padding-left: 10px;padding-right: 10px;">Voltar</span>
                  </button>
                </div>
                <div class="col-lg-2" style="text-align: -webkit-center;">
                  <input type="hidden" class="form-control" id="IDRATFORNEC" name="IDRATFORNEC">
                  <input type="hidden" class="form-control" id="percMax" value="100.00" name="percMax">

                  <button type="button" onclick="window.location.href='rateioFornecedor.php?msn=2';" class="btn btn-success btn-icon-split" id="cadForn" style="display: block;" disabled>
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span style="padding-left: 10px;padding-right: 10px;">Cadastrar</span>
                  </button>

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

    funTipoDespesa('#tipoDespesa');
    funPeriodicidade('#periodicidade');
    funTipoPgto('#tipoPgto');

    $("#tipo_serv").on("blur", function(e){
      if($("#fornecedor").val() !== '' && $("#filial").val() !== '' && $("#tipo_serv").val() !== '') {
        funCheckDuplicidade($("#idfornecedor").val(),$("#filial").val(),$("#tipo_serv").val());
      }
    });

    function funCheckDuplicidade($idfornecedor,$idfilial,$tipo_serv) {
      $.post("../fun/funRateioFornecedor.php?fun=checkduplicidade",
      {
        idfornecedor: $idfornecedor,
        idfilial: $idfilial,
	tipo_serv: $tipo_serv,
      },
      function(data,status){
        if(data == 'duplicado'){
          alert("Cadastro para esse fornecedor e filial já existe!");
        }
      });
    }


    $("#newRat").click(function(){

      var retorno = $('#selectCC').val().split("_");

      $idrateiofornecedor = $('#IDRATFORNEC').val();

      $.post("../fun/functions.php?function=funInserirRateio",
      {
        idrateiofornecedor: $idrateiofornecedor,
        idcc: retorno[0],
        percentual: $('#percRat').val().replace(',', '.')
      },
      function(data,status){

        if(data == '0'){
          alert("Não é permitido mais de um rateio no mesmo centro de custo!");
        }else{

          if (data == $('#percMax').val()) {
            $("#cadForn").attr('disabled', false);
          }else{
            $("#cadForn").attr('disabled', true);
          }

          funRetornaRateioPercentual($('#IDRATFORNEC').val());

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

        if (data == $('#percMax').val()) {
          $("#cadForn").attr('disabled', false);
        }else{
          $("#cadForn").attr('disabled', true);
        }

        funRetornaRateioPercentual($('#IDRATFORNEC').val());

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

    $(document).on('submit','#novorateiofornecedor', function(event){
      event.preventDefault();
      var dados = $(this).serialize();

      $.ajax({
        url: '../fun/funRateioFornecedor.php?fun=novoRateioFornecedor',
        method: 'post',
        data: dados,
        success: function(data){
          $('#IDRATFORNEC').val(data);
          $('#RATEIOCENTROCUSTO').css('display','block');
          $('#botaoprecadastro').css('display','none');
        }
      })
    })



  </script>

</body>

</html>
