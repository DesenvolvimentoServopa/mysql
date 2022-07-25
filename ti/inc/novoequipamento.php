<?php
session_start();
require_once('../bd/conexao.php');
require_once('../bd/conexao_ocs.php');

//DATA DE HOJE
$dataHoje = date('Y-m-d');

switch ($_POST['tipo_equipamento']) {
    case '1':
        # CELULAR...

        //Equipamento
        $insert = "INSERT INTO manager_inventario_equipamento 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "id_funcionario,";
        }
        $insert .= "
            usuario, 
            tipo_equipamento, 
            modelo, 
            patrimonio, 
            filial, 
            estado, 
            imei_chip, 
            status, 
            valor
        ) 
        VALUES 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "'" . $_POST['newfun'] . "',";
        }
        $insert .= "
            '" . $_SESSION['id'] . "',
            '" . $_POST['tipo_equipamento'] . "',
            '" . $_POST['modelo'] . "',
            '" . $_POST['patrimonio'] . "',
            '" . $_POST['empresa'] . "',
            '" . $_POST['estado'] . "',
            '" . $_POST['imei'] . "',
            '" . $_POST['status'] . "',
            '" . $_POST['valor'] . "'
        )";

        if (!$result = $conn->query($insert)) {

            printf("Erro[1]: %s\n", $conn->error);
            exit;
        } else {

            //busca id do equipamento para usar na hora de salvar os acessorios e a nota fiscal
            $queryBusca = "SELECT max(id_equipamento) as id_equipamento FROM manager_inventario_equipamento";
            $resultBusca = $conn->query($queryBusca);
            $id_equipamento = $resultBusca->fetch_assoc();

            //salvando relatório caso tenha funcionário
            if (!empty($_POST['newfun'])) {
                $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_POST['newfun'] . "','" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4')";

                if (!$log = $conn->query($insertLog)) {
                    printf('Erro[2]: %s\n', $conn->error);
                }
            }

            //acessorios
            if (isset($_POST['acessorio'])) {
                foreach ($_POST['acessorio'] as $id_acessorio) {
                    $insertAcessorios = "INSERT INTO manager_inventario_acessorios 
                    (
                        id_equipamento, 
                        tipo_acessorio
                    ) 
                    VALUES 
                    (
                        '" . $id_equipamento['id_equipamento'] . "', 
                        '" . $id_acessorio . "'
                    )";

                    if (!$resultAcessorios = $conn->query($insertAcessorios)) {

                        printf("Erro[3]: %s\n", $conn->error);
                        exit;
                    }
                }
            }

            //nota fiscal
            if (!empty($_POST['numero_nota'])) {

                //gambiarra pois estou com preguisa....(é eu sei o sistema é novo...... tô nem ai!)
                $updatenota = "UPDATE manager_inventario_equipamento SET numero_nota = '" . $_POST['numero_nota'] . "', data_nota = '" . $_POST['data_nota'] . "' WHERE id_equipamento = " . $id_equipamento['id_equipamento'] . "";

                if (!$resultnota = $conn->query($updatenota)) {

                    printf("Erro[4]: %s\n", $conn->error);
                    exit;
                }


                //SUBINDO O ARQ PARA O SERVIDOR
                if ($_FILES['anexo'] != NULL) {
                    $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
                    $nome_db = $_FILES['anexo']['name'];
                    $caminho = "../documentos/notas/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
                    $caminho_db = "../documentos/notas/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

                    /*VALIDAÇÃO DO FILE*/
                    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

                    $result =  $conn->query($sql_file); //aplicando a query

                    if ($tipo_file != NULL) {
                        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                        if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                            printf('Erro[5]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                            exit;
                        } else {
                            if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                                echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;
                            } else {
                                echo "Erro[6]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                                exit;
                            } //se caso não salvar vai mostrar o erro!
                        }
                    }
                } else {
                    printf('Erro[7]: Por favor inserir infomar uma nota no formato PDF para ser salvo!<br />');
                    exit;
                }

                //salvando no banco de dados
                $queryAnexo = "INSERT INTO manager_inventario_anexo 
                ( 
                    id_equipamento,
                    usuario, 
                    tipo_anexo, 
                    caminho, 
                    nome, 
                    tipo, 
                    data_criacao
                ) 
                VALUES 
                ( 
                    '" . $id_equipamento['id_equipamento'] . "',
                    '" . $_SESSION['id'] . "', 
                    '" . $tipo_file . "', 
                    '" . $caminho_db . "', 
                    '" . $nome_db . "', 
                    '4', 
                    '" . $dataHoje . "'
                )";

                if (!$resultAnexo = $conn->query($queryAnexo)) {

                    printf("Erro[8]: %s\n", $conn->error);
                    exit;
                }
            }

            //criar log de criação do equipamento
            $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '13')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[9]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $id_equipamento['id_equipamento'] . '');
            }
        }
        break;

    case '2':
        # TABLET...

        //Equipamento
        $insert = "INSERT INTO manager_inventario_equipamento 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "id_funcionario,";
        }
        $insert .= "
            usuario, 
            tipo_equipamento, 
            modelo, 
            patrimonio, 
            filial, 
            estado, 
            imei_chip, 
            status, 
            valor
        ) 
        VALUES 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "'" . $_POST['newfun'] . "',";
        }
        $insert .= "
            '" . $_SESSION['id'] . "',
            '" . $_POST['tipo_equipamento'] . "',
            '" . $_POST['modelo'] . "',
            '" . $_POST['patrimonio'] . "',
            '" . $_POST['empresa'] . "',
            '" . $_POST['estado'] . "',
            '" . $_POST['imei'] . "',
            '" . $_POST['status'] . "',
            '" . $_POST['valor'] . "'
        )";

        if (!$result = $conn->query($insert)) {

            printf("Erro[10]: %s\n", $conn->error);
            exit;
        } else {

            //busca id do equipamento para usar na hora de salvar os acessorios e a nota fiscal
            $queryBusca = "SELECT max(id_equipamento) as id_equipamento FROM manager_inventario_equipamento";
            $resultBusca = $conn->query($queryBusca);
            $id_equipamento = $resultBusca->fetch_assoc();

            //salvando relatório caso tenha funcionário
            if (!empty($_POST['newfun'])) {
                $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_POST['newfun'] . "','" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4')";

                if (!$log = $conn->query($insertLog)) {
                    printf('Erro[11]: %s\n', $conn->error);
                }
            }

            //acessorios
            if (isset($_POST['acessorio'])) {
                foreach ($_POST['acessorio'] as $id_acessorio) {
                    $insertAcessorios = "INSERT INTO manager_inventario_acessorios 
                    (
                        id_equipamento, 
                        tipo_acessorio
                    ) 
                    VALUES 
                    (
                        '" . $id_equipamento['id_equipamento'] . "', 
                        '" . $id_acessorio . "'
                    )";

                    if (!$resultAcessorios = $conn->query($insertAcessorios)) {

                        printf("Erro[12]: %s\n", $conn->error);
                        exit;
                    }
                }
            }

            //nota fiscal
            if (!empty($_POST['numero_nota'])) {
                //gambiarra pois estou com preguisa....(é eu sei o sistema é novo...... tô nem ai!)
                $updatenota = "UPDATE manager_inventario_equipamento SET numero_nota = '" . $_POST['numero_nota'] . "', data_nota = '" . $_POST['data_nota'] . "' WHERE id_equipamento = " . $id_equipamento['id_equipamento'] . "";

                if (!$resultnota = $conn->query($updatenota)) {

                    printf("Erro[13]: %s\n", $conn->error);
                    exit;
                }

                //SUBINDO O ARQ PARA O SERVIDOR
                if ($_FILES['anexo'] != NULL) {
                    $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
                    $nome_db = $_FILES['anexo']['name'];
                    $caminho = "../documentos/notas/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
                    $caminho_db = "../documentos/notas/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

                    /*VALIDAÇÃO DO FILE*/
                    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

                    $result =  $conn->query($sql_file); //aplicando a query

                    if ($tipo_file != NULL) {
                        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                        if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                            printf('Erro[14]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                            exit;
                        } else {
                            if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                                echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;
                            } else {
                                echo "Erro[15]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                                exit;
                            } //se caso não salvar vai mostrar o erro!
                        }
                    }
                } else {
                    printf('Erro[16]: Por favor inserir infomar uma nota no formato PDF para ser salvo!<br />');
                    exit;
                }

                //salvando no banco de dados
                $queryAnexo = "INSERT INTO manager_inventario_anexo 
                ( 
                    id_equipamento,
                    usuario, 
                    tipo_anexo, 
                    caminho, 
                    nome, 
                    tipo, 
                    data_criacao
                ) 
                VALUES 
                ( 
                    '" . $id_equipamento['id_equipamento'] . "',
                    '" . $_SESSION['id'] . "', 
                    '" . $tipo_file . "', 
                    '" . $caminho_db . "', 
                    '" . $nome_db . "', 
                    '4', 
                    '" . $dataHoje . "'
                )";

                if (!$resultAnexo = $conn->query($queryAnexo)) {

                    printf("Erro[17]: %s\n", $conn->error);
                    exit;
                }
            }

            //criar log de criação do equipamento
            $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '13')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[18]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $id_equipamento['id_equipamento'] . '');
            }
        }
        break;
    case '3':
        # CHIP...

        //Equipamento
        $insert = "INSERT INTO manager_inventario_equipamento 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "id_funcionario,";
        }
        $insert .= "
            usuario, 
            tipo_equipamento,
            filial,
            operadora,
            numero,
            planos_voz,
            planos_dados, 
            imei_chip, 
            status
        ) 
        VALUES 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "'" . $_POST['newfun'] . "',";
        }
        $insert .= "
            '" . $_SESSION['id'] . "',
            '" . $_POST['tipo_equipamento'] . "',
            '" . $_POST['empresaChip'] . "',
            '" . $_POST['operadoraChip'] . "',
            '" . $_POST['numeroChip'] . "',
            '";

        $insert .= !empty($_POST['planosVoz']) ? $_POST['planosVoz'] : "---";

        $insert .=  "', '";

        $insert .= !empty($_POST['planosDados']) ? $_POST['planosDados'] : "---";

        $insert .=  "',";

        $insert .= "'" . $_POST['imeiChip'] . "',
            '" . $_POST['statusChip'] . "'
        )";

        if (!$result = $conn->query($insert)) {

            printf("Erro[19]: %s\n", $conn->error);
            exit;
        } else {

            //busca id do equipamento para usar na hora de salvar os acessorios e a nota fiscal
            $queryBusca = "SELECT max(id_equipamento) as id_equipamento FROM manager_inventario_equipamento";
            $resultBusca = $conn->query($queryBusca);
            $id_equipamento = $resultBusca->fetch_assoc();

            //salvando relatório caso tenha funcionário
            if (!empty($_POST['newfun'])) {
                $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_POST['newfun'] . "','" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4')";

                if (!$log = $conn->query($insertLog)) {
                    printf('Erro[20]: %s\n', $conn->error);
                }
            }

            //nota fiscal
            if (!empty($_POST['numero_nota'])) {

                //gambiarra pois estou com preguisa....(é eu sei o sistema é novo...... tô nem ai!)
                $updatenota = "UPDATE manager_inventario_equipamento SET numero_nota = '" . $_POST['numero_nota'] . "', data_nota = '" . $_POST['data_nota'] . "' WHERE id_equipamento = " . $id_equipamento['id_equipamento'] . "";

                if (!$resultnota = $conn->query($updatenota)) {

                    printf("Erro[21]: %s\n", $conn->error);
                    exit;
                }

                //SUBINDO O ARQ PARA O SERVIDOR
                if ($_FILES['anexo'] != NULL) {
                    $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
                    $nome_db = $_FILES['anexo']['name'];
                    $caminho = "../documentos/notas/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
                    $caminho_db = "../documentos/notas/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

                    /*VALIDAÇÃO DO FILE*/
                    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

                    $result =  $conn->query($sql_file); //aplicando a query

                    if ($tipo_file != NULL) {
                        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                        if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                            printf('Erro[22]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                            exit;
                        } else {
                            if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                                echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;
                            } else {
                                echo "Erro[23]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                                exit;
                            } //se caso não salvar vai mostrar o erro!
                        }
                    }
                } else {
                    printf('Erro[24]: Por favor inserir infomar uma nota no formato PDF para ser salvo!<br />');
                    exit;
                }

                //salvando no banco de dados
                $queryAnexo = "INSERT INTO manager_inventario_anexo 
                ( 
                    id_equipamento,
                    usuario, 
                    tipo_anexo, 
                    caminho, 
                    nome, 
                    tipo, 
                    data_criacao
                ) 
                VALUES 
                ( 
                    '" . $id_equipamento['id_equipamento'] . "',
                    '" . $_SESSION['id'] . "', 
                    '" . $tipo_file . "', 
                    '" . $caminho_db . "', 
                    '" . $nome_db . "', 
                    '4', 
                    '" . $dataHoje . "'
                )";

                if (!$resultAnexo = $conn->query($queryAnexo)) {

                    printf("Erro[25]: %s\n", $conn->error);
                    exit;
                }
            }

            //criar log de criação do equipamento
            $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '13')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[26]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $id_equipamento['id_equipamento'] . '');
            }
        }
        break;
    case '4':
        # MODEM...

        //Equipamento
        $insert = "INSERT INTO manager_inventario_equipamento 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "id_funcionario,";
        }
        $insert .= "
            usuario, 
            tipo_equipamento,
            filial,
            operadora,
            numero,
            planos_voz,
            planos_dados, 
            imei_chip, 
            status
        ) 
        VALUES 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "'" . $_POST['newfun'] . "',";
        }
        $insert .= "
            '" . $_SESSION['id'] . "',
            '" . $_POST['tipo_equipamento'] . "',
            '" . $_POST['empresaChip'] . "',
            '" . $_POST['operadoraChip'] . "',
            '" . $_POST['numeroChip'] . "',
            '";

        $insert .= !empty($_POST['planosVoz']) ? $_POST['planosVoz'] : "---";

        $insert .=  "', '";

        $insert .= !empty($_POST['planosDados']) ? $_POST['planosDados'] : "---";

        $insert .=  "',";

        $insert .= "'" . $_POST['imeiChip'] . "',
            '" . $_POST['statusChip'] . "'
        )";

        if (!$result = $conn->query($insert)) {

            printf("Erro[27]: %s\n", $conn->error);
            exit;
        } else {

            //busca id do equipamento para usar na hora de salvar os acessorios e a nota fiscal
            $queryBusca = "SELECT max(id_equipamento) as id_equipamento FROM manager_inventario_equipamento";
            $resultBusca = $conn->query($queryBusca);
            $id_equipamento = $resultBusca->fetch_assoc();

            //salvando relatório caso tenha funcionário
            if (!empty($_POST['newfun'])) {
                $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_POST['newfun'] . "','" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4')";

                if (!$log = $conn->query($insertLog)) {
                    printf('Erro[28]: %s\n', $conn->error);
                }
            }

            //nota fiscal
            if (!empty($_POST['numero_nota'])) {

                //gambiarra pois estou com preguisa....(é eu sei o sistema é novo...... tô nem ai!)
                $updatenota = "UPDATE manager_inventario_equipamento SET numero_nota = '" . $_POST['numero_nota'] . "', data_nota = '" . $_POST['data_nota'] . "' WHERE id_equipamento = " . $id_equipamento['id_equipamento'] . "";

                if (!$resultnota = $conn->query($updatenota)) {

                    printf("Erro[29]: %s\n", $conn->error);
                    exit;
                }

                //SUBINDO O ARQ PARA O SERVIDOR
                if ($_FILES['anexo'] != NULL) {
                    $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
                    $nome_db = $_FILES['anexo']['name'];
                    $caminho = "../documentos/notas/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
                    $caminho_db = "../documentos/notas/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

                    /*VALIDAÇÃO DO FILE*/
                    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

                    $result =  $conn->query($sql_file); //aplicando a query

                    if ($tipo_file != NULL) {
                        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                        if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                            printf('Erro[30]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                            exit;
                        } else {
                            if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                                echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;
                            } else {
                                echo "Erro[31]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                                exit;
                            } //se caso não salvar vai mostrar o erro!
                        }
                    }
                } else {
                    printf('Erro[32]: Por favor inserir infomar uma nota no formato PDF para ser salvo!<br />');
                    exit;
                }

                //salvando no banco de dados
                $queryAnexo = "INSERT INTO manager_inventario_anexo 
                ( 
                    id_equipamento,
                    usuario, 
                    tipo_anexo, 
                    caminho, 
                    nome, 
                    tipo, 
                    data_criacao
                ) 
                VALUES 
                ( 
                    '" . $id_equipamento['id_equipamento'] . "',
                    '" . $_SESSION['id'] . "', 
                    '" . $tipo_file . "', 
                    '" . $caminho_db . "', 
                    '" . $nome_db . "', 
                    '4', 
                    '" . $dataHoje . "'
                )";

                if (!$resultAnexo = $conn->query($queryAnexo)) {

                    printf("Erro[33]: %s\n", $conn->error);
                    exit;
                }
            }

            //criar log de criação do equipamento
            $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '13')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[34]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $id_equipamento['id_equipamento'] . '');
            }
        }


        break;
    case '5':
        # RAMAL IP...

        //Equipamento
        $insert = "INSERT INTO manager_inventario_equipamento 
           (";
        if (!empty($_POST['newfun'])) {
            $insert .= "id_funcionario,";
        }
        $insert .= "
            usuario, 
            tipo_equipamento, 
            modelo, 
            numero, 
            filial,
            locacao,
            status
        ) 
        VALUES 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "'" . $_POST['newfun'] . "',";
        }
        $insert .= "
            '" . $_SESSION['id'] . "',
            '" . $_POST['tipo_equipamento'] . "',
            '" . $_POST['modeloRamal'] . "',
            '" . $_POST['numeroRamal'] . "',
            '" . $_POST['empresaRamal'] . "',
            '" . $_POST['locacaoRamal'] . "',
            '1'
        )";

        if (!$result = $conn->query($insert)) {

            printf("Erro[35]: %s\n", $conn->error);
            exit;
        } else {

            //busca id do equipamento para usar na hora de salvar os acessorios e a nota fiscal
            $queryBusca = "SELECT max(id_equipamento) as id_equipamento FROM manager_inventario_equipamento";
            $resultBusca = $conn->query($queryBusca);
            $id_equipamento = $resultBusca->fetch_assoc();

            //salvando relatório caso tenha funcionário
            if (!empty($_POST['newfun'])) {
                $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_POST['newfun'] . "','" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4')";

                if (!$log = $conn->query($insertLog)) {
                    printf('Erro[36]: %s\n', $conn->error);
                }
            }

            //criar log de criação do equipamento
            $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '13')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[37]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $id_equipamento['id_equipamento'] . '');
            }
        }

        break;
    case '10':
        # SCANNER...

        //Equipamento
        $insert = "INSERT INTO manager_inventario_equipamento 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "id_funcionario,";
        }
        $insert .= "
            usuario, 
            tipo_equipamento, 
            modelo, 
            serialnumber,
            patrimonio, 
            filial,
            locacao,
            situacao,
            status";

        if ($_POST['situacaoscan'] == 4) {
            $insert .= ", fornecedor_scan, data_fim_contrato";
        } else if ($_POST['situacaoscan'] == 5) {
            $insert .= ", numero_nota, data_nota";
        }

        $insert .= ") 
        VALUES 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "'" . $_POST['newfun'] . "',";
        }
        $insert .= "
            '" . $_SESSION['id'] . "',
            '" . $_POST['tipo_equipamento'] . "',
            '" . $_POST['modeloScan'] . "',
            '" . $_POST['serieScan'] . "',
            '" . $_POST['patrimonioScan'] . "',
            '" . $_POST['empresaScan'] . "',
            '" . $_POST['locacaoScan'] . "',
            '" . $_POST['situacaoscan'] . "',
            '1'";

        if ($_POST['situacaoscan'] == 4) {

            $insert .= ", '" . $_POST['fornecedorScan'] . "', '" . $_POST['dataFimContrato'] . "'";
        } else if ($_POST['situacaoscan'] == 5) {

            $insert .= ", '" . $_POST['numero_notaScan'] . "', '" . $_POST['data_notaScan'] . "'";
        }

        $insert .= ")";

        if (!$result = $conn->query($insert)) {

            printf("Erro[38]: %s\n", $conn->error);
            exit;
        } else {
            //busca id do equipamento para usar na hora de salvar os acessorios e a nota fiscal
            $queryBusca = "SELECT max(id_equipamento) as id_equipamento FROM manager_inventario_equipamento";
            $resultBusca = $conn->query($queryBusca);
            $id_equipamento = $resultBusca->fetch_assoc();

            //salvando relatório caso tenha funcionário
            if (!empty($_POST['newfun'])) {
                $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_POST['newfun'] . "','" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4')";

                if (!$log = $conn->query($insertLog)) {
                    printf('Erro[39]: %s\n', $conn->error);
                }
            }

            //nota fiscal
            if (!empty($_POST['numero_nota'])) {

                //SUBINDO O ARQ PARA O SERVIDOR
                if ($_FILES['anexoScan'] != NULL) {
                    $tipo_file = $_FILES['anexoScan']['type']; //Pegando qual é a extensão do arquivo
                    $nome_db = $_FILES['anexoScan']['name'];
                    $caminho = "../documentos/notas/" . $_FILES['anexoScan']['name']; //caminho onde será salvo o FILE
                    $caminho_db = "../documentos/notas/" . $_FILES['anexoScan']['name']; //pasta onde está o FILE para salvar no Bando de dados

                    /*VALIDAÇÃO DO FILE*/
                    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

                    $result =  $conn->query($sql_file); //aplicando a query

                    if ($tipo_file != NULL) {
                        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                        if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                            printf('Erro[40]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                            exit;
                        } else {
                            if (move_uploaded_file($_FILES['anexoScan']['tmp_name'], $caminho)) { //aplicando o salvamento
                                echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;
                            } else {
                                echo "Erro[41]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                                exit;
                            } //se caso não salvar vai mostrar o erro!
                        }
                    }
                } else {
                    printf('Erro[42]: Por favor inserir infomar uma nota no formato PDF para ser salvo!<br />');
                    exit;
                }

                //salvando no banco de dados
                $queryAnexo = "INSERT INTO manager_inventario_anexo 
                ( 
                    id_equipamento,
                    usuario, 
                    tipo_anexo, 
                    caminho, 
                    nome, 
                    tipo, 
                    data_criacao
                ) 
                VALUES 
                ( 
                    '" . $id_equipamento['id_equipamento'] . "',
                    '" . $_SESSION['id'] . "', 
                    '" . $tipo_file . "', 
                    '" . $caminho_db . "', 
                    '" . $nome_db . "', 
                    '4', 
                    '" . $dataHoje . "'
                )";

                if (!$resultAnexo = $conn->query($queryAnexo)) {

                    printf("Erro[43]: %s\n", $conn->error);
                    exit;
                }
            }

            //criar log de criação do equipamento
            $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '13')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[44]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $id_equipamento['id_equipamento'] . '');
            }
        }

        break;
    case '11':
        # DVR...

        //Equipamento
        $insert = "INSERT INTO manager_inventario_equipamento 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "id_funcionario,";
        }
        $insert .= "
            usuario, 
            tipo_equipamento, 
            modelo,
            patrimonio, 
            serialnumber, 
            ip,
            locacao,
            status
        ) 
        VALUES 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "'" . $_POST['newfun'] . "',";
        }
        $insert .= "
            '" . $_SESSION['id'] . "',
            '" . $_POST['tipo_equipamento'] . "',
            '" . $_POST['modeloDVR'] . "',
            '" . $_POST['patrimonioDVR'] . "',
            '" . $_POST['serieDVR'] . "',
            '" . $_POST['ipDVR'] . "',
            '" . $_POST['localizacaoDVR'] . "',
            '1'
        )";

        if (!$result = $conn->query($insert)) {

            printf("Erro[45]: %s\n", $conn->error);
            exit;
        } else {

            //busca id do equipamento para usar na hora de salvar os acessorios e a nota fiscal
            $queryBusca = "SELECT max(id_equipamento) as id_equipamento FROM manager_inventario_equipamento";
            $resultBusca = $conn->query($queryBusca);
            $id_equipamento = $resultBusca->fetch_assoc();

            //salvando relatório caso tenha funcionário
            if (!empty($_POST['newfun'])) {
                $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_POST['newfun'] . "','" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4')";

                if (!$log = $conn->query($insertLog)) {
                    printf('Erro[46]: %s\n', $conn->error);
                }
            }

            //criar log de criação do equipamento
            $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '13')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[47]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $id_equipamento['id_equipamento'] . '');
            }
        }

        break;

    case '8':
        # CPU...

        //VERIFICANDO SE O EQUIPAMENTO ESTA CADASTRADO

        $queryValidar = "SELECT id_equipamento, patrimonio FROM manager_inventario_equipamento WHERE patrimonio =  '" . $_POST['patrimonio'] . "'";
        $result = $conn->query($queryValidar);
        $validar = $result->fetch_assoc();

        if (!empty($validar['patrimonio'])) {
            header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $validar['id_equipamento'] . '');
            exit;
        }

        //alterando patrimonio no OCS
        $updateAcount = "UPDATE accountinfo SET TAG = '" . $_POST['patrimonio'] . "' WHERE HARDWARE_ID = '" . $_SESSION['hardware_id'] . "'";

        if (!$restulAcount = $conn_ocs->query($updateAcount)) {
            printf("Erro[48]: %s\n", $conn_ocs->error);
            exit;
        }

        //Equipamento
        $insert = "INSERT INTO manager_inventario_equipamento 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "id_funcionario,";
        }
        $insert .= "
                usuario,
                tipo_equipamento, 
                modelo,
                patrimonio, 
                dominio, 
                filial,
                locacao,
                departamento,
                situacao,
                status,
                hostname,
                ip,
                processador,
                hd,
                memoria,
                serialnumber,
                data_criacao
            ) 
            VALUES 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "'" . $_POST['newfun'] . "',";
        }
        $insert .= "
                '" . $_SESSION['id'] . "',
                '" . $_POST['tipo_equipamento'] . "',
                '" . $_POST['modelo'] . "',
                '" . $_POST['patrimonio'] . "',
                '" . $_POST['dominio'] . "',
                '" . $_POST['empresa'] . "',
                '" . $_POST['locacao'] . "',
                '" . $_POST['departamento'] . "',
                '" . $_POST['situacao'] . "',
                '" . $_POST['status'] . "',
                '" . $_POST['hostname'] . "',
                '" . $_POST['ip'] . "',  
                '" . $_POST['processador'] . "',               
                '" . $_POST['hd'] . "',                
                '" . $_POST['memoria'] . "',                
                '" . $_SESSION['serial_number'] . "',
                '" . $dataHoje . "')";

        if (!$result = $conn->query($insert)) {
            printf("Erro[49]: %s\n", $conn->error);
            exit;
        } else {

            //busca id do equipamento para usar na hora de salvar os demais abaixos
            $queryBusca = "SELECT max(id_equipamento) as id_equipamento FROM manager_inventario_equipamento";
            $resultBusca = $conn->query($queryBusca);
            $id_equipamento = $resultBusca->fetch_assoc();

            //salvando relatório caso tenha funcionário
            if (!empty($_POST['newfun'])) {
                $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_POST['newfun'] . "','" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4')";

                if (!$log = $conn->query($insertLog)) {
                    printf('Erro[50]: %s\n', $conn->error);
                }
            }

            //SUBINDO O ARQ PARA O SERVIDOR
            if ($_FILES['anexo'] != NULL) {
                $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
                $nome_db = $_FILES['anexo']['name'];
                $caminho = "../documentos/notas/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
                $caminho_db = "../documentos/notas/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

                /*VALIDAÇÃO DO FILE*/
                $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

                $result =  $conn->query($sql_file); //aplicando a query

                if ($tipo_file != NULL) {
                    /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                    if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                        printf('Erro[51]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                        exit;
                    } else {
                        if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                            echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;
                        } else {
                            echo "Erro[52]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                            exit;
                        } //se caso não salvar vai mostrar o erro!
                    }
                }

                //sistema operacional
                $insertSO = "INSERT INTO manager_sistema_operacional 
            (
                id_equipamento, 
                locacao, 
                empresa,
                versao, 
                serial, 
                fornecedor,
                numero_nota,
                data_nota,
                file_nota,
                file_nota_nome
            ) 
            VALUES 
            (
                '" . $id_equipamento['id_equipamento'] . "',
                '" . $_POST['locacao'] . "',
                '" . $_POST['empresa'] . "',
                '" . $_POST['versaoSO'] . "',
                '" . $_POST['chaveProduto'] . "',
                '" . $_POST['fornecedor'] . "',
                '" . $_POST['numero_nota'] . "',
                '" . $_POST['data_nota'] . "',
                '" . $caminho_db . "',
                '" . $nome_db . "')";

                if (!$restulSO = $conn->query($insertSO)) {
                    printf("Erro[53]: %s\n", $conn->error);
                    exit;
                }
            } else {

                //sistema operacional
                $insertSO = "INSERT INTO manager_sistema_operacional 
                (
                    id_equipamento, 
                    locacao, 
                    empresa,
                    versao, 
                    serial
                ) 
                VALUES 
                (
                    '" . $id_equipamento['id_equipamento'] . "',
                    '" . $_POST['locacao'] . "',
                    '" . $_POST['empresa'] . "',
                    '" . $_POST['versaoSO'] . "',
                    '" . $_POST['chaveProduto'] . "')";

                if (!$restulSO = $conn->query($insertSO)) {
                    printf("Erro[54]: %s\n", $conn->error);
                    exit;
                }
            }

            //OFFICE

            if (!empty($_POST['versao'])) {

                $insertSO = "INSERT INTO manager_office 
            (
                id_equipamento, 
                locacao, 
                empresa,
                versao, 
                serial
            ) 
            VALUES 
            (
                '" . $id_equipamento['id_equipamento'] . "',
                '" . $_POST['locacao'] . "',
                '" . $_POST['empresa'] . "',
                '" . $_POST['versao'] . "',
                '" . $_POST['chaveProduto'] . "')";

                if (!$restulSO = $conn->query($insertSO)) {
                    printf("Erro[55]: %s\n", $conn->error);
                    exit;
                }
            }

            //criar log de criação do equipamento
            $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '13')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[56]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $id_equipamento['id_equipamento'] . '');
            }
        }

        break;

    case '9':
        # NOTEBOOK...

        //VERIFICANDO SE O EQUIPAMENTO ESTA CADASTRADO

        $queryValidar = "SELECT id_equipamento, patrimonio FROM manager_inventario_equipamento WHERE patrimonio =  '" . $_POST['patrimonio'] . "'";
        $result = $conn->query($queryValidar);
        $validar = $result->fetch_assoc();

        if (!empty($validar['patrimonio'])) {
            header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $validar['id_equipamento'] . '');
            exit;
        }

        //alterando patrimonio no OCS
        $updateAcount = "UPDATE accountinfo SET TAG = '" . $_POST['patrimonio'] . "' WHERE HARDWARE_ID = '" . $_SESSION['hardware_id'] . "'";

        if (!$restulAcount = $conn_ocs->query($updateAcount)) {
            printf("Erro[57]: %s\n", $conn_ocs->error);
            exit;
        }

        //Equipamento
        $insert = "INSERT INTO manager_inventario_equipamento 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "id_funcionario,";
        }
        $insert .= "
                usuario,
                tipo_equipamento, 
                modelo,
                patrimonio, 
                dominio, 
                filial,
                locacao,
                departamento,
                situacao,
                status,
                hostname,
                ip,
                processador,
                hd,
                memoria,
                serialnumber,
                data_criacao
            ) 
            VALUES 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "'" . $_POST['newfun'] . "',";
        }
        $insert .= "
                '" . $_SESSION['id'] . "',
                '" . $_POST['tipo_equipamento'] . "',
                '" . $_POST['modelo'] . "',
                '" . $_POST['patrimonio'] . "',
                '" . $_POST['dominio'] . "',
                '" . $_POST['empresa'] . "',
                '" . $_POST['locacao'] . "',
                '" . $_POST['departamento'] . "',
                '" . $_POST['situacao'] . "',
                '" . $_POST['status'] . "',
                '" . $_POST['hostname'] . "',
                '" . $_POST['ip'] . "',  
                '" . $_POST['processador'] . "',               
                '" . $_POST['hd'] . "',                
                '" . $_POST['memoria'] . "',                
                '" . $_SESSION['serial_number'] . "',
                '" . $dataHoje . "')";

        if (!$result = $conn->query($insert)) {
            printf("Erro[58]: %s\n", $conn->error);
            exit;
        } else {

            //busca id do equipamento para usar na hora de salvar os demais abaixos
            $queryBusca = "SELECT max(id_equipamento) as id_equipamento FROM manager_inventario_equipamento";
            $resultBusca = $conn->query($queryBusca);
            $id_equipamento = $resultBusca->fetch_assoc();

            //salvando relatório caso tenha funcionário
            if (!empty($_POST['newfun'])) {
                $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_POST['newfun'] . "','" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4')";

                if (!$log = $conn->query($insertLog)) {
                    printf('Erro[59]: %s\n', $conn->error);
                }
            }

            //SUBINDO O ARQ PARA O SERVIDOR
            if ($_FILES['anexo'] != NULL) {
                $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
                $nome_db = $_FILES['anexo']['name'];
                $caminho = "../documentos/notas/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
                $caminho_db = "../documentos/notas/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

                /*VALIDAÇÃO DO FILE*/
                $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

                $result =  $conn->query($sql_file); //aplicando a query

                if ($tipo_file != NULL) {
                    /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                    if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                        printf('Erro[60]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                        exit;
                    } else {
                        if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                            echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;
                        } else {
                            echo "Erro[61]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                            exit;
                        } //se caso não salvar vai mostrar o erro!
                    }
                }

                //sistema operacional
                $insertSO = "INSERT INTO manager_sistema_operacional 
            (
                id_equipamento, 
                locacao, 
                empresa,
                versao, 
                serial, 
                fornecedor,
                numero_nota,
                data_nota,
                file_nota,
                file_nota_nome
            ) 
            VALUES 
            (
                '" . $id_equipamento['id_equipamento'] . "',
                '" . $_POST['locacao'] . "',
                '" . $_POST['empresa'] . "',
                '" . $_POST['versaoSO'] . "',
                '" . $_POST['chaveProduto'] . "',
                '" . $_POST['fornecedor'] . "',
                '" . $_POST['numero_nota'] . "',
                '" . $_POST['data_nota'] . "',
                '" . $caminho_db . "',
                '" . $nome_db . "')";

                if (!$restulSO = $conn->query($insertSO)) {
                    printf("Erro[62]: %s\n", $conn->error);
                    exit;
                }
            } else {

                //sistema operacional
                $insertSO = "INSERT INTO manager_sistema_operacional 
                (
                    id_equipamento, 
                    locacao, 
                    empresa,
                    versao, 
                    serial
                ) 
                VALUES 
                (
                    '" . $id_equipamento['id_equipamento'] . "',
                    '" . $_POST['locacao'] . "',
                    '" . $_POST['empresa'] . "',
                    '" . $_POST['versao'] . "',
                    '" . $_POST['chaveProduto'] . "')";

                if (!$restulSO = $conn->query($insertSO)) {
                    printf("Erro[63]: %s\n", $conn->error);
                    exit;
                }
            }

            //OFFICE

            if (!empty($_POST['versao'])) {

                $insertSO = "INSERT INTO manager_office 
            (
                id_equipamento, 
                locacao, 
                empresa,
                versao, 
                serial
            ) 
            VALUES 
            (
                '" . $id_equipamento['id_equipamento'] . "',
                '" . $_POST['locacao'] . "',
                '" . $_POST['empresa'] . "',
                '" . $_POST['versao'] . "',
                '" . $_POST['chaveProduto'] . "')";

                if (!$restulSO = $conn->query($insertSO)) {
                    printf("Erro[64]: %s\n", $conn->error);
                    exit;
                }
            }

            //criar log de criação do equipamento
            $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '13')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[65]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $id_equipamento['id_equipamento'] . '');
            }
        }

        break;

    case '12':

        # HARDWARE REDE...

        //Equipamento
        $insert = "INSERT INTO manager_inventario_equipamento 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "id_funcionario,";
        }
        $insert .= "
            usuario, 
            tipo_equipamento, 
            modelo,
            patrimonio, 
            serialnumber, 
            locacao,
            status
        ) 
        VALUES 
        (";
        if (!empty($_POST['newfun'])) {
            $insert .= "'" . $_POST['newfun'] . "',";
        }
        $insert .= "
            '" . $_SESSION['id'] . "',
            '" . $_POST['tipo_equipamento'] . "',
            '" . $_POST['modeloREDE'] . "',
            '" . $_POST['patrimonioREDE'] . "',
            '" . $_POST['serieREDE'] . "',
            '" . $_POST['localizacaoREDE'] . "',
            '1'
        )";

        if (!$result = $conn->query($insert)) {

            printf("Erro[46]: %s\n", $conn->error);
            exit;
        } else {

            //busca id do equipamento para usar na hora de salvar os acessorios e a nota fiscal
            $queryBusca = "SELECT max(id_equipamento) as id_equipamento FROM manager_inventario_equipamento";
            $resultBusca = $conn->query($queryBusca);
            $id_equipamento = $resultBusca->fetch_assoc();

            //salvando relatório caso tenha funcionário
            if (!empty($_POST['newfun'])) {
                $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_POST['newfun'] . "','" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4')";

                if (!$log = $conn->query($insertLog)) {
                    printf('Erro[47]: %s\n', $conn->error);
                }
            }


            //nota fiscal
            if (!empty($_POST['numero_nota'])) {

                //SUBINDO O ARQ PARA O SERVIDOR
                if ($_FILES['anexo'] != NULL) {
                    $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
                    $nome_db = $_FILES['anexo']['name'];
                    $caminho = "../documentos/notas/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
                    $caminho_db = "../documentos/notas/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

                    /*VALIDAÇÃO DO FILE*/
                    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

                    $result =  $conn->query($sql_file); //aplicando a query

                    if ($tipo_file != NULL) {
                        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                        if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                            printf('Erro[48]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                            exit;
                        } else {
                            if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                                echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;
                            } else {
                                echo "Erro[49]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                                exit;
                            } //se caso não salvar vai mostrar o erro!
                        }
                    }
                } else {
                    printf('Erro[42]: Por favor inserir infomar uma nota no formato PDF para ser salvo!<br />');
                    exit;
                }

                //salvando no banco de dados
                $queryAnexo = "INSERT INTO manager_inventario_anexo 
                ( 
                    id_equipamento,
                    usuario, 
                    tipo_anexo, 
                    caminho, 
                    nome, 
                    tipo, 
                    data_criacao
                ) 
                VALUES 
                ( 
                    '" . $id_equipamento['id_equipamento'] . "',
                    '" . $_SESSION['id'] . "', 
                    '" . $tipo_file . "', 
                    '" . $caminho_db . "', 
                    '" . $nome_db . "', 
                    '4', 
                    '" . $dataHoje . "'
                )";

                if (!$resultAnexo = $conn->query($queryAnexo)) {

                    printf("Erro[50]: %s\n", $conn->error);
                    exit;
                }
            }

            //criar log de criação do equipamento
            $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $id_equipamento['id_equipamento'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '13')";

            if (!$log = $conn->query($insertLog)) {
                printf('Erro[51]: %s\n', $conn->error);
            } else {
                header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $id_equipamento['id_equipamento'] . '');
            }
        }

        break;
}

$conn->close();
