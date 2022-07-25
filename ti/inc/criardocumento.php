<?php


/* ini_set('display_Erros',1);
ini_set('display_startup_erros',1);
Erro_reporting(E_ALL); */
session_start();

require_once('../bd/conexao.php');

//DATA DE HOJE
$dataHoje = date('d/m/Y');
$documentos_perm = "../documentos";
chmod($documentos_perm,0777);



//FUNCIONARIO - SERVE APENAS PARA RELATÓRIO
if ($_SESSION['id_funcionario'] != NULL) {

    $id_funcionario = $_SESSION['id_funcionario'];

} else {
    $queryFun = "SELECT id_funcionario FROM manager_inventario_equipamento WHERE id_equipamento = ".$_POST['equip']."";
    
    if(!$resultFun = $conn->query($queryFun)){
        echo "Não consegui localizar o funcionario, entre em contato com o administrador";
    }else{
        $fun = $resultFun->fetch_assoc();
        $id_funcionario = $fun['id_funcionario'];
    }
}

switch ($_POST['tipo_documento']) {
    case '1':
        # NOTA FISCAL

        //PEGANDO O ID DOS EQUIPAMENTOS
        $qt = count($_POST['equip']);
        $cont = 1;

        if ($_POST['equip'] != NULL) {

            foreach ($_POST['equip'] as $id_equipamento) {

                if ($qt > $cont) {
                    $where .= $id_equipamento . ',';
                } else {
                    $where .= $id_equipamento;
                }

                //CRIANDO LOG
                $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $id_equipamento . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '6')";

                if (!$log = $conn->query($insertLog)) {

                    printf('Erro[1]: %s\n', $conn->Erro);
                }

                $cont++;
            }
        }

        //DATA DA NOTA
        $dataNota = $_POST['data_nota'];

        //SUBINDO O ARQ PARA O SERVIDOR
        if ($_FILES['anexo'] != NULL) {
            $data = date('dmYHi');
            $data = str_replace(':', '', $data);
            $tipo_file = $data.'-'.$_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
            $nome_db = $data.'-'.$_FILES['anexo']['name'];
            $caminho = "../documentos/notas";
            chmod($caminho,0777);
            $caminho = "../documentos/notas/" . $nome_db; //caminho onde será salvo o FILE
            $caminho_db = "../documentos/notas/" . $nome_db; //pasta onde está o FILE para salvar no Bando de dados

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
                        echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;
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
            $query = "UPDATE manager_sistema_operacional SET fornecedor = '" . $_POST['fornecedor'] . "' , numero_nota = '" . $_POST['numeroNota'] . "', file_nota = '" . $caminho_db . "', file_nota_nome = '$nome_db', data_nota = '" . $dataNota . "' WHERE id_equipamento IN (" . $where . ")";
        } elseif ($_POST['tipo_nota'] == 2) {

            #OFFICE
            $query = "UPDATE manager_office SET fornecedor = '" . $_POST['fornecedor'] . "' , numero_nota = '" . $_POST['numeroNota'] . "', file_nota = '" . $caminho_db . "', file_nota_nome = '$nome_db', data_nota = '" . $dataNota . "' WHERE id_equipamento IN (" . $where . ")";
        } else {

            if (!empty($_GET['id_equip'])) {
                $id = "id_equipamento";
                $idvalor = $_GET['id_equip'];
            } else {
    
                $id = "id_funcionario";
                $idvalor = $id_funcionario;
            }

            #DIVERSOS - SALVANDO A NOTA
            $query = "INSERT INTO manager_inventario_anexo (".$id.", usuario, tipo_anexo, caminho, nome, tipo, data_criacao) 
            VALUES ('" . $idvalor . "', '" . $_SESSION['id'] . "', '" . $tipo_file . "', '" . $caminho_db . "', '" . $nome_db . "', '1', '" . $dataHoje . "')";

            #DIVERSOS - SALVANDO A NOTA!
            $nota = "UPDATE manager_inventario_equipamento SET numero_nota = '".$_POST['numeroNota']."', data_nota = '".$dataNota."' WHERE id_equipamento IN (" . $where . ")";
            $resultNota = $conn->query($nota);
        }


        if (!$resultDocumento = $conn->query($query)) {
            printf('Erro[5]: %s\n', $conn->Erro);
            exit;
        }else{
            echo $query;
        }

        break;

    case '2':
        # TERMO.

        //PEGANDO O ID DOS EQUIPAMENTOS

        if ($_POST['equip'] != NULL) {


            //SUBINDO O ARQ PARA O SERVIDOR
            if ($_FILES['anexo'] != NULL) {
                $data= date('dmYHi');
                $data = str_replace(':', '', $data);
                $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
                $nome_db = $data.'-'.$_FILES['anexo']['name'];
                $caminho = "../documentos/termos";
                chmod($caminho,0777);
                $caminho = "../documentos/termos/" . $nome_db; //caminho onde será salvo o FILE
                $caminho_db = "../documentos/termos/" . $nome_db; //pasta onde está o FILE para salvar no Bando de dados
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

            foreach ($_POST['equip'] as $id_equipamento) {

                #DIVERSOS
                $query = "INSERT INTO manager_inventario_anexo (id_funcionario, id_equipamento, usuario, tipo_anexo, caminho, nome, tipo, data_criacao) 
                VALUES ('" . $id_funcionario . "','" . $id_equipamento . "', '" . $_SESSION['id'] . "', '" . $tipo_file . "', '" . $caminho_db . "', '" . $nome_db . "', '2', '" . $dataHoje . "')";


                if (!$resultDocumento = $conn->query($query)) {
                    printf('Erro[9]: %s\n', $conn->Erro);
                    exit;
                }

                #TERMO ASSINADO
                $updateTermo = "UPDATE manager_inventario_equipamento SET termo = 0 WHERE id_equipamento = '" . $id_equipamento . "'";

                if (!$resultupdateTermo = $conn->query($updateTermo)) {
                    printf('Erro[10]: %s\n', $conn->Erro);
                    exit;
                }
            }
        } else {

            printf('Erro[11]: Selecione pelo menos um equipamento!');
        }

        break;
    case '3':
        # CHECK-LIST
        //PEGANDO O ID DOS EQUIPAMENTOS

        if ($_POST['equip'] != NULL) {


            //SUBINDO O ARQ PARA O SERVIDOR
            if ($_FILES['anexo'] != NULL) {
                $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
                $data= date('dmYHi');
                $data = str_replace(':', '', $data);
                $nome_db = $data.'-'.$_FILES['anexo']['name'];
                $caminho = "../documentos/checklist";
                chmod($caminho,0777);
                $caminho = "../documentos/checklist/" . $nome_db; //caminho onde será salvo o FILE
                $caminho_db = "../documentos/checklist/" . $nome_db; //pasta onde está o FILE para salvar no Bando de dados

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

            foreach ($_POST['equip'] as $id_equipamento) {

                #DIVERSOS
                $query = "INSERT INTO manager_inventario_anexo (id_funcionario, id_equipamento, usuario, tipo_anexo, caminho, nome, tipo, data_criacao) 
                VALUES ('" . $id_funcionario . "','" . $id_equipamento . "', '" . $_SESSION['id'] . "', '" . $tipo_file . "', '" . $caminho_db . "', '" . $nome_db . "', '3', '" . $dataHoje . "')";


                if (!$resultDocumento = $conn->query($query)) {
                    printf('Erro[15]: %s\n', $conn->Erro);
                    exit;
                }
            }
        } else {

            printf('Erro[16]: Selecione pelo menos um equipamento!');
        }
        break;
    case '4':

        # DIVERSOS

        if ($_FILES['anexo'] != NULL) {
            $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
            $data= date('dmYHi');
            $data = str_replace(':', '', $data);
            $nome_db = $data.'-'.$_FILES['anexo']['name'];
            $caminho = "../documentos/diversos";
            chmod($caminho,0777);
            $caminho = "../documentos/diversos/" . $nome_db; //caminho onde será salvo o FILE
            $caminho_db = "../documentos/diversos/" . $nome_db; //pasta onde está o FILE para salvar no Bando de dados

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

        if (!empty($_GET['id_equip'])) {
            $id = "id_equipamento";
            $idvalor = $_GET['id_equip'];
        } else {

            $id = "id_funcionario";
            $idvalor = $id_funcionario;
        }

        #DIVERSOS
        $query = "INSERT INTO manager_inventario_anexo (" . $id . ", usuario, tipo_anexo, caminho, nome, tipo, data_criacao) 
        VALUES ('" . $idvalor . "', '" . $_SESSION['id'] . "', '" . $tipo_file . "', '" . $caminho_db . "', '" . $nome_db . "', '4', '" . $dataHoje . "')";


        if (!$resultDocumento = $conn->query($query)) {
            printf('Erro[20]: %s\n', $conn->Erro);
            exit;
        }

        //CRIANDO LOG
        $insertLog = "INSERT INTO manager_log (" . $id . ", data_alteracao, usuario, tipo_alteracao) VALUES ('" . $idvalor . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '6')";

        if (!$log = $conn->query($insertLog)) {

            printf('Erro[21]: %s\n', $conn->Erro);
        }

        break;
}

if (!empty($_GET['id_equip'])) {
    header('location: ../front/equipamentodocumentos.php?pagina=5&id_equip=' . $_GET['id_equip'] . '');
} else {
    header('location: ../front/funcionariodocumentos.php?pagina=3');
}
$conn->close();
