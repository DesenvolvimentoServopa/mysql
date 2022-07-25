<!-- ======= Header ======= -->
<?php
include('header.php');
?>
<!-- End Header -->

<body>
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active" style="background-image: url(../assets/img/comida_natural.jpg)">
                    <div class="carousel-container">
                        <div class="container">
                            <h2 class="animate__animated animate__fadeInDown">Bem vindo ao <span>Cardápio</span></h2>
                            <p class="animate__animated animate__fadeInUp">Uma alimentação saudável requer quantidades certas, sem exageros e também sem exclusões e alimentos que forneçam ao corpo: proteínas, carboidratos, gorduras, fibras, cálcio vitaminas e outros minerais. A diversidade de grãos, verduras, legumes e frutas deve fazer parte das refeições do dia a dia. É importante também evitar o consumo de alimentos industrializados. Na maioria das vezes, eles são compostos de substâncias que prejudicam o nosso organismo, como corantes, conservantes, sódio e açúcar em grandes quantidades.</p>
                            <a href="javascript:" class="btn-get-started animate__animated animate__fadeInUp scrollto" onclick="esconderBotoes()">Selecione o cardárpio!</a>
                            <div id="selcardapio" class="container" style="margin-top: 20px; display:none;"> 
                                <a href="cardapios.php?id=1" class="btn-get-started-filial animate__animated animate__fadeInUp scrollto">Servopa Matriz</a>
                                <a href="cardapios.php?id=2" class="btn-get-started-filial animate__animated animate__fadeInUp scrollto">Caminhões Curitiba</a>
                                <a href="cardapios.php?id=3" class="btn-get-started-filial animate__animated animate__fadeInUp scrollto">Caminhões Cambé</a> 
                            </div>                          
                        </div>                                            
                    </div>                    
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->
</body>

<script>
    function esconderBotoes(){

        var botaoCardapio = document.getElementById("selcardapio").style.display;

            if(botaoCardapio == 'none'){
                document.getElementById("selcardapio").style.display = "block";
            }else{
                document.getElementById("selcardapio").style.display = "none";
            }
        }
</script>

