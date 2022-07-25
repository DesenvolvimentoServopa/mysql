<?php
//ESSE AQRUIVO FOI CRIADO ESPECIALMENTE PARA EQUIPAMENTOS DE REDE!
session_start();
//chamar o banco
require_once('../bd/conexao.php');
require_once('pesquisas.php');

//reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

//chamando ele pelo autoload do vendor
require '../vendor/autoload.php';

//buscando as informações do equipamento de rede

$queryEquipamento .= " WHERE MIE.id_equipamento = " . $_GET['idEquipamento'];
$result = $conn->query($queryEquipamento);
$equipamento = $result->fetch_assoc();

//Buscando todos os equipamentos que possui o mesmo numero de nota.
$queryNumeroNota = "SELECT patrimonio, serialnumber, modelo FROM manager_inventario_equipamento WHERE numero_nota = '" . $equipamento['numero_nota'] . "'";
$resultNumeroNota = $conn->query($queryNumeroNota);


/*CORPO DO PDF*/

//Logo do documento
$image = "../img/logo.png";

$body = "
<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Modelo Windows</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
	<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.1/css/all.css' integrity='sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf' crossorigin='anonymous'>	
	<link rel='stylesheet' href='../css/checklist.css' crossorigin='anonymous'>		
	<style type='text/css'>
    th, .user {
        text-align: center !important;
    }
    .font{
        font-size: 11px;
    }
		img{width: 20%}

  </style>
</head>
<body>
<div class='container'>
  <table class='table table-bordered'  style='font-size: 8px; border: 1px solid #dee2e6'>
    <thead>
      <tr>
        <th colspan='2'>";
$body .= "<img src='data:image/png;base64," .  base64_encode(file_get_contents(@$image)) . "' ...></th>
        <th colspan='3' class='text-sm'>Modelo - Hardware Rede</th>
      </tr>
    </thead>
    <tbody>
      <tr>        
        <td colspan='5'>Localização: <span class='font'>" . $equipamento['locacao'] . "</span></td>
      </tr>
      <tr>
        <td colspan='3'>Nota Fiscal: <span class='font'>" . $equipamento['numero_nota'] . "</span></td>
        <td colspan='2'>Data Nota: <span class='font'>" . date('d/m/Y', strtotime($equipamento['data_nota'])) . "</span></td>
      </tr>
      <tr>
        <td colspan='5'>Fornecedor: <span class='font'>" . $equipamento['fornecedor_scan'] . "</span></td>
      </tr>
    </tbody> 
  </table>
</div>

<div class='container'>             
  <table class='table table-bordered'  style='font-size: 8px; border: 1px solid #dee2e6'>
    <thead>
    <tr>
      <th class='text-sm'>Patrimônio</th>
      <th class='text-sm'>Nº Série</th>
      <th class='text-sm'>Modelo</th>
    </tr>
    </thead>
    <tbody>";
while ($numeroNota = $resultNumeroNota->fetch_assoc()) {
  $body .= "<tr>
                  <td>" . $numeroNota['patrimonio'] . "</td>
                  <td>" . $numeroNota['serialnumber'] . "</td>
                  <td>" . $numeroNota['modelo'] . "</td>
                </tr>";
}
$body .= " 
    </tbody> 
  </table>
</div>

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
$dompdf->loadHtml($body);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait'); // portrait = retrato, landscape = paisagem

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('modeloPatrimonio_' . $equipamento['patrimonio'] . '.pdf', array("Attachment" => 1)); //1 - Download 0 - Previa

$conn->close();
