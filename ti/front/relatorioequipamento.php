<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */

session_start();
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');
require_once('../inc/dropdown.php');

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="relatorios.php?pagina=6"><i class="fas fa-file-contract"></i> Relatórios</a> /
    <i class="fas fa-laptop"></i> Relatórios Equipamento
  </h1>
  <hr />
  <!-- /.container-fluid -->
  <form action="relatorioresultadoequip.php" method="GET" autocomplete="off">

    <!--TIPO 1-->
    <input type="text" style="display: none;" name="tipo" value="2">

    <!--TIPO EQUIPAMENTO-->
    <h1 class="h6 mb-2 text-gray-800">
      <i class="fas fa-angle-double-right"></i> Tipo Equipamento:
    </h1>

    <div class="col-md-4 py-4 input-group">
      <select name="tipoEquip" class="form-control">
        <option value="">----------</option>
        <?php

        $queryEquipamentos .= " AND id_equip IN (";

        while ($permissaoEquipamento = $resultPermissaoEquipamento->fetch_assoc()) {

          $queryEquipamentos .= $permissaoEquipamento['id_equipamento'] . ',';
        }

        $queryEquipamentos .= "'') ORDER BY nome ASC";

        $rest = $conn->query($queryEquipamentos);

        while ($tipoEquip = $rest->fetch_assoc()) {
          echo '<option value="' . $tipoEquip['id'] . '">' . $tipoEquip['nome'] . '</option>';
        }

        ?>
      </select>
    </div>

    <!--STATUS-->
    <h1 class="h6 mb-2 text-gray-800">
      <i class="fas fa-angle-double-right"></i> Status:
    </h1>

    <div class="col-md-4 py-4 input-group">
      <select name="status" class="form-control">
        <option value="">----------</option>
        <?php
        $resultStatusEquipament = $conn->query($queryStatusEquipamento);

        while ($statusEquipament = $resultStatusEquipament->fetch_assoc()) {
          echo '<option value="' . $statusEquipament['id'] . '">' . $statusEquipament['nome'] . '</option>';
        }
        ?>
      </select>
    </div>

    <!--EMPRESA-->
    <h1 class="h6 mb-2 text-gray-800">
      <i class="fas fa-angle-double-right"></i> Empresa:
    </h1>

    <div class="col-md-4 py-4 input-group">
      <select name="empresa" class="form-control">
        <option value="">----------</option>
        <?php
        $resultEmpresa = $conn->query($queryEmpresa);

        while ($empresa = $resultEmpresa->fetch_assoc()) {
          echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
        }
        ?>
      </select>
    </div>
    <hr>
    <button type="submit" class="btn btn-success btn-icon-split textCenterTela mb-5">
      <span class="icon text-white-50">
        <i class="fas fa-search"></i>
      </span>
      <span class="text">Gerar Relatório</span>
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