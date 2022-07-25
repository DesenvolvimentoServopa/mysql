<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../img/favicon.ico" rel="icon">

  <title>Inventário - Esqueceu a senha</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">

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
              <div class="col-lg-6 d-none d-lg-block">
                <img src="../img/logo.png" class="rounded mx-auto d-block logo" alt="Logo Servopa">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Esqueceu sua senha?</h1>
                    <p class="mb-4">Nós entendemos, coisas acontecem. Basta inserir seu endereço de e-mail abaixo e
                      enviaremos uma nova senha para o seu e-mail!</p>
                  </div>
                  <form class="user" action="../inc/email_forget.php" method="POST">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="username" aria-describedby="emailHelp" placeholder="Insira o seu e-mail...">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Reinicie sua Senha
                    </button>
                  </form>
                  <div class="col-lg-14 mb-3 my-2 small <?= ($_GET['msn'] == 1) ? "d-lg-block" : "d-none" ?>">
                    <div class="card bg-success text-white shadow">
                      <div class="card-body">
                        Solicitação enviada com sucesso. <br /> Aguarde uns minutinhos e verifique o seu e-mail!
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-14 mb-3 my-2 small <?= ($_GET['msn'] == 2) ? "d-lg-block" : "d-none" ?>">
                    <div class="card bg-warning text-white shadow">
                      <div class="card-body">
                        E-mail informado já existente. <br /> caso não lembre a senha, preencha o campo acima!
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="register.php">Crie a sua conta aqui!</a>
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

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>