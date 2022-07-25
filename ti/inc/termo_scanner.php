<?php
/* ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); */

require_once('../bd/conexao.php');
require_once('pesquisas.php');
require_once('permissoes.php');


//reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

//chamando ele pelo autoload do vendor
require '../vendor/autoload.php';

//EQUIPAMENTO
$queryEquipamento .= " WHERE MIE.id_equipamento = ".$_GET['id']."";
$resultEquip = $conn->query($queryEquipamento);

//FUNCIONARIO
if(!empty($_GET['id_fun'])){
	$queryColaborador .= " WHERE MIF.id_funcionario = ".$_GET['id_fun']."";
	
	$resultFun = $conn->query($queryColaborador);
	$colaborador = $resultFun->fetch_assoc();
}

/*CORPO DO PDF*/

//Logo do documento
$image = "../img/logo.png";

$html = "
<html>
	<head>
		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
		<style type='text/css'>
			p.termo_titulo{
				font-size: 9px; 
				font-weight: bold;
			}
			p.texto{
				font-size:11px;
			}
			.titulo_secundario{
				font-weight: bold;
				font-size: 11px;
				text-decaration: sublime
			}
			table{
				font-size: 8px;
				font-weight: bold;
			}
			th{
				font-weight: bold;
			}
			img{width: 20%}
		</style>
	</head>
	<body>
		<header>";
		$html .= "<img src='data:image/png;base64," .  base64_encode(file_get_contents(@$image)) . "' ...>
		</header>
		<div id='termo_header'>
			<p class='text-center'>&ldquo;TERMO DE ENTREGA E DECLARAÇÃO&rdquo;</p>
		</div>
		<div id='termo_body'>
			<div id='termo_equipamento'>
				<p class='text-center termo_titulo'>EQUIPAMENTOS CORPORATIVOS</p>
			</div>
			<div id='tabela_equipamento'>
				<div id='tabela_titulo_principal'>
					<p class='titulo_segundario'><u>Descrição dos Produtos:</u></p>
				</div>
				<div id='termo_tabela'>
					<table class='table table-sm'>
					  <tr  style=background-color:#b3b3cc>				
						<th>MODELO</th>
						<th>N. SÉRIE</th>
						<th>PATRIMÔNIO</th>    
                      </tr>";
					  while ($equipamento = $resultEquip->fetch_assoc()) {				 
							
						  $html .= "<tr>";
							  $html .= "<td>"; $html .= empty($equipamento['modelo']) ? "---" : $equipamento['modelo']; $html .= "</td>";
							  $html .= "<td>"; $html .= empty($equipamento['serialnumber']) ? "---" : $equipamento['serialnumber']; $html .= "</td>";
							  $html .= "<td>"; $html .= empty($equipamento['patrimonio']) ? "---" : $equipamento['patrimonio']; $html .= "</td>";						
						  $html .= "</tr>";
					  }
		  $html .= "</table>
				</div>
			</div>
			
			<div id='tabela_titulo_principal'>
				<p class='titulo_segundario'><u>Termo:</u></p>
			</div>
			<div id='termo_texto'>
				<p class='text-sm-left texto'>
					Recebi da empresa: <b>"; $html .= empty($colaborador['empresa']) ? "_______________________________________________________________" : $colaborador['empresa']; $html .= "</b> a título de empréstimo, para meu uso exclusivo, o equipamento especificado neste termo de responsabilidade, comprometendo-me a matê-lo em perfeito estado de conservação, ficando ciente de que:
				</p>

				<p class='text-sm-left texto'>
					1 - Se o equipamento for danificado ou inutilizado por emprego inadequado, mau uso, negligência ou extravio, a empresa me fornecerá novo equipamento e cobrará o valor de um equipamento da mesma marca ou equivalente ao da praça.
				<p>

				<p class='text-sm-left texto'>
					2 - Em caso de dano, inutilização ou extravio do equipamento deverei comunicar imediatamente ao setor competente.
				<p>

				<p class='text-sm-left texto'>
					3 - Terminando os serviços ou no caso de rescisão do contrato de trabalho, devolverei o equipamento completo e em perfeito estado de conservação, considerando-se o tempo do uso do mesmo, ao setor competente.
				<p>

				<p class='text-sm-left texto'>
					4 - Estando os equipamentos em minha posse, estarei sujeito a inspeções sem prévio aviso.
				<p>

			</div>
			<br />
			<div id='termo_data'>
				<p class='text-center'>____________, ____ de _____________ de ________</p>
			</div>
			<div id='termo_footer'>
				<p class='font-weight-light'>
					Colaborador(A): "; $html .= empty($colaborador['nome']) ? "_______________________________________________________________" : $colaborador['nome']; $html .= "
				</p>
				<p class='font-weight-light'>
					CPF: "; $html .= empty($colaborador['cpf']) ? "______.______.______-___" : $colaborador['cpf']; $html .= "
				</p>
				<br />
				<p class='font-weight-light'>Assinatura:_______________________________________________________________ </p>
			</div>
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
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait'); // portrait = retrato, landscape = paisagem

// Render the HTML as PDF
$dompdf->render();

$dompdf->stream('termo(' . $colaborador['nome'] . ').pdf', array("Attachment" => true));//true - Download false - Previa


$conn->close();
