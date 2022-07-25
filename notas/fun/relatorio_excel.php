<?php
session_start();
//chamar o banco
require_once('../conf/conexao.php');

//aplicando a query
$resultado_relatorios = $conn->query($_SESSION['query_relatorios']);

/*
* Criando e exportando planilhas do Excel
* /
*/
// Definimos o nome do arquivo que será exportado

$arquivo = 'relatorio_Notas.xls';

// Criamos uma tabela HTML com o formato da planilha
$html = "
<html>
	<style>
		td{
			border: solid 1px;
		}
	</style>
	<body>
		<table class='table table-sm' style='font-size:12px;'>
		  <thead>
		    <tr>				
            <th>ID Nota</th>
            <th>Filial</th>
            <th>CNPJ</th>
            <th>Fornecedor</th>
            <th>Numero Nota</th>
            <th>Valor Nota</th>
            <th>Data Emissão</th>
            <th>Vencimento</th>
            <th>Fluig</th>
            <th>Usuário</th>
		    </tr>
		  </thead>
		  <tbody>";

while ($row_relatorio = $resultado_relatorios->fetch_assoc()) {
    $html .= "
			<tr>";
    $html .=  empty($row_relatorio['IDNOTA']) ? '<td>----------</td>' : '<td>' . $row_relatorio['IDNOTA'] . '</td>';
    $html .=  empty($row_relatorio['FILIAL']) ? '<td>----------</td>' : '<td>' . $row_relatorio['FILIAL'] . '</td>';
    $html .=  empty($row_relatorio['CNPJ']) ? '<td>----------</td>' : '<td>' . $row_relatorio['CNPJ'] . '</td>';
    $html .=  empty($row_relatorio['FORNECEDOR']) ? '<td>----------</td>' : '<td>' . $row_relatorio['FORNECEDOR']  . '</td>';
    $html .=  empty($row_relatorio['NUMERONOTA']) ? '<td>----------</td>' : '<td>' . $row_relatorio['NUMERONOTA']  . '</td>';
    $html .=  empty($row_relatorio['VALORNOTA']) ? '<td>----------</td>' : '<td>' . $row_relatorio['VALORNOTA'] . '</td>';
	$html .=  empty($row_relatorio['DATAEMISSAO']) ? '<td>----------</td>' : '<td>' . $row_relatorio['DATAEMISSAO']  . '</td>';
	$html .=  empty($row_relatorio['DATAVENCIMENTO']) ? '<td>----------</td>' : '<td>' . $row_relatorio['DATAVENCIMENTO']  . '</td>';
	$html .=  empty($row_relatorio['FLUIG']) ? '<td>----------</td>' : '<td>' . $row_relatorio['FLUIG']  . '</td>';
	$html .=  empty($row_relatorio['USUARIO']) ? '<td>----------</td>' : '<td>' . $row_relatorio['USUARIO']  . '</td>';

    $html .= "
		    </tr>";
}
$html .= "</tbody>
		</table>
	</body>
</html>";

// Configurações header para forçar o download
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
header("Content-Description: PHP Generated Data");
// Envia o conteúdo do arquivo
echo $html;
exit;