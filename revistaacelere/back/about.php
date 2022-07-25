<?php
//chamar banco
include('../config/conexao.php');

//subir o arquivo para o servidor

    //criar a pasta da edição

    $caminho = '../assets/img/edicao'.$_POST['edicao'].'';

    if(!mkdir($caminho, 0777, true)){

        echo "Erro[01]: Nao consegui criar a pasta";

    }else{
        //Subir o arquivo

        sleep(10);
                
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho."/". $_FILES['arquivo']['name']) ) { //aplicando o salvamento
            echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;
        } else {
            echo "Erro[02]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
            exit;
        } //se caso nÃ£o salvar vai mostrar o erro!
        
    }


//salvar as informações para o banco

    //query
    $insert = "INSERT INTO revista (id_usuario, nome_usuario, caminho, edicao)
    VALUES (".$_GET['id_usuario'].", '".$_GET['nome']."', '".$caminho."/".$_FILES['arquivo']['name']."',".$_POST['edicao']." )";

    //aplicando a query

    if(!$result = $mysqli->query($insert)){
        printf('Erro[03]: %s \n', $mysqli->error);
    }    
    
    
//fechar o banco

$mysqli->close;

//volto para tela incial informando o usuário que foi salvo ou não a informação.

header('location: ../front/about.php?id_usuario='.$_GET['id_usuario'].'&nome='.$_GET['nome'].'&msn=1');