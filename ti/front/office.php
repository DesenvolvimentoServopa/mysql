<?php
  session_start();

  require_once('header.php');
  require_once('../inc/pesquisas.php');
  require_once('../bd/conexao.php');

  $queryoffice .= " WHERE MO.id_equipamento = 0 AND MO.deletar = 0";

  $result = $conn->query($queryoffice);

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="listequipamentos.php?pagina=5"><i class="fas fa-laptop"></i> Equipamentos</a> /
    <i class="fab fa-windows"></i> Office's
  </h1>
  <hr />

  <!-- Page Heading -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">
        <i class="fab fa-windows"></i> Office's
        <a href="officeedit.php?pagina=5" class="float-right btn btn-success" title="Novo Office"><i class="fas fa-plus"></i></a>
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
            while ($office = $result->fetch_assoc()) {
              echo '<tr>';

                    echo empty($office['versao']) ?  '<td>-</td>' :  '<td>' . $office['versao'] . '</td>';
                    echo empty($office['serial']) ?  '<td>-</td>' :  '<td>' . $office['serial'] . '</td>';
                    echo empty($office['fornecedor']) ?  '<td>-</td>' :  '<td>' . $office['fornecedor'] . '</td>';
                    echo empty($office['numero_nota']) ?  '<td>-</td>' :  '<td>' . $office['numero_nota'] . ' <a href="' . $office['caminho'] . '" class="text-info" target="_blank" title="Ver Nota"><i class="fas fa-eye"></i></a></td>';
                    echo empty($office['data_nota']) ?  '<td>-</td>' :  '<td>' . $office['data_nota'] . '</td>';
                    echo empty($office['empresa']) ?  '<td>-</td>' :  '<td>' . $office['empresa'] . '</td>';
                    echo empty($office['locacao']) ?  '<td>-</td>' :  '<td>' . $office['locacao'] . '</td>';
                    /*AÇÂO*/
                    echo '<td>
                            <a href="officeedit.php?pagina=5&id=' . $office['id'] . '" class="text-success menu rigtIcones" title="Editar/Visualizar">
                              <i class="fas fa-pen"></i>
                            </a>';

                            if(!empty($_GET['id_equip'])){
                              echo '<a class="text-success menu rigtIcones" title="Vincular para o equipamento id='.$_GET['id_equip'].'" href="../inc/vincularoffice.php?id='.$office['id'].'&id_equip='.$_GET['id_equip'].'">
                              <i class="fas fa-plus"></i>
                            </a>';
                            }else{
                              echo '<a class="text-success menu rigtIcones" title="Vincular a um equipamento" href="vincularoffice.php?pagina=5&id=' . $office['id'] . '">
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