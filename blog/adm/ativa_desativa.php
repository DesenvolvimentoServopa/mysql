<?php
//sessão
session_start();
//banco de dados
require 'conexao.php';

if($_GET['ativa'] == 'sim'){//ativando

    if(empty($_GET['id'])){
        //postagem
        $ativa = "UPDATE blog_post SET deletar = 0 WHERE id_postagem = ".$_GET['id_post']."";
        $result = $conn->query($ativa) or die(mysqli_error($conn));
       
    }else{
        //usuário
        $ativa = "UPDATE blog_user SET deletar = 0 WHERE id_user = ".$_GET['id']."";
        $result = $conn->query($ativa) or die(mysqli_error($conn));
    }  

}else{//desativa

    if(empty($_GET['id'])){
        //postagem
        $desativa = "UPDATE blog_post SET deletar = 1, tipo_postagem = 0 WHERE id_postagem = ".$_GET['id_post']."";
        $result = $conn->query($desativa) or die(mysqli_error($conn));
        if ($result){
            echo 'deu certo';
        }else{
            echo 'deu ruim';
        }
    }else{
        //usuário
        $desativa = "UPDATE blog_user SET deletar = 1 WHERE id_user = ".$_GET['id']."";
        $result = $conn->query($desativa) or die(mysqli_error($conn));        
    }        
}
//fechando o banco


//volta para a tela

if(empty($_GET['id'])){
    //postagem
    if($_GET['ativa'] === 'sim'){//ativando
        header('location: dashboard.php?pagina=1&msn=2');
    }else{
        header('location: dashboard.php?pagina=1&msn=3');
    }

}else{
    //usuário
    if($_GET['ativa'] === 'sim'){//ativando
        header('location: list_user.php?pagina=4&msn=2');
    }else{
        header('location: list_user.php?pagina=4&msn=3');
    }
}

mysqli_close($conn);
?>