<?php
session_start();
require_once('../bd/conexao.php');

//usuário
if(!empty($_POST['id_usuario'])){
    $usuario = $_POST['id_usuario'];
}else{
    $usuario = $_SESSION["id"];
}

//EDITANDO PERFIL
$updateUsuario = "UPDATE manager_profile SET profile_name = '".$_POST['nome']."', profile_mail = '".$_POST['email']."', ";

if($_POST['senha'] != NULL){
    $updateUsuario .= "profile_password = '" . md5($_POST['senha']) . "', ";
}

$updateUsuario .= "profile_type = '".$_POST['perfil']."' WHERE (id_profile = ".$usuario.")";

if(!$result = $conn->query($updateUsuario)){
    printf('Erro[1]: %s\n', $conn->error);
    exit;
}

//EDITANDO PERMISSÕES EQUIPAMENTOS
if(isset($_POST['equipPermissao'])){
    
    //LIMPAR
    $queryValidando = "DELETE FROM manager_profile_equip WHERE id_profile = ".$usuario."";
    $resultadoValidando = $conn->query($queryValidando);

    //ADICIONAR PERMISSÃO
    foreach($_POST['equipPermissao'] as $id_equip){

        $insert = "INSERT INTO manager_profile_equip (id_profile, id_equipamento) VALUES ('".$usuario."', '".$id_equip."')";
        
        if(!$resultInsert = $conn->query($insert)){
            printf('Erro[3]: %s\n', $conn->error);
            exit;
        }
    }

}

//EDITANDO PERMISSÕES
$emitir = isset($_POST['emitir']) ? '1' : '0';
$editarHistorico = isset($_POST['editarHistorico']) ? '1' : '0';
$editarFuncionario = isset($_POST['EditarFuncionario']) ? '1' : '0';
$ativarCPF = isset($_POST['ativarCPF']) ? '1' : '0';
$desativarCPF = isset($_POST['desativarCPF']) ? '1' : '0';

$updatePermissao = "UPDATE manager_profile SET emitir_check_list = '".$emitir."', editar_historico = '".$editarHistorico."', editar_cadastro_funcionario = '".$editarFuncionario."', ativar_cpf = '".$ativarCPF."', desativar_cpf = '".$desativarCPF."' WHERE (id_profile = ".$usuario.")";


if($result = $conn->query($updatePermissao)){
    if(!empty($_POST['id_usuario'])){
        header('location: ../front/perfilUsuarios.php?pagina=2&id_usuario='.$_POST['id_usuario'].'&msn=1&#senha');
    }else{
        header('location: ../front/perfil.php?msn=1&#senha');
    }
}else{
    printf('Erro[2]: %s\n', $conn->error);
    exit;
}

$conn->close();
