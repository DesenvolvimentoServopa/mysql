<?php
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');

$queryLog .= "WHERE ML.id_equipamento = " . $_GET['id_equip'] . " ORDER BY ML.id DESC";

$resultLog = $conn->query($queryLog);

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="listequipamentos.php?pagina=5"><i class="fas fa-laptop"></i> Equipamentos</a> /
    <a href="editequipamento.php?pagina=5&id_equip=<?= $_GET['id_equip']  ?>"><i class="fas fa-pen"></i> Editando <?= $_GET['id_equip']  ?></a> /
    <i class="fas fa-list"></i> Histórico
  </h1>
  <hr />

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">Lista do que aconteceu com esse funcionário</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered small-lither" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>DATA</th>
              <th>RESPONSAVEL</th>
              <th>ALTERAÇÂO</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>ID</th>
              <th>DATA</th>
              <th>RESPONSAVEL</th>
              <th>ALTERAÇÂO</th>
            </tr>
          </tfoot>
          <tbody class="colorTable">
            <?php

            while ($log = $resultLog->fetch_assoc()) {

              switch ($log['tipo_alteracao']) {
                case '0':
                  $idLog = 'Edição de Cadastro';
                  break;
            
                case '1':
                  $idLog = 'Liberou Check-List';
                  break;
            
                case '2':
                  $idLog = 'Emitido Check-List';
                  break;
            
                case '3':
                  $idLog = 'Emitido Termo';
                  break;
            
                case '4':
                  $idLog = 'Vinculado Equipamento';
                  break;
            
                case '5':
                  $idLog = 'Retirado Equipamento';
                  break;
            
                case '6':
                  $idLog = 'Documento Anexado';
                  break;
            
                case '7':
                  $idLog = 'Documento Excluido';
                  break;
            
                case '8':
                  $idLog = 'Inserido Histórico';
                  break;
            
                case '9':
                  $idLog = 'Excluido Histórico';
                  break;
            
                case '10':
                  $idLog = 'Editado Histórico';
                  break;
            
                case '11':
                  $idLog = 'Desativado';
                  break;
            
                case '12':
                  $idLog = 'Ativado';
                  break;
            
                case '13':
                  $idLog = 'Novo';
                  break;
            
                case '14':
                  $idLog = 'Removido Office';
                  break;
            
                case '15':
                  $idLog = 'Adicionado Office';
                  break;
            
                case '16':
                  $idLog = 'Removido Windows';
                  break;
            
                case '17':
                  $idLog = 'Adicionado Windows';
                  break;
              }

              echo '<tr>';
              echo $log['id'] != NULL ?  '<td>' . $log['id'] . '</td>' :  '<td>----------</td>';
              echo $log['data_alteracao'] != NULL ?  '<td>' . $log['data_alteracao'] . '</td>' :  '<td>----------</td>';
              echo $log['profile_name'] != NULL ?  '<td>' . $log['profile_name'] . '</td>' :  '<td>----------</td>';
              echo $idLog != NULL ?  '<td>' . $idLog . '</td>' :  '<td>----------</td>';
              echo '</tr>';
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

</body>
<!-- Logout Modal-->
<div class="modal fade" id="adicionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Localizar Funcionário</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../inc/pesquisaFuncionario.php" method="POST" autocomplete="off">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Digite o CPF" id="RegraValida" name="cpf" onkeydown="javascript: fMasc( this, mCPF );">
            <span class="small-lither">Veja se o funcionário ja está cadastrado!</span>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-info" type="submit">Procurar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</html>