<?php

$arquivoatual = pathinfo($_SERVER['PHP_SELF'],PATHINFO_BASENAME);

if ($arquivoatual == 'index.php') {

  $caminho1= '';
  $caminho2= 'front/';

}else{

  $caminho1= '../';
  $caminho2= '';

}

?>

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo $caminho1; ?>index.php">
<div class="sidebar-brand-icon /*rotate-n-15*/">
  <i class="fas fa-balance-scale"></i>
</div>
<div class="sidebar-brand-text mx-3">Lançamento de Notas</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
<a class="nav-link" href="<?php echo $caminho1; ?>index.php">
  <i class="fas fa-fw fa-tachometer-alt"></i>
  <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider" style="margin-bottom: 0;">

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
  <i class="fas fa-fw fa-cog"></i>
  <span>Cadastros</span>
</a>
<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
  <div class="bg-white py-2 collapse-inner rounded">
    <?php if($permission == 1){?>
    <a class="collapse-item" href="<?php echo $caminho2; ?>filial.php">Filial</a>
    <?php }?>
    <a class="collapse-item" href="<?php echo $caminho2; ?>fornecedor.php">Fornecedor</a>
    <a class="collapse-item" href="<?php echo $caminho2; ?>rateioFornecedor.php">Rateio Fornecedor</a>
    <?php if($permission == 1){?>
    <a class="collapse-item" href="<?php echo $caminho2; ?>dropdowns.php">Drop Downs</a>
    <?php }?>
    <a class="collapse-item" href="<?php echo $caminho2; ?>workflow.php">Fornecedores catalogados</a>
  </div>
</div>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
  <i class="fas fa-fw fa-chart-area"></i>
  <span>Relatórios</span>
</a>
<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
  <div class="bg-white py-2 collapse-inner rounded">
    <a class="collapse-item" href="<?php echo $caminho2; ?>relFornecedor.php">Rateio Fornecedor</a>
    <a class="collapse-item" href="<?php echo $caminho2; ?>relatorioNF.php">Relatório Notas</a>
  </div>
</div>
</li>

<!-- Divider -->

<hr class="sidebar-divider" style="margin-bottom: 0;">

<li class="nav-item">
<a class="nav-link" href="<?php echo $caminho2; ?>lancarNota.php">
  <i class="fas fa-fw fa-file-invoice-dollar"></i>
  <span>Lançar Nota Manual</span></a>
</li>
<?php if($permission == 1){?>
<hr class="sidebar-divider" style="margin-bottom: 0;">




<!-- Nav Item - Tables -->
<li class="nav-item">
<a class="nav-link" href="<?php echo $caminho2; ?>usuario.php">
  <i class="fas fa-users"></i>
  <span>Usuários</span></a>
</li>

<!-- Divider -->

<?php }?>
<hr class="sidebar-divider d-none d-md-block">
<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
<button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>