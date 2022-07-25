<?php
require_once('header.php');
require_once('../bd/conexao.php');
require_once('../bd/conexao_ocs.php');
require_once('../bd/google.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-database"></i> Banco de Dados</h1>

  <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?> bg-gray-200 paddingDez">DB - 01</h6>
  <br>
  <ul class="list-servidor">
    <li>
      <?php
      if (!$conn) {
        echo "<span class='colorBlue'>Status:</span> <span class='colorRed'>OFF</span><br />";
        printf("Erro: %s\n", mysqli_connect_error());
      } else {
        echo "<span class='colorBlue'>Status:</span> <span class='colorGrenn'>ON</span>";
      }
      ?>
    </li>
    <li><span class="colorBlue">IP:</span> <?= $servername ?></li>
    <li><span class="colorBlue">DB:</span> <?= $dbname ?></li>
    <li><span class="colorBlue">Porta:</span> <?= $port ?></li>
    <li><?= printf("<span class='colorBlue'>Servidor:</span> %s\n", $conn->server_info) ?>;</li>
    <li><?= printf("<span class='colorBlue'>Versão DB:</span> %s\n", $conn->client_info) ?>;</li>
  </ul>
  <hr>

  <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?> bg-gray-200 paddingDez">DB - 02</h6>
  <br>
  <ul class="list-servidor">
    <li>
      <?php
      if (!$conn_ocs) {
        echo "<span class='colorBlue'>Status:</span> <span class='colorRed'>OFF</span><br />";
        printf("Erro: %s\n", mysqli_connect_error());
      } else {
        echo "<span class='colorBlue'>Status:</span> <span class='colorGrenn'>ON</span>";
      }
      ?>
    </li>
    <li><span class='colorBlue'>IP:</span> <?= $servernameOcs ?></li>
    <li><span class='colorBlue'>DB:</span> <?= $dbnameOcs ?></li>
    <li><span class='colorBlue'>Porta:</span> <?= $portOcs ?></li>
    <li><?= printf("<span class='colorBlue'>Servidor:</span> %s\n", $conn_ocs->server_info) ?>;</li>
    <li><?= printf("<span class='colorBlue'>Versão DB:</span> %s\n", $conn_ocs->client_info) ?>;</li>
  </ul>
  <hr>

  <h6 class="m-0 font-weight-bold text-<?= $_SESSION["colorHeader"] ?> bg-gray-200 paddingDez">DB - 03</h6>
  <br>
  <ul class="list-servidor">
    <li>
      <?php
      if (!$conn_db) {
        echo "<span class='colorBlue'>Status:</span> <span class='colorRed'>OFF</span><br />";
        echo "Erro: não foi possível conectar-se ao MySQL." . PHP_EOL . "<br />";
      } else {
        echo "<span class='colorBlue'>Status:</span> <span class='colorGrenn'>ON</span>";
      }
      ?>
    </li>
    <li><span class='colorBlue'>IP:</span> <?= $servernamePesquisa ?></li>
    <li><span class='colorBlue'>DB:</span> <?= $dbnamePesquisa ?></li>
    <li><span class='colorBlue'>Porta:</span> <?= $portPesquisa ?></li>
    <li><?= printf("<span class='colorBlue'>Servidor:</span> %s\n", $conn_db->server_info) ?>;</li>
    <li><?= printf("<span class='colorBlue'>Versão DB:</span> %s\n", $conn_db->client_info) ?>;</li>
  </ul>
  <hr>

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

</html>