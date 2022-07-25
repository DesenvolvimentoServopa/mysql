<?php

//funcão de conversão de dados HD
function HD($size){
    $filesizename = array(" Bytes", " GB", " TB", " PB", " EB", " ZB", " YB");
    return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
} 
//funcão de converso de dados Memória
function RAM($size){
    $filesizename = array(" Bytes", " GB", " TB", " PB", " EB", " ZB", " YB");
    return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
}

?>