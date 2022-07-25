<?php
//sessão
session_start();

//banco de dados
require 'conexao.php';

if($_GET['pagina'] == 5){//apenas uma imagem
    // SALVANDO OS FILES 
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
    }
    //DATA DROP
    if($_POST['dataFim'] == NULL){
        $data_fim = '---';
    }else{
        $data_fim = $_POST['dataFim'];
    }
    //data hoje
    $data = date('d/m/Y');

    //caso a publicação será feita no modal
    if($_POST['tipo_postagem'] == 1){

        //verificando se já existe alguma postagem com o tipo_postagem = 1
        $tipo_postagem = "SELECT tipo_postagem FROM blog_post WHERE tipo_postagem = 1";
        $result_tipo = $conn->query($tipo_postagem);

        //alterando antes de salvar a nova publicação
        while($row_tipo = $result_tipo->fetch_assoc()){
            $alter_tipo = "UPDATE blog_post SET tipo_postagem = 0";
            $result_alter = $conn->query($alter_tipo) or die(mysqli_error($banco_blog));
        }
    }

    //salvando no banco de dados a nova postagem

    $postagem_insert = "INSERT INTO blog_post (id_post_user, tipo_postagem, tipo_arquivo, titulo, mensagem, file_img, data, data_drop, alerta_comentario)
                        VALUE ('".$_SESSION['id']."',
                                '".$_POST['tipo_postagem']."',
                                '".$tipo_file."',
                                '".$_POST['titulo']."',
                                '".$_POST['mensagem']."',
                                '".$caminho_db."',
                                '".$data."',
                                '".$data_fim."',
                                '".$_POST['alertar_comentario']."'
                                )";
    $resul_insert = $conn->query($postagem_insert)or die(mysqli_error($banco_blog));

    //voltando para a tela
    header('location: dashboard.php?pagina=1&msn=5');

    }elseif($_GET['pagina'] == 6){//varias imagens          
        
        //DATA DROP
        if($_POST['dataFim'] == NULL){
            $data_fim = '---';
        }else{
            $data_fim = $_POST['dataFim'];
        }
        //data hoje
        $data = date('d/m/Y');

        //caso a publicação será feita no modal
        if($_POST['tipo_postagem'] == 1){

            //verificando se já existe alguma postagem com o tipo_postagem = 1
            $tipo_postagem = "SELECT tipo_postagem FROM blog_post WHERE tipo_postagem = 1";
            $result_tipo = $conn->query($tipo_postagem);

            //alterando antes de salvar a nova publicação
            while($row_tipo = $result_tipo->fetch_assoc()){
                $alter_tipo = "UPDATE blog_post SET tipo_postagem = 0";
                $result_alter = $conn->query($alter_tipo) or die(mysqli_error($banco_blog));
            }
        }

        //salvando no banco de dados a nova postagem
        $postagem_insert = "INSERT INTO blog_post (id_post_user, tipo_postagem, titulo, mensagem, data, data_drop, alerta_comentario, carousel)
                            VALUE ('".$_SESSION['id']."',
                                    '".$_POST['tipo_postagem']."',
                                    '".$_POST['titulo']."',
                                    '".$_POST['mensagem']."',
                                    '".$data."',
                                    '".$data_fim."',
                                    '".$_POST['alertar_comentario']."',
                                    '1'
                                    )";
        $resul_insert = $conn->query($postagem_insert)or die(mysqli_error($banco_blog));
        

        //pegando o ultimo ID da postafem acima
        $queryID = "SELECT MAX(id_postagem) AS id FROM blog_post";
        $resultID = $conn->query($queryID);
        $id_postagem = $resultID->fetch_assoc();

        //#### VAMOS COMEÇAR A SALVAR O FILE ####

        $contIMG = 0;        

        while ($_FILES['file'.$contIMG.'']['type'] != NULL){

            // SALVANDO OS FILES 
            if($_FILES['file'.$contIMG.'']['name'] != NULL){
                //salvando o file da nota
                $tipo_file = $_FILES['file'.$contIMG.'']['type'];//Pegando qual é a extensão do arquivo
                $nome_db = $_FILES['file'.$contIMG.'']['name'];
                $caminho = "/var/www/html/blog/postagens/" . $_FILES['file'.$contIMG.'']['name'];//caminho onde será salvo o FILE
                $caminho_db = "postagens/" . $_FILES['file'.$contIMG.'']['name'];//pasta onde está o FILE para salvar no Bando de dados

                /*VALIDAÇÃO DO FILE*/
                $sql_file = "SELECT type FROM blog_file_upload WHERE type LIKE '".$tipo_file."'";//query de validação 

                $result =  $conn->query($sql_file);//aplicando a query
                $row = $result->fetch_array();//salvando o resultado em uma variavel

                /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                if($tipo_file != NULL){
                    if ($row['type'] != NULL) {//se é arquivo valido       
                        if (move_uploaded_file($_FILES['file'.$contIMG.'']['tmp_name'], $caminho )){//aplicando o salvamento
                            //echo "Arquivo enviado para = ".$_FILES['file_nota_celular'.$cont_equip.'']['tmp_name'].$uploadfile;
                        }else{
                        echo "Arquivo não foi enviado!";
                        }//se caso não salvar vai mostrar o erro!
                    }else{// se o arquivo não é valido vai levar para tela de erro    
                        echo "Arquivo Invalido!";
                        exit;
                    }//end IF validação
                }//end IF anexo cheio
            } 
            
            //SALVAR O FILE NO BANCO DE DADOS

            $filePostagem = "INSERT INTO blog_post_carousel (tipo_arquivo, file_img, id_postagem, data) VALUES ('".$tipo_file."','".$caminho_db."','".$id_postagem['id']."','".$data."')";
            $insertPostagem = $conn->query($filePostagem) or die(mysqli_error($banco_blog));
            
            $contIMG++;
        }//salvando file

        header('location: dashboard.php?pagina=1&msn=5');
    }//fim salvando a postagem

//fechando o banco
mysqli_close($banco_blog);
?>