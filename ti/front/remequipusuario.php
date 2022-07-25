<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */

session_start();
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');
require_once('../inc/dropdown.php');

//SE VIER DA PAQUINA DE EQUIPAMENTOS

if ($_GET['pagina'] == 5) {

  $id_funcionario = $_GET['id_fun'];

  $paginacao = '<a href="listequipamentos.php?pagina=5"><i class="fas fa-laptop"></i> Equipamentos</a> /';

} else {

  if ($_GET['id_fun'] != NULL) {
    $id_funcionario = $_GET['id_fun'];
  } else {
    $id_funcionario = $_SESSION['id_funcionario'];
  }

  //funcionario
  $queryFunNome = "SELECT nome FROM manager_inventario_funcionario WHERE id_funcionario = " . $id_funcionario . "";
  $funcionario = $conn->query($queryFunNome);
  $nomeFuncionario = $funcionario->fetch_assoc();
  
  $paginacao = '
  <a href="colaboradores.php?pagina=3"><i class="fas fa-users"></i> Colaboradores</a> / 
  <a href="funcionario.php?pagina=3&id_fun='.$id_funcionario.'"><i class="fas fa-user"></i>' . $nomeFuncionario['nome'] . '</a> /
  <a href="funcionarioequip.php?pagina=3&id_fun='.$id_funcionario.'"><i class="fas fa-laptop"></i> Equipamentos</a> /';
}

//EQUIPAMENTO
$queryEquipamento .= " WHERE MIE.id_funcionario = " . $id_funcionario . " AND MIE.tipo_equipamento IN (";

while ($permissaoEquipamento = $resultPermissaoEquipamento->fetch_assoc()) {
  $queryEquipamento .= $permissaoEquipamento['id_equipamento'] . ',';
}

$queryEquipamento .= "'')";

$resultEquipamento = $conn->query($queryEquipamento);

//FUNCIONÁRIO
$queryColaborador .= " WHERE MIF.deletar = 0  AND MIF.departamento is not null ORDER BY MIF.nome";
$resultFuncionario = $conn->query($queryColaborador);

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="mb-6 text-gray-800">
    <!-- Page Heading -->
    <h1 class="text-xs mb-6 text-gray-800">
      <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
      <?= $paginacao ?>

      <i class="fas fa-times-circle"></i> Remover Equipamento
    </h1>
  </h1>
  <hr />
  <!-- /.container-fluid -->
  <form action="../inc/remequipusuario.php?pagina=<?= $_GET['pagina'] ?>&id_fun=<?= $_GET['id_fun'] ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
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

    <div>
      <h1 class="h6 mb-2 text-gray-800"><i class="fas fa-angle-double-right"></i> Mais algum equipamento ?</h1>
      <div class="col-md-4 py-4 input-group">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="todosEquipamentos" id="simEquip" value="1" onclick="equipOne()">
          <label class="form-check-label" for="simEquip">
            Sim
          </label>
        </div>
        <div class="form-check left">
          <input class="form-check-input" type="radio" name="todosEquipamentos" id="naoEquip" value="2" onclick="equipTwo()" checked>
          <label class="form-check-label" for="naoEquip">
            Não
          </label>
        </div>
        <!--MOSTRAR TABELA DOS EQUIPAMENTOS-->
        <script>
          function equipTwo() {
            document.getElementById("tabelaEquip").style.display = "none";
          }

          function equipOne() {
            document.getElementById("tabelaEquip").style.display = "block";
          }
        </script>
      </div>
    </div>
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
                    <td>';
                if ($_GET['id_equip'] == $equip['id_equipamento']) {
                  echo '<input type="checkbox" value="' . $equip['id_equipamento'] . '" name="equip[]" readonly checked>';
                } else {
                  echo '<input type="checkbox" value="' . $equip['id_equipamento'] . '" name="equip[]">';
                }
                echo '</td>
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

    <div>
      <h1 class="h6 mb-2 text-gray-800"><i class="fas fa-angle-double-right"></i> Deseja atribuir a um NOVO FUNCIONÁRIO ?</h1>
      <div class="col-md-4 py-4 input-group">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="todosFuncionarios" id="simFun" value="1" onclick="funOne()">
          <label class="form-check-label" for="simFun">
            Sim
          </label>
        </div>
        <div class="form-check left">
          <input class="form-check-input" type="radio" name="todosFuncionarios" id="naoFun" value="2" onclick="funTwo()" checked>
          <label class="form-check-label" for="naoFun">
            Não
          </label>
        </div>
        <!--MOSTRAR TABELA DOS EQUIPAMENTOS-->
        <script>
          function funTwo() {
            document.getElementById("tabelaFun").style.display = "none";
          }

          function funOne() {
            document.getElementById("tabelaFun").style.display = "block";
          }
        </script>
      </div>
    </div>
    <!-- DataTales Example -->
    <div id="tabelaFun" style="display: none;">
      <h1 class="h6 mb-2 text-gray-800"><i class="fas fa-angle-double-right"></i> Escolha um novo funcionário!</h1>
      <div class="col-md-4 py-4 input-group">
        <select name="newfun" class="form-control">
          <option value="">---</option>
          <?php

          while ($funcionario = $resultFuncionario->fetch_assoc()) {
            echo '
                <option value="' . $funcionario['id_funcionario'] . '">' . $funcionario['nome'] . '</option>';
          }
          ?>
        </select>
        <div class="input-group-append">
          <a class="btn btn-success btn-pen-square btn-sm float-rigth" title="Novo Usuário" href="#" data-toggle="modal" data-target="#adicionar">
            <i class="fas fa-user-plus fa-sm"></i>
          </a>
        </div>
      </div>
    </div>

    <h1 class="h6 mb-2 text-gray-800"><i class="fas fa-angle-double-right"></i> Anexar Check-List:</h1>
    <div class="col-md-4 py-4 input-group">
      <input type="file" id="formFile" name="filechecklist">
    </div>

    <div>
      <h1 class="h6 mb-2 text-gray-800"><i class="fas fa-angle-double-right"></i> Qual é o motivo ? <span class="colorRed">*</span></h1>
      <div class="form-group py-2">
        <div class="form-check">
          <textarea class="form-control form-control-user" name="motivo" style="width: 45%;" placeholder="Escreva..." required></textarea>
        </div>
      </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-danger btn-icon-split textCenterTela mb-5">
      <span class="icon text-white-50">
        <i class="fas fa-times"></i>
      </span>
      <span class="text">Remover Equipamento</span>
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
</body>

</html>