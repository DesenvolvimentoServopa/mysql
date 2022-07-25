<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/favicon.ico" rel="icon">

  <title>Inventário TI</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

</head>

<body class="bg-gradient-info">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-lg-block">
                <img src="img/logo.png" class="rounded mx-auto d-block logo" alt="Logo Servopa">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Insira Suas Credênciais</h1>
                  </div>
                  <form class="user" action="inc/validation.php" method="POST">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Usuário..." name="username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Senha..." name="password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Lembrar de mim</label>
                      </div>
                    </div>
                    <div class="col-lg-12 mb-3 <?= ($_GET['erro'] == 1) ? "d-lg-block" : "d-none" ?>">
                      <div class="card bg-warning text-white shadow text-center">
                        <div class="card-body">
                          Usuário não Localizado
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 mb-3 <?= ($_GET['erro'] == 2) ? "d-lg-block" : "d-none" ?>">
                      <div class="card bg-danger text-white shadow text-center">
                        <div class="card-body">
                          Usuário Desativado
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 mb-3 small <?= ($_GET['msn'] == 1) ? "d-lg-block" : "d-none" ?>">
                      <div class="card bg-success text-white shadow text-center">
                        <div class="card-body">
                          Solicitação enviada com sucesso!<br /> Agora basta aguardar o e-mail de confirmação do cadastro
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Entrar
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="front/forgot-password.php">Esqueceu a senha?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="front/register.php">Crie a sua conta aqui!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>