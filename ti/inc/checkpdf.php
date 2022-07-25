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
$queryColaboradorPDF .= $funcionario . " LIMIT 1";
$resultColaborador = $conn->query($queryColaboradorPDF);
$colaborador = $resultColaborador->fetch_assoc();

//OBSERVAÇÕES
$queryOBS = "SELECT * FROM manager.manager_inventario_obs WHERE id_funcionario = " . $colaborador['id_funcionario'] . " ORDER BY id_obs DESC LIMIT 1";
$resultOBS = $conn->query($queryOBS);
$obs = $resultOBS->fetch_assoc();

/*CORPO DO PDF*/

//Logo do documento
$image = "../img/logo.png";
$imageTwo = "../img/logo2.png";

$html = "
<html>
	<head>
		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.1/css/all.css' integrity='sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf' crossorigin='anonymous'>
		<link rel='stylesheet' href='../css/checklistuser.css' crossorigin='anonymous'>	
		<style type='text/css'>
			img{width: 20%}
		</style>
		</head>
	<body>

		<div id='logo2'>";
		$html .= "<img src='data:image/png;base64," .  base64_encode(file_get_contents(@$imageTwo)) . "' ...>
		</div>

		<div id='logo'>";
		$html .= "<img src='data:image/png;base64," .  base64_encode(file_get_contents(@$image)) . "' ...>
		</div>

		<div id='tabela'>
			<table class='table table-sm'>
				<thead>
					<tr>
						<th colspan='4'><p class='text-left'><u>1) Dados do Funcionário</u></p></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class='linha_table' scope='row'>FUNCIONÁRIO:</td>
						<td class='info_user'>" . $colaborador['nome'] . "</td>
						<td class='linha_table'>CPF:</td>
						<td class='info_user'>" . $colaborador['cpf'] . "</td>
					</tr>
					<tr>
						<td class='linha_table'>DEPARTAMENTO:</td>
						<td class='info_user'>" . $colaborador['departamento'] . "</td>
						<td class='linha_table'>FUNÇÃO:</td>
						<td class='info_user'>" . $colaborador['funcao'] . "</td>
					</tr>
					<tr>
						<td class='linha_table'>FILIAL:</td>
						<td colspan='4' class='info_user'>" . $colaborador['empresa'] . "</td>
					</tr>
				<tbody>
			</table>
		</div>

		<div id='equipamento_title'>
			<p class='text-left'><u>2) Lista dos Equipamentos:</u></p>
		</div>";

while ($equipamento = $resultEquip->fetch_assoc()) {

	//rowspan
	if($equipamento['tipo_equipamento'] == 2 || $equipamento['tipo_equipamento'] == 1){
		$rowspan = '6';
	}else{
		$rowspan = '2';
	}

	//acessorios
	$queryAcessorios = "SELECT MDA.nome FROM manager_inventario_acessorios MIA LEFT JOIN manager_dropacessorios MDA ON (MIA.tipo_acessorio = MDA.id_acessorio) WHERE MIA.id_equipamento = " . $equipamento['id_equipamento'] . "";
	$resultAcessorios = $conn->query($queryAcessorios);

	$html .= "
			<div id='tabela_equipamento'>
				" . $equipamento['tipo_equipamento'] . " - " . $equipamento['situacao'] . "
				<table class='table table-sm'>
					<tbody>
						<tr>
							<td rowspan='" . $rowspan . "' class='marcador' width='30'>(&nbsp; &nbsp;)</td>
							<td colspan=''><b>Modelo:</b> " . $equipamento['modelo'] . "</td>
							<td><b>Operadora:</b> " . $equipamento['operadora'] . "</td>												
							<td rowspan='" . $rowspan . "' width='200'><u>OBS.:</u></td>
						</tr>
						<tr>
							<td><b>Imei:</b> " . $equipamento['imei_chip'] . "</td>
							<td><b>Numero:</b> " . $equipamento['numero'] . "</td>
						</tr>
						<tr>";
	while ($acessorios = $resultAcessorios->fetch_assoc()) {
		$html .= "<td colspan='2'>(&nbsp; &nbsp;)" . $acessorios['nome'] . "</td>";
	}
	$html .= "	</tr>
					</tbody>
				</table>
			</div>";
}

$html .= "<p class='text-left'>Na condição de empregado(a) da filial <b>" . $colaborador['empresa'] . "</b>, estou devolvendo neste ato os equipamentos descritos conforme a cima.</p>
		<p class='text-left'><u>3) CHECAR ITENS NA DEVOLUÇÃO</u></p>
		<div id='tabela_devolucao'>

			<table style='font-size: 9px; border: 1px solid #dee2e6'>
			  <thead>
			    <tr>
			      <th>Checar</th>
			      <th style='padding-right: 6px;border: solid 1px #dee2e6;'>Status</th>
			      <th style='padding-right: 300px;'>Observacao + Valor do Conserto</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <td>Senha de Desbloqueio</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Dados Pessoais</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Carregador</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Fone de Ouvido</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Cabos</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Botões Faltantes</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Tela Trincada</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Tela Trincada</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Danos por Queda</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Umidade</td>
			      <td></td>
			      <td></td>
			    </tr>
			  </tbody>
			</table>

		</div>
		<div style='margin-top: 10px'>
			<p class='text-left'>Para os fins do par. 1° do Art. 462 a CLT, desde já autorizo o desconto nas minhas verbas rescisórias, afim de ressarcir os danos acima.</p>
		</div>
		<div id='termo_data'>
			<p class='text-center'>____________, ____ de _____________ de ________</p>
		</div>
		<div id='assinatura'>
			<p class='text-left'>______________________________</p>
			<p class='text-left' style='margin-top: -18px;'>" . $colaborador['empresa'] . "</p>
			<p class='text-left'>______________________________</p>
			<p class='text-left' style='margin-top: -18px;'>" . $colaborador['nome'] . "</p>
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

//Output file
$dompdf->stream('checklist_' . $colaborador['nome'] . '.pdf', array("Attachment" => true)); //true - Download, false - Abre no navegador

//close dados bank
$conn->close();
