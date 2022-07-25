<?php
session_start();
//banco de dados
require 'conexao.php';

// SALVANDO OS FILES DA NOTA CELULAR
if($_FILES['file']['name'] != NULL){
    //salvando o file da nota
    $tipo_file = $_FILES['file']['type'];//Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['file']['name'];
    $caminho = "/var/www/html/blog/postagens/" . $_FILES['file']['name'];//caminho onde será salvo o FILE
    $caminho_db = "postagens/".$_FILES['file']['name'];//pasta onde está o FILE para salvar no Bando de dados

    /*VALIDAÇÃO DO FILE*/
    $sql_file = "SELECT type FROM blog_file_upload WHERE type LIKE '".$tipo_file."'";//query de validação 
   
    $result =  $conn->query($sql_file);//aplicando a query
    $row = $result->fetch_array();//salvando o resultado em uma variavel
    
  
    /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
    if($tipo_file != NULL){
        if ($row['type'] != NULL) {//se é arquivo valido       
            if (move_uploaded_file($_FILES['file']['tmp_name'], $caminho )){//aplicando o salvamento
                //echo "Arquivo enviado para = ".$_FILES['file_nota_celular'.$cont_equip.'']['tmp_name'].$uploadfile;
            }else{
            echo "Arquivo não foi enviado!";
            }//se caso não salvar vai mostrar o erro!
        }else{// se o arquivo não é valido vai levar para tela de erro    
            echo "Arquivo Invalido!";
            exit;
        }//end IF validação
    }//end IF anexo cheio

    $alterando = "UPDATE blog_post SET titulo = '".$_POST['titulo']."', mensagem = '".$_POST['mensagem']."', file_img = '".$caminho_db."' WHERE id_postagem = ".$_POST['id_post']."";
    $resultado_alterando = $conn->query($alterando) or die(mysqli_error($banco_blog));
    
}else{

    $alterando = "UPDATE blog_post SET titulo = '".$_POST['titulo']."', mensagem = '".$_POST['mensagem']."' WHERE id_postagem = ".$_POST['id_post']."";
    $resultado_alterando = $conn->query($alterando) or die(mysqli_error($banco_blog));
    
}

header('location: dashboard.php?pagina=1&msn=4');

//fechando o banco
mysqli_close($banco_blog);

//voltando para a tela


?>