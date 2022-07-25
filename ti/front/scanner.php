<?php
session_start();

require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');

$queryEquipamento .= " WHERE MIE.tipo_equipamento = 10 AND MIE.deletar = 0";

$result = $conn->query($queryEquipamento);

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="listequipamentos.php?pagina=5"><i class="fas fa-laptop"></i> Equipamentos</a> /
    <i class="fas fa-print"></i> Scanner
  </h1>
  <hr />

  <!-- Page Heading -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">
        <i class="fas fa-print"></i> Scanner
        <a href="novoequipamento.php?pagina=5" class="float-right btn btn-success" title="Novo Scanner"><i class="fas fa-plus"></i></a>
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered small-lither" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>SITUAÇÃO</th>
              <th>MODELO</th>
              <th>N.SÉRIE</th>
              <th>PATRIMÔNIO</th>
              <th>FORNECEDOR</th>
              <th>FIM CONTRATO</th>
              <th>EMPRESA</th>
              <th>LOCAÇÃO</th>
              <th>STATUS</th>
              <th class="maior">AÇÃO</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>SITUAÇÃO</th>
              <th>MODELO</th>
              <th>N.SÉRIE</th>
              <th>PATRIMÔNIO</th>
              <th>FORNECEDOR</th>
              <th>FIM CONTRATO</th>
              <th>EMPRESA</th>
              <th>LOCAÇÃO</th>
              <th>STATUS</th>
              <th class="maior">AÇÃO</th>
            </tr>
          </tfoot>
          <tbody class="colorTable">
            <?php
            while ($scanner = $result->fetch_assoc()) {
              echo '<tr>';
              echo empty($scanner['situacao']) ?  '<td>-</td>' :  '<td>' . $scanner['situacao'] . '</td>';
              echo empty($scanner['modelo']) ?  '<td>-</td>' :  '<td>' . $scanner['modelo'] . '</td>';
              echo empty($scanner['serialnumber']) ?  '<td>-</td>' :  '<td>' . $scanner['serialnumber'] . '</td>';
              echo empty($scanner['patrimonio']) ?  '<td>-</td>' :  '<td>' . $scanner['patrimonio'] . '</td>';
              echo empty($scanner['fornecedor_scan']) ?  '<td>-</td>' :  '<td>' . $scanner['fornecedor_scan'] . '</td>';
              echo empty($scanner['data_fim_contrato']) ?  '<td>-</td>' :  '<td>' . $scanner['data_fim_contrato'] . '</td>';
              echo empty($scanner['empresa']) ?  '<td>-</td>' :  '<td>' . $scanner['empresa'] . '</td>';
              echo empty($scanner['locacao']) ?  '<td>-</td>' :  '<td>' . $scanner['locacao'] . '</td>';
              echo empty($scanner['status']) ?  '<td>-</td>' :  '<td style="font-size: 8px;">' . $scanner['status'] . '</td>';
              /*AÇÂO*/

              //EDITAR
              echo '<td>
              <a class="text-success menu rigtIcones" title="Editar" href="editequipamento.php?pagina=5&id_equip=' . $scanner['id_equipamento'] . '"><i class="fas fa-pen"></i></a>';

              //USUÀRIO
              if (!empty($scanner['nome'])) {
                echo '<a class="text-info menu rigtIcones" title="' . $scanner['nome'] . '" href="../inc/pesquisaFuncionario.php?id=' . $scanner['id_funcionario'] . '"><i class="fas fa-user"></i></a>';
              } else {
                echo '<a class="text-warning menu rigtIcones" title="Vincular Colaborador" href="vincular.php?pagina=5&amp;id_equip=' . $scanner['id_equipamento'] . '"><i class="fas fa-user-plus"></i></a>';
              }

              //TERMO
              echo '
              <a href="../inc/termo_scanner.php?id=' . $scanner['id_equipamento'] . '&id_fun=' . $scanner['id_funcionario'] . '" class="text-primary menu rigtIcones" title="Emitir termo" target="_blank">
                <i class="fas fa-file"></i>
              </a>';

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