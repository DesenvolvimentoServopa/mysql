<?php
include('header.php');

$id = 'SELECT id from revista order by id desc limit 1';
$result = $mysqli->query($id);
$row = $result->fetch_assoc();

?>
<body>
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex justify-content-center align-items-center">
    <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">
      <h1>Essa edição está especial!<br>Fique por dentro de tudo que acontece em nossa empresa.</h1>
      <a href="courses.php?pagina=2&id=<?=$row['id']?>" class="btn-get-started">Ler Agora</a>
    </div>
  </section><!-- End Hero -->
</body>
<?php
include('footer.php');
?>