<?php
require_once('../bd/conexao.php');

require_once('header.php');

require_once('../inc/dropdown.php');

require_once('../inc/dropdownlist.php');

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="../front/front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="../front/config.php?pagina=2"><i class="fas fa-cogs"></i> Configuração </a> /
    <a href="../front/configDropdowns.php?pagina=2"><i class="fas fa-wrench"></i> Drop Downs </a> /
    <i class="<?= $icone ?>"></i> <?= $nome ?>
  </h1>
  <hr />

  <div class="col-lg-4 mb-2 my-3" style="display: <?= $_GET['msn'] == 1 ? 'block' : 'none'  ?>;">
    <div class="card bg-danger text-white shadow">
      <div class="card-body">
        Excluido com Sucesso!
      </div>
    </div>
  </div>

  <div class="col-lg-4 mb-2 my-3" style="display: <?= $_GET['msn'] == 2 ? 'block' : 'none'  ?>;">
    <div class="card bg-success text-white shadow">
      <div class="card-body">
        Criado com Sucesso!
      </div>
    </div>
  </div>

  <div class="col-lg-4 mb-2 my-3" style="display: <?= $_GET['msn'] == 3 ? 'block' : 'none'  ?>;">
    <div class="card bg-info text-white shadow">
      <div class="card-body">
        Editado com Sucesso!
      </div>
    </div>
  </div>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Lista de <?= $nome ?> cadastradas no sistema
        <a class="btn btn-success btn-pen-square btn-sm float-rigth" title="Adicionar" href="#" data-toggle="modal" data-target="#adicionar"><i class="fas fa-plus"></i></a>
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Ação</th>
            </tr>
          </tfoot>
          <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
              echo '
                  <tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['nome'] . '</td>
                    <td>                    
                      <a class="btn btn-success btn-pen-square btn-sm" title="Editar" href="#" data-toggle="modal" data-target="#editar' . $row['id'] . '"><i class="fas fa-pen"></i></a>
                      <a href="../inc/excluirdropdown.php?id=' . $row['id'] . '&tipo=' . $_GET['tipo'] . '" class="btn btn-danger btn-trash-square btn-sm" title="Excluir"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>

                  <!-- Logout Modal-->
                  <div class="modal fade" id="editar' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Editando ' . $nome . '</h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form id="editando" method="POST" action="../inc/editardrop.php?id=' . $row['id'] . '&tipo=' . $_GET['tipo'] . '">
                            <div class="form-group">
                              <label for="nome">Nome</label>
                              <input type="text" class="form-control" id="nome" value="' . $row['nome'] . '" name="nome">
                            </div>
                            <div class="modal-footer">
                              <button class="btn btn-secondary" for"editando" type="button" data-dismiss="modal">Cancelar</button>
                              <button type="submit" for="editando" class="btn btn-primary">Editar</a>
                            </div>                        
                          </form>                        
                        </div>
                      </div>
                    </div>
                  </div>';
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

<!-- Logout Modal-->
<div class="modal fade" id="adicionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionando uma <?= $nome ?></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editando" method="POST" action="../inc/adicionardrop.php?tipo=<?= $_GET['tipo'] ?>">
          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" value="" name="nome">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button type="submit" for="editando" class="btn btn-primary">Salvar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</body>

</html>