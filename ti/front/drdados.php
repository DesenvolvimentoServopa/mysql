<?php
require_once('header.php');

require_once('../bd/google.php');


$query = "SELECT * FROM google WHERE cod_tabela = " . $_GET['id'] . "";
$result = $conn_db->query($query);
$row = $result->fetch_assoc();
?>

<!-- Begin Page Content -->
<div class="container-fluid py-4">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="pdados.php?pagina=4"><i class="fab fa-google"></i> Pesquisa </a> /
    <i class="fas fa-list"></i> Resultado
  </h1>
  <hr />

  <!-- Conteudo -->
  <!-- Area de Pesquisa -->

  <div class="googleldados2">
    <img src="../img/google.png">
    <!-- <div class="dentro"> -->
    <form class="container w-p d-none d-sm-inline-block form-inline mr-auto ml-md-0 my-2 my-md-0 mw-100 navbar-search" method="POST" action="ldados.php?pagina=4">
      <div class="input-group">
        <input type="text" class="borderradius form-control bg-blue border-0 small" placeholder="Pesquisar" aria-label="Pesquisar" aria-describedby="basic-addon2" name="pesquisa">
        <div class="p-relative">
          <button type="submit" class="btn btn-primary btn-icon-split menu ">
            <span class="icon text-white-50">
              <i class="fas fa-search"></i>
            </span>
          </button>
          <a href="adados.php?pagina=4" class="btn btn-primary btn-icon-split menu">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span></span>
          </a>
        </div>
    </form>
  </div>
</div>

<hr class="absolutehr">
</hr>
<!-- Primeiro Card -->
<div class="text-center">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Deseja realmente excluir o manual <br />"<span class="colorRed"><?= $row['titulo'] ?></span>"</h1>
  <div>
    <hr>
    <a href="pdados.php?pagina=4" class="btn btn-success">VOLTAR</a>
    <a href="../inc/drdados.php?id=<?= $_GET['id'] ?>" class="btn btn-danger">SIM</a>
  </div>
  <div>
  </div>

  <!-- End of Main Content -->

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