<!DOCTYPE html>
<?php 
  //validando
  if($_GET['pagina'] != 4){
    header('location: 404.php');
  }
  require 'header.php';

  require 'menu_lateral.php'; 
?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class='fas fa-plus'></i> Criando Usuário</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-user"></i><a href="list_user.php?pagina=4">Usuários</a></li>
              <li><i class='fas fa-plus'></i>Novo Usuário</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6" style="width: 86%;">
            <section class="panel">
              <div class="panel-body">
                <form role="form" method="POST" action="insert_user.php">
                  <div class="form-group">
                    <label for="nome">Login: </label>
                    <input name="nome" type="text" class="form-control" style="width: 40%;" id="login" value="">
                  </div>
                  <div class="form-group">
                    <label for="email">E-mail: </label>
                    <input name="email" type="text" class="form-control" style="width: 40%;" id="email" value="">
                  </div>                  
                  <div class="form-group">
                    <label for="exibicao">Nome: </label>
                    <input name="exibicao" type="text" class="form-control" style="width: 40%;" id="exibicao" value="">
                  </div>                 
                  <div class="form-group">
                    <label for="senha_atual">Senha: </label>
                    <input name="senha_atual" type="password" class="form-control" style="width: 30%;" id="senha_atual">
                  </div>
                  <div class="form-group">
                    <div class="col-sm-10" style="margin-top: 20px; margin-left: -16px;">
                      <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                  </div>                  
                </form>
              </div>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
  </section>
  <!--MOSTRAR / ESCONDER-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
  <script>
    $('input[name="arquivo"]').change(function () {
      if ($('input[name="arquivo"]:checked').val() === "0") {
          $('#file').show();
      } else {
          $('#file').hide();
      }
    })
  </script>

  <!--TEXTAREA EDIÇÃO-->
  <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> <script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  //]]>
  </script>
  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

  <!-- jquery ui -->
  <script src="js/jquery-ui-1.9.2.custom.min.js"></script>

  <!--custom checkbox & radio-->
  <script type="text/javascript" src="js/ga.js"></script>
  <!--custom switch-->
  <script src="js/bootstrap-switch.js"></script>
  <!--custom tagsinput-->
  <script src="js/jquery.tagsinput.js"></script>
  <!-- bootstrap-wysiwyg -->
  <script src="js/jquery.hotkeys.js"></script>
  <script src="js/bootstrap-wysiwyg.js"></script>
  <script src="js/bootstrap-wysiwyg-custom.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/bootstrap-colorpicker.js"></script>
  <script src="js/daterangepicker.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
</body>
</html>