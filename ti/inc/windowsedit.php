<?php
session_start();
require_once('../bd/conexao.php');


//DATA DE HOJE
$dataHoje = date('d/m/Y');


if (!empty($_GET['id'])) { //EDITANDO

    $update = "UPDATE manager_sistema_operacional SET 
    versao = '" . $_POST['versao'] . "',
    serial = '" . $_POST['serial'] . "',
    fornecedor = '" . $_POST['fornecedor'] . "',
    empresa = " . $_POST['empresa'] . ",
    locacao = ".$_POST['locacao']."
    WHERE id= " . $_GET['id'] . "";

    if (!$result = $conn->query($update)) {

        printf('ERRO[1]: %s\n', $conn->error);
    } else {

        header('location: ../front/windowsedit.php?pagina=5&id=' . $_GET['id'] . '');
    }
} else { //SALVANDO

    //SUBINDO ARQUIVO
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
                    echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho . "<br />";
                } else {
                    echo "Erro[3]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
                } //se caso não salvar vai mostrar o erro!
            }
        }

        //SALVANDO NO BANCO DE DADOS
        $insert = "INSERT INTO manager_sistema_operacional (id_equipamento, locacao, empresa, versao, serial, fornecedor, numero_nota, file_nota, file_nota_nome, data_nota) 
        VALUES 
        ('0',
        '" . $_POST['locacao'] . "', 
        '" . $_POST['empresa'] . "', 
        '" . $_POST['versao'] . "',
        '" . $_POST['serial'] . "',
        '" . $_POST['fornecedor'] . "',
        '" . $_POST['numero_nota'] . "',
        '" . $caminho_db . "',
        '" . $nome_db . "', 
        '" . $_POST['data_nota'] . "')";

        if (!$result = $conn->query($insert)) {
            printf('ERRO[4]: %s\n', $conn->error);
        } else {
            //caso já tenha um id de equipamento será vinculado ao mesmo!

            if (!empty($_GET['id_equip'])) {
                $querySO = "SELECT max(id) AS id FROM manager_sistema_operacional";
                $resultSO = $conn->query($querySO);
                $idSO = $resultSO->fetch_assoc();

                //salvando
                $updateEquipamento = "UPDATE manager_sistema_operacional SET id_equipamento = '" . $_GET['id_equip'] . "' WHERE id = '" . $idSO['id'] . "'";
                if (!$resultUPdate = $conn->query($updateEquipamento)) {
                    
                    printf('ERRO[5]: não foi possivel vincular equipamento pelo seguinte erro: %s\n', $conn->error);
                    exit;

                } else {

                    //salvando log no equipamento
                    $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) 
                VALUES ('" . $_GET['id_equip'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '17')";

                    if (!$log = $conn->query($insertLog)) {
                        printf('Erro[6]: %s\n', $conn->error);
                    } else {

                        header('location: ../front/editequipamento.php?pagina=5&id_equip=' . $_GET['id_equip'] . '');
                    }
                }
            } else {
                header('location: ../front/windows.php?pagina=5');
            }
        }
    }
}

$conn->close();
