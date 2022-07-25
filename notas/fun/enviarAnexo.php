<?php
require_once('../conf/conexao.php');

$dataHoje = date('Y-m-d');

//criando variavel para apenas salvar a nota
$recebendoArquivo = $_GET['enviarArquivo'];

//Subindo a nota fiscal
$tipo_file = $_FILES['anexo']['type']; //Pegando qual é a extensão do arquivo
$nome_db = $_FILES['anexo']['name'];
$caminho = "../modelo-nota/" . $_FILES['anexo']['name']; //caminho onde será salvo o FILE
$caminho_db = "../modelo-nota/" . $_FILES['anexo']['name']; //pasta onde está o FILE para salvar no Bando de dados

if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) { //aplicando o salvamento
    echo "<span style='color: green'>SUCESSO: </span>Arquivo enviado para = " . $caminho;
} else {
    echo "<span id='erro'>Erro[1]: Arquivo não foi enviado! - CONTATE O ADMINISTRADOR DO SISTEMA<br /></span>";
    echo $_FILES['anexo']['tmp_name'].$caminho;
} //se caso não salvar vai mostrar o erro!

/*Se o receber aquivo for igual a 1 ele vai estar recebendo o arquivo do salvarNota 
e caso ele seja nullo ele vai realizar o envio do anexo e salvar no banco de dados*/

if ($recebendoArquivo == NULL) {

    //salvando a nota na tabela dbnotas.cad_anexos
    $query = "SELECT ID_LANCARNOTAS FROM cad_lancarnotas WHERE

                    ID_USUARIO = '" . $_GET['idUsuario'] . "' 
                    AND ID_FILIAL = '" . $_GET['id_filial'] . "' 
                    AND date_create = '" . $dataHoje . "'
                    AND CNPJ = '" . $_GET['cnpjFornecedor'] . "' 

                ORDER BY ID_LANCARNOTAS DESC LIMIT 1";

    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    $insert = "INSERT INTO cad_anexos (ID_LANCARNOTA, url_nota) VALUES ('" . $row['ID_LANCARNOTAS'] . "', '" . $caminho_db . "')";

    if (!$resultInsert = $conn->query($insert)) {
        printf('Erro[2]: %s\n', $conn->error);
    } else {
        header('Location: roboLancarNota.php?back=1&usuario=' . $_GET['usuario'] . '&cnpjFornecedor=' . $_GET['cnpjFornecedor'] . '&cnpjFilial=' . $_GET['cnpjFilial'] . '');
    }
}

//fechando o banco
$conn->close();
