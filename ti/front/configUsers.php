<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');

//permissão de tela
if ($_SESSION['perfil'] != '0') {
  exit;
}

?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs text-gray-800">
    <a href="../front/front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="../front/config.php?pagina=2"><i class="fas fa-cogs"></i> Configuração </a> /
    <i class="fas fa-users"></i> Lista Usuários </a>
  </h1>
  <hr />

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>"><i class="fas fa-users"></i> Usuários
        <a class="btn btn-success btn-pen-square btn-sm float-right" title="Adicionar" href="novoUsuario.php?pagina=2"><i class="fas fa-plus"></i></a>
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered small" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nome</th>
              <th>E-mail</th>
              <th>Perfil</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>Nome</th>
              <th>E-mail</th>
              <th>Perfil</th>
              <th>Ações</th>
            </tr>
          </tfoot>
          <tbody>
            <?php
            //chamando os usuário
            $resultUsuarios = $conn->query($queryUsuarios);

            while ($usuarios = $resultUsuarios->fetch_assoc()) {
              echo '<tr>
                      <td>' . $usuarios['id_profile'] . '</td>
                      <td>' . $usuarios['profile_name'] . '</td>
                      <td>' . $usuarios['profile_mail'] . '</td>
                      <td>' . $usuarios['nome_perfil'] . '</td>
                      <td>';

              if ($usuarios['profile_deleted'] == 1) {

                echo '
                        <a href="../inc/ativarDesativar.php?id_usuario=' . $usuarios['id_profile'] . '&cod=0" class="btn btn-success btn-circle btn-sm" title="Ativar">
                          <i class="fas fa-check"></i>
                        </a>';
              } else {
                echo '
                      <a href="../inc/ativarDesativar.php?id_usuario=' . $usuarios['id_profile'] . '&cod=1" class="btn btn-danger btn-circle btn-sm" title="Desativar">
                        <i class="fas fa-times-circle"></i>
                      </a>
                      <a href="perfilUsuarios.php?pagina=2&id_usuario=' . $usuarios['id_profile'] . '" class="btn btn-info btn-circle btn-sm" title="Editar">
                        <i class="fas fa-pencil-alt"></i>
                      </a>';
              }
              echo '</td>
                    </tr>';
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