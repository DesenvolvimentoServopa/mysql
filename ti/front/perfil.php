<?php
require_once('header.php');
require_once('../inc/dropdown.php');
require_once('../inc/permissoes.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="../front/front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <i class="fas fa-user"></i> Meu Perfil
  </h1>
  <hr />
<!-- /.container-fluid -->
<div class="col-lg-6 left">
  <!-- Circle Buttons -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Edite seu perfil</h6>
    </div>
    <div class="card-body">
      <form action="../inc/editarPerfil.php" method="POST">
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" class="form-control" id="nome" value="<?= $_SESSION["nome"] ?>" name="nome">
        </div>
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="text" class="form-control" id="email" value="<?= $_SESSION["mail"] ?>" name="email">
        </div>
        <div class="form-group">
          <label for="senha">Senha</label>
          <input type="password" class="form-control" id="senha" name="senha">
        </div>
        <div class="form-group" style="display: <?= $perfil ?>;">
          <label for="exampleFormControlSelect2">Perfil</label>
          <select class="form-control" id="exampleFormControlSelect2" name="perfil">
            <option selected value="<?= $_SESSION["perfil"] ?>"><?= $_SESSION["nome_perfil"]['type_name'] ?></option>
            <option>----------</option>
            <?php
            $resultPerfil = $conn->query($queryPerfil);

            while ($perfil = $resultPerfil->fetch_assoc()) {
              echo '<option value="' . $perfil['type_profile'] . '">' . $perfil['type_name'] . '</option>';
            }
            ?>
          </select>
        </div>
        <div class="form-group" style="display: <?= $alterarPermissoes ?>;">
          <label for="exampleFormControlInput1">Permissões</label>
          <div class="form-group border-left-primary border-bottom-primary paddingDez">
            <div class="form-check ">
              <input class="form-check-input" type="checkbox" id="ativarCPF" <?= $_SESSION["ativar_cpf"] == 0 ?: "checked" ?> name="ativarCPF">
              <label class="form-check-label" for="ativarCPF">
                Ativar CPF
              </label>
            </div>
            <div class="form-check ">
              <input class="form-check-input" type="checkbox" id="desativarCPF" <?= $_SESSION["desativar_cpf"] == 0 ?: "checked" ?> name="desativarCPF">
              <label class="form-check-label" for="desativarCPF">
                Desativar CPF
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="emitir" <?= $_SESSION["emitir_check_list"] == 0 ?: "checked" ?> name="emitir">
              <label class="form-check-label" for="emitir">
                Emitir Check-List
              </label>
            </div>
            <div class="form-check ">
              <input class="form-check-input" type="checkbox" id="editarHistorico" <?= $_SESSION["editar_historico"] == 0 ?: "checked" ?> name="editarHistorico">
              <label class="form-check-label" for="editarHistorico">
                Editar histórico
              </label>
            </div>
            <div class="form-check ">
              <input class="form-check-input" type="checkbox" id="EditarFuncionario" <?= $_SESSION["editar_cadastroFuncionario"] == 0 ?: "checked" ?> name="EditarFuncionario">
              <label class="form-check-label" for="EditarFuncionario">
                Editar Cadastro Funcionário
              </label>
            </div>
          </div>

        </div>
        <button type="submit" class="btn btn-facebook btn-block">Salvar</button>
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

</html>