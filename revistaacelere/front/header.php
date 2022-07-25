<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Revista Acelere</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <!--Fa fa icon-->
  <script src="https://kit.fontawesome.com/c1f732237b.js" crossorigin="anonymous"></script>

  <!--SEGURANÇA-->
  <script src="../../js/seg.js"></script>
  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>



<!-- =======================================================
  * Template Name: Mentor - v4.3.0
  * Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
  <div class="container d-flex align-items-center">
    <h1 class="logo me-auto"><a href="index.php?pagina=1">Revista Acelere</a></h1>
    <nav id="navbar" class="navbar order-last order-lg-0">
      <ul>

        <li class="dropdown"><a href="#"><span>Edições Anteriores</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
          <?php

            include('../config/conexao.php');          

            $selecao = "SELECT id, edicao FROM revista";
            
            $result = $mysqli->query($selecao);

            while($row = $result->fetch_assoc()){
                echo '<li>
                          <a href="courses.php?pagina=2&id='.$row['id'].'">'.$row['edicao'].'ª Edição '; 
                         
                          if($_GET['id'] == $row['id']){
                            echo '<i class="fas fa-hand-point-left"></i>';
                          }
                echo     '</a>
                      </li>';
            }
          ?>
          </ul>
        </li>



      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
    <!-- Uncomment below if you prefer to use an image logo -->
    <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
    <a href="http://rede.paranapart.com.br/unico/" class="get-started-btn">

      <?php
      if ($_GET["pagina"] == NULL and $_GET["nome"] == NULL) {
        echo "<script>
                window.location.replace('../../unico/index.php')
              </script>";
      } else {
        echo empty($_GET["nome"]) ? "Acesso restrito" : $_GET["nome"];
      }
      ?>


    </a>
  </div>
</header><!-- End Header -->