<?php
require_once('../bd/conexao.php');


if(!empty($_GET['id'])){
    $updatedrop = "UPDATE manager_office SET

    numero_nota = '0',
    file_nota = '0',
    file_nota_nome = '0',
    data_nota = '0'
    
    WHERE id = ".$_GET['id']."";
    
    if(!$result = $conn->query($updatedrop)){
        printf('ERRO[1]: %s\n',$conn->error);
    }else{
        header('location: ../front/officeedit.php?pagina=5&id='.$_GET['id'].'');
    }
}else{
    $updatedrop = "UPDATE manager_sistema_operacional SET

    numero_nota = '0',
    file_nota = '0',
    file_nota_nome = '0',
    data_nota = '0'
    
    WHERE id = ".$_GET['id_so']."";
    
    if(!$result = $conn->query($updatedrop)){
        printf('ERRO[1]: %s\n',$conn->error);
    }else{
        header('location: ../front/windowsedit.php?pagina=5&id='.$_GET['id_so'].'');
    }
}

$conn->close();
?>