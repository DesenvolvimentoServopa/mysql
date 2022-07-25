<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Intranet Rede Paranapart</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="keywords">
    <meta name="description">

    <!-- Favicons -->
    <link href="img/favicon.ico" rel="icon">
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="css/style.css" rel="stylesheet">

    <!--Efeitos-->
    <link rel="stylesheet" href="lista/_efeitos/css/hover.css">
    <link rel="stylesheet" href="lista/_efeitos/css/hover-min.css">

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118964886-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-118964886-1');
    </script>
</head>


<body>
    <!--==========================
    Modal
============================-->
    <?php
    //chamando o banco de dados
    include 'inc/conexao.php';

    //verificando se existe uma postagem tipo MODAL
    $verificar_modal = "SELECT
                            id_postagem,
                            tipo_arquivo, 
                            file_img AS caminho, 
                            titulo 
                        FROM  
                            blog_post
                        WHERE 
                            tipo_postagem = 1 AND
                            deletar = 0";
    $resultado_modal = mysqli_query($banco_blog, $verificar_modal);

    //tipo de arquivo
    $video = 'video/mp4';
    $pdf = 'application/pdf';

    if ($linha_modal = mysqli_fetch_assoc($resultado_modal)) {

        if ($linha_modal['tipo_arquivo'] == $video) { //se for video
            echo "
                    <div class='container'>
                    <div class='modal fade' id='aviso'>
                        <div class='modal-dialog'>
                        <div class='modal-content' style='width: 120%;'>
                            <div class='modal-header'>          
                            <h4 class='modal-title'>
                            " . $linha_modal['titulo'] . "
                            </h4>
                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                            </div>        
                            <div class='modal-body'>
                            <video width='568' controls>
                                <source src='blog/" . $linha_modal['caminho'] . "' type='video/mp4'>
                                <source src='blog/" . $linha_modal['caminho'] . "' type='video/ogg'>
                                Seu navegador não suporta HTML5 video.
                            </video>
                            </div>
                            <div class='modal-footer'>
                            <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>";
        } elseif ($linha_modal['tipo_arquivo'] == $pdf) {
            echo "
                    <div class='container'>
                    <div class='modal fade' id='aviso'>
                    <div class='modal-dialog'>
                        <div class='modal-content' style='width: 120%;'>
                        <div class='modal-header'>          
                            <h4 class='modal-title'>
                            " . $linha_modal['titulo'] . "
                            </h4>
                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        </div>        
                        <div class='modal-body'>
                            <div id='comunicado'>
                            <iframe src='blog/" . $linha_modal['caminho'] . "' height='400' width='570'></iframe>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>";
        } else { //se for imagem
            echo "
                <div class='container'>
                    <div class='modal fade' id='aviso'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                        <div class='modal-header'>          
                            <h4 class='modal-title'>
                            " . $linha_modal['titulo'] . "
                            </h4>
                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        </div>        
                        <div class='modal-body'>
                            <div id='comunicado'>
                            <a href='http://10.100.1.217/blog/postagem.php?id_post=" . $linha_modal['id_postagem'] . "'>
                                <img id='imagen_comunicado' src='blog/" . $linha_modal['caminho'] . "' style='width: 466px;'></img>
                            </a>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>";
        } //fim IF tipo de arquivo
    } // fim IF resultado bando
    ?>
    <!--==========================
    Header
============================-->
    <header id="header" class="fixed-top">
        <div class="container">
            <div class="logo float-left">
                <a href="#portfolio" class="scrollto"><img src="img/logo.png" alt="" class="img-fluid"></a>
            </div>

            <nav class="main-nav float-right d-none d-lg-block">
                <ul>
                    <li class="drop-down"><a href="#">Abertura Chamados</a>

                        <ul>
                            <li><a href="http://10.100.1.217/glpi/index.php" target="_blanck">Grupo Servopa</a></li>
                            <li><a href="http://10.130.1.144/glpi " target="_blanck">Consórcio</a></li>
                        </ul>
                    </li>

                    <li><a href="http://10.100.1.217/lista" target="_blanck">Lista Ramais</a></li>
                    <li class="drop-down"><a href="">Departamentos</a>
                        <ul>
                            <li class="drop-down"><a href="#">Consórcio</a>
                                <ul>
                                    <li><a href="http://srvphpprod.consorcio.local/glpi/front/central.php" target="_blanck">Requisição para desenvolvimento de TI</a></li>
                                    <li><a href="consorcio.html" target="_blanck">
                                            <p>Manual de Prevenção à Lavagem de Dinheiro</p>
                                            <p style="font-size: 10px;">(Quarta Edição de 01/10/2020)</p>
                                        </a></li>
                                    <li><a href="https://drive.google.com/file/d/1_xyimZLsBhbM6hir2ldfFyR6FzCyavpU/view?usp=sharing" target="_blanck">Código de Ética e Conduta</a></li>
                                    <li><a href="https://drive.google.com/file/d/1A58CAjID63xNRZQ-bzMUS99orOI5ogjg/view?usp=sharing" target="_blanck">Vídeo Treinamento do Programa de Integridade/PLD</a></li>
                                </ul>
                            </li>
                            <li class="drop-down"><a href="#">R.H</a>
                                <ul>
                                    <li><a href="https://sites.google.com/a/servopa.com.br/rh/home" target="_blanck">Portal R.H</a></li>
                                    <li><a href="revistaacelere/index.html" target="_blanck">Revista Acelere</a></li>
                                </ul>
                            </li>
                            <li><a href="https://sites.google.com/a/servopa.com.br/auditoria/">Auditoria</a></li>
                            <li><a href="https://sites.google.com/servopa.com.br/gestaocompartilhada/gest%C3%A3o-compartilhada">Gestão Compartilhada</a></li>
                            <li class="drop-down"><a href="#">T.I</a>
                                <ul>
                                    <li class="drop-down"><a href="#">HOMOLOGAÇÃO</a>
                                        <ul>
                                            <li><a href="http://smart-tst.gruposervopa.com.br/smartshare/" target="_blanck">SMARTSHARE</a></li>
                                            <li><a href="http://10.100.1.214/unico/index.php" target="_blanck">SISTEMAS</a></li>
                                            <li><a href="http://10.100.1.214/glpi/index.php" target="_blanck">GLPI (Grupo Servopa)</a></li>
                                        
                                        </ul>
                                    </li>
                                    <li><a href="http://10.100.1.223/#/login" target="_blanck">TESTE DRIVER</a></li>
                                    <li><a href="http://10.100.1.217/unico/index.php" target="_blanck">SISTEMAS</a></li>
                                    <li><a href="https://sites.google.com/a/servopa.com.br/manual-grupo-servopa/home" target="_blanck">Manuais / Atualizações / Documentos</a></li>
                                </ul>
                            </li>
                            <li><a href="https://sites.google.com/servopa.com.br/cadastro/home">Cadastro</a></li>
                            <!-- <li class="drop-down"><a href="#">Pecas</a>
                                <ul>
                                    <li><a href="tv/index.php" target="_blanck">TV</a></li>
                                </ul>
                            </li> -->
                            <li class="drop-down"><a href="#">Compras</a>
                                <ul>
                                    <li><a href="https://www.otkweb.com.br/login" target="_blanck">Solicitação Material</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="drop-down"><a href="">Fábrica</a>
                        <ul>
                            <li><a href="https://www.hyundai.com.br/" target="_blanck">Hyundai</a></li>
                            <li><a href="https://carros.peugeot.com.br/" target="_blanck">Peugeot</a></li>
                            <li><a href="https://www.triumphcwb.com.br/" target="_blanck">Triumph</a></li>
                            <li class="drop-down"><a href="#">Audi</a>
                                <ul>
                                    <li><a href="https://auth.portaltecsinapse.com.br/realms/Audi/protocol/openid-connect/auth?response_type=code&client_id=AudiPortal&redirect_uri=https%3A%2F%2Fciaudibrasil.com.br%2F&state=2802%2F2e849bd2-2ad0-4ca3-9a0a-faa6d92a9099&login=true&scope=openid" target="_blanck">Portal Audi</a></li>
                                    <li><a href="https://auditraining.konviva.com.br/lms/#/home" target="_blanck">Training</a></li>
                                    <li><a href="https://grp.volkswagenag.com/isam/sps/authsvc/policy/grpuidpw?Target=https://grp.volkswagenag.com/isam/sps/globalb2x/saml20/logininitial%3FRequestBinding%3DHTTPPost%26PartnerId%3Dhttps%3A//grp.global.volkswagenag.com/isam/sps/spglobal/saml20%26Target%3Dhttps%3A//grp.global.volkswagenag.com/web/module/users" target="_blanck">Portal
                                            Rede VW</a></li>
                                    <li><a href="https://www.revisoesplanejadasaudi.com.br/login.aspx?ReturnUrl=%2f" target="_blanck">Revisões Planejadas</a></li>
                                    <li><a href="https://www.ipsos.com/pt-br" target="_blanck">CSS</a></li>
                                </ul>
                            </li>
                            <li class="drop-down"><a href="#">Honda</a>
                                <ul>
                                    <li><a href="http://www.hondaposvenda.com.br/Portal/adm/Account/Index?ReturnUrl=%2fPortal%2fadm%2f" target="_blanck">Pós vendas Honda</a></li>
                                    <li><a href="https://myhonda.force.com/concessionaria/login?ec=302&inst=61&startURL=%2Fconcessionaria%2Fapex%2FmyHonda_LeadBox%3Fsfdc.tabName%3D01r61000000edb2" target="_blanck">My Honda</a></li>
                                    <li><a href="http://www1.hondaihs.com.br/" target="_blanck">Honda IHS</a></li>
                                </ul>
                            </li>
                            <li class="drop-down"><a href="#">Volkswagen</a>
                                <ul>
                                    <li><a href="http://www.portalredevw.com.br/" target="_blanck">Portal Rede VW</a>
                                    </li>
                                    <li><a href="https://www.vw.com.br/pt.html" target="_blanck">Volkswagen Brasil</a>
                                    </li>
                                    <li><a href="https://portal.cpn.vwg/login/login_en.html" target="_blanck">Portal
                                            CPN</a></li>
                                    <li><a href="https://dcs1.volkswagen.com.br/" target="_blanck">Sivolks / Sincro</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="drop-down"><a href="#">Harley-Davidson</a>
                                <ul>
                                    <li><a href="https://www.harley-davidson.com/br/pt/index.html" target="_blanck">Harley-Davidson</a>
                                    </li>
                                    <li><a href="https://www.theoneharley-davidson.com.br/" target="_blanck">The One
                                            Harley</a></li>
                                    <li><a href="https://www.redwheelharley-davidson.com.br/" target="_blanck">Red Wheel
                                            Harley</a></li>
                                    <li><a href="https://www.h-dnet.com/isam/sps/auth" target="_blanck">Sing On</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="drop-down"><a href="#">Notas Eletrônicas</a>
                        <ul>
                            <li><a href="https://www.renaven.com.br/" target="_blank">RENAVEN-NBS</a></li>
                            <li class="drop-down"><a href="#">DETRAN</a>
                                <ul>
                                    <li><a href="https://www.extratodebito.detran.pr.gov.br/detranextratos/geraExtrato.do?action=iniciarProcesso" target="_blank">Detran PR</a></li>
                                    <li><a href="http://www.detran.sc.gov.br/informacoes/veiculos" target="_blank">Detran SC</a></li>
                                    <li><a href="https://www.detran.ac.gov.br/site/apps/veiculo/consulta/filtro-consulta-veiculo.jsp" target="_blank">Detran AC</a></li>
                                    <li><a href="https://www.detran.al.gov.br/" target="_blank">Detran AL</a></li>
                                    <li><a href="https://digital.detran.am.gov.br/?openModalVeiculo=%2Fveiculo%2Fmultas" target="_blank">Detran AM</a></li>
                                    <li><a href="http://www.detran.ap.gov.br/detranap/veiculo/consulta-de-veiculos/" target="_blank">Detran AP</a></li>
                                    <li><a href="http://www.servicos.detran.ba.gov.br/pages/consultaveiculo/consultaveiculoindex.xhtml" target="_blank">Detran BA</a></li>
                                    <li><a href="http://central.detran.ce.gov.br/central_servicos" target="_blank">Detran CE</a></li>
                                    <li><a href="http://getran.detran.df.gov.br/site/veiculos/consultas/filtroplacarenavam-consultaveiculo.jsp" target="_blank">Detran DF</a></li>
                                    <li><a href="https://publicodetran.es.gov.br/NovoConsultaVeiculoES.asp" target="_blank">Detran ES</a>
                                    </li>
                                    <li><a href="https://www.detran.go.gov.br/psw/#/pages/pagina-inicial" target="_blank">Detran GO</a>
                                    </li>
                                    <li><a href="http://licenciamento.detran.ma.gov.br/Licenciamento/consulta/Home.xhtml" target="_blank">Detran MA</a></li>
                                    <li><a href="https://www.detran.mg.gov.br/veiculos/situacao-do-veiculo/consulta-situacao-do-veiculo" target="_blank">Detran MG</a></li>
                                    <li><a href="https://www.detran.mt.gov.br/" target="_blank">Detran MT</a></li>
                                    <li><a href="http://www.detran.ms.gov.br/consulta-de-debitos/" target="_blank">Detran MS</a></li>
                                    <li><a href="http://www.detran.pa.gov.br/sistransito/detran-web/servicos/veiculos/indexRenavam.jsf" target="_blank">Detran PA</a></li>
                                    <li><a href="http://detran.pb.gov.br/veiculo/consulta-do-veiculo" target="_blank">Detran PB</a></li>
                                    <li><a href="https://www.detran.pe.gov.br/" target="_blank">Detran PE</a></li>
                                    <li><a href="https://webas.sefaz.pi.gov.br/clvn/" target="_blank">Detran PI</a></li>
                                    <li><a href="http://www.detran.rj.gov.br/_monta_aplicacoes.asp?cod=11&amp;tipo=consulta_multa" target="_blank">Detran RJ</a></li>
                                    <li><a href="http://www2.detran.rn.gov.br/externo/consultarveiculo.asp" target="_blank">Detran RN</a>
                                    </li>
                                    <li><a href="https://consulta.detran.ro.gov.br/CentralDeConsultasInternet/Software/ViewConsultaVeiculos.aspx" target="_blank">Detran RO</a></li>
                                    <li><a href="https://www.rr.getran.com.br/site/apps/veiculo/filtroplacarenavam-consultaveiculo.jsp" target="_blank">Detran RR</a></li>
                                    <li><a href="https://www.portaldetransito.rs.gov.br/dtw2/app/servico/vei/consulta-veiculo-form.xhtml" target="_blank">Detran RS</a></li>
                                    <li><a href="https://seguro.detran.se.gov.br/portal/?pg=cons_veiculo" target="_blank">Detran SE</a>
                                    </li>
                                    <li><a href="https://www.ipva.fazenda.sp.gov.br/IPVANET_Consulta/Consulta.aspx" target="_blank">Detran
                                            SP</a></li>
                                    <li><a href="http://www.sefaz2.to.gov.br/ipva/extrato_debito.php" target="_blank">Detran TO</a></li>
                                </ul>
                            </li>
                            <li><a href="http://www.buscacep.correios.com.br/sistemas/buscacep/" target="_blank">Busca
                                    CEP</a></li>
                            <li><a href="http://10.100.1.138/eFormseMonitor/Account/Login" target="_blank">E-monitor</a>
                            </li>
                            <li><a href="http://10.100.1.138/eFormsColdweb/Account/Login" target="_blank">ColdWeb</a>
                            </li>
                            <li><a href="http://srvctpeugeot306:8080/dianfse/servlet/hnfse0001" target="_blank">Dianfse</a></li>
                            <li><a href="http://www.sintegra.gov.br/" target="_blank">Sintegra</a></li>
                            <li><a href="http://www.roseno.info/cidadesconsulta.aspx" target="_blank">Código IBGE</a>
                            </li>
                            <li><a href="https://www.bcb.gov.br/acessoinformacao/legado?url=https:%2F%2Fwww.bcb.gov.br%2Frex%2FCenso2000%2Fport%2Fmanual%2Fpais.asp%3Fidpai%3Dcenso2000inf" target="_blank">Cód. Cidade SISBAGEN</a></li>
                            <li class="drop-down"><a href="#">Notas Eletrônicas</a>
                                <ul>
                                    <li><a href="http://www.notaparana.pr.gov.br/" target="_blank">PR</a></li>
                                    <li><a href="https://fazenda.rs.gov.br/inicial" target="_blank">RS</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="drop-down"><a href="#">Programas</a>
                        <ul>
                            <li><a href="https://cotavw.com.br" target="_blanck">Cotavw</a></li>
                            <li><a href="https://appsmart.gruposervopa.com.br/smartshare/" target="_blanck">SMARTSHARE</a></li>
                            <li><a href="http://10.100.1.223/#/login" target="_blanck">Teste-Driver</a></li>
                            <li><a href="https://mail.google.com/mail/u/0/#inbox" target="_blanck">Gmail</a></li>
                            <li><a href="https://gruposervopa.fluig.com/portal/home" target="_blanck">Fluig</a></li>
                            <li><a href="http://auditt.gruposervopa.local:9080/SISCON/servlet/app" target="_blanck">Siscon</a></li>
                            <li><a href="http://auditt.gruposervopa.local:9080/SERADM/servlet/app" target="_blanck">Seradm</a></li>
                            <li><a href="http://sisrev.gruposervopa.local:9080/SISREV/servlet/app" target="_blanck">Sisrev</a></li>
                            <li><a href="http://intranet.gruposervopa.com.br/appftp.html" target="_blanck">FTP</a></li>
                            <li><a href="http://intranet.gruposervopa.com.br/appftp-sisrev.html" target="_blanck">FTP Sisrev</a></li>
                            <li><a href="https://apps.autoavaliar.com.br/login/app" target="_blanck">Auto Avaliar</a></li>
                            <li><a href="apollo-nbs.rdp" download="">Apollo / NBS</a></li>
                            <li><a href="http://10.100.1.18/WebCRM/Forms/frmLogin.aspx" target="_blanck">Web CRM</a></li>
                            <li><a href="https://fisystem.com.br/fi/" target="_blanck">F&I System</a></li>
                            <li><a href="https://syonet.gruposervopa.com.br/portal/index.jsp" target="_blanck">Syonet CRM</a></li>

                        </ul>
                    </li>
                </ul>
            </nav><!-- .main-nav -->
        </div>
    </header><!-- #header -->
    <main id="main">

        <!--==========================
    Programas
============================-->
        <section id="about">
            <div class="container-vertical">
                <div class="row-vertical">
                    <ul class="programa">
                        <!--SISCON-->
                        <li>
                            <a href="http://auditt.consorcio.local:9080/SISCON/servlet/app" target='_blank' class="programas">
                                <div class="hvr-grow-shadow siscon"></div>
                            </a>
                        </li>
                        <!--SISREV-->
                        <li>
                            <a href="http://sisrev.gruposervopa.local:9080/SISREV/servlet/app" target='_blank' class="programas">
                                <div class="hvr-grow-shadow sisrev"></div>
                            </a>
                        </li>

                        <!--SMART SHARE-->
                        <li>
                            <a href="https://appsmart.gruposervopa.com.br/smartshare/" target="_blank" class="programas">
                                <div class="hvr-grow-shadow smartShare"></div>
                            </a>
                        </li>
                        <!--GMAIL-->
                        <li>
                            <a href="https://mail.google.com/mail/u/0/#inbox" target='_blank' class="programas">
                                <div class="hvr-grow-shadow gmail"></div>
                            </a>
                        </li>
                        <!--PPOV-->
                        <li>
                            <a href='http://10.100.1.77:8090/p-pov-planning/login.xhtml' target="_blank" class="programas">
                                <div class="hvr-grow-shadow ppov"></div>
                            </a>
                        </li>
                        <!--SYONET-->
                        <li>
                            <a href="https://syonet.gruposervopa.com.br/portal/index.jsp" target='_blank' class="programas">
                                <div class="hvr-grow-shadow syonet"></div>
                            </a>
                        </li>
                        <!--FLUIG-->
                        <li>
                            <a href="https://gruposervopa.fluig.com/portal/home" target='_blank' class="programas">
                                <div class="hvr-grow-shadow fluig"></div>
                            </a>
                        </li>
                        <!--ROOVER-->
                        <li>
                            <a href='https://roover.gruposervopa.com.br/' target="_blank" class="programas">
                                <div class="hvr-grow-shadow roover"></div>
                            </a>
                        </li>
                        <!--BI-->
                        <li>
                            <a href="https://srvqlikserver.gruposervopa.com.br" target='_blank' class="programas">
                                <div class="hvr-grow-shadow bi"></div>
                            </a>
                        </li>

                        <!--SYONET CONSORCIO-->
                        <li>
                            <a href="https://syonet.consorcioservopa.com.br" target='_blank' class="programas">
                                <div class="hvr-grow-shadow syonetConsorcio"></div>
                            </a>
                        </li>
                        <!--BI CONSORCIO-->
                        <li>
                                     
                            <a href="https://srvqlikv2.gruposervopa.local/" target='_blank' class="programas">
                                <div class="hvr-grow-shadow biConsorcio"></div>
                            </a>
                        </li>

                        <!--LINX-->
                        <li>
                            <a href='http://10.100.1.171:81/LinxDMSPrincipal/#/login' target="_blank" class="programas" title='funciona penas no navegador Google Chrome'>
                                <div class="hvr-grow-shadow linx"></div>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </section>

        <!--==========================
    Comunicado
============================-->
        <section id="about">
            <div class="container">
                <div class="row about-container">
                    <iframe src="info_blog/index.php" height="3650" width="1300" scrolling="no" style="border: dotted 1px #dbd8d8;"></iframe>
                </div>
                <div class="text-left">
                    <div class="plus">
                        <a href="blog/index.php" class="plus_link"><i class="fa fa-plus" aria-hidden="true"></i> Postagens</a>
                    </div>
                </div>
            </div>
        </section><!-- #Comunicado -->
    </main>



    <!--==========================
    Footer
  ============================-->
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Departamento T.I - Todos os direitos reservados
            </div>
            <div class="credits">
                Responsável pelo desenvolvimento <a href="javascript:">Felipe Lara</a> - Ramal: 110-2151
            </div>
        </div>
    </footer><!-- #footer -->

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/jquery/jquery-migrate.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/mobile-nav/mobile-nav.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <!-- Contact Form JavaScript File -->
    <script src="contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="js/main.js"></script>
    <script src="js/seg.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

    <script>
        var senha = 0;

        if (senha != 1) {
            $('#aviso').modal('show');
        }
    </script>

</body>

</html>