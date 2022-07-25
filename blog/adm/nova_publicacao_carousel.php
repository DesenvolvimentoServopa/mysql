<?php 
session_start();
require 'conexao.php';
 //validando
 if($_GET['pagina'] != 6){
    header('location: 404.php');
  }

?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Dashboard - BLOG </title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->

    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicons/favicon.ico">
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="../assets/js/config.js"></script>
    <script src="../vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>





    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->




    <link href="vendors/flatpickr/flatpickr.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="../vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="../assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="../assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="../assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="../assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
    var isRTL = JSON.parse(localStorage.getItem('isRTL'));
    if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
    } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
    }
    </script>
</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
            var isFluid = JSON.parse(localStorage.getItem('isFluid'));
            if (isFluid) {
                var container = document.querySelector('[data-layout]');
                container.classList.remove('container');
                container.classList.add('container-fluid');
            }
            </script>
            <nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
                <script>
                var navbarStyle = localStorage.getItem("navbarStyle");
                if (navbarStyle && navbarStyle !== 'transparent') {
                    document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
                }
                </script>
                <div class="d-flex align-items-center">
                    <div class="toggle-icon-wrapper">

                        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle"
                            data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span
                                class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

                    </div><a class="navbar-brand" href="#">
                        <div class="d-flex align-items-center py-3"><span class="font-sans-serif">BLOG ADMIN</span>
                        </div>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content scrollbar">
                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                <!-- parent pages--><a class="nav-link" href="dashboard.php?pagina=1" role="button"
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                class="fas fa-calendar-alt"></span></span><span
                                            class="nav-link-text ps-1">Dashboard</span>
                                    </div>
                                </a>
                                <!-- parent pages--><a class="nav-link" href="postagens.php?pagina=2" role="button"
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                class="fas fa-comments"></span></span><span
                                            class="nav-link-text ps-1">Comentarios</span>
                                    </div>
                                </a>
                                <!-- parent pages--><a class="nav-link" href="tipo_postagens.php?pagina=5" role="button"
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                class="fas fa-envelope-open"></span></span><span
                                            class="nav-link-text ps-1">Nova postagem</span>
                                    </div>
                                </a>
                                <div class="settings mb-3">
                                </div>
                    </div>
                </div>
            </nav>
            <div class="content">
                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
                        aria-controls="navbarVerticalCollapse" aria-expanded="false"
                        aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                                class="toggle-line"></span></span></button>
                    <a class="navbar-brand me-1 me-sm-3" href="../index.html">
                        <div class="d-flex align-items-center"><img class="me-2" src="../assets/img/icons/logo.png"
                                alt="" width="40" /><span class="font-sans-serif">Blog admin</span>
                        </div>
                    </a>

                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                        <li  style="margin-right:15px" class="nav-item">
                            <div class="theme-control-toggle fa-icon-wait px-2">
                                <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle"
                                    type="checkbox" data-theme-control="theme" value="dark" />
                                <label class="mb-0 theme-control-toggle-label theme-control-toggle-light"
                                    for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Trocar para tema claro"><span class="fas fa-sun fs-0"></span></label>
                                <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark"
                                    for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Trocar para tema escuro"><span class="fas fa-moon fs-0"></span></label>
                            </div>
                        </li>
                        <li style="margin-right:15px" class="nav-item">
                            <a class="nav-link px-0 notification-indicator notification-indicator-warning notification-indicator-fill fa-icon-wait"
                                href="postagens.php?pagina=2"><span class="fas fa-bell" data-fa-transform="shrink-7"
                                    style="font-size: 33px;"></span><span
                                    class="notification-indicator-number"><?php echo $_SESSION['posts'];?></span></a>

                        </li>
                        <li class="nav-item dropdown">

                            <!-- <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification"
                                aria-labelledby="navbarDropdownNotification">
                                <div class="card card-notification shadow-none">
                                    <div class="card-header">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto">
                                                <h6 class="card-header-title mb-0">Notifications</h6>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="scrollbar-overlay" style="max-height:19rem">
                                        <div class="list-group list-group-flush fw-normal fs--1">
                                            <div class="list-group-title border-bottom">Novos</div>
                                            <div class="list-group-item">
                                                <a class="notification notification-flush notification-unread"
                                                    href="#!">
                                                    <div class="notification-body">
                                                        <p class="mb-1"><strong>Emma Watson</strong> replied to your
                                                            comment : "Hello world 😍"</p>
                                                        <span class="notification-time"><span class="me-2" role="img"
                                                                aria-label="Emoji">💬</span>Just now</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </li>
                        <li style="margin-right:50px" class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser" href="#"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-xl"><?= $_SESSION['exibicao'] ?>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                    <a class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#error-modal"><span>Meu
                                            Perfil</span></a>
                                    <div class="dropdown-divider"></div>
                                    <?php
                                        if($_SESSION["id"] == 8){
                                        echo "<li><a href='list_user.php?pagina=4'><i class='icon_group'></i>Usuários</a></li>";
                                        }
                                        ?>
                                    <a class="dropdown-item" href="unset.php"><i class="icon-key">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="card">
                    <div class="card-body overflow-hidden p-lg-6">
                        <div class="row align-items-center">
                            <div class="col-lg-6"></div>
                            <div>
                                <h4 class="mb-1">Nova postagem <i class="far fa-plus-square"></i></h4>
                                <br>
                            </div><br>
                        </div>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="dashboard.php?pagina=1">Home / </a></li>
                            <li><i  style="margin-left:15px" class="fa fa-comments"></i> Nova postagem</li>
                        </ol><br>
                        <div class="card">
                            <div class="card-body">
                                <form class="form-validate form-horizontal" id="feedback_form" method="POST"
                                    action="salvar_postagem.php?pagina=6" enctype="multipart/form-data"
                                    autocomplete="off">
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-2">Titulo:</label>
                                        <div class="col-lg-7">
                                            <input class="form-control" id="cname" name="titulo" maxlength="40"
                                                type="text" required>
                                            <span class="help-block">Limite de 40 caracteres</span>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="agree" class="control-label ">Tipo da
                                            postagem:</label>
                                        <div class="col-lg-4 ">
                                            <input class="form-check-input" type="radio" id="tipoPostagem1" value="0"
                                                name="tipo_postagem" checked="">
                                            <span class="form-check-label" for="tipoPostagem1">
                                                Simples
                                            </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <input class="form-check-input" type="radio" id="tipoPostagem2" value="1"
                                                name="tipo_postagem">
                                            <span class="form-check-label" for="tipoPostagem2">
                                                Modal
                                                <a href="javascript:">
                                                    <i class="fas fa-question-circle menor"
                                                        title="Quando abrir a intranet a postagem ficará na tela principal, ideal para postagem importantes."
                                                        aria-hidden="true"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group"><br>
                                        <label for="agree" class="control-label ">Data fim de visibiliade?</label>
                                        <select  style="width:200px" class="form-control fimDate" id="dataFim" required>
                                            <option value="">Selecione...</option>
                                            <option value="0">Sim</option>
                                            <option value="1">Não</option>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="form-group" style="display: none;" id="dataDiv">
                                        <label for="agree" class="control-label">Inativar postagem:</label>
                                        <input style="width:200px" type="date" class="form-control date col-sm-3 inativarDate"
                                            id="datepicker" placeholder="DD / MM / AAAA" name="dataFim">
                                    </div>
                                        <br>
                                    <div class="form-group">
                                        <label for="agree" class="control-label "
                                            style="width: 30%;">Alerta
                                            comentários?
                                            <a href="javascript:">
                                                <i class="fas fa-question-circle menor"
                                                    title="Todo comentário referente a está postagem você receberá por e-mail !"
                                                    aria-hidden="true"></i>
                                            </a>
                                        </label>
                                        <br>
                                        <select style="width:200px" class="form-control m-bot15 fimDate" id="dataFim"
                                            name='alertar_comentario' required>
                                            <option value="">Selecione...</option>
                                            <option value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="agree" class="control-label">Imagem / Video:</label>
                                        <table class="table table-bordered table-hover" id="tab_logic_R">
                                            <tr id='addrR0'><input type="file" class="form-control-file" id="file"
                                                    name="file0" required></tr>
                                            <tr id='addrR1'></tr>
                                        </table>
                                        <a id="ramal_row" class="btn btn-success"><i class="fas fa-plus-square"></i></a>
                                        <a id='ramal_remover' class="btn btn-danger excluir"><i
                                                class="fas fa-minus-square"></i></a>
                                    </div>
                                    <!-- CKEditor --><br>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <label for="agree" class="control-label">Mensagem:</label>
                                            <div id='texto'>
                                                <textarea name="mensagem" style="width: 100%;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div><br>
                                        <button type="submit" class="btn btn-primary postar">Realizar a
                                            Postagem</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    <div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1"
        aria-labelledby="settings-offcanvas">
        <div class="offcanvas-header settings-panel-header bg-shape">
            <div class="z-index-1 py-1 light">
                <h5 class="text-white"> <span class="fas fa-palette me-2 fs-0"></span>Configurações</h5>
                <p class="mb-0 fs--1 text-white opacity-75"> Custumize seu próprio estilo</p>
            </div>
            <button class="btn-close btn-close-white z-index-1 mt-0" type="button" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body scrollbar-overlay px-card" id="themeController">
            <h5 class="fs-0">Cor do tema</h5>
            <p class="fs--1">Escolha o tema perfeito para sua pagina.</p>
            <div class="btn-group d-block w-100 btn-group-navbar-style">
                <div class="row gx-2">
                    <div class="col-6">
                        <input class="btn-check" id="themeSwitcherLight" name="theme-color" type="radio" value="light"
                            data-theme-control="theme" />
                        <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherLight"> <span
                                class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                    src="../assets/img/generic/falcon-mode-default.jpg" alt="" /></span><span
                                class="label-text">Claro</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="themeSwitcherDark" name="theme-color" type="radio" value="dark"
                            data-theme-control="theme" />
                        <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherDark"> <span
                                class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                    src="../assets/img/generic/falcon-mode-dark.jpg" alt="" /></span><span
                                class="label-text">Escuro</span></label>
                    </div>
                </div>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start"><img class="me-2"
                        src="../assets/img/icons/left-arrow-from-left.svg" width="20" alt="" />
                    <div class="flex-1">
                        <h5 class="fs-0">Troca de lados</h5>
                        <p class="fs--1 mb-0">Troque a direção da sua dashboard</p>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input ms-0" id="mode-rtl" type="checkbox" data-theme-control="isRTL" />
                </div>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start"><img class="me-2" src="../assets/img/icons/arrows-h.svg"
                        width="20" alt="" />
                    <div class="flex-1">
                        <h5 class="fs-0">Layout Fluido</h5>
                        <p class="fs--1 mb-0">Alternar sistema de container</p>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input ms-0" id="mode-fluid" type="checkbox" data-theme-control="isFluid" />
                </div>
            </div>
            <hr />
            <hr />
            <h5 class="fs-0 d-flex align-items-center">Vertical Navbar Estilo</h5>
            <p class="fs--1 mb-0">Escolha entre estilos para sua navbar vertical</p>
            <p> </p>
            <div class="btn-group d-block w-100 btn-group-navbar-style">
                <div class="row gx-2">
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-transparent" type="radio" name="navbarStyle"
                            value="transparent" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-transparent"> <img
                                class="img-fluid img-prototype" src="../assets/img/generic/default.png" alt="" /><span
                                class="label-text"> Transparent</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-inverted" type="radio" name="navbarStyle"
                            value="inverted" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-inverted"> <img
                                class="img-fluid img-prototype" src="../assets/img/generic/inverted.png" alt="" /><span
                                class="label-text"> Inverted</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-card" type="radio" name="navbarStyle" value="card"
                            data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-card"> <img
                                class="img-fluid img-prototype" src="../assets/img/generic/card.png" alt="" /><span
                                class="label-text"> Card</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-vibrant" type="radio" name="navbarStyle"
                            value="vibrant" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-vibrant"> <img
                                class="img-fluid img-prototype" src="../assets/img/generic/vibrant.png" alt="" /><span
                                class="label-text"> Vibrant</span></label>
                    </div>
                </div>
            </div>

        </div>
    </div><a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
        <div class="card-body d-flex align-items-center py-md-2 px-2 py-1">
            <div class="bg-soft-primary position-relative rounded-start" style="height:34px;width:28px">
                <div class="settings-popover"><span class="ripple"><span
                            class="fa-spin position-absolute all-0 d-flex flex-center"><span
                                class="icon-spin position-absolute all-0 d-flex flex-center">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z"
                                        fill="#2A7BE4"></path>
                                </svg></span></span></span></div>
            </div><small
                class="text-uppercase text-primary fw-bold bg-soft-primary py-2 pe-2 ps-1 rounded-end">Config</small>
        </div>
    </a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
    <!--MOSTRAR E ESCONDER-->
    <script>
        

    $("#dataFim").change(

        function() {
            $('#dataDiv').hide();

            if (this.value == "0") {
                $('#dataDiv').show();
                b.setAttribute("required", "required");
            }else{
                b.removeAttribute('required', 'required');
            }

        }

    );
    </script>
    <script>

//RAMAL - equip_add.php
  $(document).ready(function(){
    var i=1;
    $("#ramal_row").click(function(){
      $('#addrR'+i).html("<label for='agree' class='control-label'>"+(i+1)+":</label><input type='file' class='form-control-file' id='file' name='file"+i+"'>");
       $('#tab_logic_R').append('<tr id="addrR'+(i+1)+'"></tr>');
      i++; 
    });
  $("#ramal_remover").click(function(){
      if(i>1){
      $("#addrR"+(i-1)).html('');
      i--;
    }
  });
});    
</script>

    <!--TEXTAREA EDIÇÃO-->
    <script src="https://cdn.tiny.cloud/1/dqzhgrnm6i4pdh6dtzylwat5bntthf86t9852obx0fvy58ei/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
    tinymce.init({
        selector: 'textarea'
    });
    </script>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->


    <script src="../assets/js/flatpickr.js"></script>
    <script src="../vendors/popper/popper.min.js"></script>
    <script src="../vendors/bootstrap/bootstrap.min.js"></script>
    <script src="../vendors/anchorjs/anchor.min.js"></script>
    <script src="../vendors/is/is.min.js"></script>
    <script src="../vendors/fontawesome/all.min.js"></script>
    <script src="../vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="../vendors/list.js/list.min.js"></script>
    <script src="../assets/js/theme.js"></script>

</body>

</html>