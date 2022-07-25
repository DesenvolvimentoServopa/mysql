<!DOCTYPE html>
<html lang="pt-BR" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Blog Notícias</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="favicon" sizes="16x16" href="assets/ico/favico.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="assets/js/config.js"></script>
    <script src="vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <link href="css/style2.css" rel="stylesheet" id="style_felipe">
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
            <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-lg">

                <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard"
                    aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                            class="toggle-line"></span></span></button>
                <a class="navbar-brand me-1 me-sm-3" href="index.php">
                    <div class="d-flex align-items-center"><span class="font-sans-serif">Blog Notícias</span>
                    </div>
                </a>
                <div style="text-align: center;" class="collapse navbar-collapse scrollbar" id="navbarStandard">
                    <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">
                        <li class="nav-link-text ps1"><a class="nav-link-text" style="margin-left:20px"
                                href="https://sites.google.com/a/servopa.com.br/rh/home" role="button"
                                aria-haspopup="true" aria-expanded="false">Recursos Humanos</a>

                        </li>
                        <li class="nav-link-text ps1"><a class="nav-link-text" style="margin-left:20px"
                                href="https://sites.google.com/a/servopa.com.br/auditoria/" role="button"
                                aria-haspopup="true" aria-expanded="false">Auditoria</a>

                        </li>
                        <li class="nav-link-text ps1"><a class="nav-link-text" style="margin-left:20px"
                                href="http://rede.paranapart.com.br/ti/index.php" role="button" aria-haspopup="true"
                                aria-expanded="false">TI</a>

                        </li>
                        <li class="nav-link-text"><a class="nav-link-text" style="margin-left:20px"
                                href="https://sites.google.com/servopa.com.br/gestaocompartilhada/gest%C3%A3o-compartilhada"
                                role="button" aria-haspopup="true" aria-expanded="false">Gestão Compartilhada</a>

                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                    <li>
                        <div class="search-box" style="width: 18rem;">
                            <form class="position-relative" data-bs-toggle="search" data-bs-display="static"
                                method="post" action="pesquisa.php">
                                <input class="form-control search-input fuzzy-search" type="search"
                                    placeholder="Digite algo" aria-label="Search" name="pesquisar" />
                                <span class="fas fa-search search-box-icon"></span>
                            </form>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="theme-control-toggle fa-icon-wait px-2">
                            <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle"
                                type="checkbox" data-theme-control="theme" value="dark" />
                            <label class="mb-0 theme-control-toggle-label theme-control-toggle-light"
                                for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                title="Trocar para tema claro"><span class="fas fa-sun fs-0"></span></label>
                            <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark"
                                for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                title="Trocar para tema escuro"><span class="fas fa-moon fs-0"></span></label>
                        </div>
                    </li>

                    <?php if($_GET['usuario'] != NULL){
                          echo "<a href='adm/index.php'><i class='icon-user'></i>".$_GET['usuario']."</a>";
                      }else{
                      echo"
                   <a  href='adm/index.php'>
                            <button type='button' class='btn btn-primary'>
                                Entrar
                            </button>
                        </a>";}
?>
                </ul>
            </nav>
            <br>
            <div class="card">
                <div class="card-body">
                    <div class="card-header bg-light py-2">
                        <div class="row flex-between-center">
                            <div class="col-auto">
                                <h6 class="mb-0">
                                    <ul class="breadcrumb notop">
                                        <li>
                                            <i class="icon-home"></i>
                                            <a href="http://rede.paranapart.com.br">Intranet</a>
                                            <span class="divider">/</span>
                                        </li>
                                        <li>
                                            <i class="icon-tags"></i>
                                            <a href="index.php?pagina=1">Blog - Grupo Servopa</a>
                                            <span class="divider">/</span>
                                        </li>
                                        <li class="active">
                                            <i class="icon-hand-right"></i>
                                            Postagem
                                        </li>
                                    </ul>

                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <?php switch ($_GET['msn']) {
                        case '1':
                          echo "<h4><div class='alert alert-success border-2 d-flex align-items-center' role='alert'>
                          <div class='bg-success me-3 icon-item'><span class='fas fa-check-circle text-white fs-3'></span></div>
                          <p class='mb-0 flex-1'>Seu comentário será analisado e postado logo em seguida!</p>
                          <button class='btn-close' type='button' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div></h4>";
                        break;

                        case '2':
                          echo "<h4><div class='alert alert-danger border-2 d-flex align-items-center' role='alert'>
                          <div class='bg-danger me-3 icon-item'><span class='fas fa-times-circle text-white fs-3'></span></div>
                          <p class='mb-0 flex-1'>Seu comentário foi bloqueado por conter alguma palavra imprópria!!</p>
                          <button class='btn-close' type='button' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div></h4>";
                        
                        break;
  
}?><br><br>
            <div class="card" style="box-shadow:  8px 8px 30px 20px #b0b0b0,
          -8px -8px 19px #ffffff;border-bottom-left-radius:0px;border-bottom-right-radius:0px;">
                <div class="card-body" style="border-bottom-left-radius:0px;border-bottom-right-radius:0px;">
                    <?php
//tipo de arquivo
$video = "video/mp4";
$pdf = "application/pdf";

//conexão com o bando de dados
  require_once('conexao.php');
  
	//pesquisa para o BD
	$busca = "SELECT 
              BP.id_postagem, 
              BP.titulo, 
              BP.tipo_arquivo,
              BP.file_img AS caminho, 
              BP.mensagem, 
              BP.data,
              BU.exibicao AS usuario,
              BP.carousel
            FROM
              blog_post BP
            LEFT JOIN
              blog_user BU ON BP.id_post_user = BU.id_user
            WHERE
              BP.deletar = 0 AND
              BP.id_postagem = '".$_GET['id_post']."'
            ORDER BY BP.id_postagem DESC";
            $resultado = $conn->query($busca);

            //contador de comentários
            $comentario =  "SELECT count(*) AS contagem FROM blog_comentarios WHERE id_postagem = '".$_GET['id_post']."'";
            $result = $conn->query($comentario); 
            $row_comentario = $result->fetch_assoc();
            ?>

                    <!-- POSTAGEM -->
                    <?php
              
            if($linha = $resultado->fetch_assoc()){
              echo "<article class='blog-post'>
              <div class='post-heading'>
                <h3><a href='javascript:'>".$linha['titulo']."</a></h3>
              </div>";
              
              "<div class='clearfix'>
              </div>";
              if($linha['tipo_arquivo'] == $video){
                echo "
                <video width='700' controls>
                    <source src='".$linha['caminho']."' type='video/mp4'>
                    <source src='".$linha['caminho']."' type='video/ogg'>
                    Seu navegador não suporta HTML5 video.
                </video>";
              }elseif($linha['tipo_arquivo'] == $pdf){
                echo "<iframe src='".$linha['caminho']."' width='780' height='600'></iframe>";
              }elseif($linha['carousel'] == 1){

                $carrorel = "SELECT file_img FROM blog_post_carousel WHERE id_postagem = ".$linha['id_postagem']."";

                $reCarrosel = $conn->query($carrorel);

                echo "

                <div class='carousel slide' id='carouselExampleControls' data-bs-ride='carousel'>
                  <div class='carousel-indicators'>
                    <button class='active' type='button' data-bs-target='#carouselExampleControls' data-bs-slide-to='0' aria-current='true' aria-label='Slide 1'></button>
                    <button type='button' data-bs-target='#carouselExampleControls' data-bs-slide-to='1' aria-label='Slide 2'></button>
                    <button type='button' data-bs-target='#carouselExampleControls' data-bs-slide-to='2' aria-label='Slide 3'></button>
                  </div>
                  <div class='carousel-inner rounded'>";

                  $conte = 0;
              
                  while($row_carrosel = $reCarrosel->fetch_assoc()){
              
                  switch ($conte) {
                    case '0':
                      echo "<div class='carousel-item active'><img class='d-block w-100' src='../blog/".$row_carrosel['file_img']."' alt='First Slide'/></div>";
                    break;
                                         
                    default:
                      echo "<div class='carousel-item'><img class='d-block w-100' src='../blog/".$row_carrosel['file_img']."' alt='Second Slide'/></div>";
                  }
                  $conte++;    
                }
                  
                    echo"
                  </div>
                  <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleControls' data-bs-slide='prev'>
                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                    <span class='sr-only'>Previous</span>
                  </button>
                  <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleControls' data-bs-slide='next'>
                    <span class='carousel-control-next-icon' aria-hidden='true'></span>
                    <span class='sr-only'>Next</span>
                  </button>
                </div>
                
                ";
            

              }else{
                echo "<img src='".$linha['caminho']."' style='width: 100%' />";
              } 
              $data = $linha['data'];
              $data = implode("/",array_reverse(explode("-",$data)));

              echo "<ul class='post-meta'>
              <li class='first'><span><i class='far fa-calendar'></i> $data </span></li>
              <li><span><i class='far fa-comment' style='margin-left:5px;'></i><a href='postagem.php?id_post=".$linha['id_postagem']."' title='Adicione um comentário'> ".$row_comentario['contagem']." comentários</a></span></li>
              <li class= 'last'><span><i class='fas fa-tag'></i> <a href='postagem.php?id_post=".$linha['id_postagem']."'>".$linha['usuario']."</a></span></li>
            </ul>
              <p>".$linha['mensagem']."</p>
            
            <!-- end article full post -->";
            }
           

           ?>
                    <br>
                    <h4><i class="fab fa-font-awesome-flag"></i> Comentários</h4>
                    <ul class="media-list postagem">
                        <?php
            $id = 0;
              //coletando os comentários
              $comentario_text = "SELECT 
                                      BC.nome,
                                      BC.data,
                                      BC.comentario,
                                      BC.id_postagem,
                                      BD.nome AS departamento,
                                      BE.nome AS empresa
                                  FROM
                                      blog_comentarios BC
                                          LEFT JOIN
                                      blog_departamento BD ON BC.departamento = BD.id_departamento
                                          LEFT JOIN
                                      blog_empresa BE ON BC.empresa = BE.id_empresa
                                  WHERE
                                      BC.id_postagem = '".$_GET['id_post']."' order by BC.id_comentario DESC ";

              $resultado_text = $conn->query($comentario_text);

              while($linha_text = $resultado_text->fetch_assoc()){    
                $data = $linha_text['data'];
                $data = implode("/",array_reverse(explode("-",$data)));
                              
                echo "
                    <li class='media'>
                      <div class='media-body'>
                        <h5 class='media-heading'>
                          <p>
                          ".$linha_text['comentario']."
                          </p>
                          <a href='javascript:'>
                          <b style='font-size: 16px'>".$linha_text['nome']."
                            </a>
                          <b style='font-size: 10px'>".$linha_text['departamento']." - ".$linha_text['empresa']." </b>
                        </h5>
                        <h6><span style='font-size: 10px;'>$data</span></h6>                                                  
                      </div>
                    </li> 
                    ";
                    $id++;
              }//fim while 
            ?>
                    </ul>
                    <hr />
                    <div class="comment-post">
                        <h4>Insira o seu comentário</h4>
                        <form action="enviar_email.php?id_post=<?= $_GET['id_post'] ?>" method="post"
                            class="comment-form " name="comment-form">
                            <div class="row">
                                <div class="span6 ">
                                    <input class="form-control" id="exampleFormControlInput1" type="text"
                                        placeholder="Seu nome" name="nome" style="width:40%;" />
                                </div><label></label>
                                <label></label>
                                <div class="row">
                                    <div class="col">
                                    <select class="form-select" aria-label="Default select example"
                                        name="departamento" placeholder="Departamento">
                                        <option value="">Selecione Departamento</option>
                                        <?php
                                            $departamento = "SELECT * FROM blog_departamento ORDER BY nome ASC";
                                            $resultado_departamento = $conn->query($departamento);
                                            while($row_depart = $resultado_departamento->fetch_assoc()){
                                                echo "<option value='".$row_depart["id_departamento"]."'>".$row_depart["nome"]."</option>";
                                            }
                                        ?>
                                    </select>
                                    </div>
                                    <div class="col">
                                    <select  class="form-select" aria-label="Default select example"
                                        name="empresa">
                                        <option value="">Selecione Filial</option>
                                        <?php
                                        $empresa = "SELECT * FROM blog_empresa ORDER BY nome ASC";
                                        $resultado_empresa = $conn->query($empresa);
                                        while($row_empresa = $resultado_empresa->fetch_assoc()){
                                            echo "<option value='".$row_empresa["id_empresa"]."'>".$row_empresa["nome"]."</option>";
                                        }
                                        ?>

                                    </select>
                                    </div>
                                </div>


                                <br><label></label>
                                <div class="span8">
                                    <label class="form-label" for="exampleFormControlTextarea1">Comentário
                                        <span>*</span></label>
                                    <textarea style="width:95%" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                        placeholder="Seu comentário" name="comentario" required></textarea><br>
                                    <button class="btn btn-small btn-primary" type="submit">Salvar
                                        comentário</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>
    <div class="card-footer" style="text-align: center;">
        <div class="fs--1 mt-4 mb-3">
            <div class="col-12 col-sm-auto text-center">
                <p style="text-align: center;">&copy; Departamento T.I - Todos os direitos reservados<span
                        class="d-none d-sm-inline-block"> | </span><br class="d-sm-none" /> 2022 Desenvolvido por <a
                        href="#">Matheus Voltz</a> - Ramal:
                    110-2326</p>
            </div>

        </div>
    </div>
    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="vendors/popper/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/anchorjs/anchor.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="vendors/echarts/echarts.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="vendors/list.js/list.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>