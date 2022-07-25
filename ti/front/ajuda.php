<?php
require_once('header.php');

require_once('../inc/permissoes.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid py-4">

  <!-- Page Heading -->
  <h1 class="text-xs h6 mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <i class="far fa-question-circle"></i> Central de Ajuda
  </h1>
  <hr />

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><i class="far fa-question-circle"></i> Central de Ajuda</h1>
  <p class="mb-4">Abaixo possui todos os módulos disponíveis neste sistema, então escolha e tire sua duvida! - Porém se ainda sim precisar de ajuda, peço que abra um chamado para a categoria GLPI/Robô ou ligar para o numero 110-2151</p>

  <!-- Content Row -->
  <div class="row">
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4" style="display: <?= $colaboradores ?>;">
      <a href='ajudacolaborador.php?pagina=7' class="text-decoration">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-warning text-uppercase mb-1"></div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Colaboradores</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4" style="display: <?= $equipamentos ?>;">
      <a href='ajudaequipamento.php?pagina=7' class="text-decoration">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-danger text-uppercase mb-1"></div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Equipamentos</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-laptop fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4" style="display: <?= $relatorio ?>;">
      <a href='ajudarelatorio.php?pagina=7' class="text-decoration">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-success text-uppercase mb-1"></div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Relatórios</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4" style="display: <?= $google ?>;">
      <a href='ajudagoogle.php?pagina=7' class="text-decoration">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="menu font-weight-bold text-info text-uppercase mb-1">Manuais</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Google</div>
              </div>
              <div class="col-auto">
                <i class="fab fa-google fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
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