<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */

require_once('../bd/conexao.php');
require_once('header.php');
require_once('../inc/dropdown.php');
require_once('../inc/pesquisas.php');
require_once('../inc/permissoes.php');


//OFFICE QUE SERA EDITADO
if (!empty($_GET['id'])) {
  $queryoffice .= " WHERE MO.id = " . $_GET['id'] . "";
  $resultOffice = $conn->query($queryoffice);
  $office = $resultOffice->fetch_assoc();
}

//FUNCIONÁRIO
$queryColaborador .= " WHERE MIF.deletar = 0 AND MIF.departamento IS NOT NULL ORDER BY MIF.nome ASC";
$resultFuncionario = $conn->query($queryColaborador);

?>
<!-- Begin Page Content -->
<div class="container-fluid py-4">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="listequipamentos.php?pagina=5"><i class="fas fa-laptop"></i> Equipamentos</a> /
    <i class="fas fa-plus"></i> Novo Equipamento
  </h1>
  <hr>
  <div class="col-lg-6 left">
    <!-- Circle Buttons -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>"><i class="fas fa-plus"></i> Novo Equipamento</h6>
      </div>
      <div class="card-body">
        <form action="../inc/novoequipamento.php" method="POST" enctype="multipart/form-data" autocomplete="off">

          <div class="form-group">
            <!--EQUIPAMENTO-->
            <label for="versao">Tipo Equipamento:</label>
            <select class="form-control" id="tipo_equipamento" name="tipo_equipamento" onchange="tipoEquipamento()">
              <option>----------</option>
              <?php

              $queryEquipamentos .= " AND id_equip IN (";

              while ($permissaoEquipamento = $resultPermissaoEquipamento->fetch_assoc()) {

                $queryEquipamentos .= $permissaoEquipamento['id_equipamento'] . ',';
              }

              $queryEquipamentos .= "'')  ORDER BY nome ASC";

              $rest = $conn->query($queryEquipamentos);

              while ($tipoEquip = $rest->fetch_assoc()) {
                echo '<option value="' . $tipoEquip['id'] . '">' . $tipoEquip['nome'] . '</option>';
              }

              ?>
            </select>
          </div>

          <!--CELULAR / TABLET-->
          <div id="celularTablet" style="display: none;">
            <!--MODELO CELULAR / TABLET-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info"> Modelo:</label>
              <input type="text" class="form-control" name="modelo">
            </div>
            <!--PATRIMONIO CELULAR / TABLET-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info"> Patrimônio:</label>
              <input type="text" class="form-control" name="patrimonio">
            </div>
            <!--EMPRESA CELULAR / TABLET-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info"> Empresa:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="empresa">
                <option>----------</option>
                <?php

                $resultEmpresa = $conn->query($queryEmpresa);

                while ($empresa = $resultEmpresa->fetch_assoc()) {
                  echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
            <!--ESTADO CELULAR / TABLET-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info"> Estado:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="estado">
                <option>----------</option>
                <?php

                $resultEstado = $conn->query($queryEstado);

                while ($estado = $resultEstado->fetch_assoc()) {
                  echo '<option value="' . $estado['id'] . '">' . $estado['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
            <!--ACESSORIOS CELULAR / TABLET-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info"> Acessorios:</label><br>
              <?php

              $resultAcessorios = $conn->query($queryAcessorios);

              while ($Acessorios = $resultAcessorios->fetch_assoc()) {

                echo '<input type="checkbox" id="acessorios' . $Acessorios['id'] . '" name="acessorio[]" value="' . $Acessorios['id'] . '">
                        <label class="form-check-label" for="acessorios' . $Acessorios['id'] . '">' . $Acessorios['nome'] . '</label><br>';
              }
              ?>
            </div>
            <!--* IMEI CELULAR / TABLET-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info"> IMEI:</label>
              <input type="text" class="form-control" name="imei">
            </div>
            <!--STATUS CELULAR / TABLET-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info"> Status:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="status">
                <option>----------</option>
                <?php

                $resultStatus = $conn->query($queryStatusEquipamento);

                while ($status = $resultStatus->fetch_assoc()) {
                  echo '<option value="' . $status['id'] . '">' . $status['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
            <!--* VALOR CELULAR / TABLET-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info"> Valor:</label>
              <div class="form-group col-md-4">
                <div class="input-group-append">
                  <span class="btn btn-primary">
                    R$
                  </span>
                </div>
                <input type="text" class="form-control iconeAjustar" name="valor" onKeyPress="return(moeda(this,'.',',',event))">
              </div>
            </div>
          </div>
          <!--FIM-->

          <!--CHIP / MODEM-->
          <div id="chipModem" style="display: none;">
            <!--EMPRESA CHIP / MODEM-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Empresa:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="empresaChip">
                <option>----------</option>
                <?php

                $resultEmpresa = $conn->query($queryEmpresa);

                while ($empresa = $resultEmpresa->fetch_assoc()) {
                  echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
            <!--OPERADOR CHIP / MODEM-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Operadora:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="operadoraChip">
                <option>----------</option>
                <?php

                $resultqueryOperadora = $conn->query($queryOperadora);

                while ($operadora = $resultqueryOperadora->fetch_assoc()) {
                  echo '<option value="' . $operadora['id'] . '">' . $operadora['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
            <!--NUMERO CHIP / MODEM-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Número:</label>
              <input type="text" class="form-control" name="numeroChip" id="telefone" maxlength="15" placeholder="(xx) xxxx-xxx">
            </div>
            <!--PLANOS CHIP / MODEM-->
            <div class="form-group">
              <label for="voz" class="border-bottom-info">Planos:</label><br>
              <input type="checkbox" name="planosVoz" value="VOZ" id="voz">
              <label class="form-check-label" for="voz">Voz</label><br>

              <input type="checkbox" name="planosDados" value="DADOS" id="dados">
              <label class="form-check-label" for="dados">Dados</label><br>
            </div>
            <!--STATUS CHIP / MODEM-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Status:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="statusChip">
                <option>----------</option>
                <?php

                $resultStatusCHIP = $conn->query($queryStatusEquipamento);

                while ($chip = $resultStatusCHIP->fetch_assoc()) {
                  echo '<option value="' . $chip['id'] . '">' . $chip['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
            <!--IMEI CHIP / MODEM-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">IMEI:</label>
              <input type="text" class="form-control" name="imeiChip">
            </div>
          </div>
          <!--FIM-->

          <!--DVR-->
          <div id="dvr" style="display: none;">

            <!--MODELO DVR-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Modelo:</label>
              <input type="text" class="form-control" name="modeloDVR">
            </div>
            <!--PATRIMONIO DVR-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Patrimônio:</label>
              <input type="text" class="form-control" name="patrimonioDVR">
            </div>
            <!--NUMERO SERIE DVR-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">N. de série:</label>
              <input type="text" class="form-control" name="serieDVR">
            </div>
            <!--IP DVR-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">IP:</label>
              <input type="text" class="form-control" name="ipDVR">
            </div>
            <!--LOCALIZAÇÂO DVR-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Localização:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="localizacaoDVR">
                <option>----------</option>
                <?php

                $resultLocacao = $conn->query($queryLocacao);

                while ($locacao = $resultLocacao->fetch_assoc()) {
                  echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <!--HARDWARE REDE-->
          <div id="hREDE" style="display: none;">
            <!--MODELO REDE-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Modelo:</label>
              <input type="text" class="form-control" name="modeloREDE">
            </div>
            <!--PATRIMONIO REDE-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Patrimônio:</label>
              <input type="text" class="form-control" name="patrimonioREDE">
            </div>
            <!--NUMERO SERIE REDE-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">N. de série:</label>
              <input type="text" class="form-control" name="serieREDE">
            </div>
            <!--LOCALIZAÇÂO REDE-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Localização:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="localizacaoREDE">
                <option>----------</option>
                <?php

                $resultLocacao = $conn->query($queryLocacao);

                while ($locacao = $resultLocacao->fetch_assoc()) {
                  echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <!--FIM-->

          <!--RAMAL IP-->
          <div id="ramalIP" style="display: none;">
            <!--MODELO RAMAL-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Modelo:</label>
              <input type="text" class="form-control" name="modeloRamal">
            </div>
            <!--NUMERO RAMAL-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Número:</label>
              <input type="text" class="form-control" name="numeroRamal" maxlength="15">
            </div>
            <!--EMPRESA RAMAL-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Empresa:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="empresaRamal">
                <option>----------</option>
                <?php

                $resultEmpresa = $conn->query($queryEmpresa);

                while ($empresa = $resultEmpresa->fetch_assoc()) {
                  echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
            <!--LOCACAO RAMAL-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Locação:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="locacaoRamal">
                <option>----------</option>
                <?php

                $resultLocacao = $conn->query($queryLocacao);

                while ($locacao = $resultLocacao->fetch_assoc()) {
                  echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <!--FIM-->

          <!--SCANNER-->
          <div id="scanner" style="display: none;">
            <!--MODELO Scan-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Modelo:</label>
              <input type="text" class="form-control" name="modeloScan">
            </div>
            <!--SERIE Scan-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">N. série:</label>
              <input type="text" class="form-control" name="serieScan">
            </div>
            <!--PATRIMONIO Scan-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Patrimônio:</label>
              <input type="text" class="form-control" name="patrimonioScan">
            </div>
            <!--EMPRESA Scan-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Empresa:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="empresaScan">
                <option>----------</option>
                <?php

                $resultEmpresa = $conn->query($queryEmpresa);

                while ($empresa = $resultEmpresa->fetch_assoc()) {
                  echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
            <!--LOCACAO Scan-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Locação:</label>
              <select class="form-control" id="exampleFormControlSelect2" name="locacaoScan">
                <option>----------</option>
                <?php

                $resultLocacao = $conn->query($queryLocacao);

                while ($locacao = $resultLocacao->fetch_assoc()) {
                  echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
            <!--SITUAÇÂO Scan-->
            <div class="form-group">
              <label for="situacaoScan">Situação:</label>
              <select class="form-control" id="situacaoscan" name="situacaoscan" onchange="a()">
                <option>----------</option>
                <?php

                $resultSituacao = $conn->query($querySituacao);

                while ($situacao = $resultSituacao->fetch_assoc()) {
                  echo '<option value="' . $situacao['id'] . '">' . $situacao['nome'] . '</option>';
                }
                ?>
              </select>
            </div>

            <!--SITUAÇÂO ALUGADO Scan-->
            <div id="alugado" style="display: none;">
              <!--FORNECEDOR-->
              <div class="form-group">
                <label for="fornecedorScan" class="border-bottom-info">Fornecedor:</label>

                <select class="form-control" id="situacaoscan" name="fornecedorScan" onchange="a()">
                  <option>----------</option>
                  <?php

                  $resultFornecedor = $conn->query($queryFornecedor);

                  while ($fornecedor = $resultFornecedor->fetch_assoc()) {
                    echo '<option value="' . $fornecedor['id'] . '">' . $fornecedor['nome'] . '</option>';
                  }
                  ?>
                </select>




              </div>
              <!--DATA FIM CONTRATO-->
              <div class="form-group">
                <label for="dataFimContrato" class="border-bottom-info">Data fim contrato:</label>
                <input type="text" class="form-control" name="dataFimContrato" placeholder="xx/xx/xxxx">
              </div>
            </div>
            <!--SITUAÇÂO COMPRADO Scan-->
            <div id="comprado" style="display: none;">
              <div class="form-group">
                <label for="numero_notaScan" class="border-bottom-info">Número Nota:</label>
                <div class="col-md-6 py-2">
                  <input type="text" class="form-control" name="numero_notaScan">
                </div>
              </div>

              <div class="form-group">
                <label for="data_notaScan" class="border-bottom-info">Data Nota:</label>
                <div class="col-md-4 py-2">
                  <input type="text" class="form-control" name="data_notaScan" placeholder="xx/xx/xxxx">
                </div>
              </div>

              <div class="form-group">
                <label for="anexoScan" class="border-bottom-info">Nota Fiscal:</label>
                <div class="col-md-4 py-2">
                  <input type="file" name="anexoScan">
                </div>
              </div>
            </div>
          </div>
          <!--FIM-->

          <!-- NOTA FISCAL-->
          <div class="form-group" id="nota" style="display: none;">
            <label for="exampleFormControlSelect2" class="border-bottom-info">Possui Nota Fiscal?</label>
            <div class="py-2 input-group">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="todosEquipamentos" id="exampleRadios1" value="1" onclick="sim()">
                <label class="form-check-label" for="exampleRadios1">
                  Sim
                </label>
              </div>
              <div class="form-check" style="margin-left: 10px;">
                <input class="form-check-input" type="radio" name="todosEquipamentos" id="exampleRadios2" value="2" onclick="nao()" checked="">
                <label class="form-check-label" for="exampleRadios2">
                  Não
                </label>
              </div>
            </div>

            <div id='notafiscal' style="display: none;">
              <hr>
              <div class="form-group">
                <label for="exampleFormControlSelect2" class="border-bottom-info">Número Nota:</label>
                <div class="col-md-6 py-2">
                  <input type="text" class="form-control" name="numero_nota">
                </div>
              </div>

              <div class="form-group">
                <label for="exampleFormControlSelect2" class="border-bottom-info">Data Nota:</label>
                <div class="col-md-4 py-2">
                  <input type="text" class="form-control" name="data_nota" placeholder="xx/xx/xxxx">
                </div>
              </div>

              <div class="form-group">
                <label for="exampleFormControlSelect2" class="border-bottom-info">Nota Fiscal:</label>
                <div class="col-md-4 py-2">
                  <input type="file" name="anexo">
                </div>
              </div>
            </div>
          </div>

          <!--COLABORADOR-->
          <div style="display: none;" id="colaborador">
            <h1 class="h6 mb-2 text-gray-800 border-bottom-info"> Atribuir um colaborador ?</h1>
            <div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="todosFuncionarios" id="simFun" value="1" onclick="funOne()">
                <label class="form-check-label" for="simFun">
                  Sim
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input " type="radio" name="todosFuncionarios" id="naoFun" value="2" onclick="funTwo()" checked>
                <label class="form-check-label" for="naoFun">
                  Não
                </label>
              </div>
              <br>
              <!--MOSTRAR TABELA DOS EQUIPAMENTOS-->
              <script>
                function funTwo() {
                  document.getElementById("tabelaFun").style.display = "none";
                }

                function funOne() {
                  document.getElementById("tabelaFun").style.display = "block";
                }
              </script>
            </div>
          </div>
          <div id="tabelaFun" style="display: none;">
            <div class="col-md-20 py-4 input-group">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Escolha o Colaborador

                    <a class="btn btn-success btn-pen-square btn-sm float-rigth" title="Novo Usuário" href="#" data-toggle="modal" data-target="#adicionar">
                      <i class="fas fa-user-plus fa-sm"></i>
                    </a>
                  </h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered small-lither" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>AÇÃO</th>
                          <th>NOME</th>
                          <th>C.P.F</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>AÇÃO</th>
                          <th>NOME</th>
                          <th>C.P.F</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php

                        while ($colaborador = $resultFuncionario->fetch_assoc()) {
                          echo '<tr><td> <input class="" type="radio" name="newfun" value="' . $colaborador['id_funcionario'] . '" > </td>';
                          echo $colaborador['nome'] != NULL ?  '<td>' . $colaborador['nome'] . '</td>' :  '<td>----------</td>';
                          echo $colaborador['cpf'] != NULL ?  '<td>' . $colaborador['cpf'] . '</td>' :  '<td>----------</td>';
                        } //FIM WHILE $COLABORADOR
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- BOTAO SALVAR-->
          <div id="salvarButton">
            <hr>
            <button type="submit" class="btn btn-success btn-block">Salvar</button>
            <hr>
          </div>
        </form>

        <!--CPU / NOTEBOOK-->
        <div id="cpuNotebook" style="display: none;">
          <form action="../inc/pesquisaocs.php" method="POST" id="cpuNote" autocomplete="off">
            <!--* PATRIMONIO CPU / NOTEBOOK-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Patrimônio:</label>
              <div class="input-group-append">

                <div class="col-md-6 py-2">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="patimonioEquipamento">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit" for="cpuNote">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </form>
        </div>
        <!--FIM-->
      </div>
    </div>
  </div>
</div>

<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>TI Grupo Servopa - Qualquer dúvida ligue no 110-2151</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="adicionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Localizar Funcionário</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../inc/pesquisaFuncionario.php" method="POST" autocomplete="off">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Digite o CPF" id="RegraValida" name="cpf" onkeydown="javascript: fMasc( this, mCPF );" maxlength="14" onblur="ValidarCPF(this)">

            <span class="small-lither">Veja se ja está cadastrado!</span><br />
            <span class="text-danger" style="display: none;" id="cpfInvalido"><i class="fas fa-times-circle"></i> CPF Invalido!</span>
            <span class="text-success" style="display: none;" id="cpfValido"><i class="fas fa-check-circle"></i> CPF OK!</span>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-info" id="procurar" type="submit" disabled="false">Procurar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</body>
<!--MOSTRAR TABELA DOS EQUIPAMENTOS-->
<script>
  function nao() {
    document.getElementById("notafiscal").style.display = "none";
  }

  function sim() {
    document.getElementById("notafiscal").style.display = "block";
  }
</script>

</html>