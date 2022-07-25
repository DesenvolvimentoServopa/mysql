<?php
//chamando banco de dados
require '../../inc/conexao.php';
//sessão
session_start();

/* ----------------- editando o funcionario ----------------- */

if(empty($_POST['senha_atual'])){
    $senha = $_POST['senha'];
}else{
    $senha = $_POST['senha_atual'];
}

empty($_POST['id_user']) ? $where = "WHERE id_user = ".$_SESSION['id']."" : $where = "WHERE id_user = ".$_POST['id_user']."";

$insert_usuario = "UPDATE blog_user SET nome = '".$_POST['nome']."', email = '".$_POST['email']."', exibicao = '".$_POST['exibicao']."', senha = '". $senha."' ".$where."";
$result = mysqli_query($banco_blog, $insert_usuario) or die(mysqli_error($banco_blog));

//fechando o banco 
mysqli_close($banco_blog);

//voltando para a tela

if(empty($_POST['id_user'])){
    header('location: dashboard.php?msn=1&pagina=1');
}else{
    header('location: list_user.php?pagina=4&msn=1');
}

?>