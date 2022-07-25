<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */

require_once('../bd/conexao.php');
require_once('header.php');
require_once('../inc/dropdown.php');
require_once('../inc/pesquisas.php');


//OFFICE QUE SERA EDITADO
if (!empty($_GET['id'])) {
  $queryoffice .= " WHERE MO.id = " . $_GET['id'] . "";
  $resultOffice = $conn->query($queryoffice);
  $office = $resultOffice->fetch_assoc();
}

?>
<!-- Begin Page Content -->
<div class="container-fluid py-4">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="../front/front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="../front/listequipamentos.php?pagina=5"><i class="fas fa-laptop"></i> Equipamentos</a> /
    <a href="../front/office.php?pagina=5"><i class="fab fa-windows"></i> Office's </a> /
    <?= empty($_GET['id']) ? "<i class='fas fa-plus'></i> Novo Office" : '<i class="fas fa-pen"></i> Editar Office' ?>
  </h1>
  <!-- /.container-fluid -->
  <hr>
  <div class="col-lg-6 left">
    <!-- Circle Buttons -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>"> <?= empty($_GET['id']) ? "<i class='fas fa-plus'></i> Novo Office" : '<i class="fas fa-pen"></i> Editar Office' ?> </h6>
      </div>
      <div class="card-body">
        <form action="../inc/officeedit.php?id=<?= $_GET['id'] ?>&id_equip=<?= $_GET['id_equip'] ?>" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="versao">Versão:</label>
            <select class="form-control" id="exampleFormControlSelect2" name="versao" required>
              <?php

              echo empty($office['id_versao']) ? "" : "<option value='" . $office['id_versao'] . "'>" . $office['versao'] . "</option>";

              echo "<option value='' >----------</option>";
              $r = $conn->query($queryListOffice);

              while ($listOffice = $r->fetch_assoc()) {
                echo '<option value="' . $listOffice['id'] . '">' . $listOffice['nome'] . '</option>';
              }

              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="email">Serial:</label>
            <input type="text" class="form-control" id="serial" value="<?= $office['serial'] ?>" name="serial">
          </div>

          <div class="form-group">
            <label for="exampleFormControlSelect2">Fornecedor:</label>
            <select class="form-control" id="exampleFormControlSelect2" class="border-bottom-info" name="fornecedor">

              <?php

              echo empty($office['fornecedor']) ?: "<option value='" . $office['fornecedor'] . "'>" . $office['fornecedor'] . "</option>";

              echo "<option>----------</option>";

              $resultFornecedor = $conn->query($queryFornecedor);

              while ($fornecedor = $resultFornecedor->fetch_assoc()) {
                echo '<option value="' . $fornecedor['nome'] . '">' . $fornecedor['nome'] . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="exampleFormControlSelect2">Empresa:</label>
            <select class="form-control" id="exampleFormControlSelect2" name="empresa">
              <?php

              echo empty($office['id_empresa']) ?: "<option value='" . $office['id_empresa'] . "'>" . $office['empresa'] . "</option>";

              echo "<option>----------</option>";

              $resultEmpresa = $conn->query($queryEmpresa);

              while ($empresa = $resultEmpresa->fetch_assoc()) {
                echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="exampleFormControlSelect2">Localização:</label>
            <select class="form-control" id="exampleFormControlSelect2" name="locacao">
              <?php

              echo empty($office['id_locacao']) ?: "<option value='" . $office['id_locacao'] . "'>" . $office['locacao'] . "</option>";

              echo "<option>----------</option>";

              $resultLocacao = $conn->query($queryLocacao);

              while ($locacao = $resultLocacao->fetch_assoc()) {
                echo '<option value="' . $locacao['id'] . '">' . $locacao['nome'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group" style="display: <?= empty($_GET['id']) ? 'block' : 'none' ?>">
            <label for="exampleFormControlSelect2">Possui Nota Fiscal?</label>
            <div class="py-2 mb-2 input-group">
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
                <label for="exampleFormControlSelect2">Número Nota:</label>
                <div class="col-md-6 py-2">
                  <input type="text" class="form-control" value="<?= $office['fornecedor'] ?>" name="numero_nota">
                </div>
              </div>

              <div class="form-group">
                <label for="exampleFormControlSelect2">Data Nota:</label>
                <div class="col-md-4 py-2">
                  <input type="text" class="form-control" value="<?= $office['fornecedor'] ?>" name="data_nota" placeholder="xx/xx/xxxx">
                </div>
              </div>

              <div class="form-group">
                <label for="exampleFormControlSelect2">Nota Fiscal:</label>
                <div class="col-md-4 py-2">
                  <input type="file" name="anexo">
                </div>
              </div>
            </div>
          </div>
          <hr>
          <?php
          if (empty($_GET['id'])) {
            echo '<button type="submit" class="btn btn-success btn-block">Salvar';
            if (!empty($_GET['id_equip'])) {
              echo " + Vincular ao equipamento";
            }
            echo "</button>";
          } else {
            echo '<button type="submit" class="btn btn-info btn-block">Editar</button>';
          }
          ?>
          <hr>
        </form>
      </div>

    </div>

  </div>
  <div class="card-body" style="display: <?= empty($_GET['id']) ? 'none' : 'block' ?>">
    <h6 class="m-0 font-weight-bold text-primary">
      <i class="fas fa-file"></i> Nota Fiscal OFFICE
      <a href="#" data-toggle="modal" data-target="#novo" class="float-right btn btn-success" style="margin-bottom: 20px;" title="Novo Documento"><i class="fas fa-plus"></i></a>
    </h6>
    <div class="table-responsive">
      <table class="table table-bordered small-lither" id="" cellspacing="0">
        <thead class="bold">
          <tr>
            <th>NOTA FISCAL</th>
            <th>NÚMERO NOTA FISCAL</th>
            <th>DATA NOTA FISCAL</th>
            <th class="maior">AÇÃO</th>
          </tr>
        </thead>
        <tbody class="colorTable">
          <?php
          echo '<tr>';
          echo empty($office['nome'])  ?  '<td></td>' :  '<td><a href="' . $office['caminho'] . '" class="text-info" target="_blank" title="Ver documento">' . $office['nome'] . '</a></td>';
          echo empty($office['numero_nota']) != 0 ?  '<td></td>' :  '<td>' . $office['numero_nota'] . '</td>';
          echo empty($office['data_nota']) != 0 ?  '<td></td>' :  '<td>' . $office['data_nota'] . '</td>';
          /*AÇÂO*/
          echo empty($office['numero_nota']) ? '<td></td>' : '<td><a href="javascript:" class="text-danger menu rigtIcones" title="Excluir" data-toggle="modal" data-target="#desativar"><i class="fas fa-trash"></i></a>
        </td>';
          /*FIM AÇÂO*/
          echo '</tr>';
          ?>
        </tbody>
      </table>
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
<!-- Logout Modal-->
<div class="modal fade" id="desativar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Realmente quer <span class='colorRed'>EXCLUIR</span> essa Nota ?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <span class="textCenterModal"><?= $office['nome']  ?></span>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Não</button>
        <a class="btn btn-primary" href="../inc/notadrop.php?pagina=5&id=<?= $office['id'] ?>">Sim</a>
      </div>
    </div>
  </div>
</div>

<!-- Novo documento modal-->
<div class="modal fade" id="novo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-file-upload"></i> Nova Nota Fiscal</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../inc/novanota.php?id=<?= $office['id'] ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
          <!--NOTA FISCAL DATA-->


          <div class="col-md-12 form-group">
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

          <div class="col-md-4 input-group">
            <div class="form-group">
              <label for="nome">Número Nota: </label>
              <input type="text" class="form-control" name="numero_nota">
            </div>
          </div>
          <div class="col-md-4 input-group">
            <div class="form-group">
              <label for="nome">Data Nota: </label>
              <input type="text" class="form-control" name="data_nota" placeholder="xx/xx/xxxx">
            </div>
          </div>
          <div class="col-md-4 input-group">
            <div class="form-group">
              <label for="nome">Nota: </label>
              <input type="file" class="form-control-file" name="anexo" required>
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-success" type="submit">Salvar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
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