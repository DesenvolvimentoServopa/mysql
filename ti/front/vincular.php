<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */

session_start();
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');
require_once('../inc/dropdown.php');

//EQUIPAMENTO
$queryEquipamento .= " WHERE MIE.id_equipamento = " . $_GET['id_equip'] . "";
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
    <i class="fas fa-user-plus"></i> Vincular
  </h1>
  <hr />
  <!-- /.container-fluid -->
  <form action="../inc/vincular.php?id_equip=<?= $_GET['id_equip'] ?>" method="POST" autocomplete="off">
    <div>
      <!-- Page Heading -->
      <h1 class="h6 mb-2 text-gray-800"><i class="fas fa-angle-double-right"></i> Qual status ficará o equipamento? <span class="colorRed">*</span> </h1>
      <div class="col-md-4 py-4 input-group">
        <select name="status" class="form-control" required>
          <option value="">---</option>
          <?php

          $resultStatus = $conn->query($queryStatusEquipamento);

          while ($status = $resultStatus->fetch_assoc()) {
            echo '
                <option value="' . $status['id'] . '">' . $status['nome'] . '</option>';
          }
          ?>
        </select>
      </div>
    </div>
    <h1 class="h6 mb-2 text-gray-800"><i class="fas fa-angle-double-right"></i> Escolha o Colaborador <span class="colorRed">*</span> </h1>
    <div class="col-md-20 py-4 input-group">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Lista de Colaboradores

            <a class="btn btn-success btn-pen-square btn-sm float-rigth" title="Novo Usuário" href="#" data-toggle="modal" data-target="#adicionar">
              <i class="fas fa-user-plus fa-sm"></i>
            </a>
          </h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered small-lither" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>AÇÃO</th>
                  <th>NOME</th>
                  <th>C.P.F</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>AÇÃO</th>
                  <th>NOME</th>
                  <th>C.P.F</th>
                </tr>
              </tfoot>
              <tbody>
                <?php

                while ($colaborador = $resultFuncionario->fetch_assoc()) {
                  echo '<tr><td> <input class="" type="radio" name="newfun" value="' . $colaborador['id_funcionario'] . '" > </td>';
                  echo $colaborador['nome'] != NULL ?  '<td>' . $colaborador['nome'] . '</td>' :  '<td>----------</td>';
                  echo $colaborador['cpf'] != NULL ?  '<td>' . $colaborador['cpf'] . '</td>' :  '<td>----------</td>';
                } //FIM WHILE $COLABORADOR
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>




    <hr>
    <button type="submit" class="btn btn-success btn-icon-split textCenterTela mb-5">
      <span class="icon text-white-50">
        <i class="fas fa-check"></i>
      </span>
      <span class="text">Vincular Equipamento</span>
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
        <form action="../inc/pesquisaFuncionario.php?pagina=5&id_equip=<?= $_GET['id_equip'] ?>" method="POST" autocomplete="off">
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
</body>

</html>