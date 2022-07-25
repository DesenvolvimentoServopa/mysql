<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */
session_start();
require_once('header.php');
require_once('../bd/google.php');

if (!empty($_GET['id'])) {
  $query = "SELECT * FROM google WHERE cod_tabela = " . $_GET['id'] . "";
  $result = $conn_db->query($query);
  $row = $result->fetch_assoc();
}
?>

<!-- Begin Page Content -->
<div class="container-fluid py-4">
  <!-- Page Heading -->

  <div>
    <h1 class="text-xs mb-6 h6 text-gray-800">
      <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
      <a href="pdados.php?pagina=4"><i class="fab fa-google"></i> Pesquisa </a> /
      <?= empty($_GET['id']) ? "<i class='fas fa-plus'></i> Adicionar" : "<i class='fas fa-pen'></i> Editar" ?>
    </h1>
    <hr />
  </div>

  <div class="col-lg-12">
    <!-- Circle Buttons -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 h6 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>"><?= empty($_GET['id']) ? "Adicionar Conteúdo" : "Editando Conteúdo" ?></h6>
      </div>

      <div class="card-body">
        <form action="../inc/adados.php?id=<?= $_GET['id'] ?>" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="nome"><a class="negritoad">Titulo</a></label>
            <input type="text" class="form-control" id="titulo" value="<?= empty($row['titulo']) ? '' : $row['titulo'] ?>" name="titulo">
          </div>
          <!-- Label de Informações -->
          <label for="email"><a class="negritoad">
              <hr>Conteúdo
              <hr class="tamanhohr">
            </a></label>
          <div class="form-group mb1">
            <textarea name='body' id='txtArtigo'><?= empty($row['body']) ? '' : $row['body'] ?></textarea>

            <script>
              $(document).ready(function() {
                $('#txtArtigo').summernote();
              });
            </script>
          </div>

          <div class="form-group mb1" style="display: <?= empty($row['caminho_arquivo']) ? 'none' : 'block' ?>;">
            <label for="email">
              <a href="<?= $row['caminho_arquivo'] ?>" class="btn btn-primary btn-icon-split menu rigth" target="_blank">
                <span class="icon text-white-50">
                  <i class="fas fa-eye"></i>
                </span>
                <span class="text">Exibir documento anexado!</span>
              </a>
            </label>
          </div>

          <div id="notafiscal">
            <div class="form-group">
              <label for="nome"><a class="negritoad">Anexar novo Documento: </a></label>
              <input type="file" class="form-control" name="anexo">
            </div>
          </div>
          <!-- Botão Salvar -->
          <div>
            <a href="pdados.php?pagina=4" class="btn btn-primary btn-block22">Voltar</a>
            <button type="submit" class="btn btn-primary btn-block22">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<hr>
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>




</html>