<?php
require_once('header.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid py-4">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="ajuda.php?pagina=7">
      <i class="far fa-question-circle"></i> Central de Ajuda
    </a> /
    <i class="fas fa-user"></i> Colaborador
  </h1>
  <hr />

  <!-- Duvida 1º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Localizar um colaborador ?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample1">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/21.mp4" type="video/mp4">
          <source src="../documentos/vd/21.mp4" type="video/ogg">
          Seu navegador não é suportado. Por favor atualize ou use navegadores mais utilizados pela a maioria!
        </video>
      </div>
    </div>
  </div>

  <!-- Duvida 2º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Cadastrar um colaborador ?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample2">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/22.mp4" type="video/mp4">
          <source src="../documentos/vd/22.mp4" type="video/ogg">
          Seu navegador não é suportado. Por favor atualize ou use navegadores mais utilizados pela a maioria!
        </video>
      </div>
    </div>
  </div>

  <!-- Duvida 3º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample3" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Editar um colaborador ?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample3">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/23.mp4" type="video/mp4">
          <source src="../documentos/vd/23.mp4" type="video/ogg">
          Seu navegador não é suportado. Por favor atualize ou use navegadores mais utilizados pela a maioria!
        </video>
      </div>
    </div>
  </div>

  <!-- Duvida 4º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample4" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Excluir um colaborador ?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample4">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/24.mp4" type="video/mp4">
          <source src="../documentos/vd/24.mp4" type="video/ogg">
          Seu navegador não é suportado. Por favor atualize ou use navegadores mais utilizados pela a maioria!
        </video>
      </div>
    </div>
  </div>

  <!-- Duvida 5º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample5" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Emitir um Check-List ?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample5">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/25.mp4" type="video/mp4">
          <source src="../documentos/vd/25.mp4" type="video/ogg">
          Seu navegador não é suportado. Por favor atualize ou use navegadores mais utilizados pela a maioria!
        </video>
      </div>
    </div>
  </div>

  <!-- Duvida 6º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample6" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Emitir um Termo?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample6">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/26.mp4" type="video/mp4">
          <source src="../documentos/vd/26.mp4" type="video/ogg">
          Seu navegador não é suportado. Por favor atualize ou use navegadores mais utilizados pela a maioria!
        </video>
      </div>
    </div>
  </div>

  <!-- Duvida 7º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample7" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Ver os equipamento de um colaborador ?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample7">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/27.mp4" type="video/mp4">
          <source src="../documentos/vd/27.mp4" type="video/ogg">
          Seu navegador não é suportado. Por favor atualize ou use navegadores mais utilizados pela a maioria!
        </video>
      </div>
    </div>
  </div>
  <!-- Duvida 8º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample8" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Ver os históricos de um colaborador ?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample8">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/28.mp4" type="video/mp4">
          <source src="../documentos/vd/28.mp4" type="video/ogg">
          Seu navegador não é suportado. Por favor atualize ou use navegadores mais utilizados pela a maioria!
        </video>
      </div>
    </div>
  </div>
  <!-- Duvida 9º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample9" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Ver os documentos de um colaborador ?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample9">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/29.mp4" type="video/mp4">
          <source src="../documentos/vd/29.mp4" type="video/ogg">
          Seu navegador não é suportado. Por favor atualize ou use navegadores mais utilizados pela a maioria!
        </video>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="mt-5 sticky-footer bg-white">
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