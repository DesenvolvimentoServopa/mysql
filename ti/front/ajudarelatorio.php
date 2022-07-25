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
    <i class="fas fa-laptop"></i> Equipamento
  </h1>
  <hr />

  <!-- Duvida 1º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Como gerar um relatório ?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample1">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/05.mp4" type="video/mp4">
          <source src="../documentos/vd/05.mp4" type="video/ogg">
          Seu navegador não é suportado. Por favor atualize ou use navegadores mais utilizados pela a maioria!
        </video>
      </div>
    </div>
  </div>

  <!-- Duvida 2º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Exportar para excel ?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample2">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/06.mp4" type="video/mp4">
          <source src="../documentos/vd/06.mp4" type="video/ogg">
          Seu navegador não é suportado. Por favor atualize ou use navegadores mais utilizados pela a maioria!
        </video>
      </div>
    </div>
  </div>

  <!-- Duvida 3º -->
  <div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample3" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Imprimir em PDF ?</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse " id="collapseCardExample3">
      <div class="card-body centro">
        <video width="600" height="300" controls>
          <source src="../documentos/vd/07.mp4" type="video/mp4">
          <source src="../documentos/vd/07.mp4" type="video/ogg">
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