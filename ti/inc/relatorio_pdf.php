<?php
session_start();

/* ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
 */

//chamar o banco
require_once('../bd/conexao.php');


//reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

//chamando ele pelo autoload do vendor
require '../vendor/autoload.php';

//aplicando a query
$resultado_relatorios = $conn->query($_SESSION['query_relatorios']);

//Logo do documento
$image = "../img/logo.png";

//corpo da msn
$html = "
<html>
	<head>
		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
		<style type='text/css'>
			td{
				border: 2px solid #dee2e6;
				font-size: 8px
			}
			th{
				border: 2px solid #dee2e6;
				font-size: 12px;
			}
			img{width: 20%}
		</style>
	</head>
	<body>		
		<header>";
		$html .= "<img src='data:image/png;base64," .  base64_encode(file_get_contents(@$image)) . "' ...>
		</header>
		<div class='container-fluid'>
 			<p class='text-center'><b>RELATÓRIO INVENTÁRIO</b></p>
		</div>
		<br>
		<br>
		<br>
		<table class='table table-sm' style='font-size:12px;'>
		  <thead>
		  <tr>				
		  <th scope='col'>STATUS</th>
		  <th scope='col'>NOME</th>
		  <th scope='col'>CPF</th>
		  <th scope='col'>FUNÇÃO</th>
		  <th scope='col'>DEPARTAMENTO</th>
		  <th scope='col'>EMPRESA</th>
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
	$html .=  empty($row_relatorio['status']) ? '<td></td>' : '<td>' . $row_relatorio['status'] . '</td>';
	$html .=  empty($row_relatorio['nome']) ? '<td></td>' : '<td>' . $row_relatorio['nome'] . '</td>';
	$html .=  empty($row_relatorio['cpf']) ? '<td></td>' : '<td>' . $row_relatorio['cpf']  . '</td>';
	$html .=  empty($row_relatorio['funcao']) ? '<td></td>' : '<td>' . $row_relatorio['funcao']  . '</td>';
	$html .=  empty($row_relatorio['departamento']) ? '<td></td>' : '<td>' . $row_relatorio['departamento'] . '</td>';
	$html .=  empty($row_relatorio['empresa']) ? '<td></td>' : '<td>' . $row_relatorio['empresa'] . '</td>';
	$html .=  empty($row_relatorio['tipo_equipamento']) ? '<td></td>' : '<td>' . $row_relatorio['tipo_equipamento'] . '</td>';
	$html .=  empty($row_relatorio['patrimonio']) ? '<td></td>' : '<td>' . $row_relatorio['patrimonio'] . '</td>';
	$html .=  empty($row_relatorio['modelo']) ? '<td></td>' : '<td>' . $row_relatorio['modelo']  . '</td>';
	$html .=  empty($row_relatorio['imei_chip']) ? '<td></td>' : '<td>' . $row_relatorio['imei_chip'] . '</td>';
	$html .=  empty($row_relatorio['numero']) ? '<td></td>' : '<td>' . $row_relatorio['numero'] . '</td>';
	$html .=  empty($row_relatorio['valor']) ? '<td></td>' : '<td>' . $row_relatorio['valor'] . '</td>';

	$html .= "
                </tr>";
}
$html .= "</tbody>
		</table>
	</body>
</html>";

// instantiate and use the dompdf class
$dompdf = new Dompdf();

//habilitado o acesso ao download de assets remotos - Para funcionar o Bootstrap
$options = new Options();

//habilitado o acesso ao download de assets remotos - Para funcionar o Bootstrap
$options->set('isRemoteEnabled', true);

$options->setIsHtml5ParserEnabled(true);

//habilitado o acesso ao download de assets remotos - Para funcionar o Bootstrap
$dompdf = new Dompdf($options);

//load body PDF
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape'); // portrait = retrato, landscape = paisagem

// Render the HTML as PDF
$dompdf->render();

//Output file
$dompdf->stream('relatorio_colaborador.pdf', array("Attachment" => true)); //true - Download, false - Abre no navegador

$conn->close();