<?php
/* ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); */
session_start();

require_once('../bd/conexao.php');
require_once('pesquisas.php');

// ID ou CPF
if ($_GET['id'] != NULL) {
    $idFuncionario = "id_funcionario = '" . $_GET['id'] . "'";
} else {
    $idFuncionario = "cpf = '" . $_POST['cpf'] . "'";
}


//procurando funcionário
$queryColaborador .= " WHERE MIF.".$idFuncionario."";

$resultFuncionario = $conn->query($queryColaborador);

$funcionario = $resultFuncionario->fetch_assoc();

if ($funcionario['id_funcionario'] != NULL) {

    if ($funcionario['deletar'] == 1) {

        unset($_SESSION['id_funcionario']);
        unset($_SESSION['nomeFuncionario']);
        unset($_SESSION['cpf']);
        unset($_SESSION['funcaoFuncionario']);
        unset($_SESSION['departamentoFuncionario']);
        unset($_SESSION['statusFuncionario']);
        unset($_SESSION['id_statusFuncionario']);
        unset($_SESSION['empresaFuncionario']);
        unset($_SESSION['id_funcaoFuncionario'] );
        unset($_SESSION['id_departamentoFuncionario']);
        unset($_SESSION['id_empresaFuncionario'] );

        header('location: ../front/mensagemgeral.php?pagina=3&id=' . $funcionario['id_funcionario'] . '');

        exit;

    } else {

        $_SESSION['id_funcionario'] = $funcionario['id_funcionario'];
        $_SESSION['nomeFuncionario'] = $funcionario['nome'];
        $_SESSION['cpf'] = $funcionario['cpf'];
        $_SESSION['funcaoFuncionario'] = $funcionario['funcao'];
        $_SESSION['empresaFuncionario'] = $funcionario['empresa'];
        $_SESSION['departamentoFuncionario'] = $funcionario['departamento'];
        $_SESSION['statusFuncionario'] = $funcionario['status'];
        $_SESSION['id_statusFuncionario'] = $funcionario['id_status'];
        $_SESSION['id_funcaoFuncionario'] = $funcionario['id_funcao'];
        $_SESSION['id_departamentoFuncionario'] = $funcionario['id_departamento'];
        $_SESSION['id_empresaFuncionario'] = $funcionario['id_empresa'];

        header('location: ../front/funcionario.php?pagina=3');

        exit;
    }
} else {
    unset($_SESSION['id_funcionario']);
    unset($_SESSION['nomeFuncionario']);
    unset($_SESSION['cpf']);
    unset($_SESSION['funcaoFuncionario']);
    unset($_SESSION['departamentoFuncionario']);
    unset($_SESSION['statusFuncionario']);
    unset($_SESSION['id_statusFuncionario']);
    unset($_SESSION['empresaFuncionario']);
    unset($_SESSION['id_funcaoFuncionario'] );
    unset($_SESSION['id_departamentoFuncionario']);
    unset($_SESSION['id_empresaFuncionario'] );

    header('location: ../front/funcionario.php?pagina=3&cpf='.$_POST['cpf'].'&voltarpara='.$_GET['pagina'].'&id_equip='.$_GET['id_equip'].'');

    exit;
}

$conn->close();

?>