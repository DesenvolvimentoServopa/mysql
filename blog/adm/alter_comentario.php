<?php
//chamando a sessão
session_start();
//chamando o banco
require 'conexao.php';

//tirando o comentario do ADM
if($_GET['avisa'] != NUll){

    $query_tira = "UPDATE blog_comentarios SET avisado_responsavel = 1 where id_comentario = ".$_GET['avisa']."";
    $resultado_tira = $conn->query($query_tira) or die(mysqli_error($conn));
    if ($resultado_tira){
        header('location: postagens.php?pagina=2');
    }else{
        header('location: 404.php');
    }

}


//fechando o banco
mysqli_close($conn);

//voltando para tela informando


?>