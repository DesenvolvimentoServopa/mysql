<?php

session_start();

require_once('../conf/conexao.php');
include '../fun/funCheck.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lançamento de Notas</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">



    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <?php include 'navmenu.php'; ?>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <?php include 'header.php'; ?>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    
                    <div class="col-lg-4 mb-2 my-3"
                        style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 1){ echo 'none';}elseif($_GET['msn'] == 1){ echo 'block';} ?>;">
                        <div class="card bg-danger text-white shadow">
                            <div class="card-body">
                                Excluido com Sucesso!
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-2 my-3"
                        style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 2){ echo 'none';}elseif($_GET['msn'] == 2){ echo 'block';} ?>;">
                        <div class="card bg-success text-white shadow">
                            <div class="card-body">
                                Criado com Sucesso!
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-2 my-3"
                        style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 3){ echo 'none';}elseif($_GET['msn'] == 3){ echo 'block';} ?>;">
                        <div class="card bg-info text-white shadow">
                            <div class="card-body">
                                Editado com Sucesso!
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-2 my-3"
                        style="display: <?php if(!isset($_GET['msn']) || $_GET['msn'] != 4){ echo 'none';}elseif($_GET['msn'] == 4){ echo 'block';} ?>;">
                        <div class="card bg-danger text-white shadow">
                            <div class="card-body">
                               Por favor insira um usuário!
                            </div>
                        </div>
                    </div>


                    <div class="row" style="padding-bottom: 15px;">

                        <div class="col-lg-9">

                            <!-- Page Heading -->
                            <h1 class="h3 mb-2 text-gray-800">Fornecedores Catalogados</h1>

                        </div>

                        <div class="col-lg-3" style="text-align: -webkit-right;">
                            <?php if($permission == 1){?>
                            <button type="button" data-toggle="modal" data-target="#modalNewWorkflow"
                                class="btn btn-success btn-icon-split" style="display: block;">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span style="padding-left: 10px;padding-right: 10px;">Novo Workflow</span>
                            </button>
                            <?php }?>
                        </div>

                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modalNewWorkflow" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form id="novoworkflow" method="POST" action="../fun/funWorkflow.php?fun=novoworkflow">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Cadastro de Workflow</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="cnpjWorkflow">CNPJ</label>
                                            <input type="text" class="form-control" id="cnpjWorkflow"
                                                name="cnpjWorkflow" maxlength="18" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nomeWorkflow">Nome</label>
                                            <input type="text" class="form-control" id="nomeWorkflow"
                                                name="nomeWorkflow" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="idWorkflow">IDWFDOPORTAL</label>
                                            <input type="text" class="form-control" id="idWorkflow" name="idWorkflow" required>
                                        </div>
                                        <input type="hidden" class="form-control" name="idw" id="idw">
                                        <?php 
                                        
                                            // consulta no db usuarios ativos
                                        $sql = "SELECT nome,ID_USUARIO FROM dbnotas.cad_login WHERE deletar = 0 ORDER BY nome ASC;";
                                        $result = $conn->query($sql); //verifica consulta
                                        
                                                if($result){
                                                                //mostra os usuarios ativos em forma de lista
                                                    while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                        echo '<a href"#" class="custom-control custom-switch">';
                                                        echo '<p class class="list-group-item-text">                
                                                        <input type="checkbox" class="custom-control-input" id="id_user'.$row['ID_USUARIO'].'" name="id_user[]" value="'.$row['ID_USUARIO'].'" >
                                                        <label class="custom-control-label" for="id_user'.$row['ID_USUARIO'].'"> '.$row['nome'].'</p></input>';
                                                        echo '</a>';
                                                        
                                                    }
                                                }
                                                
                                                ?>

                                    </div>
                                    <br>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancelar</button>
                                        <input type="submit" class="btn btn-success" name="newWorkflow"
                                            value="Salvar" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Listagem de Workflows Cadastrados</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dtWorkflow" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>CNPJ</th>
                                            <th>ID WF DO PORTAL</th>
                                            <th>Nome</th>
                                            <?php if($permission == 1){ ?><th>Ação</th><?php }?>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include 'footer.php'; ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->




    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>


    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script type="text/javascript">
    // Material Select Initialization
    $(document).ready(function() {
        $('.mdb-select').materialSelect();
    });
    $(document).ready(function() {
        $('.mdb-select').materialSelect();
    });

    $("#cnpjWorkflow").on("keyup", function(e) {
        $(this).val(
            $(this).val()
            .replace(/\D/g, '')
            .replace(/^(\d{2})(\d{3})?(\d{3})?(\d{4})?(\d{2})?/, "$1.$2.$3/$4-$5"));
    });

    $('#cnpjWorkflow').keypress(function(e) {
        $(this).mask('00.000.000/0000-00');

    });


    $("#cnpjWorkflow").on("blur", function(e) {
        if (validarCNPJ($("#cnpjWorkflow").val()) == false) {
            alert("CNPJ inválido!");
            $("#cnpjWorkflow").val("");
        }
    });

    $(function() {
        $('[data-toggle="popover"]').popover()
    })



    function validarCNPJ(cnpj) {

        cnpj = cnpj.replace(/[^\d]+/g, '');

        if (cnpj == '') return false;

        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;

        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0, tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;

        return true;

    }
    
    </script>

    </script>
    <script>
    </script>

</body>

</html>