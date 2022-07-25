<?php
require_once('header.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid py-4">

  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <i class="fab fa-google"></i> Pesquisa
  </h1>
  <hr />

  <!-- Conteudo -->

  <!-- Topbar Search -->
  <div class="centro">
    <img src="../img/google.png">
    <hr>
    <div class="dentro">
      <form class="container d-none d-sm-inline-block form-inline mr-auto ml-md-0 my-2 my-md-0 mw-100 navbar-search" method="POST" action="ldados.php?pagina=4">
        <div class="input-group">
          <input type="text" class="borderradius form-control bg-blue border-0 small" placeholder="Pesquisar" aria-label="Pesquisar" aria-describedby="basic-addon2" name="pesquisa">
        </div>
        <hr>
        <button type="submit" class="btn btn-primary btn-icon-split menu rigth">
          <span class="icon text-white-50">
            <i class="fas fa-search"></i>
          </span>
          <span class="text">Pesquisar</span>
        </button>
        <a href="adados.php?pagina=4" class="btn btn-primary btn-icon-split menu">
          <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
          </span>
          <span class="text">Adicionar Conteúdo</span>
        </a>
    </div>
    </form>
  </div>

  <!-- Conteudo  /.container-fluid -->
  <!-- AMADOR QUE FALA NEH -->
  <div>
    <hr>
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