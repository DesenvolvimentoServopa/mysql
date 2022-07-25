<?php
//session start
session_start();
//verificando se o perfil está ativo
$_SESSION["perfil"] != NULL ?: header('location: ../index.php');

//data de hoje
$dataHoje = date('d/m/Y');

require_once('../inc/permissoes.php');
require_once('../bd/conexao.php');

//OFFICE
$queryPermissaoEquipamento .= " AND MPE.id_equipamento IN (8, 9)";
$result = $conn->query($queryPermissaoEquipamento);

if (!empty($permissao = $result->fetch_assoc())) {
    $mostrar = "block";
} else {
    $mostrar = "none";
}

//SCANNER
$queryPermissaoEquipamentoScanner = "SELECT 
MPE.id_equipamento, 
MDE.nome 
FROM manager_profile_equip MPE
LEFT JOIN manager_dropequipamentos MDE ON (MPE.id_equipamento = MDE.id_equip) WHERE MPE.id_profile = " . $_SESSION['id'] . " AND MPE.id_equipamento = 10";

$resultScanner = $conn->query($queryPermissaoEquipamentoScanner);

if (!empty($permissaoScanner = $resultScanner->fetch_assoc())) {
    $mostrarScanner = "block";
} else {
    $mostrarScanner = "none";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="../img/favicon.ico" rel="icon">

    <title>Inventário - TI</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/0c2d7c72a0.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <!-- Segurança-->
    <script src="../../js/seg.js"></script>

    <!-- Formulario Avançado -->
    <script src="../ckeditor/ckeditor.js"></script>

</head>

<body id="page-top" onload="moveRelogio()">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-<?= $_SESSION["colorHeader"] ?> sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center backgroundWhite" href="front.php?pagina=1">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-boxes iconeLogo"></i>
                </div>
                <div class="sidebar-brand-text mx-3">
                    <img src="../img/fd_logo.png" alt="fd_logo" id="fdLogo">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= $_GET['pagina'] == 1 ? 'active' : '' ?>">
                <a class="nav-link" href="front.php?pagina=1">
                    <i class="fas fa-home"></i>
                    <span>Home</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Nav Item - Charts -->
            <li class="nav-item  <?= $_GET['pagina'] == 3 ? 'active' : '' ?>" style="display: <?= $colaboradores ?>;">
                <a class="nav-link" href="colaboradores.php?pagina=3">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Colaboradores</span>
                </a>
            </li>
            <!-- Nav Item - Charts -->
            <li class="nav-item <?= $_GET['pagina'] == 5 ? 'active' : '' ?>" style="display: <?= $equipamentos ?>;">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#equip" aria-expanded="true" aria-controls="equip">
                    <i class="fas fa-laptop"></i>
                    <span>Equipamentos</span>
                </a>
                <div id="equip" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="novoequipamento.php?pagina=5"><i class="fas fa-plus"></i> Cadastrar Novo</a>
                        <hr>
                        <a class="collapse-item" href="equipamentosall.php?pagina=5">Todos Equipamentos</a>
                        <a class="collapse-item" href="equipamentos.php?pagina=5">Ativos</a>
                        <a class="collapse-item" href="equipamentosdisponiveis.php?pagina=5">Disponíveis</a>
                        <a class="collapse-item" href="equipcondenados.php?pagina=5">Condenados</a>
                        <a class="collapse-item" href="office.php?pagina=5" style="display: <?= $mostrar ?>;">Office Disponíveis</a>
                        <a class="collapse-item" href="windows.php?pagina=5" style="display: <?= $mostrar ?>;">Windows Disponíveis</a>
                        <a class="collapse-item" href="scanner.php?pagina=5" style="display: <?= $mostrarScanner ?>;">Scanner</a>
                    </div>
                </div>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse menu -->
            <li class="nav-item <?= $_GET['pagina'] == 2 ? 'active' : '' ?>" style="display: <?= $config ?>;">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Configurações</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="novoUsuario.php?pagina=2"><i class="fas fa-plus"></i> Novo Usuário</a>
                        <hr>
                        <a class="collapse-item" href="perfil.php?pagina=2">Meu Perfil</a>
                        <a class="collapse-item" href="configUsers.php?pagina=2">Lista Usuários</a>
                        <a class="collapse-item" href="configDropdowns.php?pagina=2">Drop Downs</a>
                        <a class="collapse-item" href="infodb.php?pagina=2">Banco de Dados</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse menu -->
            <li class="nav-item <?= $_GET['pagina'] == 6 ? 'active' : '' ?>" style="display: <?= $relatorio ?>;">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-file-contract"></i>
                    <span>Relatórios</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="relatoriocolaborador.php?pagina=6">Colaborador</a>
                        <a class="collapse-item" href="relatorioequipamento.php?pagina=6">Equipamento</a>
                        <a class="collapse-item" href="relatorionotafiscal.php?pagina=6" style="display: none;">Nota Fiscal</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item <?= $_GET['pagina'] == 4 ? 'active' : '' ?>" style="display: <?= $google ?>;">
                <a class="nav-link" href="pdados.php?pagina=4">
                    <i class="fab fa-fw fa-google"></i>
                    <span>Google</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Nav Item - Charts -->
            <li class="nav-item <?= $_GET['pagina'] == 7 ? 'active' : '' ?>">
                <a class="nav-link" href="ajuda.php?pagina=7">
                    <i class="far fa-question-circle"></i>
                    <span>Central de Ajuda</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://rede.paranapart.com.br/glpi" target="_blank">
                    <i class="fas fa-link"></i>
                    <span>GLPI</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Relogio -->
                    <form name="form_relogio">
                        <ul>
                            <li class="data padding-top"><?= $dataHoje ?></li>
                            <li class="padding-top"><input class="form-control bg-light border-0 small relogio" type="text" name="relogio" size="8" disabled></li>
                        </ul>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Alerts -->

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" title="Paleta de cores">
                                <i class="fas fa-brush colorRed"></i>
                                <!-- Counter - Alerts -->
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Escolhar uma cor!
                                </h6>
                                <a class="dropdown-item" href="../inc/color.php?color=primary">
                                    <div class="px-3 py-2 bg-gradient-primary text-white"></div>
                                </a>
                                <a class="dropdown-item" href="../inc/color.php?color=success">
                                    <div class="px-3 py-2 bg-gradient-success text-white"></div>
                                </a>
                                <a class="dropdown-item" href="../inc/color.php?color=info">
                                    <div class="px-3 py-2 bg-gradient-info text-white"></div>
                                </a>
                                <a class="dropdown-item" href="../inc/color.php?color=warning">
                                    <div class="px-3 py-2 bg-gradient-warning text-white"></div>
                                </a>
                                <a class="dropdown-item" href="../inc/color.php?color=pink">
                                    <div class="px-3 py-2 bg-gradient-pink text-white"></div>
                                </a>
                                <a class="dropdown-item" href="../inc/color.php?color=purple">
                                    <div class="px-3 py-2 bg-gradient-purple text-white"></div>
                                </a>
                                <a class="dropdown-item" href="../inc/color.php?color=danger">
                                    <div class="px-3 py-2 bg-gradient-danger text-white"></div>
                                </a>
                                <a class="dropdown-item" href="../inc/color.php?color=dark">
                                    <div class="px-3 py-2 bg-gradient-dark text-white"></div>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle text-success" href="ajuda.php?pagina=7" id="alertsDropdown" title="Central de Ajuda">
                                <i class="far fa-question-circle"></i>
                            </a>

                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION["nome"] ?></span>
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="perfil.php?pagina=2">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Meu Perfil
                                </a>
                                <a class="dropdown-item" href="config.php?pagina=2" style="display: <?= $config ?>;">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Configurações
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Sair
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <script language="JavaScript">
                    function moveRelogio() {
                        momentoAtual = new Date()
                        hora = momentoAtual.getHours()
                        hora = ("0" + hora).slice(-2)
                        minuto = momentoAtual.getMinutes()
                        minuto = ("0" + minuto).slice(-2);
                        segundo = momentoAtual.getSeconds()
                        segundo = ("0" + segundo).slice(-2);

                        horaImprimivel = hora + " : " + minuto + " : " + segundo

                        document.form_relogio.relogio.value = horaImprimivel

                        setTimeout("moveRelogio()", 1000)
                    }
                </script>


                <!-- Bootstrap core JavaScript-->
                <script src="../vendor/jquery/jquery.min.js"></script>
                <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                <!-- Core plugin JavaScript-->
                <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

                <!-- Custom scripts for all pages-->
                <script src="../js/sb-admin-2.min.js"></script>

                <!-- mascaras -->
                <script src="../js/cpf.js"></script>


                <!-- Page level plugins -->
                <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
                <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

                <!-- Page level custom scripts -->
                <script src="../js/demo/datatables-demo.js"></script>

                <!-- FUNÇÕES -->
                <script src="../js/funcoes.js"></script>

                <!--MASCARAS-->
                <script src="../js/addequipamento.js"></script>
                <script src="../js/moeda.js"></script>
                <script src="../js/telefone.js"></script>


                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Realmente deseja sair?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Não</button>
                                <a class="btn btn-primary" href="../inc/unset.php">Sim</a>
                            </div>
                        </div>
                    </div>
                </div>