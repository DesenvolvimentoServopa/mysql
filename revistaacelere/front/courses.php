<?php
include('header.php');

$caminho = 'SELECT caminho FROM revista where id = '.$_GET['id'].'';


$result = $mysqli->query($caminho);
$row = $result->fetch_assoc();
?>

<body>
  <main id="main">
    <!-- ======= Breadcrumbs ======= -->

    <div class="breadcrumbs" data-aos="fade-in" style="margin-bottom: 150px;">
        <div class="container">
          <div class="ratio ratio-16x9">
            <iframe src="<?= $row['caminho'] ?> " title="Revista Acelere" allowfullscreen></iframe>
          </div>
        </div>
    </div>
  </main>
</body>

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<?php
include('footer.php');
?>