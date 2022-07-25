<?php
require_once('../../../config/databases.php');

$droptable = "DROP TABLE IF EXISTS `empresas_bpmgp`;";

$sucess = $conn->query($droptable);


if($sucess){
    echo 'Tabela Excluida com sucesso';
}else{
    echo 'Erro ao excluir';
}

// Empresas tablea mysql

$createTableEmp = "CREATE TABLE `empresas_bpmgp` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `NOME_EMPRESA` VARCHAR(80) NULL,
    `SISTEMA` VARCHAR(1) NULL,
    `EMPRESA_APOLLO` VARCHAR(10) NULL,
    `REVENDA_APOLLO` VARCHAR(10) NULL,
    `EMPRESA_NBS` VARCHAR(10) NULL,
    `ORGANOGRAMA_SENIOR` VARCHAR(3) NULL,
    `EMPRESA_SENIOR` VARCHAR(10) NULL,
    `FILIAL_SENIOR` VARCHAR(10) NULL,
    `ID_EMPRESA` VARCHAR(10) NULL,
    `SITUACAO` VARCHAR(1) NULL,
    `CONSORCIO` VARCHAR(1) NULL,
    `NUMERO_CAIXA` VARCHAR(5) NULL,
    `APROVADOR_CAIXA` VARCHAR(100) NULL,
    `UF_GESTAO` VARCHAR(2) NULL,
    PRIMARY KEY (`id`));";

$execCreate = $conn->query($createTableEmp);

if($execCreate){
    echo "Importação feita com sucesso";
}else{
    echo "Erro na importação";
}

$url = "http://10.100.1.216/smartshare/inc/smartApi.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
$resultado = json_decode(curl_exec($ch));

// var_dump($resultado);

foreach ($resultado->empresaSmart as $empSmart) {


    $querySmart = "INSERT INTO empresas_bpmgp 
                            (NOME_EMPRESA,SISTEMA,UF_GESTAO,CONSORCIO,APROVADOR_CAIXA,NUMERO_CAIXA,FILIAL_SENIOR,ID_EMPRESA,EMPRESA_SENIOR,
                            ORGANOGRAMA_SENIOR,EMPRESA_APOLLO,REVENDA_APOLLO,SITUACAO,EMPRESA_NBS)
   
    VALUES ('" . $empSmart->EMPRESA ."',
            '" . $empSmart->SISTEMA . "',
            '" . $empSmart->UF . "' ,
            '" . $empSmart->CONSORCIO ."',
            '" . $empSmart->APROVADOR_CAIXA ."',
            '" . $empSmart->NUMERO_CAIXA ."',
            '" . $empSmart->FILIAL_SENIOR ."',
            '" . $empSmart->ID ."',
            '" . $empSmart->EMPRESA_SENIOR ."',
            '" . $empSmart->ORGANOGRAMA_SENIOR ."',
            '" . $empSmart->EMPRESA_APOLLO ."',
            '" . $empSmart->REVENDA_APOLLO ."',
            '" . $empSmart->SITUACAO . "',
            '" . $empSmart->EMPRESA_NBS ."'
            )";
    
    if (!$execQuery = $conn->query($querySmart)) {
        echo "Error: " . $querySmart . "<br>" . $conn->error;
    }
    
    

// switch para a tabela em baixo
    switch ($empSmart->SISTEMA) {
        case "A":
            $sistema = "APOLLO";
            break;
        case "N":
            $sistema = "BANCO NBS";
            break;
        case "H":
            $sistema = "BANCO HARLEY";
            break;
        case " ":
            $sistema = "EMPRESA QUE NÃO USA SISTEMA ERP";
            break;
        case "0":
            $sistema = "EMPRESA QUE NÃO USA SISTEMA ERP";
            break;
    }

$consorcio = ($empSmart->CONSORCIO == 'S') ? 'SIM' : 'NÃO';

$situacao = ($empSmart->SITUACAO == 'A') ? 'ATIVO' : 'DESATIVADO';

$valueApollo = ($empSmart->EMPAPOLLO == 0) ? '' : $empSmart->EMPAPOLLO;

$valueRevApollo = ($empSmart->REVAPOLLO == 0) ? '' : $empSmart->REVAPOLLO;

$valueEmpNbs = ($empSmart->EMPNBS == 0) ? '' : $empSmart->EMPNBS;


    $tabela .= '
                    <tr>
                        <td>'.$empSmart->ID.'</td>
                        <td>'.$empSmart->EMPRESA.'</td>
                        <td>'.$empSmart->UF.'</td>
                        <td>'.$sistema.'</td>
                        <td>'.$consorcio.'</td>
                        <td>'.$situacao.'</td>
                        <td><a href="editEmp.php?pg=2&tela=3&ID='.$empSmart->ID.'" title="Editar" class="btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                            
                            <a href="#" title="Desativar" class="btn-danger btn-sm"><i class="bi bi-trash"></i></a>

                            <a href="#" title="Exibir mais informações" class="btn-info btn-sm"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>';


}                    
                        

