<?php

include '../inc/querys.php';
include '../../unico/api/tokenSelbettiAPI.php';

//array de usuários que não podem ser demitidos                    
$usuariosNaoDemitir = array(
    "everaldo.003403",
    "everaldo.003400",
    "aviso.previo",
    "cadastro.senior",
    "apoio.curitiba",
    "beneficio.servopa",
    "abolicao"
);

//URL para usar dentro da API
$urlAlterarUsuarios = 'https://appsmart.gruposervopa.com.br/smartshare/SmartShareAPI/api/v3/Usuario/AtualizarUsuario';

//Variavel para utilizar no While dentro da tabela para a criação das linhas
$contador = 1;

//Busca usuário ATIVOS na Selbetti e confere na Vetor - 
$querySelbettiDemitidos .= " WHERE idTipoUsuario = '3' AND stAtivo = '1' "; //tipo usuario = 1 e 2 são ADM's
$resultadoSelbetti = $connLocal->query($querySelbettiDemitidos);

//Busca todos os usuários DEMITIDOS
$queryDemitidos = "SELECT * FROM selbetti_users WHERE stAtivo = '0' order by usuario ASC";
$execQueryDemitidos = $connLocal->query($queryDemitidos);

//Montando a tabela com as informações!
echo '
    <div class="container-sn">
        <h4 id="mostrarImportadosDemitidos">Usuários que já estavam demitidos!
            <a href="javascript:mostrarListaDemitidos();"class="alert-link">Mostrar / Esconder</a>
        </h4>
    </div>

    <div id="tabelaImportadosDemitidos" style="display: none; width: 27%;">
        <table class="table table-sm table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <br>
                    <th scope="col">#</th>
                    <th scope="col">Usuário</th>
                </tr>                            
            </thead>
            <tbody>';

                $contagem = 1;

                while ($rowQueryDemitidos = $execQueryDemitidos->fetch_assoc()) {

                    if ($rowQueryDemitidos['stAtivo'] == 0) {
                        echo ' 
                            <tr>
                                <th scope="row">' . $contagem . '</th>
                                <td>' . $rowQueryDemitidos['usuario'] . '</td>
                            </tr>';
                    }

                    $contagem++;
                    
                }

                echo'
            </tbody>
        </table>
    </div>';

//inicio While
while ($rowSelbetti = $resultadoSelbetti->fetch_assoc()) {

    //teste de usuários que não podem ser demitidos
    $achei = in_array($rowSelbetti['usuario'], $usuariosNaoDemitir);

    if (empty($achei)) {
        //Verificando se o usuário Selbetti existe dentro da tabela da Vetor
        $query = "SELECT * FROM vetor_users WHERE usuario = '" . $rowSelbetti['usuario'] . "'";
        $resultado = $connLocal->query($query);
        $rowAlteraUser = $resultado->fetch_assoc();         
        
        //Se o usuario for NULL precisa ter seu status alterado na Selbetti para demitido
        if ($rowAlteraUser['usuario'] == NULL) {

            //Faz a alteração do usuário para demitido através da API com o Selbetti
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $urlAlterarUsuarios,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'PUT',
                    CURLOPT_POSTFIELDS => '{
                                                    "cdUsuario": ' . $rowSelbetti['cdUsuario'] . ',
                                                    "idTipoUsuario": ' . $rowSelbetti['idTipoUsuario'] . ',
                                                    "dsNome": "' . $rowSelbetti['nome'] . '",
                                                    "dsEmail": "' . $rowSelbetti['email'] . '",
                                                    "dsImpressaoDigital": "",
                                                    "dsTelefone": "",
                                                    "vlRamal": "",
                                                    "cdPapelPrincipal": 100,
                                                    "cdAreaPrincipal": 1012,
                                                    "idTipoLogin": 0,
                                                    "idVisaoInicialWF": 1,
                                                    "idVisaoInicial": 1,
                                                    "stPermiteTrocarVisaoInicial": true,
                                                    "vlDiasTrocarSenha": 999,
                                                    "stTrocarSenhaProximoLogin": false,
                                                    "stAusente": false,
                                                    "stAtivo": false,
                                                    "stMobile": true,
                                                    "stIndexador": false
                                                }',
                    CURLOPT_HTTPHEADER => array(
                        'tokenUsuario: ' . $tokenUsuarioSelbetti . '',
                        'dsChaveAutenticacao: ' . $dsChaveAutenticacao . '',
                        'dsCliente: ' . $dsCliente . ' ',
                        'Content-Type: application/json'
                    ),
                )
            );

            $response = curl_exec($curl);

            curl_close($curl);

            /* echo $response; */

            //salvando no relatorio para enviar e-mail
            $insertRelatorioDemitidos = 'INSERT INTO relatorio_demitidos (nome, usuario, email) VALUES 
            ("' . $rowSelbetti['nome'] . '", "' . $rowSelbetti['usuario'] . '", "' . $rowSelbetti['email'] . '")';

            if (!$resultRelatorioDemitidos = $connLocal->query($insertRelatorioDemitidos)) {
                printf("Erro demitidos[1]: %s\n", $connLocal->error);
                exit;
            }

            $connLocal->close();

            $insertVetorDesativ = "INSERT INTO relatorio_users(nome, usuario, email, dessit) VALUES ('" . $rowSelbetti['nome'] . "', '" . $rowSelbetti['usuario'] . "', '" . $rowSelbetti['email'] . "','DESATIVADO')";

            if (!$resultVetorUsuario = $connLocal->query($insertVetorDesativ)) {
                printf("Erro[7]: %s\n", $connLocal->error);
                exit;
            }

            $connLocal->close();

        } // if de array

    }

    

} //fim While

/*----------------------Montando lista de usuários demitidos----------------------------*/
$selectDemitidos = "SELECT * FROM relatorio_demitidos";
$execRelatorioDemitidos = $connLocal->query($selectDemitidos);
$rowRelatorio = $execRelatorioDemitidos->fetch_assoc();

$cont = 1;

if ($rowRelatorio['usuario'] != null) { //se existir da tabela mostra os resultados
    echo '
        <br>
        <div class="container-sm">
            <h2 class="bd-title" id="content">Lista usuarios que foram demitidos</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Nome</td>
                        <td>E-mail</td>
                        <td>Login</td>
                    </tr>
                </thead>
                <tbody>';
                $selectDemitidosS = "SELECT * FROM relatorio_demitidos order by nome ASC";
                $execRelatorioDemitidosS = $connLocal->query($selectDemitidosS);

                while ($rowTabela = $execRelatorioDemitidosS->fetch_assoc()) {
                    echo '
                        <tr>
                            <td>' . $cont . '</td>
                            <td>' . $rowTabela['nome'] . '</td>
                            <td>' . $rowTabela['email'] . '</td>
                            <td>' . $rowTabela['usuario'] . '</td>
                        </tr>';
                    $cont++;
                }
                echo '
                </tbody>
            </table>
        </div>';
} else { //se não existir a tabela mostra os resultados
    echo '<br>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"><i class="fa-solid fa-triangle-exclamation fa-1x"></i> </use></svg>
                <div>
                    &nbsp Não foram encontrados novos colaboradores para a demissão! <a href="javascript:close_tab();" class="alert-link">Fechar</a>
                </div>
            </div>
        </div>';
}
