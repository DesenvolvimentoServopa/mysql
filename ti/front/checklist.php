<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */

session_start();
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');

//colaborador

if ($_GET['id'] == NULL) {

  $id_funcionario = $_SESSION['id_funcionario'];
  $nomeFuncionario = $_SESSION['nomeFuncionario'];
} else {
  $id_funcionario = $_GET['id'];

  //funcionario
  $queryColaborador .= "WHERE MIF.id_funcionario = " . $id_funcionario . "";
  $funcionario = $conn->query($queryColaborador);
  $nomeFuncionario = $funcionario->fetch_assoc();
}

//equipamento
$queryEquipamento .= "WHERE MIE.id_funcionario = " . $id_funcionario . " AND MIE.tipo_equipamento IN (";

while ($permissaoEquipamento = $resultPermissaoEquipamento->fetch_assoc()) {
  $queryEquipamento .= $permissaoEquipamento['id_equipamento'] . ',';
}

$queryEquipamento .= "'')";

$resultEquipamento = $conn->query($queryEquipamento);


?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="mb-6 text-gray-800">
    <!-- Page Heading -->
    <h1 class="text-xs mb-6 text-gray-800">
      <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
      <a href="colaboradores.php?pagina=3"><i class="fas fa-users"></i> Colaboradores</a> /
      <?php
      if ($_GET['id'] == NULL) {

        echo '
          <a href="funcionario.php?pagina=3"><i class="fas fa-user"></i> ' . $nomeFuncionario . '</a> /
          <a href="funcionarioequip.php?pagina=3"><i class="fas fa-laptop"></i> Equipamentos</a> /
          ';
      } else {
        echo '<a href="../inc/pesquisaFuncionario.php?id=' . $nomeFuncionario['id_funcionario'] . '"><i class="fas fa-user"></i> ' . $nomeFuncionario['nome'] . '</a> /';
      }
      ?>

      <i class="fas fa-file"></i> Emitir Check-List
    </h1>
  </h1>
  <hr />
  <!-- /.container-fluid -->
  <form action="../inc/checklist.php?id=<?= $_GET['id'] ?>" method="POST">
    <!-- Page Heading -->
    <h1 class="h6 mb-2 text-gray-800"><i class="fas fa-angle-double-right"></i> Este funcionário foi demitido ?</h1>
    <div class="col-md-4 py-4 input-group">
      <select name="demitido" class="form-control" required>
        <option value="">---</option>
        <option value="0">Sim</option>
        <option value="1">Não</option>
      </select>
    </div>

    <!-- Page Heading -->
    <h1 class="h6 mb-2 text-gray-800"><i class="fas fa-angle-double-right"></i> Emitir check-list de todos os equipamentos ?</h1>
    <div class="col-md-4 py-4 input-group">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="todosEquipamentos" id="exampleRadios1" value="1" onclick="sim()" checked>
        <label class="form-check-label" for="exampleRadios1">
          Sim
        </label>
      </div>
      <div class="form-check left">
        <input class="form-check-input" type="radio" name="todosEquipamentos" id="exampleRadios2" value="2" onclick="nao()">
        <label class="form-check-label" for="exampleRadios2">
          Não
        </label>
      </div>
    </div>

<!-- End of Main Content -->

<!-- DataTales Example -->
<div class="card shadow mb-4" id="tabelaEquip" style="display: none;">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Qual Equipamento ?</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered small" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Check</th>
            <th>Equipamento</th>
            <th>Modelo</th>
            <th>Patrimonio</th>
            <th>Número</th>
            <th>IMEI</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Check</th>
            <th>Equipamento</th>
            <th>Modelo</th>
            <th>Patrimonio</th>
            <th>Número</th>
            <th>IMEI</th>
          </tr>
        </tfoot>
        <tbody class="colorTable">
          <?php
          while ($equip = $resultEquipamento->fetch_assoc()) {
            echo '
                  <tr>
                    <td><input type="checkbox" value="' . $equip['id_equipamento'] . '" name="equip[]"></td>
                    <td>';
            echo empty($equip['tipo_equipamento']) ? "---" : $equip['tipo_equipamento'];
            echo '</td>
                    <td>';
            echo empty($equip['modelo']) ? "---" : $equip['modelo'];
            echo '</td>
                    <td>';
            echo empty($equip['patimonio']) ? "---" : $equip['patrimonio'];
            echo '</td>
                    <td>';
            echo empty($equip['numero']) ? "---" : $equip['numero'];
            echo '</td>
                    <td>';
            echo empty($equip['imei_chip']) ? "---" : $equip['imei_chip'];
            echo '</td>
                  </tr>
                  ';
          }

          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<hr>
<button type="submit" class="btn btn-warning btn-icon-split textCenterTela mb-5">
  <span class="icon text-white-50">
    <i class="fas fa-check"></i>
  </span>
  <span class="text">Emitir Check-List</span>
</button>
</form>
</div>

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
    document.getElementById("tabelaEquip").style.display = "block";
  }

  function sim() {
    document.getElementById("tabelaEquip").style.display = "none";
  }
</script>

</html>