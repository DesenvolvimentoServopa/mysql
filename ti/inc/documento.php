<?php
/* ini_set('display_Erros',1);
ini_set('display_startup_erros',1);
Erro_reporting(E_ALL); */
session_start();

require_once('../bd/conexao.php');

//DATA DE HOJE
$dataHoje = date('d/m/Y');


switch ($_POST['tipo_documento']) {
    case '1':
        # NOTA FISCAL

        //CRIANDO LOG
        $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_GET['id_equip'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '6')";

        if (!$log = $conn->query($insertLog)) {

            printf('Erro[1]: %s\n', $conn->Erro);
        }

        //DATA DA NOTA
        $dataNota = $_POST['data_nota'];

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
                    printf('Erro[2]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                    exit;
                } else {
                    if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                        /*echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;*/
                    } else {
                        echo "Erro[3]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                    } //se caso não salvar vai mostrar o erro!
                }
            }
        } else {
            printf('Erro[4]: Por favor inserir infomar uma nota no formato PDF para ser salvo!<br />');
        }

        //FINALIZANDO
        if ($_POST['tipo_nota'] == 1) {

            #WINDOWS
            $query = "UPDATE manager_sistema_operacional SET fornecedor = '" . $_POST['fornecedor'] . "' , numero_nota = '" . $_POST['numeroNota'] . "', file_nota = '" . $caminho_db . "', file_nota_nome = '$nome_db', data_nota = '" . $dataNota . "' WHERE id_equipamento = " . $_GET['id_equip'] . "";
        
        } elseif ($_POST['tipo_nota'] == 2) {

            #OFFICE
            $query = "UPDATE manager_office SET fornecedor = '" . $_POST['fornecedor'] . "' , numero_nota = '" . $_POST['numeroNota'] . "', file_nota = '" . $caminho_db . "', file_nota_nome = '$nome_db', data_nota = '" . $dataNota . "' WHERE id_equipamento = " . $_GET['id_equip'] . "";
        
        } else {

            #DIVERSOS - SALVANDO O DOCUMENTO
            $query = "INSERT INTO manager_inventario_anexo (id_equipamento, usuario, tipo_anexo, caminho, nome, tipo, data_criacao) 
            VALUES ('" . $_GET['id_equip'] . "', '" . $_SESSION['id'] . "', '" . $tipo_file . "', '" . $caminho_db . "', '" . $nome_db . "', '1', '" . $dataHoje . "')";

            #DIVERSOS - SALVANDO A NOTA!
            $nota = "UPDATE manager_inventario_equipamento SET numero_nota = '".$_POST['numeroNota']."', data_nota = '".$dataNota."', fornecedor_scan = '".$_POST['fornecedor']."' WHERE id_equipamento = '".$_GET['id_equip']."'";
            $resultNota = $conn->query($nota);
        }

        if (!$resultDocumento = $conn->query($query)) {
            printf('Erro[5]: %s\n', $conn->Erro);
            exit;
        }

        break;

    case '2':
        # TERMO.

        //PEGANDO O ID DOS EQUIPAMENTOS

        if ($_GET['id_equip'] != NULL) {


            //SUBINDO O ARQ PARA O SERVIDOR
            if ($_FILES['anexo'] != NULL) {
                $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
                $nome_db = $_FILES['anexo']['name'];
                $caminho = "../documentos/termos/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
                $caminho_db = "../documentos/termos/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

                /*VALIDAÇÃO DO FILE*/
                $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

                $result =  $conn->query($sql_file); //aplicando a query

                if ($tipo_file != NULL) {
                    /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                    if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                        printf('Erro[6]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                        exit;
                    } else {
                        if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                            /*echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;*/
                        } else {
                            echo "Erro[7]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                        } //se caso não salvar vai mostrar o erro!
                    }
                }
            } else {
                printf('Erro[8]: Por favor inserir infomar uma termo no formato PDF para ser salvo!<br />');
            }

            #DIVERSOS
            $query = "INSERT INTO manager_inventario_anexo (id_equipamento, usuario, tipo_anexo, caminho, nome, tipo, data_criacao) 
            VALUES ('" . $_GET['id_equip'] . "', '" . $_SESSION['id'] . "', '" . $tipo_file . "', '" . $caminho_db . "', '" . $nome_db . "', '2', '" . $dataHoje . "')";


            if (!$resultDocumento = $conn->query($query)) {
                printf('Erro[9]: %s\n', $conn->Erro);
                exit;
            }

            #TERMO ASSINADO
            $updateTermo = "UPDATE manager_inventario_equipamento SET termo = 1 WHERE id_equipamento = '" . $_GET['id_equip'] . "'";

            if (!$resultupdateTermo = $conn->query($updateTermo)) {
                printf('Erro[10]: %s\n', $conn->Erro);
                exit;
            }
        } else {

            printf('Erro[11]: Selecione pelo menos um equipamento!');
        }

        break;
    case '3':
        //PEGANDO O ID DOS EQUIPAMENTOS

        if ($_GET['id_equip'] != NULL) {


            //SUBINDO O ARQ PARA O SERVIDOR
            if ($_FILES['anexo'] != NULL) {
                $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
                $nome_db = $_FILES['anexo']['name'];
                $caminho = "../documentos/checklist/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
                $caminho_db = "../documentos/checklist/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

                /*VALIDAÇÃO DO FILE*/
                $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

                $result =  $conn->query($sql_file); //aplicando a query

                if ($tipo_file != NULL) {
                    /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                    if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                        printf('Erro[12]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                        exit;
                    } else {
                        if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                            /*echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;*/
                        } else {
                            echo "Erro[13]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                        } //se caso não salvar vai mostrar o erro!
                    }
                }
            } else {
                printf('Erro[14]: Por favor inserir infomar uma check-list no formato PDF para ser salvo!<br />');
            }

            #DIVERSOS
            $query = "INSERT INTO manager_inventario_anexo (id_equipamento, usuario, tipo_anexo, caminho, nome, tipo, data_criacao) 
            VALUES ('" . $_GET['id_equip'] . "', '" . $_SESSION['id'] . "', '" . $tipo_file . "', '" . $caminho_db . "', '" . $nome_db . "', '3', '" . $dataHoje . "')";


            if (!$resultDocumento = $conn->query($query)) {
                printf('Erro[15]: %s\n', $conn->Erro);
                exit;
            }
        } else {
            printf('Erro[16]: Selecione pelo menos um equipamento!');
        }
        break;

    case '4':

        # DIVERSOS
        if ($_FILES['anexo'] != NULL) {
            $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
            $nome_db = $_FILES['anexo']['name'];
            $caminho = "../documentos/diversos/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
            $caminho_db = "../documentos/diversos/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

            /*VALIDAÇÃO DO FILE*/
            $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

            $result =  $conn->query($sql_file); //aplicando a query

            if ($tipo_file != NULL) {
                /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                    printf('Erro[17]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
                    exit;
                } else {
                    if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                        /*echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;*/
                    } else {
                        echo "Erro[18]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                    } //se caso não salvar vai mostrar o erro!
                }
            }
        } else {
            printf('Erro[19]: Por favor inserir infomar uma check-list no formato PDF para ser salvo!<br />');
        }

        #DIVERSOS
        $query = "INSERT INTO manager_inventario_anexo (id_equipamento, usuario, tipo_anexo, caminho, nome, tipo, data_criacao) 
        VALUES ('" . $_GET['id_equip'] . "', '" . $_SESSION['id'] . "', '" . $tipo_file . "', '" . $caminho_db . "', '" . $nome_db . "', '4', '" . $dataHoje . "')";


        if (!$resultDocumento = $conn->query($query)) {
            printf('Erro[20]: %s\n', $conn->Erro);
            exit;
        }

        //CRIANDO LOG
        $insertLog = "INSERT INTO manager_log (id_equipamento, data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_GET['id_equip'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '6')";

        if (!$log = $conn->query($insertLog)) {

            printf('Erro[21]: %s\n', $conn->Erro);
        }

        break;
}

header('location: ../front/equipamentodocumentos.php?pagina=5&id_equip=' . $_GET['id_equip'] . '');

$conn->close();
