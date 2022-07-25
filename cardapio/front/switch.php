<?php

    
switch ($_GET['id']) {
    case 1:
        $nome = "Servopa Matriz Tradicional";
        $campoData = "../cardapios/principal.pdf";
        $campoDataDuchef = "../cardapios/duchef.pdf";
        $nomeDuchef = "Servopa Matriz <a href='javascript:'>DuChef</a>";
        $duchef = 'block';
        break;
    case 2:
        $nome = "Caminhões Curitiba";
        $campoData = "../cardapios/caminhoescuritiba.pdf";
        $campoDataDuchef = "../cardapios/duchef.pdf";
        $nomeDuchef = "...";
        $duchef = 'none';
        break;
    case 3:
        $nome = "Caminhões Cambé";        
        $campoData = "../cardapios/caminhoescambe.pdf";
        $campoDataDuchef = "../cardapios/duchef.pdf";
        $nomeDuchef = "...";
        $duchef = 'none';
        break;
}

?>