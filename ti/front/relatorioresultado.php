<?php
session_start();
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');
require_once('../inc/permissoes.php');

$queryRelatorio = $queryRelColab .= $whereColaborador;

//mostrar apenas equipamentos que o usuário é responsavel

$queryRelatorio .= " AND MIE.tipo_equipamento IN (";

while ($permissaoEquipamento = $resultPermissaoEquipamento->fetch_assoc()) {

  $queryRelatorio .= $permissaoEquipamento['id_equipamento'] . ',';
}

$queryRelatorio .= "'')";

switch ($_GET['mostrarEquipamento']) {
  case '1':
    $queryRelatorio .= " AND MIE.id_equipamento IS NOT NULL"; //mostrar apenas os colaboradores COM equipamentos
    break;

  case '2':
    $queryRelatorio .= " AND MIE.id_equipamento IS NULL";//mostrar apenas os colaboradores SEM equipamentos
    break;
}

$resultColaborador = $conn->query($queryRelatorio);

//sessão para exportar EXCEL
$_SESSION['query_relatorios'] = $queryRelatorio;

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="relatorios.php?pagina=6"><i class="fas fa-file-contract"></i> Relatórios</a> /
    <a href="relatoriocolaborador.php?pagina=6"><i class="fas fa-user"></i> Relatórios Colaborador</a> /
    <i class="fas fa-tag"></i> Resultado
  </h1>
  <!-- Page Heading -->
  <hr />
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Relatório Colaborador</h1>
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
        <!--TABELA DOS FUNCIONARIOS-->
        <table class="table table-bordered small-lither" id="dataTable" width="100%" cellspacing="0" style="display: <?= $tabelaFun ?>;">
          <thead>
            <tr>
              <th>NOME</th>
              <th>C.P.F</th>
              <th>FUNÇÃO</th>
              <th>DEPARTAMENTO</th>
              <th>EMPRESA</th>
              <th>EQUIP.</th>
              <th>ID EQUIP.</th>
              <th>STATUS</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>NOME</th>
              <th>C.P.F</th>
              <th>FUNÇÃO</th>
              <th>DEPARTAMENTO</th>
              <th>EMPRESA</th>
              <th>EQUIP.</th>
              <th>ID EQUIP.</th>
              <th>STATUS</th>
            </tr>
          </tfoot>
          <tbody>
            <?php

            while ($row = $resultColaborador->fetch_assoc()) {

              echo '<tr>';
              echo $row['nome'] != NULL ?  '<td>' . $row['nome'] . '</td>' :  '<td>----------</td>';
              echo $row['cpf'] != NULL ?  '<td>' . $row['cpf'] . '</td>' :  '<td>----------</td>';
              echo $row['funcao'] != NULL ?  '<td>' . $row['funcao'] . '</td>' :  '<td>----------</td>';
              echo $row['departamento'] != NULL ?  '<td>' . $row['departamento'] . '</td>' :  '<td>----------</td>';
              echo $row['empresa'] != NULL ?  '<td>' . $row['empresa'] . '</td>' :  '<td>----------</td>';
              echo $row['tipo_equipamento'] != NULL ?  '<td>'. $row['tipo_equipamento'] . '</td>' :  '<td>----------</td>';
              echo $row['id_equipamento'] != NULL ?  '<td><a href="editequipamento.php?pagina=5&id_equip=' . $row['id_equipamento'] . '" target="_blank">' . $row['id_equipamento'] . '</a></td>' :  '<td>----------</td>';

              switch ($row['id_status']) {
                case '4':
                  echo '<td><span class="icone btn-success">' . $row['status'] . '</span></td>';
                  break;

                case '3':
                  echo '<td><span class="icone btn-warning">' . $row['status'] . '</span></td>';
                  break;

                case '8':
                  echo '<td><span class="icone btn-danger">' . $row['status'] . '</span></td>';
                  break;

                default:
                  echo '<td>DESATIVADO</td>';
                  break;
              }
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