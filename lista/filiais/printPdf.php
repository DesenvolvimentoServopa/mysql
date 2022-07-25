<?php

$filial = $_GET['locations'];

$linhas = 65;

$linhaAtual = 0;

//banco
include('conexao.php'); 

//criando a pesquisa
$query = "SELECT GU.id, GU.realname AS nome, GU.phone AS ramal, GC.name AS departamento, L.name AS filial
FROM glpi_users GU
LEFT JOIN glpi_useremails GUM ON GUM.users_id = GU.id
LEFT JOIN glpi_locations L ON GU.locations_id = L.id
LEFT JOIN glpi_usercategories GC ON GC.id = GU.usercategories_id

WHERE GU.locations_id = ".$filial."  AND GU.is_deleted = 0 ORDER BY GU.realname ASC";

$resultado = mysqli_query($conn, $query);


$pdf = '
    <heade>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">        
    </heade>
    <style>';

$pdf .= '.table{font-size: 8px;width: 275px;}';

    $pdf .= '
    .table2 {
        position: absolute;
        top: 0px;
        left: 281px;
    }
    .table3 {
        position: absolute;
        top: 0px;
        left: 562px;
    }
    .table4 {
        position: absolute;
        top: 0px;
        left: 845px;
    }
    .table5 {
        position: absolute;
        top: 1419px;
        left: 281px;
    }    
    </style>
    <body>
        <table class="table table-sm table-striped table-bordered table1">
            <thead>
                <tr>
                    <th data-field="id">Departamento</th>
                    <th data-field="name">Ramal</th>
                    <th data-field="price">Nome</th>
                </tr>
            </thead>
            <tbody>';  

            while($row = mysqli_fetch_assoc($resultado)){

                if($linhaAtual < $linhas){

                    $pdf .= '<tr>';
                    $pdf .= '<td>'.$row["departamento"].'</td>';
                    $pdf .= '<td>'.$row["ramal"].'</td>';
                    $pdf .= '<td>'.$row["nome"].'</td>';
                    $pdf .= '</tr>';                    

                }elseif($linhaAtual == $linhas){
                    $pdf .= '</tbody></table>';

                    $pdf .= '<table class="table table-sm table-striped table-bordered table2">
                        <thead>
                            <tr>
                                <th data-field="id">Departamento</th>
                                <th data-field="name">Ramal</th>
                                <th data-field="price">Nome</th>
                            </tr>
                        </thead>
                        <tbody>';

                        $pdf .= '<tr>';
                        $pdf .= '<td>'.$row["departamento"].'</td>';
                        $pdf .= '<td>'.$row["ramal"].'</td>';
                        $pdf .= '<td>'.$row["nome"].'</td>';
                        $pdf .= '</tr>';
                }elseif($linhaAtual == ($linhas + $linhas)){
                    $pdf .= '</tbody></table>';

                    $pdf .= '<table class="table table-sm table-striped table-bordered table3">
                        <thead>
                            <tr>
                                <th data-field="id">Departamento</th>
                                <th data-field="name">Ramal</th>
                                <th data-field="price">Nome</th>
                            </tr>
                        </thead>
                        <tbody>';

                        $pdf .= '<tr>';
                        $pdf .= '<td>'.$row["departamento"].'</td>';
                        $pdf .= '<td>'.$row["ramal"].'</td>';
                        $pdf .= '<td>'.$row["nome"].'</td>';
                        $pdf .= '</tr>';
                }elseif($linhaAtual == ($linhas + $linhas + $linhas)){

                        $pdf .= '</tbody></table>';

                        $pdf .= '<table class="table table-sm table-striped table-bordered table4">
                                    <thead>
                                        <tr>
                                            <th data-field="id">Departamento</th>
                                            <th data-field="name">Ramal</th>
                                            <th data-field="price">Nome</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                        $pdf .= '<tr>';
                        $pdf .= '<td>'.$row["departamento"].'</td>';
                        $pdf .= '<td>'.$row["ramal"].'</td>';
                        $pdf .= '<td>'.$row["nome"].'</td>';
                        $pdf .= '</tr>';
                }elseif($linhaAtual == ($linhas + $linhas + $linhas + $linhas)){
                        $pdf .= '</tbody></table>';

                        $pdf .= '<table class="table table-sm table-striped table-bordered table5">
                                    <thead>
                                        <tr>
                                            <th data-field="id">Departamento</th>
                                            <th data-field="name">Ramal</th>
                                            <th data-field="price">Nome</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                        $pdf .= '<tr>';
                        $pdf .= '<td>'.$row["departamento"].'</td>';
                        $pdf .= '<td>'.$row["ramal"].'</td>';
                        $pdf .= '<td>'.$row["nome"].'</td>';
                        $pdf .= '</tr>';
                }elseif($linhaAtual == ($linhas + $linhas + $linhas + $linhas + $linhas)){
                    $pdf .= '</tbody></table>';

                    $pdf .= '<table class="table table-sm table-striped table-bordered table6">
                                <thead>
                                    <tr>
                                        <th data-field="id">Departamento</th>
                                        <th data-field="name">Ramal</th>
                                        <th data-field="price">Nome</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    $pdf .= '<tr>';
                    $pdf .= '<td>'.$row["departamento"].'</td>';
                    $pdf .= '<td>'.$row["ramal"].'</td>';
                    $pdf .= '<td>'.$row["nome"].'</td>';
                    $pdf .= '</tr>';
            }elseif($linhaAtual == ($linhas + $linhas + $linhas + $linhas + $linhas)){
                $pdf .= '</tbody></table>';

                $pdf .= '<table class="table table-sm table-striped table-bordered table7">
                            <thead>
                                <tr>
                                    <th data-field="id">Departamento</th>
                                    <th data-field="name">Ramal</th>
                                    <th data-field="price">Nome</th>
                                </tr>
                            </thead>
                            <tbody>';

                $pdf .= '<tr>';
                $pdf .= '<td>'.$row["departamento"].'</td>';
                $pdf .= '<td>'.$row["ramal"].'</td>';
                $pdf .= '<td>'.$row["nome"].'</td>';
                $pdf .= '</tr>';
            }else{
                $pdf .= '<tr>';
                $pdf .= '<td>'.$row["departamento"].'</td>';
                $pdf .= '<td>'.$row["ramal"].'</td>';
                $pdf .= '<td>'.$row["nome"].'</td>';
                $pdf .= '</tr>';
            }                                      

                $linhaAtual++;
                
            }

$pdf .= '</tbody></table></body>';

mysqli_close($conn);

if(!empty($filial)){
    echo $pdf;
    exit;
}

require_once 'dompdf/autoload.inc.php';
require_once 'dompdf/lib/html5lib/Parser.php';
require_once 'dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'dompdf/lib/php-svg-lib/src/autoload.php';
require_once 'dompdf/src/Autoloader.php';

Dompdf\Autoloader::register();

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($pdf);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('lista_ramal.pdf',array("Attachment"=>0));//1 - Download 0 - Previa
