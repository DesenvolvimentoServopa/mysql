<?php
session_start();
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');

//colaborador
switch ($_GET['status']) {
  case '4':
    $status = $_GET['status'];
    break;

  case '3':
    $status = $_GET['status'];
    break;

  case '8':
    $status = $_GET['status'];
    break;

  default:
    $status = '4, 3, 8';
    break;
}

$queryColaborador .= " WHERE MIF.deletar = 0 AND MIF.status IN (" . $status . ") AND MIF.departamento is not NULL";

$resultColaborador = $conn->query($queryColaborador);

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <i class="fas fa-users"></i> Colaboradores
    <span class="float-rigth"><a href="colaboradores.php?pagina=3" id="atualiz"><i class="fas fa-sync-alt"></i> Atualizar!</a></span>
  </h1>
  <hr />
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Colaboradores</h1>
    <a href="#" data-toggle="modal" data-target="#adicionar" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Novo Colaborador</a>
  </div>
  <!-- Page Heading -->
  <div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
      <a href="colaboradores.php?pagina=3&status=4" class="text-decoration">
        <div class="card border-left-success shadow h-100 py-2" style="background-color: <?= $_GET['status'] == 4 ? "#1cc88a3b" : "white" ?>">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-success text-uppercase mb-1">Ativo</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user-check fa-2x" style="color: <?= $_GET['status'] == 4 ? "#1cc88a" : "#dddfeb" ?>"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
      <a href="colaboradores.php?pagina=3&status=3" class="text-decoration">
        <div class="card border-left-warning shadow h-100 py-2" style="background-color: <?= $_GET['status'] == 3 ? "#f6c23e52" : "white" ?>">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-warning text-uppercase mb-1">Falta Termo</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user-clock fa-2x" style="color: <?= $_GET['status'] == 3 ? "#f6c23e !important" : "#dddfeb" ?>"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
      <a href="colaboradores.php?pagina=3&status=8" class="text-decoration">
        <div class="card border-left-danger shadow h-100 py-2" style="background-color: <?= $_GET['status'] == 8 ? "#e74a3b5c" : "white" ?>">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-danger text-uppercase mb-1">Demitidos</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user-slash fa-2x" style="color: <?= $_GET['status'] == 8 ? "#e74a3b" : "#dddfeb" ?>"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">lista de colaboradores
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered small-lither" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>NOME</th>
              <th>C.P.F</th>
              <th>FUNÇÃO</th>
              <th>DEPARTAMENTO</th>
              <th>EMPRESA</th>
              <th class="maior">STATUS</th>
              <th class="maior">AÇÃO</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>ID</th>
              <th>NOME</th>
              <th>C.P.F</th>
              <th>FUNÇÃO</th>
              <th>DEPARTAMENTO</th>
              <th>EMPRESA</th>
              <th class="maior">STATUS</th>
              <th class="maior">AÇÃO</th>
            </tr>
          </tfoot>
          <tbody>
            <?php

            while ($colaborador = $resultColaborador->fetch_assoc()) {
              echo '<tr>';
              echo $colaborador['id_funcionario'] != NULL ?  '<td>' . $colaborador['id_funcionario'] . '</td>' :  '<td>----------</td>';
              echo $colaborador['nome'] != NULL ?  '<td>' . $colaborador['nome'] . '</td>' :  '<td>----------</td>';
              echo $colaborador['cpf'] != NULL ?  '<td>' . $colaborador['cpf'] . '</td>' :  '<td>----------</td>';
              echo $colaborador['funcao'] != NULL ?  '<td>' . $colaborador['funcao'] . '</td>' :  '<td>----------</td>';
              echo $colaborador['departamento'] != NULL ?  '<td>' . $colaborador['departamento'] . '</td>' :  '<td>----------</td>';
              echo $colaborador['empresa'] != NULL ?  '<td>' . $colaborador['empresa'] . '</td>' :  '<td>----------</td>';
              switch ($colaborador['id_status']) {
                case '4':
                  echo '<td><span class="icone btn-success">' . $colaborador['status'] . '</span></td>';
                  break;

                case '3':
                  echo '<td><span class="icone btn-warning">' . $colaborador['status'] . '</span></td>';
                  break;

                case '8':
                  echo '<td><span class="icone btn-danger">' . $colaborador['status'] . '</span></td>';
                  break;

                default:
                  '<td>CódErro[1]: NO STATUS</td>';
                  break;
              }

              echo '<td>                    
                      <a href="../inc/pesquisaFuncionario.php?id=' . $colaborador['id_funcionario'] . '" class="text-success menu rigtIcones" title="Editar" ><i class="fas fa-pen"></i></a>
                      <a href="checklist.php?id=' . $colaborador['id_funcionario'] . '" class="text-warning menu rigtIcones" title="Check-List"  style="display: ';
              echo empty($_SESSION['emitir_check_list']) ? "none" : "inline-block";
              echo '"><i class="far fa-list-alt"></i></a>
                      <a href="termo.php?id=' . $colaborador['id_funcionario'] . '" class="text-info menu rigtIcones" title="Termo"><i class="fas fa-file"></i></a>
                    </td>';
            } //FIM WHILE $COLABORADOR
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

</html>