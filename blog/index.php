<!DOCTYPE html>
<html lang="en-US" dir="ltr">

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
                                href="http://rede.paranapart.com.br" role="button" aria-haspopup="true"
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
                                <button type="submit" class="fas fa-search search-box-icon"></button>
                            </form>
                        </div>
                    </li>
                    <!-- Trocar para tema escuro -->
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
                    </li><?php if($_GET['usuario'] != NULL){
                          echo "<a href='adm/index.php'><i class='icon-user'></i>".$_GET['usuario']."</a>";
                      }else{
                      echo"
                   <a  href='adm/index.php'>
                            <button type='button' class='btn btn-primary'>
                                Entrar
                            </button>
                        </a>";}
?>
                    </li>
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

                                    </ul>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>

            <div class="card" style="box-shadow:  8px 8px 30px 20px #b0b0b0,
          -8px -8px 19px #ffffff;border-bottom-left-radius:0px;border-bottom-right-radius:0px;">
                <div class="card-body" style="border-bottom-left-radius:0px;border-bottom-right-radius:0px;">

                    <?php
	//conexão com o bando de dados  
  include '../inc/conexao.php';
	//pesquisa para o BD
	$busca = "SELECT 
              id_postagem, 
              titulo, 
              tipo_arquivo,
              file_img AS caminho, 
              mensagem, 
              data,
              BU.exibicao AS usuario,
              BP.carousel

            FROM
              blog_post BP
            LEFT JOIN
              blog_user BU ON BP.id_post_user = BU.id_user
            WHERE
              BP.deletar = 0
            ORDER BY id_postagem DESC";
	//Total por pagina
  $total_reg = "5"; // número de registros por página

  //tipo de arquivo
  $video = 'video/mp4';
  $pdf = 'application/pdf';
  

  //evita de exibir a página 0 de início	
	$pagina = $_GET['pagina'];
	
	if ($pagina == NULL) {
	$pc = "1";
	} else {
	$pc = $pagina;
	}	

	//valor inicial das buscas limitadas:
	$inicio = $pc - 1;
	$inicio = $inicio * $total_reg;

	//Execução da pesquisa no BD
  $limite = mysqli_query($banco_blog, "$busca LIMIT $inicio, $total_reg");

	$todos = mysqli_query($banco_blog, $busca);
	 
	$tr = mysqli_num_rows($todos); // verifica o número total de registros
	$tp = $tr / $total_reg; // verifica o número total de páginas
	 
  //alterando para data local
  
	// vamos criar as postagens
	while ($dados = mysqli_fetch_array($limite)) {

    //contador de comentários
    $comentario =  "SELECT count(*) AS contagem FROM blog_comentarios WHERE id_postagem = '".$dados['id_postagem']."'";
    $result = mysqli_query($banco_blog, $comentario); 
    $row_comentario = $result->fetch_assoc();

    

    if($dados['mensagem'] != NULL){
      $data = $dados['data'];
      $data = implode("/",array_reverse(explode("-",$data)));
      echo "
      
          <div>
           <div >
              <div class='card-heading'><!--titulo-->
                <h3><a href='postagem.php?id_post=".$dados['id_postagem']."'>".$dados['titulo']."</a></h3>
              </div><!--fim titulo-->
              <div class='row'>
              <!--corpo-->
                  <div class='span3' style='width:50%'>
                  <!--imagem-->
                    <div class='post-image' style='width: 80%'>
                      <a href='postagem.php?id_post=".$dados['id_postagem']."'>";
                        if($dados['tipo_arquivo'] == $video){
                          echo "
                              <video width='295' controls>
                                  <source src='".$dados['caminho']."' type='video/mp4'>
                                  <source src='".$dados['caminho']."' type='video/ogg'>
                                  Seu navegador não suporta HTML5 video.
                              </video>";
                        }elseif($dados['tipo_arquivo'] == $pdf){
                          echo "<iframe src='".$dados['caminho']."' height='400' width='290'></iframe>";
                        }else{
                          
                          echo "<a href='postagem.php?id_post=".$dados['id_postagem']."'><img src='".$dados['caminho']."' style='width: 100%;'/></a>
                      </a>
                      
                    </div>
                    
                    
                  </div><!--Fim imagem-->
                  
                  <div class='span5' style='width: 50%;'>
                 
                  <ul class='post-meta'>
                    <li class='first'><span><i class='far fa-calendar'> </i> $data </span></li>
                    <li><span><i class='far fa-comment'></i> <a href='postagem.php?id_post=".$dados['id_postagem']."' title='Adicione um comentário'> ".$row_comentario['contagem']." comentários</a></span></li>
                    <li class='last'><span><i class='fas fa-tag'></i ><a href='postagem.php?id_post=".$dados['id_postagem']."'> ".$dados['usuario']."</a></span></li>
                  </ul>
                  <div class='clearfix'>
                  </div>
                  <p>
                  ".$dados['mensagem']."
                </p>
                </div>

              </div><!--fim corpo-->
            </div>
            <br>
            ";
            
          }
    }else{
            
      echo "
              
              <div>
              <div class='post-heading'>
                <h3><a href='postagem.php?id_post=".$dados['id_postagem']."'>".$dados['titulo']."</a></h3>
              </div>";

              if($dados['tipo_arquivo'] == $video){
                echo "
                    <video width='560' controls>
                        <source src='".$dados['caminho']."' type='video/mp4'>
                        <source src='".$dados['caminho']."' type='video/ogg'>
                        Seu navegador não suporta HTML5 video.
                    </video>";
              }elseif($dados['tipo_arquivo'] == $pdf){
                echo "<iframe src='".$dados['caminho']."' height='800' width='770'></iframe>";
              }elseif($dados['carousel'] == 1){

                $carrorel = "SELECT file_img FROM blog.blog_post_carousel WHERE id_postagem = ".$dados['id_postagem']."";
                $reCarrosel = mysqli_query($banco_blog, $carrorel);

        echo "<div class='carousel slide' id='carouselExampleControls' data-bs-ride='carousel' style='width:50%'>
        <div class='carousel-indicators' >
          <button class='active' type='button' data-bs-target='#carouselExampleControls' data-bs-slide-to='0' aria-current='true' aria-label='Slide 1'></button>
          <button type='button' data-bs-target='#carouselExampleControls' data-bs-slide-to='1' aria-label='Slide 2'></button>
          <button type='button' data-bs-target='#carouselExampleControls' data-bs-slide-to='2' aria-label='Slide 3'></button>
        </div>
        <div class='carousel-inner rounded' >";

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
                echo "<a href='postagem.php?id_post=".$dados['id_postagem']."'><img src='".$dados['caminho']."' style='width: 80%;'/></a>";
              }
              $data = $dados['data'];
              $data = implode("/",array_reverse(explode("-",$data)));
              echo"
              <ul class='post-meta'>
                <li class='first'><span><i class='far fa-calendar'></i> $data </span></li>
                <li><span><i class='far fa-comment' style='margin-left:5px;'></i><a href='postagem.php?id_post=".$dados['id_postagem']."' title='Adicione um comentário'> ".$row_comentario['contagem']." comentários</a></span></li>
                <li class= 'last'><span><i class='fas fa-tag'></i> <a href='postagem.php?id_post=".$dados['id_postagem']."'>".$dados['usuario']."</a></span></li>
              </ul>
            </div>
          <br>
            ";

    }//Fim IF postagem

      

  }//Fim While postagem
  ?>
                    <!--PAGINAÇÃO-->

                </div>
                <br>
                <div class="pagination" style="float: right">
                    <?php
        // agora vamos criar os botões "Anterior e próximo"
        $anterior = $pc -1;
        $proximo = $pc +1;
        if ($pc>1) {
          echo " <div style='margin-top:30px;margin-right: 650px;'>
                    <a href='?pagina=$proximo' class='paginacao'>Postagens mais antigas</a>
                  </div> ";

          echo " <div style='margin-top:30px; '><a href='?pagina=$anterior' class='paginacao'>Postagens mais novas</a>
                </div>";

          
        }elseif($pc<$tp){
          echo " <div style='margin-bottom:30px; margin-left:20px;'>
                    <a href='?pagina=$proximo' class='paginacao'>Postagens mais antigas</a>
                  </div>
                 </div>
                  ";
        } 
      ?>

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