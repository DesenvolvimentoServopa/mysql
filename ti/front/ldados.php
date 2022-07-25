<?php
/* error_reporting(E_ALL);
ini_set("display_errors", 1); */

require_once('header.php');
require_once('../bd/google.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid py-4">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="pdados.php?pagina=4"><i class="fab fa-google"></i> Pesquisa </a> /
    <i class="fas fa-list"></i> você pesquisou sobre <span class="colorRed">"<?= !empty($_POST['pesquisa']) ? $_POST['pesquisa'] : "Mostrar Tudo!" ?>"</span>
  </h1>
  <hr />
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
<?php

$query = "SELECT * FROM google WHERE deleted = 0 AND (titulo like '%" . $_POST['pesquisa'] . "%' || body like '%" . $_POST['pesquisa'] . "%')";

if (!$result = $conn_db->query($query)) {
  printf('Erro[1]: %s\n', $conn_db->error);
}

while ($row = $result->fetch_assoc()) {
  echo '
 <div class="card shadow mb-4">
   <!-- Card Header - Accordion -->
   <a href="#collapseCardExample' . $row['cod_tabela'] . '" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
     <h6 class="m-0 font-weight-bold text-primary">' . $row['titulo'] . '</h6>
   </a>
   <!-- Card Content - Collapse -->
   <div class="collapse " id="collapseCardExample' . $row['cod_tabela'] . '">  
     <div class="float-rigth editar">        
       <a href="adados.php?pagina=4&id=' . $row['cod_tabela'] . '" class="text-success" title="Editar"><i class="fas fa-pen"></i></a>
       <a href="drdados.php?id=' . $row['cod_tabela'] . '" class="text-danger lixeira" title="Excluir"><i class="fas fa-trash"></i></a>
     </div>
     <div class="card-body">
       ' . $row['body'] . '
       <div style="display: ';
  echo empty($row['caminho_arquivo']) ? 'none">' : 'block">';
  echo '<iframe src="' . $row['caminho_arquivo'] . '" width="990" height="780" style="border: none;"></iframe>
       </div>
     </div>
   </div>
 </div>';
}

?>
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