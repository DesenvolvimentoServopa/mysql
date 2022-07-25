<?php
require_once('../bd/conexao.php');

switch ($_GET['tipo']) {
    case '1': //função
        $update = "UPDATE manager_dropfuncao SET nome = '" . $_POST['nome'] . "' WHERE id_funcao = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '2': //Departamento      
        $update = "UPDATE manager_dropdepartamento SET nome = '" . $_POST['nome'] . "' WHERE id_depart = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '3': //empresa
        $update = "UPDATE manager_dropempresa SET nome = '" . $_POST['nome'] . "' WHERE id_empresa = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;
    case '4': //Locação
        $update = "UPDATE manager_droplocacao SET nome = '" . $_POST['nome'] . "' WHERE id_empresa = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '5': //Status Funcionario
        $update = "UPDATE manager_dropstatus SET nome = '" . $_POST['nome'] . "' WHERE id_status = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '6': //Equipamentos
        $update = "UPDATE manager_dropequipamentos SET nome = '" . $_POST['nome'] . "' WHERE id_equip = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '7': //Status Equipamento
        $update = "UPDATE manager_dropstatusequipamento SET nome = '" . $_POST['nome'] . "' WHERE id_status = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '8': //Situação
        $update = "UPDATE manager_dropsituacao SET nome = '" . $_POST['nome'] . "' WHERE id_situacao = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '9': //Estado
        $update = "UPDATE manager_dropestado SET nome = '" . $_POST['nome'] . "' WHERE id = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '10': //Acessórios
        $update = "UPDATE manager_dropacessorios SET nome = '" . $_POST['nome'] . "' WHERE id_acessorio = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '11': //Operadora
        $update = "UPDATE manager_dropoperadora SET nome = '" . $_POST['nome'] . "' WHERE id_operadora = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '12': //Office
        $update = "UPDATE manager_dropoffice SET nome = '" . $_POST['nome'] . "' WHERE id = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '13': //Windows
        $update = "UPDATE manager_dropsistemaoperacional SET nome = '" . $_POST['nome'] . "' WHERE id = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '14': //Documentos
        $update = "UPDATE manager_dropdocumento SET nome = '" . $_POST['nome'] . "' WHERE id = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '15': //Fornecedor
        $update = "UPDATE manager_dropfornecedor SET nome = '" . $_POST['nome'] . "' WHERE id_fornecedor = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;
}

header('location: ../front/dropdownlist.php?pagina=2&tipo=' . $_GET['tipo'] . '&msn=3');

$conn->close();
