<?php
session_start();
//chamar o banco
require_once('../bd/conexao.php');

//aplicando a query
$resultado_relatorios = $conn->query($_SESSION['query_relatorios']);

/*
* Criando e exportando planilhas do Excel
* /
*/
// Definimos o nome do arquivo que será exportado

$arquivo = 'relatorio_colaborador.xls';

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
                <th scope='col'>STATUS</th>
				<th scope='col'>NOME</th>
				<th scope='col'>CPF</th>
				<th scope='col'>FUNÇÃO</th>
				<th scope='col'>DEPARTAMENTO</th>
				<th scope='col'>FILIAL</th>
				<th scope='col'>EQUIPAMENTO</th>
                <th scope='col'>PATRIMONIO</th>
				<th scope='col'>MODELO</th>
				<th scope='col'>IMEI-CHIP</th>
				<th scope='col'>NUMERO</th>
				<th scope='col'>VALOR</th>
		    </tr>
		  </thead>
		  <tbody>";

while ($row_relatorio = $resultado_relatorios->fetch_assoc()) {
    $html .= "
			<tr>";
    $html .=  empty($row_relatorio['status']) ? '<td>----------</td>' : '<td>' . $row_relatorio['status'] . '</td>';
    $html .=  empty($row_relatorio['nome']) ? '<td>----------</td>' : '<td>' . $row_relatorio['nome'] . '</td>';
    $html .=  empty($row_relatorio['cpf']) ? '<td>----------</td>' : '<td>' . $row_relatorio['cpf']  . '</td>';
    $html .=  empty($row_relatorio['funcao']) ? '<td>----------</td>' : '<td>' . $row_relatorio['funcao']  . '</td>';
    $html .=  empty($row_relatorio['departamento']) ? '<td>----------</td>' : '<td>' . $row_relatorio['departamento'] . '</td>';
    $html .=  empty($row_relatorio['empresa']) ? '<td>----------</td>' : '<td>' . $row_relatorio['empresa'] . '</td>';
    $html .=  empty($row_relatorio['tipo_equipamento']) ? '<td>----------</td>' : '<td>' . $row_relatorio['tipo_equipamento'] . '</td>';
    $html .=  empty($row_relatorio['patrimonio']) ? '<td>----------</td>' : '<td>' . $row_relatorio['patrimonio'] . '</td>';
    $html .=  empty($row_relatorio['modelo']) ? '<td>----------</td>' : '<td>' . $row_relatorio['modelo']  . '</td>';
    $html .=  empty($row_relatorio['imei_chip']) ? '<td>----------</td>' : '<td>' . $row_relatorio['imei_chip'] . '</td>';
    $html .=  empty($row_relatorio['numero']) ? '<td>----------</td>' : '<td>' . $row_relatorio['numero'] . '</td>';
    $html .=  empty($row_relatorio['valor']) ? '<td>----------</td>' : '<td>' . $row_relatorio['valor'] . '</td>';

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
