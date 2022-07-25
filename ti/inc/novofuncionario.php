<?php
session_start();
require_once('../bd/conexao.php');

$dataHoje = date('d/m/yy');


//salvando novo usuário

$insertFuncionario = "INSERT INTO manager_inventario_funcionario (usuario, cpf, nome, funcao, departamento, empresa, data_cadastro, status) 
VALUES 
(
'".$_SESSION['id']."', 
'".$_POST['cpf']."', 
'".$_POST['nome']."', 
'".$_POST['funcao']."', 
'".$_POST['departamento']."', 
'".$_POST['empresa']."', 
'".$dataHoje."', 
'".$_POST['status']."')";

if(!$insert = $conn->query($insertFuncionario)){
    printf("Erro[1]: %s\n", $conn->error);
}else{
    //salvando log

    //coletando ID
    $selectIdFuncionario = "SELECT MAX(id_funcionario) id_funcionario FROM manager_inventario_funcionario";
    $resultadoID = $conn->query($selectIdFuncionario);

    $idFuncionario = $resultadoID->fetch_assoc();

    $insertLog = "INSERT INTO manager_log (id_funcionario, data_alteracao, usuario, tipo_alteracao) VALUES ('" . $idFuncionario['id_funcionario'] . "', '" . $dataHoje . "', '" . $_SESSION["id"] . "', '13')";

    if (!$log = $conn->query($insertLog)) {
        printf('Erro[2]: %s\n', $conn->error);
    } else {

        switch ($_GET['voltarpara']){
            case '5':
                header('location: ../front/vincular.php?pagina=5&id_equip='.$_GET['id_equip'].'');
                break;
            default:
                header('location: pesquisaFuncionario.php?id=' . $idFuncionario['id_funcionario'] . '');
            break;
        }

        
    }

}


$conn->close();
