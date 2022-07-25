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
if ($_GET['id_fun'] == NULL) {
	$queryEquipamento .= $_GET['query'];
	$funcionario = $_GET['query'];
} else {
	$queryEquipamento .= " WHERE MIE.id_funcionario = " . $_GET['id_fun'] . " AND MIE.tipo_equipamento IN (";

	while ($permissaoEquipamento = $resultPermissaoEquipamento->fetch_assoc()){
		$queryEquipamento .= $permissaoEquipamento['id_equipamento']. ',';
	  }

	  $queryEquipamento .= "'')";

	$funcionario = " WHERE MIF.id_funcionario = " . $_GET['id_fun'] . "";
}

$resultEquip = $conn->query($queryEquipamento);


//FUNCIONARIO
$queryColaboradorPDF .= $funcionario." LIMIT 1";
$resultColaborador = $conn->query($queryColaboradorPDF);
$colaborador = $resultColaborador->fetch_assoc();

//OBSERVAÇÕES
$queryOBS = "SELECT * FROM manager.manager_inventario_obs WHERE id_funcionario = ".$colaborador['id_funcionario']." ORDER BY id_obs DESC LIMIT 1";
$resultOBS = $conn->query($queryOBS);
$obs = $resultOBS->fetch_assoc();

/*CORPO DO PDF*/

//Logo do documento
$image = "../img/logo.png";

$html = "
<html>
	<head>
		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
		<style type='text/css'>
		p.termo_titulo{
			 font-size: 10px; 
			 font-weight: bold;
		}
		p.texto{
			font-size:12px;
		}
		.titulo_segundario{
			font-weight: bold;
			font-size: 12px;
			text-decaration: sublime
		}
		table{
			font-size: 8px;
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
			<div id='text_departamento'>
				<span id='empresa_departamento'>
					<p class='texto'>Na condição de empregado(a) da filial <span class='titulo_segundario'>" . $colaborador['empresa'] . " - " . $colaborador['departamento'] . " / " . $colaborador['funcao'] . "</span>, estou recebendo neste ato equipamento conforme abaixo:
				</span>
			</div>
			<div id='tabela_equipamento'>
				<div id='tabela_titulo_principal'>
					<p class='titulo_segundario'><u>Descrição dos Produtos:</u></p>
				</div>
				<div id='termo_tabela'>
				<!--SE FOR CHIP, MOSTRAR APENAS CHIP E OPERADORA-->
					<table class='table table-sm'>
					  <tr>
						<th>EQUIP.</th>						
						<th>NÚMERO</th>
						<th>MODELO</th>
						<th>PATRIMÔNIO</th>
					    <th>IMEI</th> 
					    <th>VALOR</th>
					    <th>PLANOS</th>
					    <th>ACESSÓRIOS</th>
						<th>SITUAÇÃO</th>
						<th>ESTADO</th>		    
                      </tr>";
					  while ($equipamento = $resultEquip->fetch_assoc()) {

							//acessorios
							$queryAcessorios = "SELECT MDA.nome FROM manager.manager_inventario_acessorios MIA LEFT JOIN manager_dropacessorios MDA ON (MIA.tipo_acessorio = MDA.id_acessorio) WHERE MIA.id_equipamento = ".$equipamento['id_equipamento']."";
							$resultAcessorios = $conn->query($queryAcessorios);
						 
							
						  $html .= "<tr>";
							  $html .= "<td>"; $html .= empty($equipamento['tipo_equipamento']) ? "---" : $equipamento['tipo_equipamento']; $html .= "</td>";
							  $html .= "<td>"; $html .= empty($equipamento['numero']) ? "---" : $equipamento['numero']; $html .= "</td>";
							  $html .= "<td>"; $html .= empty($equipamento['modelo']) ? "---" : $equipamento['modelo']; $html .= "</td>";
							  $html .= "<td>"; $html .= empty($equipamento['patrimonio']) ? "---" : $equipamento['patrimonio']; $html .= "</td>";
							  $html .= "<td>"; $html .= empty($equipamento['imei_chip']) ? "---" : $equipamento['imei_chip']; $html .= "</td>";
							  $html .= "<td>"; $html .= empty($equipamento['valor']) ? "---" : $equipamento['valor']; $html .= "</td>";
							  $html .= "<td>"; $html .= empty($equipamento['planos_voz']) || empty($equipamento['planos_dados']) ? "---" : $equipamento['planos_dados'].",". $equipamento['planos_voz']; $html .= "</td>";
							  
							  $html .= "<td>"; 
							  
							  while($acessorios = $resultAcessorios->fetch_assoc() ){
								$html .= $acessorios['nome']."-";
							  }
							  
							  $html .= "</td>";
							  
							  $html .= "<td>"; $html .= empty($equipamento['situacao']) ? "---" : $equipamento['situacao']; $html .= "</td>";
							  $html .= "<td>"; $html .= empty($equipamento['estado']) ? "---" : $equipamento['estado']; $html .= "</td>";						
						  $html .= "</tr>";
					  }
		  $html .= "</table>
				</div>
			</div>
			<div id='termo_texto'>
				<p class='text-sm-left texto'>Comprometendo-me a devolvê-lo, em perfeito estado de conservação, mediante simples solicitação da empresa ou no caso de rescisão contratual, independente do motivo. Declaro que a utilização do referido equipamento <span class='font-weight-bold'><u> será exclusivamente em minha atividade profissional</u></span>,(não esta autorizado fotos particulares, telefones particulares, redes sociais, facebook, instagram, tinder, badoo, happn) estou ciente, da minha responsabilidade por danificar culposamente(pelo extravio, queda, danos por contato com umidade, extravio de componentes(carregador), estando isento de responsabilidade por danos advindos de desgates natural por uso cotidiano). Ciente que em caso de mau funcionamento (bateria não carrega) ou defeito do aparelho devo notificar no prazo máximo de 3 dias, após a retirada.</p>
				<p class='text-sm-left texto'>Caso haja necessidade de portar, levar para casa este eletrônico, que devo notificar qualquer estrago ou avaria imediatamente a para área de T.I, que caso se faça necessários consertos, estes deverão preferencialmente ser realizados via T.I, só em caso de impossibilidade incompatibilidade (devido a distância) o conserto será feito de forma particular.

					Para os fins do par. 1º do Art. 462 da CLT, desde já autorizo o desconto salarial à conta de eventuais danos
					causados ao equipamento,(descritos acima) reembolsando a minha empregadora pelos reparos necessários ou até mesmo a substituição de um novo aparelho. Lembrando que o valor para ressarcimento será o vigente da data da ocorrência.<p>
			</div>
			<div id='tabela_titulo_principal'>
				<p class='titulo_segundario'><u>Observações:</u></p>
			</div>
			<div id='termo_texto'>";
			if ($obs['obs'] != NULL) {

				$html .= "<div id='termo_texto'>
								<p class='text-sm-left texto'>&raquo; " . $obs['obs'] . "</p>
							</div>";
			}
			
			$html .= "</div>
			<br>
			<div id='termo_data'>
				<p class='text-center'>____________, ____ de _____________ de ________</p>
			</div>
			<div id='termo_footer'>
				<p class='font-weight-light'>Colaborador(A): " . $colaborador['nome'] . "</p>
				<p class='font-weight-light'>CPF: " . $colaborador['cpf'] . "</p>
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


$dompdf->stream('termo_' . $colaborador['nome'] . '.pdf', array("Attachment" => true));//true - Download false - Previa


$conn->close();
?>