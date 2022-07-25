<?php
include('header.php');
?>

<body>

  <main id="main">


    <!-- ======= Breadcrumbs ======= -->

    <div class="breadcrumbs" data-aos="fade-in">
      <section id="contact" class="contact">
        <div class="container">
          <h1>
            Inserir arquivo da nova Edição
          </h1>
          <form class="form-inline" action="../back/about.php?id_usuario=<?= $_GET['id_usuario'] ?>&nome=<?= $_GET['nome'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group mx-sm-3 mb-2">
              <input type="number" class="form-control" placeholder="Número da Edição" name="edicao" required>
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <input type="file" class="form-control" id="inputPassword2" name="arquivo">              
            </div>
            <h6> Max 8Mb </h6>
            <button type="submit" class="btn btn-primary mb-2">
              <span class="icon text-white-50" style="margin-right: 10px;">
                <i class="fas fa-file-import"></i>
              </span>
              Enviar
            </button>
          </form>
          <div class='container' style="display: <?= $_GET['msn'] == 1 ? "block" : "none"  ?>;">
            <h4 class="text-success">Arquivo enviado com Sucesso</h4>
          </div>

        </div>
      </section>
    </div><!-- End Breadcrumbs -->
</body>

<?php
include('footer.php');
?>