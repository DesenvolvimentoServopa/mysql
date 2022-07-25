<?php
require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');
require_once('../inc/dropdown.php');

//DOCUMENTOS DIVERSOS
$queryDocumento .= "WHERE MIA.id_equipamento = " . $_GET['id_equip'] . " AND MIA.deletar = 0 ORDER BY MIA.id_anexo DESC";
$result = $conn->query($queryDocumento);

//OFFICE
$queryoffice .= " WHERE MO.id_equipamento = " . $_GET['id_equip'] . " AND MO.numero_nota NOT IN (0)";
$resultOffice = $conn->query($queryoffice);

//WINDOWS
$queryso .= " WHERE MSO.id_equipamento = " . $_GET['id_equip'] . " AND MSO.numero_nota NOT IN (0)";
$resultSO = $conn->query($queryso);

//TIPO DE DOCUMENTOS NO SISTEMA
$queryDocumentos .= " AND id IN (1, 4)";
$resultDoc = $conn->query($queryDocumentos);

//EQUIPAMENTOS
$queryEquipamento .= " WHERE MIE.id_equipamento = " . $_GET['id_equip'] . " AND MIE.deletar = 0";
$resultEquip = $conn->query($queryEquipamento);
$equipamento = $resultEquip->fetch_assoc();

if ($equipamento['id_tipoEquipamento'] == 8 || $equipamento['id_tipoEquipamento'] == 9) {
  $display = "block";

  $valueWindows = empty($equipamento['versao_so']) ? '0' : '1';
  $valueOffice = empty($equipamento['versao_off']) ? '0' : '2';


} else {

  $display = "none";

}

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="listequipamentos.php?pagina=5"><i class="fas fa-laptop"></i> Equipamentos</a> /
    <a href="editequipamento.php?pagina=5&id_equip=<?= $_GET['id_equip']  ?>"><i class="fas fa-pen"></i> Editando <?= $_GET['id_equip']  ?></a> /

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
              <th>NUMERO NOTA</th>
              <th>DATA NOTA</th>
              <th>FORNECEDOR</th>
              <th>DATA CRIAÇÃO</th>
              <th>TIPO DE DOCUMENTO</th>
              <th>AÇÃO</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>NOME</th>
              <th>NUMERO NOTA</th>
              <th>DATA NOTA</th>
              <th>FORNECEDOR</th>
              <th>DATA CRIAÇÃO</th>
              <th>TIPO DE DOCUMENTO</th>
              <th>AÇÃO</th>
            </tr>
          </tfoot>
          <tbody class="colorTable">
            <?php
            while ($documento = $result->fetch_assoc()) { //documentos diversos
              echo '<tr>';
              echo $documento['nome'] != NULL ?  '<td> <a href="' . $documento['caminho'] . '"  target="_blank">' . $documento['nome'] . '</a></td>' :  '<td>----------</td>';
              echo $documento['numero_nota'] != NULL ?  '<td>' . $documento['numero_nota'] . '</td>' :  '<td>----------</td>';
              echo $documento['data_nota'] != NULL ?  '<td>' . date('d/m/Y', strtotime($documento['data_nota'])) . '</td>' :  '<td>----------</td>';
              echo $documento['fornecedor'] != NULL ?  '<td>' . $documento['fornecedor'] . '</td>' :  '<td>----------</td>';
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
                        <form action="../inc/excluirdocumento.php?pagina=5&id=' . $documento['id_anexo'] . '&tipo=1&id_equip=' . $_GET['id_equip'] . '" method="POST" autocomplete="off">
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

            while ($documento = $resultOffice->fetch_assoc()) { //OFFICE
              echo '<tr>';
              echo $documento['nome'] != NULL ?  '<td> <a href="' . $documento['caminho'] . '"  target="_blank">' . $documento['nome'] . '</a></td>' :  '<td>----------</td>';
              echo $documento['data_criacao'] != NULL ?  '<td>' . $documento['data_criacao'] . '</td>' :  '<td>----------</td>';
              echo '<td>Nota Fiscal</td>';
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
                        <form action="../inc/excluirdocumento.php?pagina=5&id=' . $documento['id_anexo'] . '&tipo=2&id_equip=' . $_GET['id_equip'] . '" method="POST" autocomplete="off">
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

            while ($documento = $resultSO->fetch_assoc()) { //WINDOWS
              echo '<tr>';
              echo $documento['nome'] != NULL ?  '<td> <a href="' . $documento['caminho'] . '"  target="_blank">' . $documento['nome'] . '</a></td>' :  '<td>----------</td>';
              echo $documento['data_criacao'] != NULL ?  '<td>' . $documento['data_criacao'] . '</td>' :  '<td>----------</td>';
              echo '<td>Nota Fiscal</td>';
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
                        <form action="../inc/excluirdocumento.php?pagina=5&id=' . $documento['id_anexo'] . '&tipo=3&id_equip=' . $_GET['id_equip'] . '" method="POST" autocomplete="off">
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
        <form action="../inc/documento.php?id_equip=<?= $_GET['id_equip'] ?>" method="POST" enctype="multipart/form-data" autocomplete="off">

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
                <select name="tipo_nota" id="tipo_nota" class="form-control" onchange="tiponota()">
                  <option>-----</option>
                  <option value="<?= $valueWindows ?>" style="display:<?= $display ?>;">Windows</option>
                  <option value="<?= $valueOffice ?>" style="display:<?= $display ?>;">Office</option>
                  <option value="3">Diversos</option>
                </select>
                <p id="noPermitida" class="text-xs colorRed" style="width: 230%; margin-top: 10px; display: none;">ação não permitida. Esse software não está vinculado a esse equipamento</p>
              </div>
            </div>
            <div class="input-group">
              <div class="col-md-5 form-group">
                <label for="nome">Número: </label>
                <input type="text" class="form-control" name="numeroNota">
              </div>
            </div>

            <div class="input-group">
              <div class="col-md-5 form-group">
                <label for="nome">Data: </label>
                <input type="date" class="form-control" name="data_nota" placeholder="xx/xx/xxxx">
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
            <hr />
          </div>
          <div class="form-group">
            <label for="nome">Documento: </label>
            <input type="file" class="form-control-file" name="anexo" required>
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-success" type="submit" id="salvar">Salvar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</html>