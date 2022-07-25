<?php
session_start();

require_once('header.php');
require_once('../inc/pesquisas.php');
require_once('../bd/conexao.php');


if ($_GET['id_fun'] == NULL) {

  $idFun = $_SESSION['id_funcionario'];
  $nomeFuncionario = $_SESSION['nomeFuncionario'];

} else {
  
  $idFun = $_GET['id_fun'];

  //funcionario
  $queryFunNome = "SELECT nome FROM manager_inventario_funcionario WHERE id_funcionario = " . $idFun . "";
  $funcionario = $conn->query($queryFunNome);
  $nomeFuncionario = $funcionario->fetch_assoc();
}

$queryEquipamento .= " WHERE MIE.id_funcionario = " . $idFun . " AND MIE.tipo_equipamento IN (";

while ($permissaoEquipamento = $resultPermissaoEquipamento->fetch_assoc()) {
  $queryEquipamento .= $permissaoEquipamento['id_equipamento'] . ',';
}

$queryEquipamento .= "'')";

$result = $conn->query($queryEquipamento);

?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="text-xs mb-6 text-gray-800">
    <a href="front.php?pagina=1"><i class="fas fa-home"></i> Home</a> /
    <a href="colaboradores.php?pagina=3"><i class="fas fa-users"></i> Colaboradores</a> /
    <a href="funcionario.php?pagina=3&id_fun=<?=$_GET['id_fun']?>"><i class="fas fa-user"></i> <?= empty($_GET['id_fun']) ? $nomeFuncionario : $nomeFuncionario['nome']  ?></a> /
    <i class="fas fa-laptop"></i> Equipamentos
  </h1>
  <hr />

  <!-- Page Heading -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?>">
        Lista dos equipamentos
        <a href="checklist.php?pagina=3&id=<?= $idFun ?>" class="float-right btn btn-warning" style="display: <?= empty($_SESSION["emitir_check_list"]) ? "none" : "inline-block" ?>;" title="Check-list"><i class="fas fa-list"></i></a>
        <a href="termo.php?pagina=3&id=<?= $idFun ?>" class="float-right btn btn-info" style="margin-right: 10px;" title="Termo"><i class="fas fa-file"></i></a>
        <a href="equipamentosdisponiveis.php?pagina=5" class="float-right btn btn-success" style="margin-right: 10px;" title="Vincular Equipamento Disponível"><i class="fas fa-laptop-medical"></i></a>
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered small-lither" id="dataTable" cellspacing="0">

          <?php

          if ($_SESSION['perfil'] == 1) { //USUÁRIO
            echo '<thead>
                        <tr>
                          <th>EQUIPAMENTO</th>
                          <th>MODELO</th>
                          <th>PATRIMÔNIO</th>
                          <th>FILIAL</th>
                          <th>OPERADORA</th>
                          <th>NUMERO</th>
                          <th>IMEI</th>
                          <th>VALOR</th>
                          <th>ESTADO</th>
                          <th>SITUAÇÃO</th>
                          <th>TERMO</th>
                          <th class="maior">AÇÃO</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>EQUIPAMENTO</th>
                          <th>MODELO</th>
                          <th>PATRIMÔNIO</th>
                          <th>FILIAL</th>
                          <th>OPERADORA</th>
                          <th>NUMERO</th>
                          <th>IMEI</th>
                          <th>VALOR</th>
                          <th>ESTADO</th>
                          <th>SITUAÇÃO</th>
                          <th>TERMO</th>
                          <th class="maior">AÇÃO</th>
                        </tr>
                      </tfoot>';
          } elseif ($_SESSION['perfil'] == 2) { //tecnicos
            echo '<thead>
                <tr>
                  <th>EQUIPAMENTO</th>
                  <th>PATRIMÔNIO</th>
                  <th>FILIAL</th>
                  <th>NUMERO</th>
                  <th>IP</th>
                  <th>S.O</th>
                  <th>OFFICE</th>
                  <th>AD</th>
                  <th class="maior">AÇÃO</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>EQUIPAMENTO</th>
                  <th>PATRIMÔNIO</th>
                  <th>FILIAL</th>
                  <th>NUMERO</th>
                  <th>IP</th>
                  <th>S.O</th>
                  <th>OFFICE</th>
                  <th>AD</th>
                  <th class="maior">AÇÃO</th>
                </tr>
              </tfoot>';
          } else { //demais perfis
            echo '<thead>
                    <tr>
                      <th>EQUIPAMENTO</th>
                      <th>MODELO</th>
                      <th>PATRIMÔNIO</th>
                      <th>FILIAL</th>
                      <th>OPERADORA</th>
                      <th>NUMERO</th>
                      <th>IMEI</th>
                      <th>VALOR</th>
                      <th>ESTADO</th>
                      <th>SITUAÇÃO</th>
                      <th>TERMO</th>
                      <th>IP</th>
                      <th>S.O</th>
                      <th>OFFICE</th>
                      <th>AD</th>
                      <th class="maior">AÇÃO</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>EQUIPAMENTO</th>
                      <th>MODELO</th>
                      <th>PATRIMÔNIO</th>
                      <th>FILIAL</th>
                      <th>OPERADORA</th>
                      <th>NUMERO</th>
                      <th>IMEI</th>
                      <th>VALOR</th>
                      <th>ESTADO</th>
                      <th>SITUAÇÃO</th>
                      <th>TERMO</th>
                      <th>IP</th>
                      <th>S.O</th>
                      <th>OFFICE</th>
                      <th>AD</th>
                      <th class="maior">AÇÃO</th>
                    </tr>
                  </tfoot>';
          }
          ?>
          <tbody class="colorTable">
            <?php

            while ($equipamento = $result->fetch_assoc()) {

              //LIBERADO CHECK-LIITS?
              if ($equipamento['id_tipoEquipamento'] == 8) { //desktop

                $liberado = 'href="../front/remequipusuario.php?pagina=3&id_fun='.$idFun.'&id_equip=' . $equipamento['id_equipamento'] . '" class="text-warning  menu rigtIcones"';
              } else {

                $liberado = $equipamento['liberado_rh'] == 0 ? 'href="javascript:" onclick="alertar()" class="text-danger menu rigtIcones"' : 'href="../front/remequipusuario.php?pagina=3&id_fun='.$idFun.'&id_equip=' . $equipamento['id_equipamento'] . '" class="text-warning menu rigtIcones"';
              }

              //ICONES TERMO
              $equipamento['termo'] == 0 ? $termo = "<i class='fas fa-check-circle fa-2x colorGrenn' style='margin-left: 7px;'></i>" : $termo = "<i class='fas fa-times-circle fa-2x colorRed' style='margin-left: 7px;'></i>";

              //ICONES DOMINIO
              $equipamento['dominio'] == 0 ? $dominio = "<i class='fas fa-check-circle fa-2x colorGrenn' style='margin-left: px;'></i>" : $dominio = "<i class='fas fa-times-circle fa-2x colorRed' style='margin-left: 3px;'></i>";

              //OFFICE
              if ($equipamento['id_tipoEquipamento'] == 9 || $equipamento['id_tipoEquipamento'] == 8) {
                //OFFICE
                $queryoffice = "SELECT 
                                  MO.versao AS id_versao, 
                                  MDO.nome AS versao
                                  FROM
                                  manager_office MO
                                  LEFT JOIN
                                  manager_dropoffice MDO ON (MO.versao = MDO.id) WHERE MO.id_equipamento = '" . $equipamento['id_equipamento'] . "'";

                if (!$resultOFFICE = $conn->query($queryoffice)) {
                  printf("erro[1]: %s\n", $conn->error);
                } else {
                  $office = $resultOFFICE->fetch_assoc();
                }
              }

              //WINDOWS  
              if ($equipamento['id_tipoEquipamento'] == 9 || $equipamento['id_tipoEquipamento'] == 8) {
                //WINDOWS
                $queryso = "SELECT 
                              MSO.versao AS id_versao, 
                              MDSO.nome AS versao
                              FROM
                              manager_sistema_operacional MSO
                              LEFT JOIN
                              manager_dropsistemaoperacional MDSO ON (MSO.versao = MDSO.id) WHERE MSO.id_equipamento = " . $equipamento['id_equipamento'] . "";

                if (!$resultos = $conn->query($queryso)) {
                  printf("erro[2]: %s\n", $conn->error);
                } else {
                  $so = $resultos->fetch_assoc();
                }
              }


              if ($_SESSION['perfil'] == 1) { //usuario
                echo '<tr>';
                echo $equipamento['tipo_equipamento'] != NULL ?  '<td>' . $equipamento['tipo_equipamento'] . '</td>' :  '<td>-</td>';
                echo $equipamento['modelo'] != NULL ?  '<td>' . $equipamento['modelo'] . '</td>' :  '<td>-</td>';
                echo $equipamento['patrimonio'] != NULL ?  '<td>' . $equipamento['patrimonio'] . '</td>' :  '<td>-</td>';
                echo $equipamento['empresa'] != NULL ?  '<td>' . $equipamento['empresa'] . '</td>' :  '<td>-</td>';
                echo $equipamento['operadora'] != NULL ?  '<td>' . $equipamento['operadora'] . '</td>' :  '<td>-</td>';
                echo $equipamento['numero'] != NULL ?  '<td>' . $equipamento['numero'] . '</td>' :  '<td>-</td>';
                echo $equipamento['imei_chip'] != NULL ?  '<td>' . $equipamento['imei_chip'] . '</td>' :  '<td>-</td>';
                echo $equipamento['valor'] != NULL ?  '<td>' . $equipamento['valor'] . '</td>' :  '<td>-</td>';
                echo $equipamento['estado'] != NULL ?  '<td>' . $equipamento['estado'] . '</td>' :  '<td>-</td>';
                echo $equipamento['situacao'] != NULL ?  '<td>' . $equipamento['situacao'] . '</td>' :  '<td>-</td>';

                echo $equipamento['termo'] != NULL ?  '<td>' . $termo . '</td>' :  '<td>-</td>';
                /*AÇÂO*/
                echo '<td>                  
                        <a href="editequipamento.php?pagina=5&id_equip=' . $equipamento['id_equipamento'] . '" class="text-success menu rigtIcones" title="Editar/Visualizar"><i class="fas fa-pen"></i></a>
                        <a ' . $liberado . ' title="Remover deste usuário"><i class="fas fa-times"></i></a>
                      </td>';
                /*FIM AÇÂO*/
                echo '</tr>';
              } elseif ($_SESSION['perfil'] == 2) { //tecnicos
                echo '<tr>';
                echo $equipamento['tipo_equipamento'] != NULL ?  '<td>' . $equipamento['tipo_equipamento'] . '</td>' :  '<td>-</td>';
                echo $equipamento['patrimonio'] != NULL ?  '<td>' . $equipamento['patrimonio'] . '</td>' :  '<td>-</td>';
                echo $equipamento['empresa'] != NULL ?  '<td>' . $equipamento['empresa'] . '</td>' :  '<td>-</td>';
                echo $equipamento['numero'] != NULL ?  '<td>' . $equipamento['numero'] . '</td>' :  '<td>-</td>';

                echo $equipamento['ip'] != NULL ?  '<td>' . $equipamento['ip'] . '</td>' :  '<td>-</td>';

                if ($equipamento['id_tipoEquipamento'] == 9 || $equipamento['id_tipoEquipamento'] == 8) {
                  echo $so['versao'] != NULL ?  '<td>' . $so['versao'] . '</td>' :  '<td>-</td>';
                  echo $office['versao'] != NULL ?  '<td>' . $office['versao'] . '</td>' :  '<td>-</td>';
                  echo $equipamento['dominio'] != NULL ?  '<td>' . $dominio  . '</td>' :  '<td>-</td>';
                } else {
                  echo '<td>-</td>';
                  echo '<td>-</td>';
                  echo '<td>-</td>';
                }
                /*AÇÂO*/
                echo '<td>                  
                        <a href="editequipamento.php?pagina=5&id_equip=' . $equipamento['id_equipamento'] . '" class="text-success menu rigtIcones" title="Editar/Visualizar"><i class="fas fa-pen"></i></a>
                        <a ' . $liberado . ' title="Remover deste usuário"><i class="fas fa-times"></i></a>
                      </td>';
                /*FIM AÇÂO*/
                echo '</tr>';
              } else {
                echo '<tr>';
                echo $equipamento['tipo_equipamento'] != NULL ?  '<td>' . $equipamento['tipo_equipamento'] . '</td>' :  '<td>-</td>';
                echo $equipamento['modelo'] != NULL ?  '<td>' . $equipamento['modelo'] . '</td>' :  '<td>-</td>';
                echo $equipamento['patrimonio'] != NULL ?  '<td>' . $equipamento['patrimonio'] . '</td>' :  '<td>-</td>';
                echo $equipamento['empresa'] != NULL ?  '<td>' . $equipamento['empresa'] . '</td>' :  '<td>-</td>';
                echo $equipamento['operadora'] != NULL ?  '<td>' . $equipamento['operadora'] . '</td>' :  '<td>-</td>';
                echo $equipamento['numero'] != NULL ?  '<td>' . $equipamento['numero'] . '</td>' :  '<td>-</td>';
                echo $equipamento['imei_chip'] != NULL ?  '<td>' . $equipamento['imei_chip'] . '</td>' :  '<td>-</td>';
                echo $equipamento['valor'] != NULL ?  '<td>' . $equipamento['valor'] . '</td>' :  '<td>-</td>';
                echo $equipamento['estado'] != NULL ?  '<td>' . $equipamento['estado'] . '</td>' :  '<td>-</td>';
                echo $equipamento['situacao'] != NULL ?  '<td>' . $equipamento['situacao'] . '</td>' :  '<td>-</td>';

                echo $equipamento['termo'] != NULL ?  '<td>' . $termo . '</td>' :  '<td>-</td>';
                echo $equipamento['ip'] != NULL ?  '<td>' . $equipamento['ip'] . '</td>' :  '<td>-</td>';

                if ($equipamento['id_tipoEquipamento'] == 9 || $equipamento['id_tipoEquipamento'] == 8) {
                  echo $so['versao'] != NULL ?  '<td>' . $so['versao'] . '</td>' :  '<td>-</td>';
                  echo $office['versao'] != NULL ?  '<td>' . $office['versao'] . '</td>' :  '<td>-</td>';
                  echo $equipamento['dominio'] != NULL ?  '<td>' . $dominio  . '</td>' :  '<td>-</td>';
                } else {
                  echo '<td>-</td>';
                  echo '<td>-</td>';
                  echo '<td>-</td>';
                }
                /*AÇÂO*/
                echo '<td>                  
                        <a href="editequipamento.php?pagina=5&id_equip=' . $equipamento['id_equipamento'] . '" class="text-success menu rigtIcones" title="Editar/Visualizar"><i class="fas fa-pen"></i></a>
                        <a ' . $liberado . ' title="Remover deste usuário"><i class="fas fa-times"></i></a>
                      </td>';
                /*FIM AÇÂO*/
                echo '</tr>';
              }
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
<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>TI Grupo Servopa - Qualquer dúvida ligue no 110-2151</span>
    </div>
  </div>
</footer>
</div>
</div>
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

</body>

<script type="text/javascript">
  function alertar() {
    alert("Gerar um Check-List antes!");
  }
</script>

</html>