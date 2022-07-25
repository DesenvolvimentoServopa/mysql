<?php
include('../conf/conexao.php');


//variaveis
$filial = $_GET['filial'];
$email = ($_GET['email'] == 'notas.ti@servopa.com.br') ? 'luiza.andrade@servopa.com.br' : $_GET['email'];

if($_GET['idFornecedor'] != null){
    $ID_FORNECEDOR = $_GET['idFornecedor'];
}else{
    $ID_FORNECEDOR = "(SELECT ID_FORNECEDOR FROM cad_fornecedor WHERE cpf_cnpj = '".$_GET['cnpj']."')";
}


$query = "SELECT 
CDC.descDpto, CDR.percentual
FROM
cad_rateiocentrocusto CDR
    LEFT JOIN
cad_centrocusto CDC ON (CDR.ID_CENTROCUSTO = CDC.ID_CENTROCUSTO)
WHERE
CDR.ID_RATEIOFORNECEDOR = (SELECT 
        ID_RATEIOFORNECEDOR
    FROM
        cad_rateiofornecedor
    WHERE
        ID_FORNECEDOR = ".$ID_FORNECEDOR."
            AND ID_FILIAL = (SELECT 
                ID_FILIAL
            FROM
                cad_filial
            WHERE
                cnpj  = ".$filial." LIMIT 1)
            AND ID_USUARIO = (SELECT 
                ID_USUARIO
            FROM
                cad_login
            WHERE
                login = '".$email."') LIMIT 1)";
$result = $conn->query($query);

/* echo $query;
exit;
 */
?>

<table>
    <tr>
        <td style="border: solid 1px; padding: 5px; text-align: center; " colspan="2">CENTRO DE CUSTO</td>
    </tr>

    <?php

    while($custoCentro = $result->fetch_assoc()){
        echo '<tr>
                    <td style="border: solid 1px; padding: 5px; ">'.$custoCentro['descDpto'].'</td>
                    <td style="border: solid 1px; padding: 5px; ">'.$custoCentro['percentual'].'%</td>
                </tr>';
    }
    ?>
    <tr>
        <td colspan="2" style="border: solid 1px; padding: 5px; ">Data: _____/_____/_____</td>
    </tr>
    <tr>
        <td colspan="2" style="border: solid 1px; padding: 5px; ">Responsável: _________________________</td>
    </tr>
    <tr>
        <td colspan="2" style="border: solid 1px; padding: 5px; ">Diretoria: _________________________</td>
    </tr>
</table>

<?php
$conn->close();
?>