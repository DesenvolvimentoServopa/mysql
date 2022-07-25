<?php
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');
require_once('../inc/dropdown.php');

//DOCUMENTOS DIVERSOS
$queryDocumento .= "WHERE MIA.id_funcionario = " . $_SESSION['id_funcionario'] . " AND MIA.deletar = 0 ORDER BY MIA.id_anexo DESC";
$result = $conn->query($queryDocumento);

//TIPO DE DOCUMENTOS NO SISTEMA
$resultDoc = $conn->query($queryDocumentos);

//EQUIPAMENTOS
$queryEquipamento .= " WHERE MIE.id_funcionario = " . $_SESSION['id_funcionario'] . " AND MIE.deletar = 0";
$resultEquip = $conn->query($queryEquipamento);

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="colaboradores.php?pagina=3"><i class="fas fa-users"></i> Colaboradores</a> /
    <a href="funcionario.php?pagina=3"><i class="fas fa-user"></i> <?= $_SESSION['nomeFuncionario'] ?></a> /
    <i class="fas fa-file"></i> Documentos
  </h1>
  <hr />

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>"><i class="fas fa-file"></i> Lista dos Documentos</h6>
      <a href="#" data-toggle="modal" data-target="#novo" class="float-right btn btn-success" style="margin-right: 10px;" title="Novo Documento"><i class="fas fa-plus"></i></a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered small-lither" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>NOME</th>
              <th>DATA CRIAÇÃO</th>
              <th>TIPO DE DOCUMENTO</th>
              <th>AÇÃO</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>NOME</th>
              <th>DATA CRIAÇÃO</th>
              <th>TIPO DE DOCUMENTO</th>
              <th>AÇÃO</th>
            </tr>
          </tfoot>
          <tbody class="colorTable">
            <?php
            while ($documento = $result->fetch_assoc()) {

              $nome = $documento['nome'];
              $nome = ltrim($nome,'-0123456789');

              echo '<tr>';
              echo $documento['nome'] != NULL ?  '<td> <a href="' . $documento['caminho'] . '"  target="_blank">' . $nome . '</a></td>' :  '<td>----------</td>';
              echo $documento['data_criacao'] != NULL ?  '<td>' . $documento['data_criacao'] . '</td>' :  '<td>----------</td>';
              echo $documento['tipo_documento'] != NULL ?  '<td>' . $documento['tipo_documento'] . '</td>' :  '<td>----------</td>';
              echo '
              <td>
                <a href="#" data-toggle="modal" data-target="#excluir' . $documento['id_anexo'] . '" class="left text-xs colorRed" title="Excluir">
                  <i class="fas fa-trash"></i>
                </a>
                <!-- Excluir Modal-->
                <div class="modal fade" id="excluir' . $documento['id_anexo'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">                      
                        <img src="../img/atencao.png" style="width: 9%;"/>
                        <h5 class="modal-title text-xs" id="exampleModalLabel">Documento: ' . $documento['nome'] . '</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="../inc/excluirdocumento.php?id=' . $documento['id_anexo'] . '" method="POST" autocomplete="off">
                          <div class="form-group">
                            <h1 class="h4">Deseja realmente excluir esse documento ?</h1>
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Não</button>
                            <button class="btn btn-danger" type="submit">Sim</a>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>';
              echo '</tr>';
            }
            ?>
            </td>
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
<!-- Excluir Modal-->
<div class="modal fade" id="novo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-file-upload"></i> Novo Documento</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../inc/criardocumento.php" method="POST" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-5 input-group">
            <div class="form-group">
              <label for="nome">Tipo de Documento: </label>
              <select name="tipo_documento" id="tipo_documento" class="form-control" onchange="documento()" required>
                <option>-----</option>
                <?php

                while ($tipoDocumento = $resultDoc->fetch_assoc()) {
                  echo '<option value="' . $tipoDocumento['id'] . '">' . $tipoDocumento['nome'] . '</option>';
                  echo "";
                }
                ?>
              </select>
            </div>
          </div>
          <hr />
          <!--NOTA FISCAL DATA-->
          <div id="datanota" style="display: none;" id="datanota">


            <div class="input-group">
              <div class="col-md-5 form-group">
                <label for="nome">Tipo Nota: </label>
                <select name="tipo_nota" id="tipo_nota" class="form-control" onchange="notas()">
                  <option>-----</option>
                  <option value="1">Windows</option>
                  <option value="2">Office</option>
                  <option value="3">Diversos</option>
                </select>
              </div>
            </div>

            <div class="input-group">
              <div class="col-md-5 form-group">
                <label for="nome">Número: </label>
                <input type="text" class="form-control" name="numeroNota">
              </div>
            </div>


            <div class="input-group">
              <div class="col-md-5 form-group" class="display: block">
                <label for="nome">Data da nota: </label>
                <input type="text" class="form-control" name="data_nota" placeholder="xx/xx/xxxx">
              </div>
            </div>

            <div class="col-md-12 form-group">
              <label for="exampleFormControlSelect2">Fornecedor:</label>
              <select class="form-control" id="exampleFormControlSelect2" class="border-bottom-info" name="fornecedor">
                <option>----------</option>
                <?php

                $resultFornecedor = $conn->query($queryFornecedor);

                while ($fornecedor = $resultFornecedor->fetch_assoc()) {
                  echo '<option value="' . $fornecedor['nome'] . '">' . $fornecedor['nome'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <!--EQUIPAMENTO-->
          <div class="col-md-4 input-group" style="display: none;" id="listEquip">
            <div class="form-group">
              <label for="nome">Qual Equip ? </label>
              <table class="table table-bordered small">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Patimônio</th>
                    <th scope="col">Numero</th>
                  </tr>
                </thead>
                <tbody>
                  <?php


                  while ($equip = $resultEquip->fetch_assoc()) {

                    if (!empty($equip['id_equipamento'])) {
                      echo '<tr>
                      <th scope="row"><input type="checkbox" value="' . $equip['id_equipamento'] . '" name="equip[]"></th>
                      <td>' . $equip['tipo_equipamento'] . '</td>
                      <td>' . $equip['modelo'] . '</td>
                      <td>' . $equip['patrimonio'] . '</td>                    
                      <td>' . $equip['numero'] . '</td>
                    </tr>';
                      echo '
                    <tr>
                      <th scope="row"><input type="checkbox" value="0" name="equip[]"></th>
                      <td colspan="4" style="text-align: center;">Nenhum Equipamento</td>
                    </tr>';
                    } else {
                      echo '
                      <tr>
                        <th scope="row"><input type="checkbox" value="0" name="equip[]" checked></th>
                        <td colspan="4" style="text-align: center;">Nenhum Equipamento</td>
                      </tr>';
                    }

                  }


                  ?>

                </tbody>
              </table>
            </div>
          </div>

          <hr />
          <div class="form-group">
            <label for="nome">Documento: </label>
            <input type="file" class="form-control-file" name="anexo" required>
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-success" type="submit">Salvar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</html>