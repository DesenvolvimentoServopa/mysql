<?php
require_once('header.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->

  <?php

  switch ($_GET['msn']) {
    case '1':
      echo '<div class="card mb-4">
              <div class="card-header">
                Ops! não encontrei ele!
              </div>
              <div class="card-body" style="text-align: center;">
                Não foi possivel encontrar nenhum equipamento com esse patrimônio, verifique se o mesmo está no <a href="http://rede.paranapart.com.br/ocsreports/index.php" target="_blank" class="text-danger"> OCS </a>ou se o patrimonio está correto!<br>
                <a href="novoequipamento.php?pagina=5" class="btn btn-secondary btn-icon-split text-xs" style="margin-top: 15px;">
                    <span class="icon text-white-50">
                      <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Voltar</span>
                  </a>
              </div>
            </div>';
      break;
  }

  ?>






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