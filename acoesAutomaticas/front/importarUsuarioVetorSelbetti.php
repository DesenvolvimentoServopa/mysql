<!doctype html>
<html lang="pt-br">
<!--Éssa tela é chamada pelo robo (https://ondemand.automationedge.com/#/workflow/workflows/edit/4335)-->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS v5.1.3-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Version 6 -->
    <script src="https://kit.fontawesome.com/0c2d7c72a0.js" crossorigin="anonymous"></script>

    <title>Importação Usuários Selbetti</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inconsolata&display=swap');

        .container-md {
            text-align: center;
            margin-top: 13%;
            background-color: #82e981;
            padding: 10px;
            border-radius: 10px;
        }

        .container-sn {
            text-align: center;
            margin-top: 2%;
            background-color: #81afe9;
            padding: 10px;
            border-radius: 10px;
        }

        h4 {
            font-family: 'Inconsolata', monospace;
        }

        .alert-link {
            font-size: 15px;
            color: #6a1a21;
        }
    </style>
</head>

<body>
    <div class="container-lg">
        <div class="container-md">
            <h3 class="success" id="sucesso">Importação realizada com sucesso!</h3>
        </div>
        <div class="container-sn">
            <h4 id="mostrarImportados">Lista de usuários que já estavam cadastrados!<a href="javascript:mostrarLista();" class="alert-link">Mostrar / Esconder</a></h4>
        </div>

        <?php

        require '../vendor/autoload.php';
        include '../inc/querys.php';
        include '../../unico/api/tokenSelbettiAPI.php';

        if ($tokenUsuarioSelbetti != NULL) {

            //VARIAVEIS
            $urlListarUsuarios = 'https://appsmart.gruposervopa.com.br/smartshare/SmartShareAPI/api/v2/Usuario/ListarUsuarios';
            $urlInserirUsuarios = 'https://appsmart.gruposervopa.com.br/smartshare/SmartShareAPI/api/v3/Usuario/InserirUsuario';

            /*----------------------CRIANDO TABELAS----------------------------*/

            if (!$resultTabelaOne = $connLocal->query($tabelaSelbetti)) {
                printf("Erro[1]: %s\n", $connLocal->error);
                exit;
            }

            if (!$resultTabelaTwo = $connLocal->query($tabelaVetor)) {
                printf("Erro[2]: %s\n", $connLocal->error);
                exit;
            }

            if (!$resultTabelaThree = $connLocal->query($tabelaRelatorio)) {
                printf("Erro[3]: %s\n", $connLocal->error);
                exit;
            }

            //criando tabela demitidosRelatórios
            if (!$resultTabelaFour = $connLocal->query($tabelaRelatorioDemitidos)) {
                printf("Erro[4]: %s\n", $connLocal->error);
                exit;
            }

            /*----------------------PRIMEIRA TABELA FUNCIONARIOS VETOR(Sênior)----------------------------*/

            $queryV_func .= " WHERE dessit != 'demitido' ";

            $stmt = sqlsrv_query($conn, $queryV_func);

            while (sqlsrv_fetch($stmt)) {

                $nome = sqlsrv_get_field($stmt, 0);
                $cpf = sqlsrv_get_field($stmt, 1);
                $email = sqlsrv_get_field($stmt, 2);
                $situacao = sqlsrv_get_field($stmt, 3);

                $primeirosDigitosCPF = substr(str_replace('.', '', $cpf), '0', '6');
                $inicioNome = explode(' ', trim($nome));

                $login = strtolower($inicioNome[0] . "." . $primeirosDigitosCPF);

                $dominios = array(
                    "@audicentercascavel.com.br",
                    "@audicentercuritiba.com.br",
                    "@audicentermaringa.com.br",
                    "@brisapropaganda.com.br",
                    "@carwaysul.com.br",
                    "@cascavelharley-davidson.com.br",
                    "@conseorcioservopa.com.br",
                    "@dijonpeugeot.com.br",
                    "@dijonveiculos.com.br",
                    "@ducaticuritiba.com.br",
                    "@gruposervopa.com.br",
                    "@hondaprixx.com.br",
                    "@hyundaisevec.com.br",
                    "@lemansautomoveis.com.br",
                    "@lyonveiculos.com.br",
                    "@openpointvolvocars.com.br",
                    "@passionveiculos.com.br",
                    "@redwheelsharley-davidson.com.br",
                    "@ribeiraopretohd.com.br",
                    "@servopa.com.br",
                    "@servopacaminhoes.com.br",
                    "@theoneharley-davidson.com.br",
                    "@triumphcwb.com.br",
                    "@triumphnorth.com.br",
                    "@vecodil.com.br",
                    "@volvocascavel.com.br"
                );

                $strEmail = strrchr($email, '@');

                if ($encontrei = in_array($strEmail, $dominios)) {
                    $email = $email;
                } else {
                    $email = 'email_alterar@servopa.com.br';
                }

                $insertVetor = 'INSERT INTO vetor_users (nome, usuario, email, dessit) VALUES 
                    ("' . $nome . '", "' . $login . '", "' . $email . '", "' . $situacao . '")';

                if (!$resultVetorUsuario = $connLocal->query($insertVetor)) {
                    printf("Erro[5]: %s\n", $connLocal->error);
                    exit;
                }
            }
            sqlsrv_close($conn);


            /*----------------------SEGUNDA TABELA FUNCIONARIOS DA SELBETTi----------------------------*/
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $urlListarUsuarios,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'dsCliente: ' . $dsCliente . '',
                        'dsChaveAutenticacao: ' . $dsChaveAutenticacao . '',
                        'tokenUsuario: ' . $tokenUsuarioSelbetti . '',
                        'Content-Length: 0'
                    ),
                )
            );


            $response = json_decode(curl_exec($curl));

            foreach ($response->listaUsuarios as $key => $value) {

                $insertVetor = "INSERT INTO selbetti_users (usuario, stAtivo, nome, idTipoUsuario, email, cdUsuario) VALUES 
                    ('" . $value->dsLogin . "', '" . $value->stAtivo . "', '" . $value->dsNome . "', 
                    '" . $value->idTipoUsuario . "', '" . $value->dsEmail . "', '" . $value->cdUsuario . "')";

                if (!$resultVetorUsuario = $connLocal->query($insertVetor)) {
                    printf("Erro[6]: %s\n", $connLocal->error);
                    exit;
                }
            }

            curl_close($curl);

            $teste = 1;

            /*----------------------VALIDAÇÂO - CADASTRANDO----------------------------*/
            echo ' 
                <div id="tabelaImportados" style="display: none; width: 27%;">
                    <table class="table table-sm table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Usuário</th>
                            </tr>
                        </thead>
                        <tbody>';

            $resultadoVetorUsers = $connLocal->query($queryVetorUsers);

            while ($vetorRH = $resultadoVetorUsers->fetch_assoc()) {

                $querySelbettiUsers = "SELECT * FROM selbetti_users WHERE usuario = '" . $vetorRH['usuario'] . "';";

                $resultadoSelbettiUsers = $connLocal->query($querySelbettiUsers);
                $SelbettiUsers = $resultadoSelbettiUsers->fetch_assoc();

                if ($SelbettiUsers['usuario'] == NULL) { //SE FOR NULL QUER DIZER QUE NAO TEM NA SELBETTI
                    /*----------------------salvando na selbetti----------------------------*/

                    //verificando se ja existe usuario lá

                    $queryRelatorioUsers = "SELECT * FROM relatorio_users WHERE usuario = '" . $vetorRH['usuario'] . "'";
                    $vai = $connLocal->query($queryRelatorioUsers);
                    $usuarioRepetido = $vai->fetch_assoc();

                    if ($usuarioRepetido['usuario'] == NULL) {

                       //API CRIAR USUARIO SELBETTI
                       /*  $curl = curl_init();

                        curl_setopt_array(
                            $curl,
                            array(
                                CURLOPT_URL => $urlInserirUsuarios,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => '{
                                                            "idTipoUsuario": 3,
                                                            "dsNome": "' . $vetorRH['nome'] . '",
                                                            "dsLogin": "' . $vetorRH['usuario'] . '",
                                                            "dsSenha": "servopa",
                                                            "dsEmail": "' . $vetorRH['email'] . '",
                                                            "dsImpressaoDigital": "",
                                                            "dsTelefone": "",
                                                            "vlRamal": "",
                                                            "cdPapelPrincipal": 100,
                                                            "cdAreaPrincipal": 1012,
                                                            "cdPastaInicial": 1,
                                                            "idTipoLogin": 0,
                                                            "idVisaoInicialWF": 1,
                                                            "idVisaoInicial": 1,
                                                            "stPermiteTrocarVisaoInicial": true,
                                                            "vlDiasTrocarSenha": 999,
                                                            "stTrocarSenhaProximoLogin": false,
                                                            "stAusente": false,
                                                            "stAtivo": true,
                                                            "stMobile": false,
                                                            "stIndexador": false,
                                                            "stUsuarioAD": false
                                                            }',
                                CURLOPT_HTTPHEADER => array(
                                    'dsCliente: ' . $dsCliente . '',
                                    'dsChaveAutenticacao: ' . $dsChaveAutenticacao . '',
                                    'tokenUsuario: ' . $tokenUsuarioSelbetti . '',
                                    'Content-Type: application/json'
                                ),
                            )
                        );

                        $response = curl_exec($curl);

                        curl_close($curl); */

                        /*
                        NÃO SERÁ MAIS CRIADO USUARIO NA SELBETTI POIS ACONTECEU UM ERRO QUE DUPLICOU TODOS OS USUÁIOS JA CRIADOS, 
                        ENTÃO IREMOS USAR ESSES DUPLICADOS APENAS EDITANDO E COLOCANDO OS NOVOS USUÁRIOS. QUANDO ISSO TERMINAR VOLTAREMOS A USAR A API
                        30/06/2022
                        */



                        //salvando no relatorio para enviar e-mail
                        $insertVetor = "INSERT INTO relatorio_users(nome, usuario, email, dessit) VALUES ('" . $vetorRH['nome'] . "', '" . $vetorRH['usuario'] . "', '" . $vetorRH['email'] . "','CADASTRADO')";

                        if (!$resultVetorUsuario = $connLocal->query($insertVetor)) {
                            printf("Erro[7]: %s\n", $connLocal->error);
                            exit;
                        }
                    }
                } else {
                    echo '<tr>
                            <th scope="row">' . $teste . '</th>
                            <td>' . $SelbettiUsers['usuario'] . '</td>
                        </tr>';
                }
                $teste++;
            }
            echo '</tbody>
                </table>
            </div>';

            /*----------------------mostrando lista usuario importados----------------------------*/

            $result = $connLocal->query($queryRelatorioUsers);
            if ($relatorioUsers['nome'] != null) {

                echo '<br>
                        <div class="container-sm">
                            <h2 class="bd-title" id="content">Lista usuarios importados</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nome</td>
                                        <td>E-mail</td>
                                        <td>Login</td>
                                    </tr>
                                </thead>
                                <tbody>';
                while ($tabelaUsers = $result->fetch_assoc()) {
                    echo '
                                    <tr>
                                        <td>' . $tabelaUsers['nome'] . '</td>
                                        <td>' . $tabelaUsers['email'] . '</td>
                                        <td>' . $tabelaUsers['usuario'] . '</td>
                                    </tr>';
                }
                echo '
                                </tbody>
                            </table>
                        </div>';
            } else {
                echo '<br>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"><i class="fa-solid fa-triangle-exclamation fa-1x"></i> </use></svg>
                            <div>
                                &nbsp Não foram encontrados novos colaboradores para o cadastro! <a href="javascript:close_tab();" class="alert-link">Fechar</a>
                            </div>
                        </div>';
                //require_once('demitidos.php');
                echo '
                    </div>';
            }

            //----------------------EXCLUINDO TABELAS----------------------------

            if (!$resultTabelaFor = $connLocal->query($dropSelbetti)) {
                printf("Erro[8]: %s\n", $connLocal->error);
                exit;
            } 

            if (!$resultTabelaFive = $connLocal->query($dropVetor)) {
                printf("Erro[9]: %s\n", $connLocal->error);
                exit;
            }

            if (!$resultTabelaSix = $connLocal->query($dropRelatorioDemitidos)) {
                printf("Erro[10]: %s\n", $connLocal->error);
                exit;
            }

        } else {
            echo "<div id='erro'><h3>NÃO FOI POSSIVEL VALIDAR O TOKEN</h3></div>";
            exit;
        }

        ?>
        <script>
            function close_tab() {
                if (confirm("Deseja fechar esta guia?")) {
                    window.close();
                }
            }

            function mostrarLista() {

                var modoDisplay = document.getElementById("tabelaImportados").style.display;

                if (modoDisplay == 'none') {
                    document.getElementById("tabelaImportados").style.display = "block";
                } else {
                    document.getElementById("tabelaImportados").style.display = "none";
                }

            }

            function mostrarListaDemitidos() {

                var modoDisplay = document.getElementById("tabelaImportadosDemitidos").style.display;

                if (modoDisplay == 'none') {
                    document.getElementById("tabelaImportadosDemitidos").style.display = "block";
                } else {
                    document.getElementById("tabelaImportadosDemitidos").style.display = "none";
                }
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>

<!--ENVIANDO E_MAIL-->
<?php require_once('enviar.php'); ?>