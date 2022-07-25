<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */

session_start();
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');
require_once('../inc/dropdown.php');

//EQUIPAMENTO
$queryEquipamento .= " WHERE MIE.deletar = 0 AND MIE.tipo_equipamento IN (8,9)";
$resultEquipamento = $conn->query($queryEquipamento);

//FUNCIONÁRIO
$queryColaborador .= " WHERE MIF.deletar = 0 ORDER BY MIF.nome ASC";
$resultFuncionario = $conn->query($queryColaborador);

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="listequipamentos.php?pagina=5"><i class="fas fa-laptop"></i> Equipamentos</a> /
    <a href="windows.php?pagina=5"><i class="fab fa-windows"></i> Windows Disponíveis</a> /
    <i class="fas fa-laptop-medical"></i> Vincular ao Equipamento
  </h1>
  <hr />
  <!-- /.container-fluid -->
  <form action="../inc/vincularwindows.php?id=<?= $_GET['id'] ?>" method="POST" autocomplete="off">
    <h1 class="h6 mb-2 text-gray-800">
      <i class="fas fa-angle-double-right"></i> Escolha o Equipamento [Patrimônio]?
      <span class="colorRed">*</span>
    </h1>

    <div class="col-md-4 py-4 input-group">
      <select name="equip" class="form-control" required>
        <option value="">----------</option>
        <?php


        while ($equipamentos = $resultEquipamento->fetch_assoc()) {


          $query = "SELECT * FROM manager_sistema_operacional WHERE id_equipamento = " . $equipamentos['id_equipamento'] . "";
          $result = $conn->query($query);
          $windows = $result->fetch_assoc();

          if (empty($windows['id_equipamento'])) {
            echo '<option value="' . $equipamentos['id_equipamento'] . '">' . $equipamentos['patrimonio'] . '</option>';
          }
        }
        ?>
      </select>
    </div>
    <hr>
    <button type="submit" class="btn btn-success btn-icon-split textCenterTela mb-5">
      <span class="icon text-white-50">
        <i class="fas fa-laptop-medical"></i>
      </span>
      <span class="text">Vincular</span>
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

</html>