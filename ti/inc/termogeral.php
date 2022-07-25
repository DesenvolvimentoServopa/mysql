<?php
/* ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); */

require_once('../bd/conexao.php');
require_once('pesquisas.php');

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
    $queryEquipamento .= " WHERE MIE.id_funcionario = ".$_GET['id_fun']."";
    $funcionario = " WHERE MIF.id_funcionario = ".$_GET['id_fun']."";
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

//Logo do documento
$image = "../img/logo.png";

/*CORPO DO PDF*/
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
			<div id='text_departamento'>
				<span id='empresa_departamento'>
					<p class='texto'>Na condição de empregado(a) da filial <span class='titulo_secundario'>" . $colaborador['empresa'] . " - " . $colaborador['departamento'] . " / " . $colaborador['funcao'] . "</span>, estou recebendo neste ato equipamento conforme abaixo:
				</span>
			</div>
			<div id='tabela_equipamento'>
				<div id='tabela_titulo_principal'>
					<p class='titulo_secundario'><u>Descrição dos Produtos:</u></p>
				</div>
				<div id='termo_tabela'>
					<table class='table table-sm'>";


                    while ($equipamento = $resultEquip->fetch_assoc()) {

                        //Sistema Operacional
                        $queryso = "SELECT MSO.versao AS id_versao, 
										   MDSO.nome AS versao 
									
									FROM  manager_sistema_operacional MSO 
									LEFT JOIN manager_dropsistemaoperacional MDSO ON (MSO.versao = MDSO.id) 
									
									WHERE MSO.id_equipamento = ".$equipamento['id_equipamento']."";

                        $resultMSO = $conn->query($queryso);
                        $mso = $resultMSO->fetch_assoc();

                        //Office
                        $queryoffice = "SELECT MO.versao AS id_versao, 
											   MDO.nome AS versao 
											   
										FROM manager_office MO 
										LEFT JOIN manager_dropoffice MDO ON (MO.versao = MDO.id) 
										
										WHERE MO.id_equipamento = ".$equipamento['id_equipamento']."";

                        $resultoffice = $conn->query($queryoffice);
						$office  = $resultoffice->fetch_assoc();

						

						switch ($equipamento['tipo_equipamento']){
							case "NOTEBOOK":

							case "CPU":
								$htmlCpu .= "<tr>";
									$htmlCpu .= "<td>"; $htmlCpu .= empty($equipamento['tipo_equipamento']) ? "---" : $equipamento['tipo_equipamento']; $htmlCpu .= "</td>";
									$htmlCpu .= "<td>"; $htmlCpu .= empty($equipamento['modelo']) ? "---" : $equipamento['modelo']; $htmlCpu .= "</td>";
									$htmlCpu .= "<td>"; $htmlCpu .= empty($equipamento['patrimonio']) ? "---" : $equipamento['patrimonio']; $htmlCpu .= "</td>";
									$htmlCpu .= "<td>"; $htmlCpu .= empty($equipamento['serialnumber']) ? "---" : $equipamento['serialnumber']; $htmlCpu .= "</td>";
									$htmlCpu .= "<td>"; $htmlCpu .= empty($equipamento['hd']) ? "---" : $equipamento['hd']; $htmlCpu .= "</td>";
									$htmlCpu .= "<td>"; $htmlCpu .= empty($equipamento['processador']) ? "---" : $equipamento['processador']; $htmlCpu .= "</td>";
									$htmlCpu .= "<td>"; $htmlCpu .= empty($equipamento['memoria']) ? "---" : $equipamento['memoria']; $htmlCpu .= "</td>";
									$htmlCpu .= "<td>"; $htmlCpu .= empty($mso['versao']) ? "---" : $mso['versao']; $htmlCpu .= "</td>";
									$htmlCpu .= "<td>"; $htmlCpu .= empty($office['versao']) ? "---" : $office['versao']; $htmlCpu .= "</td>";						
								$htmlCpu .= "</tr>";

								$verificaCpu = 1;
								
								break;
							
							case "CELULAR":

							case "TABLET":


								//Acessórios
								$queryacessorio = "SELECT MIA.tipo_acessorio AS acessorio
													
												FROM manager_inventario_acessorios MIA
												
												WHERE MIA.id_equipamento = ".$equipamento['id_equipamento']."";

								$resultacessorio = $conn->query($queryacessorio);

								while ($acessorio  = $resultacessorio->fetch_assoc()) {
									switch ($acessorio['acessorio']){
										case 1:
											$htmlAcessorio .= "-Base carregadora<BR>";
											break;

										case 2:
											$htmlAcessorio .= "-Cabo USB<BR>";
											break;

										case 3:
											$htmlAcessorio .= "-Fone de ouvido<BR>";
											break;

										case 4:
											$htmlAcessorio .= "-Cabo antena<BR>";
											break;
									}
								}

								$htmlTablet .= "<tr style='width: 100%'>";
									$htmlTablet .= "<td>"; $htmlTablet .= empty($equipamento['tipo_equipamento']) ? "---" : $equipamento['tipo_equipamento']; $htmlTablet .= "</td>";
									$htmlTablet .= "<td>"; $htmlTablet .= empty($equipamento['modelo']) ? "---" : $equipamento['modelo']; $htmlTablet .= "</td>";
									$htmlTablet .= "<td>"; $htmlTablet .= empty($equipamento['patrimonio']) ? "---" : $equipamento['patrimonio']; $htmlTablet .= "</td>";
									$htmlTablet .= "<td>"; $htmlTablet .= empty($equipamento['imei_chip']) ? "---" : $equipamento['imei_chip']; $htmlTablet .= "</td>";
									$htmlTablet .= "<td>"; $htmlTablet .= empty($htmlAcessorio) ? "---" : $htmlAcessorio; $htmlTablet .= "</td>";
									$htmlTablet .= "<td>"; $htmlTablet .= empty($equipamento['status']) ? "---" : $equipamento['status']; $htmlTablet .= "</td>";
									$htmlTablet .= "<td>"; $htmlTablet .= empty($equipamento['situacao']) ? "---" : $equipamento['situacao']; $htmlTablet .= "</td>";
									$htmlTablet .= "<td>"; $htmlTablet .= empty($equipamento['valor']) ? "---" : $equipamento['valor']; $htmlTablet .= "</td>";						
								$htmlTablet .= "</tr>";
								
								$htmlAcessorio = "";
								$verificaTablet = 1;

								break;
							
							case "CHIP":
								$htmlChip .= "<tr>";
									$htmlChip .= "<td>"; $htmlChip .= empty($equipamento['tipo_equipamento']) ? "---" : $equipamento['tipo_equipamento']; $htmlChip .= "</td>";
									$htmlChip .= "<td>"; $htmlChip .= empty($equipamento['numero']) ? "---" : $equipamento['numero']; $htmlChip .= "</td>";
									$htmlChip .= "<td>"; $htmlChip .= empty($equipamento['operadora']) ? "---" : $equipamento['operadora']; $htmlChip .= "</td>";
									$htmlChip .= "<td>"; $htmlChip .= empty($equipamento['plano']) ? "---" : $equipamento['plano']; $htmlChip .= "</td>";
									$htmlChip .= "<td>"; $htmlChip .= empty($equipamento['status']) ? "---" : $equipamento['status']; $htmlChip .= "</td>";					
								$htmlChip .= "</tr>";
								
								$verificaChip = 1;

								break;

							case "SCANNER":
								$htmlScanner .= "<tr>";
									$htmlScanner .= "<td>"; $htmlScanner .= empty($equipamento['tipo_equipamento']) ? "---" : $equipamento['tipo_equipamento']; $htmlScanner .= "</td>";
									$htmlScanner .= "<td>"; $htmlScanner .= empty($equipamento['modelo']) ? "---" : $equipamento['modelo']; $htmlScanner .= "</td>";
									$htmlScanner .= "<td>"; $htmlScanner .= empty($equipamento['serialnumber']) ? "---" : $equipamento['serialnumber']; $htmlScanner .= "</td>";
									$htmlScanner .= "<td>"; $htmlScanner .= empty($equipamento['patrimonio']) ? "---" : $equipamento['patrimonio']; $htmlScanner .= "</td>";					
								$htmlScanner .= "</tr>";

								$verificaScanner = 1;

								break;

							case "DVR":
								$htmlDvr .= "<tr>";
									$htmlDvr .= "<td>"; $htmlDvr .= empty($equipamento['tipo_equipamento']) ? "---" : $equipamento['tipo_equipamento']; $htmlDvr .= "</td>";
									$htmlDvr .= "<td>"; $htmlDvr .= empty($equipamento['modelo']) ? "---" : $equipamento['modelo']; $htmlDvr .= "</td>";
									$htmlDvr .= "<td>"; $htmlDvr .= empty($equipamento['serialnumber']) ? "---" : $equipamento['serialnumber']; $htmlDvr .= "</td>";
									$htmlDvr .= "<td>"; $htmlDvr .= empty($equipamento['patrimonio']) ? "---" : $equipamento['patrimonio']; $htmlDvr .= "</td>";					
								$htmlDvr .= "</tr>";
								
								$verificaDvr = 1;

								break;

							case "MODEM":
								$htmlModem .= "<tr>";
									$htmlModem .= "<td>"; $htmlModem .= empty($equipamento['tipo_equipamento']) ? "---" : $equipamento['tipo_equipamento']; $htmlModem .= "</td>";
									$htmlModem .= "<td>"; $htmlModem .= empty($equipamento['modelo']) ? "---" : $equipamento['modelo']; $htmlModem .= "</td>";
									$htmlModem .= "<td>"; $htmlModem .= empty($equipamento['serialnumber']) ? "---" : $equipamento['serialnumber']; $htmlModem .= "</td>";
									$htmlModem .= "<td>"; $htmlModem .= empty($equipamento['patrimonio']) ? "---" : $equipamento['patrimonio']; $htmlModem .= "</td>";					
								$htmlModem .= "</tr>";
								
								$verificaModem = 1;

								break;

							case "RAMAL IP":
								$htmlRamal .= "<tr>";
									$htmlRamal .= "<td>"; $htmlRamal .= empty($equipamento['tipo_equipamento']) ? "---" : $equipamento['tipo_equipamento']; $htmlRamal .= "</td>";
									$htmlRamal .= "<td>"; $htmlRamal .= empty($equipamento['numero']) ? "---" : $equipamento['numero']; $htmlRamal .= "</td>";
									$htmlRamal .= "<td>"; $htmlRamal .= empty($equipamento['operadora']) ? "---" : $equipamento['operadora']; $htmlRamal .= "</td>";					
								$htmlRamal .= "</tr>";
								
								$verificaRamal = 1;

								break;
						}
                    }

					if($verificaCpu == 1){
						$tableCpu = "
											<tr style = background-color:#b3b3cc>
												<td>EQUIP.</td>
												<td>MODELO</td>						
												<td>PATRIMÔNIO</td>											
												<td>N. SÉRIE</td>
												<td>HARD DISK(HD)</td> 
												<td>PROCESSADOR</td>						
												<td>MEMORIA</td>
												<td>SISTEMA OPERACIONAL</td>
												<td>OFFICE</td>			    
											</tr>";
						$tableCpu .= $htmlCpu;
						$html .= $tableCpu;
					}

					if($verificaTablet == 1){
						$tableTablet = "
											<tr style = background-color:#b3b3cc>
												<td>EQUIP.</td>				
												<td>MODELO</td>
												<td>PATRIMÔNIO</td>
												<td>IMEI</td> 
												<td>ACESSORIOS</td> 
												<td>STATUS</td> 
												<td>SITUAÇÃO</td>
												<td colspan = 2>VALOR</td>		    
											</tr>";
						$tableTablet .= $htmlTablet;
						$html .= $tableTablet;
					}

					if($verificaChip == 1){
						$tableChip = "
											<tr style = background-color:#b3b3cc>	
												<td>EQUIP.</td>			
												<td>NÚMERO</td>
												<td>OPERADORA</td> 
												<td>PLANO</td> 	 
												<td>STATUS</td> 
												<td></td>	    
												<td></td>	    
												<td></td>	    
												<td></td>	    
											</tr>";
						$tableChip .= $htmlChip;
						$html .= $tableChip;
					}

					if($verificaScanner == 1){
						$tableScanner = "
											<tr style = background-color:#b3b3cc>				
												<td>MODELO</td>
												<td>N. SERIE</td>
												<td colspan = 6>PATRIMÔNIO</td> 	    
											</tr>";
						$tableScanner .= $htmlScanner;
						$html .= $tableScanner;
					}
					
					if($verificaDvr == 1){
						$tableDvr = "
											<tr style = background-color:#b3b3cc>				
												<td>MODELO</td>
												<td>N. SERIE</td>
												<td colspan = 6>PATRIMÔNIO</td>	    
											</tr>";
						$tableDvr .= $htmlDvr;
						$html .= $tableDvr;
					}

					if($verificaModem == 1){
						$tableModem = "
											<tr style = background-color:#b3b3cc>				
												<td>MODELO</td>
												<td>N. SERIE</td>
												<td colspan = 6>PATRIMÔNIO</td> 		    
											</tr>";
						$tableModem .= $htmlModem;
						$html .= $tableModem;
					}

					if($verificaRamal == 1){
						$tableRamal = "
											<tr style = background-color:#b3b3cc>				
												<td>NÚMERO</td>
												<td colspan = 7>OPERADORA</td>    
											</tr>";
						$tableRamal .= $htmlRamal;
						$html .= $tableRamal;
					}
					
$html .= "
			</table>
		</div>
    </div>";

if ($obs['obs'] != NULL) {

    $html .= "
				<div id='tabela_titulo_principal'>
					<p class='titulo_secundario'><u>Observações:</u></p>
				</div>
				<div id='termo_texto'>
					<p class='text-sm-left texto'>&raquo; " . $obs['obs'] . "</p>
				</div>";
}

$html .= "
			<div id='tabela_titulo_principal'>
				<p class='titulo_secundario'><u>Termo:</u></p>
			</div>
			<div id='termo_texto'>
				<p class='text-sm-left texto'>Comprometendo-me a devolvê-lo, em perfeito estado de conservação, mediante simples solicitação da empresa ou no caso de rescisão contratual, independente do motivo. Declaro que a utilização do referido equipamento <span class='font-weight-bold'><u> será exclusivamente em minha atividade profissional</u></span>,(não esta autorizado fotos particulares, redes sociais, facebook, instagram, tinder, badoo, happn) estou ciente, da minha responsabilidade por danificar culposamente(pelo extravio, queda, danos por contato com umidade, extravio de componentes(carregador), estando isento de responsabilidade por danos advindos de desgates natural por uso cotidiano). Ciente que em caso de mau funcionamento (bateria não carrega) ou defeito do aparelho devo notificar no prazo máximo de 3 dias, após a retirada.</p>
				<p class='text-sm-left texto'>Caso haja necessidade de portar, levar para casa este eletrônico, que devo notificar qualquer estrago ou avaria imediatamente para área de T.I, que caso se faça necessários consertos, estes deverão preferencialmente ser realizados via T.I, só em caso de impossibilidade incompatibilidade (devido a distância) o conserto será feito de forma particular.

					Para os fins do par. 1º do Art. 462 da CLT, desde já autorizo o desconto salarial à conta de eventuais danos
					causados ao equipamento,(descritos acima) reembolsando a minha empregadora pelos reparos necessários ou até mesmo a substituição de um novo aparelho. Lembrando que o valor para ressarcimento será o vigente da data da ocorrência.<p>
			</div>
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

//Output file
$dompdf->stream('termo_' . $colaborador['nome'] . '.pdf', array("Attachment" => true)); //true - Download, false - Abre no navegador

$conn->close();
?>
