<?php
session_start();
if(empty($_SESSION["id"])){
    header('location: index.php');
  }
  
  
  //validando
  if($_GET['pagina'] != 1){
    header('location: 404.php');
  }
require 'conexao.php';
//query para exibir notificação do lado direito da pagina
$posts = "SELECT 
COUNT(DISTINCT BC.id_postagem) AS posts,
BC.id_postagem,
BP.titulo

FROM
blog_post BP
    INNER JOIN
blog_comentarios BC ON BP.id_postagem = BC.id_postagem
WHERE
BC.avisado_responsavel = 0
    AND BP.id_post_user = ".$_SESSION['id'].";";
        $result_post = $conn->query($posts);


//query da tabela onde exibe as ações
$postagens_query = "SELECT 
                id_postagem, titulo, mensagem, file_img, data, data_drop, deletar, carousel
              FROM
                blog_post
              WHERE id_post_user = ".$_SESSION['id']." ORDER BY id_postagem DESC ";
        $result = $conn->query($postagens_query);
       
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
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="../assets/js/config.js"></script>
    <script src="../vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="../vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="../assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="../assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="../assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="../assets/css/user.min.css" rel="stylesheet" id="user-style-default">
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
                        aria-label="Toggle Navigation"></button>
                    <a class="navbar-brand me-1 me-sm-3" href="dashboard.php?pagina=1">
                        <div class="d-flex align-items-center"><img class="me-2" src="../assets/img/icons/logo.png"
                                alt="" width="40" /><span class="font-sans-serif">BLOG ADMIN</span>
                        </div>
                    </a>
                    <ul class="navbar-nav align-items-center d-none d-lg-block">

                    </ul>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                        <li class="nav-item">
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
                        <!-- simbolo de notificação com _SESSION para exibir o numero -->
                        <li class="nav-item">
                            <a class="nav-link px-0 notification-indicator notification-indicator-warning notification-indicator-fill fa-icon-wait"
                                href="postagens.php?pagina=2">&emsp;&emsp;<span class="fas fa-bell"
                                    data-fa-transform="shrink-7" style="font-size: 33px;"></span><span
                                    class="notification-indicator-number">
                                    <?php echo $_SESSION['posts']; ?>
                                </span></a>
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
                        <!-- exibe o nome do usuario -->
                        &emsp;&emsp; <li style="margin-right:50px" class="nav-item dropdown"><a class="nav-link pe-0"
                                id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-xl"><?= $_SESSION['exibicao']?>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                    <a class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#error-modal2"><span>Meu
                                            Perfil</span></a>
                                    <div class="dropdown-divider"></div>
                                    <!-- se o usuario for de id 8 exibe um dropdown a mais -->
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
                <?php
                        if($_GET['msn'] == 1){
                            echo "<div class='alert alert-info border-2 d-flex align-items-center' role='alert'>
                            <div class='bg-info me-3 icon-item'><span class='fas fa-check-circle text-white fs-3'></span></div>
                            <p class='mb-0 flex-1'>Cadastrado realizado com sucesso!. SAIA E ENTRE NOVAMENTE PARA APLICAR A ATUALIZAÇÃO!</p>
                            <button class='btn-close' type='button' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                            ";
                        }

                        if($_GET['msn'] == 2){
                            echo "<div class='alert alert-success border-2 d-flex align-items-center' role='alert'>
                            <div class='bg-success me-3 icon-item'><span class='fas fa-check-circle text-white fs-3'></span></div>
                            <p class='mb-0 flex-1'>Postagem ativada com sucesso!</p>
                            <button class='btn-close' type='button' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                        }

                        if($_GET['msn'] == 3){
                            echo "<div class='alert alert-danger border-2 d-flex align-items-center' role='alert'>
                            <div class='bg-danger me-3 icon-item'><span class='fas fa-times-circle text-white fs-3'></span></div>
                            <p class='mb-0 flex-1'>Postagem desativada com sucesso!</p>
                            <button class='btn-close' type='button' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                        }

                        if($_GET['msn'] == 4){
                            echo "<div class='alert alert-warning border-2 d-flex align-items-center' role='alert'>
                            <div class='bg-warning me-3 icon-item'><span class='fas fa-exclamation-circle text-white fs-3'></span></div>
                            <p class='mb-0 flex-1'>Postagem editada com sucesso!</p>
                            <button class='btn-close' type='button' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                        }

                        if($_GET['msn'] == 5){
                            echo " <div class='alert alert-info border-2 d-flex align-items-center' role='alert'>
                            <div class='bg-info me-3 icon-item'><span class='fas fa-check-circle text-white fs-3'></span></div>
                            <p class='mb-0 flex-1'>Postagem realizada com sucesso!</p>
                            <button class='btn-close' type='button' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                        }
                        if($_GET['msn'] == 6){
                            echo "<div class='alert alert-danger border-2 d-flex align-items-center' role='alert'>
                            <div class='bg-danger me-3 icon-item'><span class='fas fa-times-circle text-white fs-3'></span></div>
                            <p class='mb-0 flex-1'>Postagem excluida com sucesso!</p>
                            <button class='btn-close' type='button' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                        }
                        
                    ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-12"></div>
                            <div>
                                <h4 class="mb-1">Minhas postagens<i style="margin-left: 10px"
                                        class="fas fa-book-open"></i>
                                    <a href="tipo_postagens.php?pagina=5" style="float:right; padding-bottom: 10px">
                                        <button type="button" class="btn btn-small btn-primary">Nova postagem</button>
                                    </a>
                                </h4>

                            </div>

                            <div id="tableExample">
                                <div class="table-responsive scrollbar">
                                    <table class="table table-bordered table-striped fs--1 mb-0">
                                        <thead class="bg-200 text-900">
                                            <th>Titulo</th>
                                            <th>Imagem / Video</th>
                                            <th>Mensagem</th>
                                            <th>Data postagem</th>
                                            <th>Data exclusão</th>
                                            <th>Ação</th>
                                            </tr>
                                        <tbody class="list">
                                            <?php 
                                                    while ( $row = $result->fetch_assoc() ){

                                                        $carrosel = "SELECT file_img FROM blog.blog_post_carousel WHERE id_postagem = ".$row['id_postagem']."";
                                                        $reCarrosel = $conn->query($carrosel);

                                                        echo "
                                                        <tr>
                                                            <td>".$row['titulo']."</td>";

                                                        if($row['file_img'] === '')
                                                        {
                                                       echo "<td>---</td>";
                                                        }
                                                        else{
                                                        if($row['carousel'] == 1){
                                                            echo "<td><button class='btn btn-outline-primary me-1 mb-1' type='button' data-bs-toggle='modal' data-bs-target='#carousel".$row['id_postagem']."'>Arquivo</td>"; 
                                                            }
                                                        else{
                                                            echo "<td><a href='../".$row['file_img']."' target='_blank' title='Clique para ver o arquivo'><button class='btn btn-outline-primary me-1 mb-1' type='button'>Arquivo</button></a></td>";
                                                            
                                                            }
                                                        }
                                                        if($row['mensagem']== ''){
                                                                echo '<td>-----</td>';
                                                              }else{
                                                            echo "<td><button class='btn btn-outline-primary me-1 mb-1' type='button 'data-bs-toggle='modal' data-bs-target='#arquivo".$row['id_postagem']."' title='Clique para ver a mensagem'>Mensagem</button></td>";
                                                            echo "<div class='modal fade' id='arquivo".$row['id_postagem']."' tabindex='-1' role='dialog' aria-hidden='true'>
                                                                <div class='modal-dialog modal-dialog-centered' role='document' style='max-width: 500px'>
                                                                    <div class='modal-content position-relative'>
                                                                    <div class='position-absolute top-0 end-0 mt-2 me-2 z-index-1'>
                                                                        <button class='btn-close btn btn-sm btn-circle d-flex flex-center transition-base' data-bs-dismiss='modal' aria-label='Close'></button>
                                                                    </div>
                                                                    <div class='modal-body p-0'>
                                                                        <div class='rounded-top-lg py-3 ps-4 pe-6 bg-light'>
                                                                        <h4 class='mb-1' id='modalExampleDemoLabel'>".$row['titulo']."</h4>
                                                                        </div>
                                                                        <div class='p-4 pb-0'>
                                                                        ".$row['mensagem']."
                                                                        </div>
                                                                    </div>
                                                                    <div class='modal-footer'>
                                                                        <button class='btn btn-secondary' type='button' data-bs-dismiss='modal'>Fechar</button>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                </div>";}

                                                        // convertendo data para data Brasil
                                                        $data = $row['data'];
                                                        $data = implode("/",array_reverse(explode("-",$data)));
                                                        echo "<td>$data</td>";

                                                         if ($row['data_drop'] == '0000-00-00'){     
                                                            echo "<td>---</td>";
                                                            
                                                        }else{                                                 
                                                        //    echo "<td>".$row['data_drop']."</td>";
                                                           $data = $row['data_drop'];
                                                           $data = implode("/",array_reverse(explode("-",$data)));
                                                           echo "<td>$data</td>";
                                                        }
                                                            echo "<td><div class='btn-group'>";
                                                            if($row['deletar'] == 0){                            
                                                            echo "
                                                                <a class='btn btn-primary' href='../postagem.php?id_post=".$row['id_postagem']."' title='ver no blog' target='_blank'><i class='fas fa-eye'></i></a>
                                                                <a class='btn btn-danger' href='ativa_desativa.php?id_post=".$row['id_postagem']."&ativa=nao' title='desativar'><i class='fas fa-ban'></i></a>";
                                                        }else{
                                                            echo "<a class='btn btn-success' href='ativa_desativa.php?id_post=".$row['id_postagem']."&ativa=sim' title='ativar'><i class='fas fa-check'></i></a>";
                                                        }                      
                                                        echo "
                                                        <a class='btn btn-warning' href='editar_postagem.php?pagina=3&id_post=".$row['id_postagem']."' title='editar'><i class='fas fa-edit'></i></a>
                                                        <a class='btn btn-danger' href='apagar.php?pagina=3&id_post=".$row['id_postagem']."' title='Excluir postagem'><i class='fas fa-trash-alt'></i></a>
                                                        
                                                    </div>
                                                    </td>
                                                </tr>";
                                                echo "
                                                <div class='modal fade' id='carousel".$row['id_postagem']."' data-keyboard='false' tabindex='-1' aria-labelledby='scrollinglongcontentLabel' aria-hidden='true'>
                                                <div class='modal-dialog'>
                                                  <div class='modal-content'>
                                                    <div class='modal-header'>
                                                      <h5 class='modal-title' id='scrollinglongcontentLabel'>".$row['titulo']."</h5>
                                                      <button class='btn-close' type='button' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <div class='modal-body modal-dialog modal-dialog-scrollable mt-0'>
                                                                

                                                            <div class='carousel slide' id='carouselExampleControls' data-bs-ride='carousel'>
                                                            
                                                            <div class='carousel-inner rounded'>";

                                                                $conte = 0;

                                                                while($row_carrosel = $reCarrosel->fetch_assoc()){

                                                                switch ($conte) {
                                                                case '0':
                                                                    echo "<div class='carousel-item active'><img class='d-block w-100' src='../".$row_carrosel['file_img']."'></div>";

                                                                break;
                                                                    
                                                                default:
                                                                    echo "<div class='carousel-item'><img class='d-block w-100' src='../".$row_carrosel['file_img']."'></div>";
                                                                }
                                                                $conte++;    
                                                            }
                                                                                                    
                                                           echo "</div>
                                                            
                                                            </div>


                                                    </div>
                                                    <div class='modal-footer'>
                                                      <button class='btn btn-secondary' type='button' data-bs-dismiss='modal'>Fechar</button>
                                                      
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>";
                                                }
                                                ?>
                                            </thead>
                                        </tbody>
                                    </table>
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


    <div class='offcanvas offcanvas-end settings-panel border-0' id="settings-offcanvas" tabindex="-1"
        aria-labelledby="settings-offcanvas">
        <div class="offcanvas-header settings-panel-header bg-shape">
            <div class="z-index-1 py-1 light">
                <h5 class="text-white"> <span class="fas fa-palette me-2 fs-0"></span>Configurações</h5>
                <p class="mb-0 fs--1 text-white opacity-75"> Customize seu próprio estilo</p>
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
    <!--modal-->
    <div class="modal fade" id="error-modal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="p-4 pb-0">
                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-1" id="modalExampleDemoLabel">Editando perfil</h4>
                        </div>
                        <form class="form-horizontal" role="form" method="POST" action="editando_user.php">
                            <input name="senha_atual" style="display: none;" value='<?= $_SESSION['senha']?>'>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-9 control-label">Nome</label>
                                <div class="col-lg-10">
                                    <input name="exibicao" type="text" class="form-control" id="inputexibicao4"
                                        value='<?= $_SESSION['exibicao']?>'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">E-mail</label>
                                <div class="col-lg-10">
                                    <input name="email" type="email" class="form-control" id="inputEmail4"
                                        value="<?= $_SESSION['email']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Login</label>
                                <div class="col-lg-10">
                                    <input name="nome" type="text" class="form-control menor" id="inputnome"
                                        value="<?= $_SESSION['nome']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="col-lg-2 control-label">Senha</label>
                                <div class="col-lg-10">
                                    <input type="password" class="form-control menor" placeholder="Senha" id="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="col-lg-2 control-label">Redigite</label>
                                <div class="col-lg-10">
                                    <input name="senha" type="password" class="form-control menor"
                                        placeholder="Confirme Senha" id="confirm_password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-info" style="float: right;">Editar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--FIM MODAL-->
        <script>
        var password = document.getElementById("password"),
            confirm_password = document.getElementById("confirm_password");

        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Senhas diferentes!");
            } else {
                confirm_password.setCustomValidity('');
            }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
        </script>

        
        

        <!-- ===============================================-->
        <!--    JavaScripts-->
        <!-- ===============================================-->
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