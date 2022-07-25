<?php
require_once('header.php');
require_once('../bd/conexao.php');

//permissão de tela
if ($_SESSION['perfil'] != '0') {
  exit;
}

//usuário ativos
$queryUsuario = "SELECT count(id_profile) as usuariosAtivos FROM manager_profile WHERE profile_deleted = 0";
$resultUsuarios = $conn->query($queryUsuario);
$usuario = $resultUsuarios->fetch_assoc();

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="../front/front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <i class="fas fa-cogs"></i> Configuração
  </h1>
  <hr />
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <a href='configUsers.php?pagina=2' class="text-decoration">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-primary text-uppercase mb-1">Lista Usuários</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $usuario['usuariosAtivos'] ?> ativos</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <a href='configDropdowns.php?pagina=2' class="text-decoration">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-success text-uppercase mb-1">Listas Suspensas</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Drop Down</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-wrench fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <a href='infodb.php?pagina=2' class="text-decoration">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-danger text-uppercase mb-1">Informação</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Banco de dados</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-database fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <a href='perfil.php?pagina=2' class="text-decoration">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-warning text-uppercase mb-1">Editar</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Meu perfil</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user-edit fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
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