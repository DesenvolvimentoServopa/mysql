<?php
session_start();

require_once('../bd/conexao.php');

$dataHoje = date('d/m/yy H:i:s');

//log
if (!empty($_GET['id_fun'])) {
    $funcionarioLog = $_GET['id_fun'];
}else{
    $funcionarioLog = $_SESSION['id_funcionario'];
}
//EQUIPAMENTO
if ($_POST['equip'] != NULL) {

    foreach ($_POST['equip'] as $id_equip) {
        //alterando
        $updateEquipamentos = "UPDATE manager_inventario_equipamento SET id_funcionario = ";
        
        if (empty($_POST['newfun'])) { $updateEquipamentos .= "0"; } else{ $updateEquipamentos .= $_POST['newfun']; }
        
        $updateEquipamentos .= ", status = " . $_POST['status'] . " , termo = 1, liberado_rh = 0 WHERE id_equipamento = " . $id_equip . "";

        if (!$resultUpdate = $conn->query($updateEquipamentos)) {
            printf('Error[1]: %s\n', $conn->error);
        }

        //SALVANDO LOG VINCULADO
        $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao, observacao) VALUES ('"; if (empty($_POST['newfun'])) { $insertLog .= "0"; } else{ $insertLog .= $_POST['newfun']; } $insertLog .= "', '" . $id_equip . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '4', '" . $_POST['motivo'] . "')";


        if (!$log = $conn->query($insertLog)) {
            printf('Erro[2]: %s\n', $conn->error);
        }

        //SALVANDO LOG DESVINCULADO
        $insertLog = "INSERT INTO manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao, observacao) VALUES ('" . $funcionarioLog . "', '" . $id_equip . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '5', '" . $_POST['motivo'] . "')";

        if (!$log = $conn->query($insertLog)) {
            printf('Erro[3]: %s\n', $conn->error);
        }

        //SALVANDO CHECKLIST
        if ($_FILES['filechecklist'] != NULL) {
            $tipo_file = $_FILES['filechecklist']['type']; //Pegando qual é a extensão do arquivo
            $nome_db = $_FILES['filechecklist']['name'];
            $caminho = "../documentos/checklist/" . $_FILES['filechecklist']['name']; //caminho onde será salvo o FILE
            $caminho_db = "../documentos/checklist/" . $_FILES['filechecklist']['name']; //pasta onde está o FILE para salvar no Bando de dados

            /*VALIDAÇÃO DO FILE*/
            $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

            $result = $conn->query($sql_file); //aplicando a query
            //salvando o resultado em uma variavel

            if ($tipo_file != NULL) {
                /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
                    printf('Erro[4]: %s\n Arquivo Invalido!');
                    exit;
                } else {
                    if (move_uploaded_file($_FILES['filechecklist']['tmp_name'], $caminho)) { //aplicando o salvamento
                        /* echo "Arquivo enviado para = " . $caminho; */
                    } else {
                        echo "Arquivo não foi enviado!";
                        exit;
                    } //se caso não salvar vai mostrar o erro!
                }
            }

            //SALVANDO NO BANCO DE DADOS
            $insert = "INSERT INTO manager_inventario_anexo (id_funcionario, id_equipamento, usuario, tipo_anexo, caminho, nome, tipo, data_criacao) 
            VALUES ('".$_GET['id_fun']."', '" . $id_equip . "', '" . $_SESSION['id'] . "', '" . $tipo_file . "', '" . $caminho_db . "', '" . $nome_db . "', '3', '" . $dataHoje . "')";

            if (!$resultInsert = $conn->query($insert)) {
                printf('ERRO[5]: %s\n', $conn->error);
                exit;
            }
        }
    }
}

switch ($_GET['pagina']) {
    case '3':
        header('Location: ../front/funcionarioequip.php?pagina=3');
        break;

    case '5':
        header('Location: ../front/equipamentos.php?pagina=5');
        break;
}


$conn->close();
