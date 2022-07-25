<?php
session_start();

require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');

$queryso .= " WHERE MSO.id_equipamento = 0 AND MSO.deletar = 0";

$result = $conn->query($queryso);

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="listequipamentos.php?pagina=5"><i class="fas fa-laptop"></i> Equipamentos</a> /
    <i class="fab fa-windows"></i> Windows's
  </h1>
  <hr />

  <!-- Page Heading -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">
        <i class="fab fa-windows"></i> Windows's
        <a href="windowsedit.php?pagina=5" class="float-right btn btn-success" title="Novo Windows"><i class="fas fa-plus"></i></a>
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered small-lither" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>VERSÂO</th>
              <th>SERIAL</th>
              <th>FORNECEDOR</th>
              <th>NOTA FISCAL</th>
              <th>DATA NOTA FISCAL</th>
              <th>EMPRESA</th>
              <th>LOCALIDADE</th>
              <th class="maior">AÇÃO</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>VERSÂO</th>
              <th>SERIAL</th>
              <th>FORNECEDOR</th>
              <th>NOTA FISCAL</th>
              <th>DATA NOTA FISCAL</th>
              <th>EMPRESA</th>
              <th>LOCALIDADE</th>
              <th class="maior">AÇÃO</th>
            </tr>
          </tfoot>
          <tbody class="colorTable">
            <?php
            while ($windows = $result->fetch_assoc()) {
              echo '<tr>';

              echo empty($windows['versao']) ?  '<td>-</td>' :  '<td>' . $windows['versao'] . '</td>';
              echo empty($windows['serial']) ?  '<td>-</td>' :  '<td>' . $windows['serial'] . '</td>';
              echo empty($windows['fornecedor']) ?  '<td>-</td>' :  '<td>' . $windows['fornecedor'] . '</td>';
              echo empty($windows['numero_nota']) ?  '<td>-</td>' :  '<td>' . $windows['numero_nota'] . ' <a href="' . $windows['caminho'] . '" class="text-info" target="_blank" title="Ver Nota"><i class="fas fa-eye"></i></a></td>';
              echo empty($windows['data_nota']) ?  '<td>-</td>' :  '<td>' . $windows['data_nota'] . '</td>';
              echo empty($windows['empresa']) ?  '<td>-</td>' :  '<td>' . $windows['empresa'] . '</td>';
              echo empty($windows['locacao']) ?  '<td>-</td>' :  '<td>' . $windows['locacao'] . '</td>';
              /*AÇÂO*/
              echo '<td>
                            <a href="windowsedit.php?pagina=5&id=' . $windows['id'] . '" class="text-success menu rigtIcones" title="Editar/Visualizar">
                              <i class="fas fa-pen"></i>
                            </a>';

              if (!empty($_GET['id_equip'])) {
                echo '<a class="text-success menu rigtIcones" title="Vincular para o equipamento id=' . $_GET['id_equip'] . '" href="../inc/vincularwindows.php?id=' . $windows['id'] . '&id_equip=' . $_GET['id_equip'] . '">
                              <i class="fas fa-plus"></i>
                            </a>';
              } else {
                echo '<a class="text-success menu rigtIcones" title="Vincular a um equipamento" href="vincularwindows.php?pagina=5&id=' . $windows['id'] . '">
                              <i class="fas fa-laptop-medical"></i>
                            </a>';
              }
              echo '</td>';
              /*FIM AÇÂO*/

              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
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