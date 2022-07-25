<?php
//sessão
session_start();
//banco de dados
require 'conexao.php';

if($_GET['pagina'] == 3){


 $exclui = "DELETE FROM blog_post WHERE id_postagem = ".$_GET['id_post']."";
 $result = $conn->query($exclui) or die(mysqli_error($conn));

if ($result){
    header("Location:dashboard.php?pagina=1&msn=6");
}else{
    echo "Error";
}

}    

mysqli_close($conn);
?>