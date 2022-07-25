<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */
session_start();

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

//sabendo o tipo de equipamento

switch ($_SESSION['tipo_equipamento']) {
  case 'Notebook':
    $tipoequipamento = 9;
    break;

  case 'Mini Tower':
    $tipoequipamento = 8;
    break;

  case 'Tower':
    $tipoequipamento = 8;
    break;

  case 'To be filled by O.E.M.':
    $tipoequipamento = 8;
    break;

  case 'Portable':
    $tipoequipamento = 9;
    break;

  case 'Low Profile Desktop':
    $tipoequipamento = 8;
    break;

  case 'Docking Station':
    $tipoequipamento = 9;
    break;

  case 'Desktop':
    $tipoequipamento = 8;
    break;

  case 'Default string':
    $tipoequipamento = 8;
    break;

  case '12060':
    $tipoequipamento = 8;
    break;

  default:
    $tipoequipamento = 0;
    break;
}

?>
<!-- Begin Page Content -->
<div class="container-fluid py-4">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="listequipamentos.php?pagina=5"><i class="fas fa-laptop"></i> Equipamentos</a> /
    <i class="fas fa-plus"></i> <?= $_SESSION['patrimonio'] ?>
  </h1>
  <hr>

  <div class="col-lg-6 left">
    <!-- Circle Buttons -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>"><i class="fas fa-laptop"></i> Equipamento</h6>
      </div>
      <div class="card-body">
        <form action="../inc/novoequipamento.php" method="POST" enctype="multipart/form-data" autocomplete="off">
          <!--COLABORADOR-->
          <div>
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
          <!--TIPO EQUIPAMENTO-->
          <div class="form-group">
            <label for="tipo_equipamento" class="border-bottom-info">Tipo Equipamento:</label>
            <select class="form-control" id="tipo_equipamento" name="tipo_equipamento" required>
              <?php

              if ($tipoequipamento == 0) {

                echo '<option value="">----------</option>';

                $queryEquipamentos .= " AND id_equip IN (8 ,9)";

                $rest = $conn->query($queryEquipamentos);

                while ($tipoEquip = $rest->fetch_assoc()) {
                  echo '<option value="' . $tipoEquip['id'] . '">' . $tipoEquip['nome'] . '</option>';
                }
              } else {
                //sabendo qual é o tipo de equipamento

                $queryEquipamentos .= " AND id_equip = " . $tipoequipamento . "";
                $rest = $conn->query($queryEquipamentos);
                $tipoEquip = $rest->fetch_assoc();

                echo '<option value="' . $tipoEquip['id'] . '" selected>' . $tipoEquip['nome'] . '</option>';
              }



              ?>
            </select>
          </div>
          <!--MODELO-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info" class="border-bottom-info">Modelo:</label>
            <input type="text" class="form-control" name="modelo" value="<?= $_SESSION['modelo'] ?>">
          </div>
          <!--PATRIMONIO-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info" class="border-bottom-info">Patrimônio:</label>
            <input type="text" class="form-control" name="patrimonio" value="<?= $_SESSION['patrimonio'] ?>">
          </div>
          <!--DOMINIO-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info" class="border-bottom-info">Dominío:</label>
            <div class="form-group col-md-3">
              <?= $_SESSION['possuidominio'] == 0 ? '<input type="text" class="form-control text-success" name="dominio" value="' . $_SESSION['possuidominio'] . '" style="text-align: center; display: none;" > <i class="fas fa-check-circle text-success" style="width: 175%;"> Cadastrado</i>' : '<input type="text" class="form-control text-danger" name="dominio" value="1" style="text-align: center; display: none; "><i class="fas fa-times-circle text-danger" style="width: 175%;"> Não cadastrado</i> ' ?>

            </div>
          </div>
          <!--EMPRESA-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info" class="border-bottom-info">Empresa Faturado:</label>
            <select class="form-control" id="exampleFormControlSelect2" class="border-bottom-info" name="empresa">
              <option>----------</option>
              <?php

              $resultEmpresa = $conn->query($queryEmpresa);

              while ($empresa = $resultEmpresa->fetch_assoc()) {
                echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
              }
              ?>
            </select>
          </div>
          <!--LOCACO-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info" class="border-bottom-info">Localização:</label>
            <select class="form-control" id="exampleFormControlSelect2" class="border-bottom-info" name="locacao">
              <option>----------</option>
              <?php

              $resultLocacao = $conn->query($queryLocacao);

              while ($locacao = $resultLocacao->fetch_assoc()) {
                echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
              }
              ?>
            </select>
          </div>
          <!--Departamento-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info" class="border-bottom-info">Departamento:</label>
            <select class="form-control" id="exampleFormControlSelect2" class="border-bottom-info" name="departamento">
              <option>----------</option>
              <?php

              $resultDepartamento = $conn->query($queryDepartamento);

              while ($departamento = $resultDepartamento->fetch_assoc()) {
                echo '<option value="' . $departamento['id'] . '">' . $departamento['nome'] . '</option>';
              }
              ?>
            </select>
          </div>
          <!--Situação-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info" class="border-bottom-info">Situação:</label>
            <select class="form-control" id="exampleFormControlSelect2" class="border-bottom-info" name="situacao">
              <option>----------</option>
              <?php

              $resultSituacao = $conn->query($querySituacao);

              while ($situacao = $resultSituacao->fetch_assoc()) {
                echo '<option value="' . $situacao['id'] . '">' . $situacao['nome'] . '</option>';
              }
              ?>
            </select>
          </div>
          <!--status-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info">Status:</label>
            <select class="form-control" id="exampleFormControlSelect2" class="border-bottom-info" name="status">
              <option>----------</option>
              <?php

              $resultStatus = $conn->query($queryStatusEquipamento);

              while ($status = $resultStatus->fetch_assoc()) {
                echo '<option value="' . $status['id'] . '">' . $status['nome'] . '</option>';
              }
              ?>
            </select>
          </div>
          <!--HOSTNAME-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info">Nome:</label>
            <input type="text" class="form-control" name="hostname" value="<?= $_SESSION['hostname'] ?>">
          </div>
          <!--HOSTNAME-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info">IP:</label>
            <input type="text" class="form-control" name="ip" value="<?= $_SESSION['ip'] ?>">
          </div>
          <!--PROCESSADOR-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info">Processador:</label>
            <input type="text" class="form-control" name="processador" value="<?= $_SESSION['processador'] ?>">
          </div>
          <!--HD-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info">HD:</label>
            <input type="text" class="form-control" name="hd" value="<?= $_SESSION['hd'] ?>">
          </div>
          <!--MEMORIA-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info">Memória:</label>
            <input type="text" class="form-control" name="memoria" value="<?= $_SESSION['memoria'] ?>">
          </div>
          <!--SERIAL NUMBER-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info">Número de Série:</label>
            <input type="text" class="form-control" name="serial_number" value="<?= $_SESSION['serial_number'] ?>">
          </div>
          <!-- NOTA FISCAL-->
          <div class="form-group" id="nota">
            <label for="exampleFormControlSelect2" class="border-bottom-info">Possui Nota Fiscal:</label>
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
              <!--FORNECEDOR-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Fornecedor:</label>
                <select class="form-control" id="exampleFormControlSelect2" class="border-bottom-info" name="fornecedor">
                  <option>----------</option>
                  <?php

                  $resultFornecedor = $conn->query($queryFornecedor);

                  while ($fornecedor = $resultFornecedor->fetch_assoc()) {
                    echo '<option value="' . $fornecedor['nome'] . '">' . $fornecedor['nome'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <!--NUMERO NOTA-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Número Nota:</label>
                <div class="col-md-6 py-2">
                  <input type="text" class="form-control" name="numero_nota">
                </div>
              </div>
              <!--DATA NOTA-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Data Nota:</label>
                <div class="col-md-4 py-2">
                  <input type="text" class="form-control" name="data_nota" placeholder="xx/xx/xxxx">
                </div>
              </div>
              <!--FILE NOTA-->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Nota Fiscal:</label>
                <div class="col-md-4 py-2">
                  <input type="file" name="anexo">
                </div>
              </div>
            </div>
          </div>
          <!--SISTEMA OPERACIONAL-->
          <hr>
          <h6 class="m-0 font-weight-bold text-primary"><i class="fab fa-windows"></i> Sistema Operacional</h6><br>

          <!--VERSÃO-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info">Versão:</label>
            <select class="form-control" id="exampleFormControlSelect2" class="border-bottom-info" name="versaoSO" required>
              <?php

              $queryWindows  .= " AND nome = '" . $_SESSION['sistema_operacional'] . "'";
              $resultWindows  = $conn->query($queryWindows);
              $windows = $resultWindows->fetch_assoc();

              if (!empty($windows['id'])) {
                echo '<option value="' . $windows['id'] . '" selected>' . $windows['nome'] . '</option>';
              } else {

                echo '<option value="">----------</option>';

                $query = "SELECT id, nome FROM manager_dropsistemaoperacional WHERE deletar = 0";

                $result  = $conn->query($query);

                while ($so = $result->fetch_assoc()) {
                  echo '<option value="' . $so['id'] . '">' . $so['nome'] . '</option>';
                }
              }
              ?>
            </select>
          </div>
          <!--SERIAL-->
          <div class="form-group">
            <label for="exampleFormControlSelect2" class="border-bottom-info">Chave do produto:</label>
            <input type="text" class="form-control" name="chaveProduto" value="<?= $_SESSION['chave_windows'] ?>">
          </div>

          <!--OFFICE-->
          <div style="display: <?= !empty($_SESSION['office']) ? "block" : "none" ?>;">
            <br>
            <hr>
            <h6 class="m-0 font-weight-bold text-primary"><i class="fab fa-windows"></i> OFFICE</h6><br>

            <!--VERSÃO-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Versão:</label>
              <select class="form-control" id="exampleFormControlSelect2" class="border-bottom-info" name="versao">
                <?php

                $queryListOffice  .= " AND nome = '" . $_SESSION['office'] . "' ORDER BY nome ASC";
                $resultOffice  = $conn->query($queryListOffice);
                $office = $resultOffice->fetch_assoc();

                if (!empty($office['id'])) {
                  echo '<option value="' . $office['id'] . '">' . $office['nome'] . '</option>';
                } else {

                  echo '<option value="">----------</option>';

                  $queryOffice = "SELECT id, nome FROM manager_dropoffice WHERE deletar = 0 ORDER BY nome ASC";

                  $resultOf  = $conn->query($queryOffice);

                  while ($of = $resultOf->fetch_assoc()) {
                    echo '<option value="' . $of['id'] . '">' . $of['nome'] . '</option>';
                  }
                }
                ?>
              </select>
            </div>
            <!--SERIAL-->
            <div class="form-group">
              <label for="exampleFormControlSelect2" class="border-bottom-info">Chave do produto:</label>
              <input type="text" class="form-control" name="serial_number" value="<?= $_SESSION['chave_office'] ?>">
            </div>
          </div>
          <!--FIM-->

          <!-- BOTAO SALVAR-->
          <div id="salvarButton">
            <br>
            <hr>
            <button type="submit" class="btn btn-success btn-block">Salvar</button>
          </div>
        </form>
        <!--FIM-->
      </div>
    </div>
  </div>
</div>

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