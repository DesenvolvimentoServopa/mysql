<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- v5.0.2-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Subindo Nota</title>
</head>

<?php
/* 
ESSE ARQUIVO É INICIADO ATRAVES DE UM PROCESSO AUTOMATIZADO 

RESPONSAVEL PELA CRIAÇÃO É O ANALISTA (FELIPE SILVEIRA LARA)

QUALQUER QUER DUVIDA SOBRE A EXECUÇÃO POR GENTELIZA VALIDAR NA DOCUMENTAÇÃO OU ENTRE EM CONTATO COM O TIME DE DESENVOLVIMENTO
*/

require_once('../conf/conexao.php');


$dataHoje = date('Y-m-d');
$email = ($_GET['usuario'] == 'notas.ti@servopa.com.br') ? 'luiza.andrade@servopa.com.br' : $_GET['usuario'];
$cnpjFornecedor = $_GET['cnpjFornecedor'];

if($_GET['idFornecedor'] != NULL){
    $idFornecedor = $_GET['idFornecedor'];
}else{
    $idFornecedor = "(SELECT ID_FORNECEDOR FROM cad_fornecedor WHERE CPF_CNPJ = '$cnpjFornecedor')";
}

$cnpjFilial = $_GET['cnpjFilial'];
$serie = $_GET['serie'];
$numeroNota = $_GET['numeroNota'];
$dataEmissao = $_GET['dataEmissao'];
$valorNota = $_GET['valorNota'];
$dataVencimento = $_GET['dataVencimento'];


//Ajustando valores
$caracteres = array('.', '/', '-', ',');
$filial = str_replace($caracteres, '', $cnpjFilial);

//verificando se informações estão faltanado
if ($numeroNota == NULL || $dataEmissao == NULL || $valorNota == NULL) {
    $status = 2;
} else {
    $status = 1;
}

//buscando o ID da FILIAL
$queryFilial = "SELECT ID_FILIAL FROM cad_filial WHERE cnpj = '" . $filial . "'";
$resultadoFilial = $conn->query($queryFilial);
$rowIdFilial = $resultadoFilial->fetch_assoc();

//buscando o ID do USUÀRIO
$queryUsuario = "SELECT ID_USUARIO FROM cad_login WHERE login = '" . $email . "'";
$resultadoUsuario = $conn->query($queryUsuario);
$rowIdUsuario = $resultadoUsuario->fetch_assoc();

if ($_GET['back'] != 1) {
    //Salvando na tabela cad_lancarnotas
    $query = "SELECT * FROM cad_rateiofornecedor WHERE ID_USUARIO = '" . $rowIdUsuario['ID_USUARIO'] . "' AND ID_FILIAL = '" . $rowIdFilial['ID_FILIAL'] . "' AND ID_FORNECEDOR = " . $idFornecedor . "";
    $result = $conn->query($query);

    //Salvando a nota no cad_lancarnotas
    if (!$row = $result->fetch_assoc()) {
        echo $query;
        echo "<div class='container' style='margin-top: 10px;'><span style='color: red'>ERRO: </span>Fornecedor ainda não foi devidamente cadastrado</div>";
    } else {

        //resolvendo a data de vencimento
        if (empty($dataVencimento)) {

            if ($row['vencimento_tipo'] == 0) {

                //limpando CNPJ da FILIAL
                $str = str_replace('/', '-', $dataEmissao);

                $vencimento =  date('d/m/Y', strtotime('+' . $row['vencimento'] . ' days', strtotime('' . $str . '')));
            } else {

                $vencimento = $row['vencimento'];
            }
        } else {
            $vencimento = $dataVencimento;
        }

        //salvando
        $insert = "INSERT INTO cad_lancarnotas 
                    (ID_FILIAL, 
                    ID_USUARIO,
                    ID_TIPODESPESA, 
                    ID_TIPOPAGAMENTO,
                    ID_PERIODICIDADE, 
                    CNPJ, 
                    auditoria, 
                    obra, 
                    relatorio_siscon, 
                    motivo_siscon, 
                    observacao, 
                    numero_nota, 
                    serie_nota, 
                    emissao, 
                    vencimento, 
                    valor_nota, 
                    status_desc,
                    date_create) 
                VALUES 
                    ('" . $rowIdFilial['ID_FILIAL'] . "', 
                    '" . $rowIdUsuario['ID_USUARIO'] . "', 
                    '" . $row['ID_TIPODESPESA'] . "', 
                    '" . $row['ID_TIPOPAGAMENTO'] . "',
                    '" . $row['ID_PERIODICIDADE'] . "',   
                    '" . $cnpjFornecedor . "', 
                    '" . $row['auditoria'] . "', 
                    '" . $row['obra'] . "',";

        $insert .= empty($row['relatorio_siscon']) ? "'0'," : "'" . $row['relatorio_siscon'] . "',";

        $insert .= empty($row['motivo_siscon']) ? "'0'," : "'" . $row['motivo_siscon'] . "',";

        $insert .= "
                    '" . $row['observacao'] . "', 
                    '" . $numeroNota . "', 
                    '" . $serie . "', 
                    '" . $dataEmissao . "', 
                    '" . $vencimento . "', 
                    '" . $valorNota . "', 
                    '" . $status . "',
                    '" . $dataHoje . "')";

        if (!$resultInseret = $conn->query($insert)) {
            printf('Erro[1]: %s\n', $conn->error);
        } else {
            //Salvando LOG
            $dataLog = date('d/m/Y H:i:s');

            $insertLog = "INSERT INTO log_nota (email, data_hora, log_descricao) VALUES ('" . $email . "', '" . $dataLog . "', 'Nota Lancada no sistema')";
            $resultLog = $conn->query($insertLog);

            //deletando arquivo já enviado
            $delete = "DELETE FROM tmp_nota WHERE (ID = '" . $_GET['ID'] . "')";
            $resultDelete = $conn->query($delete);
        }
    }
}


?>

<body>
    <br />
    <br />
    <div class="container py-2">
        <form method="POST" action="enviarAnexo.php?idUsuario=<?= $rowIdUsuario['ID_USUARIO'] ?>&cnpjFornecedor=<?= $cnpjFornecedor ?>&id_filial=<?= $rowIdFilial['ID_FILIAL'] ?>&cnpjFilial=<?= $_GET['cnpjFilial'] ?>&usuario=<?= $_GET['usuario'] ?>" enctype="multipart/form-data" id="formNota">
            <div class="mb-3">
                <label for="formFile" class="form-label"><?= $_GET['back'] != 1 ? "Insira Nota Fiscal:" : "Insira o boleto:" ?></label>
                <input class="form-control" type="file" id="nota" name="anexo">
            </div>
            <button type="submit" class="btn btn-primary" id="formNota">Enviar</button>
        </form>
    </div>

</body>

</html>

<?php $conn->close(); ?>