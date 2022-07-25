<?php
require_once('../bd/conexao.php');

//SUBINDO ARQUIVO
if ($_FILES['anexo'] != NULL) {
    $tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['anexo']['name'];
    $caminho = "../documentos/notas/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
    $caminho_db = "../documentos/notas/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

    /*VALIDAÇÃO DO FILE*/
    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '" . $tipo_file . "'"; //query de validação 

    $result =  $conn->query($sql_file); //aplicando a query

    if ($tipo_file != NULL) {
        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if (!$row = $result->fetch_assoc()) { //se é arquivo valido       
            printf('Erro[1]: %s\n Arquivo Invalido! - POR FAVOR INFORMAR UM ARQUIVO NO FORMATO: <span style="color: red">PDF</span><br />');
            exit;
        } else {
            if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
                echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho."<br />";
            } else {
                echo "Erro[2]: Arquivo não foi enviado! - CONTATO O ADMINISTRADOR DO SISTEMA<br />";
            } //se caso não salvar vai mostrar o erro!
        }
    }
} else {
    printf('Erro[3]: Por favor inserir infomar uma nota fiscal no formato PDF para ser salvo!<br />');
}


if(!empty($_GET['id'])){

    //OFFICE

    $updateNota = "UPDATE manager_office SET
    fornecedor = '".$_POST['fornecedor']."',
    numero_nota = '".$_POST['numero_nota']."',
    file_nota = '".$caminho_db."',
    file_nota_nome = '".$nome_db."',
    data_nota = '".$_POST['data_nota']."'

    WHERE id = ".$_GET['id']."";

    if(!$resultNota = $conn->query($updateNota)){
        printf('Erro[4]: %s\n', $conn->error);
    }else{
        header('location: ../front/officeedit.php?pagina=5&id='.$_GET['id'].'');
    }

}else{

    //WINDOWS

    $updateNota = "UPDATE manager_sistema_operacional SET
    fornecedor = '".$_POST['fornecedor']."',
    numero_nota = '".$_POST['numero_nota']."',
    file_nota = '".$caminho_db."',
    file_nota_nome = '".$nome_db."',
    data_nota = '".$_POST['data_nota']."'

    WHERE id = ".$_GET['id_so']."";

    if(!$resultNota = $conn->query($updateNota)){
        printf('Erro[5]: %s\n', $conn->error);
    }else{
        header('location: ../front/windowsedit.php?pagina=5&id='.$_GET['id_so'].'');
    }

}


$conn->close();
