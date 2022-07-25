<?php
session_start();
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');


$queryRelatorio = $queryEquipamento .= $whereEquipamento;
$resultEquipamento = $conn->query($queryRelatorio);

//sessão para exportar EXCEL
$_SESSION['query_relatorios'] = $queryRelatorio;

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="relatorios.php?pagina=6"><i class="fas fa-file-contract"></i> Relatórios</a> /
    <a href="relatorioequipamento.php?pagina=6"><i class="fas fa-user"></i> Relatórios Equipamento</a> /
    <i class="fas fa-tag"></i> Resultado
  </h1>
  <!-- Page Heading -->
  <hr />
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Relatório Equipamento</h1>
    <a href="../inc/relatorio_pdf.php" class="btn btn-sm btn-success" title="imprimir PDF" style="margin-left: 64%;" target="_blank"><i class="fas fa-print"></i></a>
    <a href="../inc/relatorio_excel.php" class="btn btn-sm btn-success" title="Exportar Excel" target="_blank"><i class="fas fa-file-excel"></i></a>
  </div>
  <!-- Page Heading -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>"><i class="fas fa-tag"></i> Resultado
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <!--TABELA DOS EQUIPAMENTOS-->
        <table class="table table-bordered small-lither" id="dataTable" width="100%" cellspacing="0" style="display: <?= $tabelaEquip ?>;">
          <thead>
            <tr>
              <th>STATUS</th>
              <th>MODELO</th>
              <th>EQUIPAMENTO</th>
              <th>PATRIMONIO</th>
              <th>NUMERO</th>
              <th>IMEI</th>
              <th>FUNCIONARIO</th>
              <th>DEPARTAMENTO</th>
              <th>EMPRESA</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>STATUS</th>
              <th>MODELO</th>
              <th>EQUIPAMENTO</th>
              <th>PATRIMONIO</th>
              <th>NUMERO</th>
              <th>IMEI</th>
              <th>FUNCIONARIO</th>
              <th>DEPARTAMENTO</th>
              <th>EMPRESA</th>
            </tr>
          </tfoot>
          <tbody>
            <?php

            while ($row = $resultEquipamento->fetch_assoc()) {

              echo '<tr>';

              switch ($row['id_status']) {
                case '1':
                  echo '<td><span class="icone btn-success">' . $row['status'] . '</span></td>';
                  break;
                case '6':
                  echo '<td><span class="icone btn-success">' . $row['status'] . '</span></td>';
                  break;
                case '10':
                  echo '<td><span class="icone btn-success">' . $row['status'] . '</span></td>';
                  break;
                case '15':
                  echo '<td><span class="icone btn-success">' . $row['status'] . '</span></td>';
                  break;
                case '2':
                  echo '<td><span class="icone btn-warning">' . $row['status'] . '</span></td>';
                  break;
                case '14':
                  echo '<td><span class="icone btn-warning">' . $row['status'] . '</span></td>';
                  break;
                case '20':
                  echo '<td><span class="icone btn-warning">' . $row['status'] . '</span></td>';
                  break;
                case '7':
                  echo '<td><span class="icone btn-danger">' . $row['status'] . '</span></td>';
                  break;
                case '11':
                  echo '<td><span class="icone btn-danger">' . $row['status'] . '</span></td>';
                  break;
                case '16':
                  echo '<td><span class="icone btn-danger">' . $row['status'] . '</span></td>';
                  break;
                case '17':
                  echo '<td><span class="icone btn-danger">' . $row['status'] . '</span></td>';
                  break;
                case '18':
                  echo '<td><span class="icone btn-danger">' . $row['status'] . '</span></td>';
                  break;
                case '19':
                  echo '<td><span class="icone btn-danger">' . $row['status'] . '</span></td>';
                  break;
                case '21':
                  echo '<td><span class="icone btn-danger">' . $row['status'] . '</span></td>';
                  break;
                default:
                  echo '<td>DESATIVADO</td>';
                  break;
              }

              echo $row['modelo'] != NULL ?  '<td>' . $row['modelo'] . '</td>' :  '<td>----------</td>';
              echo $row['tipo_equipamento'] != NULL ?  '<td><a href="editequipamento.php?pagina=5&id_equip='.$row['id_equipamento'] .'" target="_blank"">' . $row['tipo_equipamento'] . '</a></td>' :  '<td>----------</td>';
              echo $row['patrimonio'] != NULL ?  '<td>' . $row['patrimonio'] . '</td>' :  '<td>----------</td>';
              echo $row['numero'] != NULL ?  '<td>' . $row['numero'] . '</td>' :  '<td>----------</td>';
              echo $row['imei'] != NULL ?  '<td>' . $row['imei'] . '</td>' :  '<td>----------</td>';
              echo $row['nome'] != NULL ?  '<td>' . $row['nome'] . '</td>' :  '<td>----------</td>';
              echo $row['departamento'] != NULL ?  '<td>' . $row['departamento'] . '</td>' :  '<td>----------</td>';
              echo $row['empresa'] != NULL ?  '<td>' . $row['empresa'] . '</td>' :  '<td>----------</td>';
            } //FIM WHILE $row
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