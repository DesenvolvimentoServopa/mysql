<?php
require_once('../bd/conexao.php');

//tipos de perfil
$queryPerfil = "SELECT type_profile, type_name FROM manager.manager_profile_type WHERE type_profile not in (0)";
$resultPerfil = $conn->query($queryPerfil);

?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../img/favicon.ico" rel="icon">

  <title>Inventário - Registre</title>

  <!-- Custom fonts for this template-->
  <link href="../vendorfontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">

</head>

<body class="bg-gradient-info">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block">
            <img src="../img/logo.png" class="rounded mx-auto d-block logo" alt="Logo Servopa">
          </div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Solicite sua conta!</h1>
                <p class="mb-4">Será enviado uma solicitação para o administrador e o mesmo irá verificar se você pode ou não ter acesso a esse sistema</p>
              </div>
              <form class="user" action="../inc/email.php" method="POST">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName"
                      placeholder="Primeiro Nome" name="primeiroNome">
                  </div>
                  <div class="col-sm-6">
                    <select class="form-control" id="exampleLastName" name="perfil">
                        <option selected>Selecione um Perfil</option>
                        <?php
                          while($perfil = $resultPerfil->fetch_assoc()){
                            echo "<option value='".$perfil['type_name']."'>".$perfil['type_name']."</option>";
                          }
                        ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                    placeholder="Endereço de E-mail" name="email">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="exampleInputPassword"
                      placeholder="Senha">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="exampleRepeatPassword"
                      placeholder="Repita a Senha" name="senha">
                  </div>
                  <div class="col-sm-12 my-3">
                    <textarea class="form-control form-control-user" id="exampleTextarea"
                      placeholder="Escreva prevemente o motivo de ter acesso a esse sistema!" name="mensagem"></textarea>
                  </div>
                </div>
                <button type="submit" href="login.html" class="btn btn-primary btn-user btn-block">
                  Registrar
                </button>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.php">Esqueceu a senha?</a>
              </div>
              <div class="text-center">
                <a class="small" href="../index.php">já tem uma conta? Conecte-se!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendorjquery/jquery.min.js"></script>
  <script src="../vendorbootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendorjquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>