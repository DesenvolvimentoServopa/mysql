<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */

require_once('../bd/conexao.php');
require_once('header.php');
require_once('../inc/dropdown.php');
require_once('../inc/pesquisas.php');

//quantidade equipamentos
if (!empty($_SESSION['id_funcionario']) || !empty($_GET['id_fun'])) {

  !empty($_GET['id_fun']) ? $id_funcionario = $_GET['id_fun'] : $id_funcionario = $_SESSION['id_funcionario'];

  //count
  $queryEquipamentosCount .= " WHERE id_funcionario = " . $id_funcionario . " AND tipo_equipamento IN (";

  while ($permissaoEquipamento = $resultPermissaoEquipamento->fetch_assoc()) {
    $queryEquipamentosCount .= $permissaoEquipamento['id_equipamento'] . ',';
  }

  $queryEquipamentosCount .= "'') Group by id_funcionario";
  $resultCountEquip = $conn->query($queryEquipamentosCount);
  $countEquip = $resultCountEquip->fetch_assoc();

  //funcionario
  $queryColaborador .= " WHERE MIF.id_funcionario = " . $id_funcionario . "";
  $result = $conn->query($queryColaborador);
  $funcionario = $result->fetch_assoc();
}

?>
<!-- Begin Page Content -->
<div class="container-fluid py-4">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="../front/front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="../front/colaboradores.php?pagina=3"><i class="fas fa-users"></i> Colaboradores</a> /
    <?= empty($funcionario['nome']) ? "<i class='fas fa-user-plus'></i> Novo Funcionário" : "<i class='fas fa-user'></i> " . $funcionario['nome'] ?>
  </h1>
  <div class="row" style="margin-top: 30px; display: <?= empty($funcionario['nome']) ? "none" : "flex" ?>;">
    <div class="col-xl-4 col-md-6 mb-4">
      <a href="funcionarioequip.php?pagina=3" class="text-decoration">
        <div class="card border-left-success shadow h-100 py-2" style="background-color: white">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-success text-uppercase mb-1">Equipamentos</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Quantidade: <?= $countEquip['quantidade'] ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-laptop fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
      <a href="funcionariohistorico.php?pagina=3" class="text-decoration">
        <div class="card border-left-warning shadow h-100 py-2" style="background-color: white">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-warning text-uppercase mb-1">Histórico</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Funcionário</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
      <a href="funcionariodocumentos.php?pagina=3" class="text-decoration">
        <div class="card border-left-info shadow h-100 py-2" style="background-color: white">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-info text-uppercase mb-1">Arquivos</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Documentos</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-file fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
  <!-- /.container-fluid -->
  <hr>
  <div class="col-lg-6 left">
    <!-- Circle Buttons -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>"><?= empty($funcionario['nome']) ? "Novo Funcionário" : "Editando Colaborador" ?>
          <a href="#" data-toggle="modal" data-target="#desativar" class="float-right btn-danger" title="Excluir Colaborador" style="padding: 8px; border-radius: 5px; display: <?= $_SESSION['desativar_cpf'] == 1 ? "block" : "none" ?>;">
            <i class="fas fa-user-times"></i>
          </a>
        </h6>
      </div>
      <div class="card-body">
        <form action="<?= empty($funcionario['nome']) ? "../inc/novofuncionario.php?&voltarpara=".$_GET['voltarpara']."&id_equip=".$_GET['id_equip']."" : "../inc/editefuncionario.php?id=" . $id_funcionario . "" ?>" method="POST">
          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" value="<?= empty($funcionario['nome']) ? "" : $funcionario['nome'] ?>" name="nome">
          </div>
          <div class="form-group">
            <label for="email">CPF</label>
            <input type="text" class="form-control" id="cpf" value="<?= empty($funcionario['cpf']) ? $_GET['cpf'] : $funcionario['cpf'] ?>" name="cpf" onkeydown="javascript: fMasc( this, mCPF );" maxlength="14" onblur="ValidarCPF(this)" autofocus>
            <span class="text-danger" style="display: none;" id="cpfInvalido"><i class="fas fa-times-circle"></i> CPF Invalido!</span>
            <span class="text-success" style="display: none;" id="cpfValido"><i class="fas fa-check-circle"></i> CPF OK!</span>
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect2">Função</label>
            <select class="form-control" id="exampleFormControlSelect2" name="funcao">
              <option selected value="<?= empty($funcionario['id_funcao']) ? "" : $funcionario['id_funcao'] ?>">
                <?= empty($funcionario['funcao']) ? "----------" : $funcionario['funcao'] ?>
              </option>
              <?php

              echo empty($funcionario['funcao']) ? "" : "<option>----------</option>";

              $resultFuncao = $conn->query($queryFuncao);

              while ($funcao = $resultFuncao->fetch_assoc()) {
                echo '<option value="' . $funcao['id'] . '">' . $funcao['nome'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect2">Departamento</label>
            <select class="form-control" id="exampleFormControlSelect2" name="departamento">
              <option selected value="<?= empty($funcionario['id_departamento']) ? "" : $funcionario['id_departamento'] ?>">
                <?= empty($funcionario['departamento']) ? "----------" : $funcionario['departamento'] ?>
              </option>
              <?php

              echo empty($funcionario['departamento']) ? "" : "<option>----------</option>";

              $resultDepartamento = $conn->query($queryDepartamento);

              while ($departamento = $resultDepartamento->fetch_assoc()) {
                echo '<option value="' . $departamento['id'] . '">' . $departamento['nome'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect2">Empresa</label>
            <select class="form-control" id="exampleFormControlSelect2" name="empresa">
              <option selected value="<?= empty($funcionario['id_empresa']) ? "" : $funcionario['id_empresa'] ?>">
                <?= empty($funcionario['empresa']) ? "----------" : $funcionario['empresa'] ?>
              </option>
              <?php

              echo empty($funcionario['empresa']) ? "" : "<option>----------</option>";

              $resultEmpresa = $conn->query($queryEmpresa);

              while ($empresa = $resultEmpresa->fetch_assoc()) {
                echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
              }
              ?>
            </select>
          </div>
          <hr>
          <div class="form-group">
            <label for="exampleFormControlSelect2">Status</label>
            <select class="form-control" id="exampleFormControlSelect2" name="status">
              <option selected value="<?= empty($funcionario['id_status']) ? "" : $funcionario['id_status'] ?>">
                <?= empty($funcionario['status']) ? "----------" : $funcionario['status'] ?>
              </option>
              <?php

              echo empty($funcionario['status']) ? "" : "<option>----------</option>";

              $resultStatusFuncionario = $conn->query($queryStatusFuncionario);

              while ($status = $resultStatusFuncionario->fetch_assoc()) {
                echo '<option value="' . $status['id'] . '">' . $status['nome'] . '</option>';
              }
              ?>
            </select>
          </div>

          <?php
          if (empty($funcionario['nome'])) {
            echo '<button type="submit" class="btn btn-info btn-block" id="procurar">Salvar</button>';
          } else {
            echo '<button type="submit" class="btn btn-success btn-block" id="procurar"';

            if ($_SESSION['editar_cadastroFuncionario'] == 0) {
              echo 'title="Você não tem permissão" disabled';
            }

            echo '>Editar</button>';
          }
          ?>

          <div class="col-lg-15 mb-4 my-2 text-center" id="senha" style="display: <?= $_GET['msn'] == 1 ? "block" : "none" ?>;">
            <div class="card bg-success text-white shadow">
              <div class="card-body">
                Salvo com sucesso!<br>
                Para aplicar as alterações sair e entre novamente no sistema!
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

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
<!-- Logout Modal-->
<div class="modal fade" id="desativar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Realmente quer <span class='colorRed'>EXCLUIR</span> o funcionario?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <span class="textCenterModal"><?= $funcionario['nome'] ?></span>
        <hr>
        <p class="colorRed textoCentro" style="display: <?= empty($countEquip['quantidade']) ? 'none' : 'block' ?>;"> Não é permitido excluir esse colaborador pois o mesmo possui equipamentos vinculados a sua responsabilidade</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Não</button>
        <a class="btn btn-primary" href="<?= empty($countEquip['quantidade']) ? '../inc/desativarfuncionario.php?id=' . $id_funcionario . '' : 'javascript:' ?>">Sim</a>
      </div>
    </div>
  </div>
</div>

</html>