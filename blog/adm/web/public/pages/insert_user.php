<?php
//chamando banco
require '../../inc/conexao.php';

//query incluindo usuário
$insert_query = "INSERT INTO blog_user (nome, email, exibicao, senha) VALUES ('".$_POST['nome']."', '".$_POST['email']."', '".$_POST['exibicao']."', '".$_POST['senha_atual']."')";
$result_insert = mysqli_query($banco_blog, $insert_query) or die(mysqli_error($banco_blog));

//fehando banco
mysqli_close($banco_blog);

header('location: list_user.php?pagina=4&msn=4');
?>