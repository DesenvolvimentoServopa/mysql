<!DOCTYPE html>
<?php 
//validando
if($_GET['pagina'] != 4){
  header('location: 404.php');
}
require 'header.php';

require 'menu_lateral.php'; 

//pegando todas as postagens
$postagens_query = "SELECT * FROM blog_user";
$result_postagem = mysqli_query($banco_blog, $postagens_query);

?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fas fa-book-open"></i> Lista de usuários</h3>

            <div id="new">
              <a class="btn btn-danger" href="new_user.php?pagina=4">
                <i class="fas fa-plus"></i> Novo usuário
              </a>
            </div>

            <?php
                if($_GET['msn'] == 1){
                  echo "
                  <div class='alert alert-warning fade in'>
                    <button data-dismiss='alert' class='close close-sm' type='button'>
                      <i class='far fa-times-circle' style='color: red;'></i>
                    </button>
                  <strong>Atenção</strong> Usuário editado com sucesso!
                </div>";
              }

              if($_GET['msn'] == 2){
                echo "<div class='alert alert-info fade in'>
                <button data-dismiss='alert' class='close close-sm' type='button'>
                  <i class='far fa-times-circle' style='color: red;'></i>
                </button>
                <strong>Atenção</strong> Usuário reativado com sucesso!.
              </div>";
              }

              if($_GET['msn'] == 3){
                echo "<div class='alert alert-block alert-danger fade in'>
                <button data-dismiss='alert' class='close close-sm' type='button'>
                  <i class='far fa-times-circle' style='color: blue;'></i>
                </button>
                <strong>Atenção</strong> Usuário desativado com sucesso!.
              </div>";
              }
              
              if($_GET['msn'] == 4){
                echo "
                <div class='alert alert-success fade in'>
                  <button data-dismiss='alert' class='close close-sm' type='button'>
                    <i class='far fa-times-circle' style='color: red;'></i>
                  </button>
                <strong>Atenção</strong> Usuário criado com sucesso!
              </div>";
            }
            ?>
          </div>
        </div>

        <div class="row"></div>
          <div class="col-lg-12">
            <section class="panel">
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th>ID</th>
                    <th>Login</th>
                    <th>E-mail</th>                    
                    <th>Usuário</th>                                        
                    <th>Ativo / Inativo</th>
                    <th>Ação</th>
                  </tr>
                  <?php
                  while($postagens = mysqli_fetch_assoc($result_postagem)){
                    echo "
                    <tr>
                      <td>".$postagens['id_user']."</td>
                      <td>".$postagens['nome']."</td>
                      <td>".$postagens['email']."</td>
                      <td>".$postagens['exibicao']."</td>
                      <td>";
                        echo ($postagens['deletar'] == 0) ? "Ativo" : "Inativo";                      
                        echo "
                      </td>
                      <td>
                        <div class='btn-group'>";
                          
                          if($postagens['deletar'] == 0){                            
                                echo "<a class='btn btn-danger' href='ativa_desativa.php?id=".$postagens['id_user']."&ativa=nao' title='desativar'><i class='icon_close_alt2'></i></a>";
                            }else{
                              echo "<a class='btn btn-success' href='ativa_desativa.php?id=".$postagens['id_user']."&ativa=sim' title='ativar'><i class='icon_check_alt2'></i></a>";
                            }                      
                            echo "
                          <a class='btn btn-warning' href='edit_user.php?pagina=4&id=".$postagens['id_user']."' title='editar'><i class='fas fa-edit'></i></a>
                        </div>
                      </td>
                  </tr>";
                  }
                  ?>
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->

  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/jquery-ui-1.10.4.min.js"></script>
  <script src="js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
  <!-- bootstrap -->
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- charts scripts -->
  <script src="assets/jquery-knob/js/jquery.knob.js"></script>
  <script src="js/jquery.sparkline.js" type="text/javascript"></script>
  <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
  <script src="js/owl.carousel.js"></script>
  <!-- jQuery full calendar -->
  <<script src="js/fullcalendar.min.js"></script>
    <!-- Full Google Calendar - Calendar -->
    <script src="assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="js/calendar-custom.js"></script>
    <script src="js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="js/jquery.customSelect.min.js"></script>
    <script src="assets/chart-master/Chart.js"></script>

    <!--custome script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>
    <script src="js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/xcharts.min.js"></script>
    <script src="js/jquery.autosize.min.js"></script>
    <script src="js/jquery.placeholder.min.js"></script>
    <script src="js/gdp-data.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/sparklines.js"></script>
    <script src="js/charts.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>    
</body>
</html>