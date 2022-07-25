<?php
require_once('../bd/conexao.php');

switch ($_GET['tipo']) {
    case '1': //função
        $insert = "INSERT INTO manager_dropfuncao (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '2': //Departamento      
        $insert = "INSERT INTO manager_dropdepartamento (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '3': //empresa
        $insert = "INSERT INTO manager_dropempresa (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;
    case '4': //Locação
        $insert = "INSERT INTO manager_droplocacao (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '5': //Status Funcionario
        $insert = "INSERT INTO manager_dropstatus (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '6': //Equipamentos
        $insert = "INSERT INTO manager_dropequipamentos (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '7': //Status Equipamento
        $insert = "INSERT INTO manager_dropstatusequipamento (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '8': //Situação
        $insert = "INSERT INTO manager_dropsituacao (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '9': //Estado
        $insert = "INSERT INTO manager_dropestado (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '10': //Acessórios
        $insert = "INSERT INTO manager_dropacessorios (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '11': //Operadora
        $insert = "INSERT INTO manager_dropoperadora (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '12': //Office
        $insert = "INSERT INTO manager_dropoffice (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '13': //Windows
        $insert = "INSERT INTO manager_dropsistemaoperacional (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '14': //Documentos
        $insert = "INSERT INTO manager_dropdocumento (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;

    case '15': //Fornecedores
        $insert = "INSERT INTO manager_dropfornecedor (nome) VALUE ('" . $_POST['nome'] . "')";
        $result = $conn->query($insert);

        break;
}

header('location: ../front/dropdownlist.php?pagina=2&tipo=' . $_GET['tipo'] . '&msn=2');

$conn->close();
