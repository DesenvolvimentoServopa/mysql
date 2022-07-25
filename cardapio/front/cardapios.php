<!-- ======= Header ======= -->
<?php
include('header.php');

if (!empty($_GET['id'])) {

    require_once('switch.php');

    echo '
    <body>
    <main id="main">
        <!-- ======= Hero Section ======= -->
        <section id="inner-page" class="breadcrumbs">
            <div class="container">
                <div class="section-title">
                    <h2>refeição</h2>
                    <p>' . $nome . '</p>
                </div>
            </div>
        </section>
        
        <!-- ======= Breadcrumbs ======= -->
        <section id="pricing" class="pricing container">
            <div class="d-flex justify-content-between align-items-center" data-aos="fade-in">
                <div class="ratio ratio-16x9">
                    <object data="' . $campoData . '" type="application/pdf">
                    </object>
                </div>
            </div>
        </section>
        <!-- End Hero -->
        <div style="display: ' . $duchef . '" id="duchef">
            <!-- ======= Hero Section ======= -->
            <section id="inner-page" class="breadcrumbs">
                <div class="container">
                    <div class="section-title">
                        <h2>refeição</h2>
                        <p>' . $nomeDuchef . '</p>
                    </div>
                </div>
            </section>
            
            <!-- ======= Breadcrumbs ======= -->
            <section id="pricing" class="pricing container">
                <div class="d-flex justify-content-between align-items-center" data-aos="fade-in">
                    <div class="ratio ratio-16x9">
                        <object data="' . $campoDataDuchef . '" type="application/pdf">
                        </object>
                    </div>
                </div>
            </section>
        </div>
        </main>
        <!-- End Hero -->
        
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
            <i class="bi bi-arrow-up-short"></i>
        </a>
    </body>';
} else {
    header("location: index.php");
    exit;
}

?>

<?php
include('footer.php');
?>

<!-- End Footer -->