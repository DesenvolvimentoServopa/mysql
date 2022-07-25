<?php
/* 
ESSE ARQUIVO É INICIADO ATRAVES DE UM PROCESSO AUTOMATIZADO QUE TEM O NOME DE (LENDO NOTA) 

RESPONSAVEL PELA CRIAÇÃO É O ANALISTA (FELIPE SILVEIRA LARA)

QUALQUER QUER DUVIDA SOBRE A EXECUÇÃO POR GENTELIZA VALIDAR NA DOCUMENTAÇÃO OU ENTRE EM CONTATO COM O TIME DE DESENVOLVIMENTO
*/

require_once('../conf/conexao.php');

//recebendo as variaveis vinda do ROBO
$fornecedor = $_GET['fornecedor'];
$email = $_GET['email'];
$caminho = $_GET['caminho'];

//retirando os caracteres do CNPJ
$caracteres = array('.', '/', '-');
$cnpj = str_replace($caracteres, '', $fornecedor);

//caminho
$caracterCaminho = "\\";
$destino = str_replace($caracterCaminho, '\\\\', $caminho);

//verificando se os dados recebidos pelo robo são notas para serem lançadas.
$query = "SELECT 
            CRF.ID_FORNECEDOR,
            CF.CPF_CNPJ,
            CF.nome_fornecedor,
            CL.login
        FROM
            dbnotas.cad_rateiofornecedor CRF
        LEFT JOIN
            cad_fornecedor CF ON (CRF.ID_FORNECEDOR = CF.ID_FORNECEDOR)
        LEFT JOIN
            cad_login CL ON (CRF.ID_USUARIO = CL.ID_USUARIO)
        WHERE  CF.CPF_CNPJ = '" . $cnpj . "' AND CL.login = '".$email."'";


$result = $conn->query($query);

while ($nota = $result->fetch_assoc()) {

    if ($nota['login'] == $email) {

        //salvando os dados na temp para dar continuidade
        $verificando = "SELECT * FROM tmp_nota WHERE cnpj = '".$cnpj."'";
        $resultVeri = $conn->query($verificando);
        $rowVeri = $resultVeri->fetch_assoc();

        if(empty($rowVeri['ID'])){
            $insert = "INSERT INTO tmp_nota (cnpj, email, caminho_nota) VALUES ('".$cnpj."', '".$email."', '".$destino."')";

            if(!$result = $conn -> query($insert)){

                echo "Não foi possivel salvar o CNPJ na tmp_nota";

            }else{  

                echo "<div id='sucesso'><p style='color: greem'>Cadastrador com Sucesso!</p></div>";              
                echo "<div id='sucesso'><p>Fornecedor: " . $nota['nome_fornecedor'] . "</p></div>";
            }
        }else{
            echo "<br/> Nota já cadastrada!";
        }

    }else{
        echo "<div id='error'><p>email nao encontrado</p></div>";
        echo "<div><p>".$query."</p></div>";

    }
}


$conn->close();
