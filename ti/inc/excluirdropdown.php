<?php
require_once('../bd/conexao.php');

switch ($_GET['tipo']) {
    case '1': //função
        $update = "UPDATE manager_dropfuncao SET deletar = 1 WHERE id_funcao = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '2': //Departamento      
        $update = "UPDATE manager_dropdepartamento SET deletar = 1 WHERE id_depart = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '3': //empresa
        $update = "UPDATE manager_dropempresa SET deletar = 1 WHERE id_empresa = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;
    case '4': //Locação
        $update = "UPDATE manager_droplocacao SET deletar = 1 WHERE id_empresa = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '5': //Status Funcionario
        $update = "UPDATE manager_dropstatus SET deletar = 1 WHERE id_status = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '6': //Equipamentos
        $update = "UPDATE manager_dropequipamentos SET deletar = 1 WHERE id_equip = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '7': //Status Equipamento
        $update = "UPDATE manager_dropstatusequipamento SET deletar = 1 WHERE id_status = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '8': //Situação
        $update = "UPDATE manager_dropsituacao SET deletar = 1 WHERE id_situacao = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '9': //Estado
        $update = "UPDATE manager_dropestado SET deletar = 1 WHERE id = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '10': //Acessórios
        $update = "UPDATE manager_dropacessorios SET deletar = 1 WHERE id_acessorio = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '11': //Operadora
        $update = "UPDATE manager_dropoperadora SET deletar = 1 WHERE id_operadora = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '12': //Office
        $update = "UPDATE manager_dropoffice SET deletar = 1 WHERE id = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '13': //Windows
        $update = "UPDATE manager_dropsistemaoperacional SET deletar = 1 WHERE id = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '14': //Documentos
        $update = "UPDATE manager_dropdocumento SET deletar = 1 WHERE id = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;

    case '15': //Fornecedores
        $update = "UPDATE manager_dropfornecedor SET deletar = 1 WHERE id = " . $_GET['id'] . "";
        $result = $conn->query($update);

        break;
}

header('location: ../front/dropdownlist.php?pagina=2&tipo=' . $_GET['tipo'] . '&msn=1');

$conn->close();
