<?php
session_start();

require_once('../bd/conexao.php');

//DATA DE HOJE
$dataHoje = date('d/m/Y');

switch ($_GET['tipo']) {
    case '2': //OFFICE

        //ALTERANDO
        $updateDeletar = "UPDATE manager_office  SET numero_nota = 0, file_nota = 0, data_nota = 0 WHERE id_equipamento = " . $_GET['id_equip'] . "";

        if (!$result = $conn->query($updateDeletar)) {
            printf('ERRO[1]: %s\n', $conn->error);
            exit;
        }

        //CRIANDO LOG
        $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_GET['id_equip'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '7')";

        if (!$log = $conn->query($insertLog)) {

            printf('Erro[2]: %s\n', $conn->error);
        } else {

            header('Location: ../front/equipamentodocumentos.php?pagina=5&id_equip=' . $_GET['id_equip'] . '');
        }

        break;

    case '3': //WINDWOS
        # code...

        $updateDeletar = "UPDATE manager_sistema_operacional SET numero_nota = 0, file_nota = 0, data_nota = 0 WHERE id_equipamento = " . $_GET['id_equip'] . "";

        if (!$result = $conn->query($updateDeletar)) {
            printf('ERRO[3]: %s\n', $conn->error);
            exit;
        }

        //CRIANDO LOG
        $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_GET['id_equip'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '7')";

        if (!$log = $conn->query($insertLog)) {

            printf('Erro[4]: %s\n', $conn->error);
        } else {

            header('Location: ../front/equipamentodocumentos.php?pagina=5&id_equip=' . $_GET['id_equip'] . '');
        }
        break;

    default: //DOCUMENTOS DIVERSOS
        $updateDeletar = "UPDATE manager_inventario_anexo SET deletar = 1 WHERE id_anexo = " . $_GET['id'] . "";

        if (!$result = $conn->query($updateDeletar)) {
            printf('ERRO[5]: %s\n', $conn->error);
            exit;
        }

        if ($_GET['tipo'] == 1) {
            //CRIANDO LOG
            $insertLog = "INSERT INTO manager_log (id_equipamento,  data_alteracao, usuario, tipo_alteracao) VALUES ('" . $_GET['id_equip'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '7')";

            if (!$log = $conn->query($insertLog)) {

                printf('Erro[6]: %s\n', $conn->error);
            } else {

                header('Location: ../front/equipamentodocumentos.php?pagina=5&id_equip=' . $_GET['id_equip'] . '');
            }
        } else {
            header('Location: ../front/funcionariodocumentos.php?pagina=3');
        }

        break;
}

$conn->close();
