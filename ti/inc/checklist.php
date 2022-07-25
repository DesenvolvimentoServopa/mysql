<?php
session_start();

require_once('../bd/conexao.php');

$dataHoje= date('d/m/Y H:i:s');


//FUNCIONARIO
if(empty($_GET['id'])){
    $id_fun = $_SESSION['id_funcionario'];
}else{
    $id_fun = $_GET['id'];
}

//DEMITINDO FUNCIONÁRIO
if($_POST['demitido'] == 0){//0=sim; 1=não
    $updateDemitido= "UPDATE manager_inventario_funcionario SET status = 8 WHERE id_funcionario = ".$id_fun."";

    if(!$resultUpdate = $conn->query($updateDemitido)){
        printf("Error[1]: %s\n", $conn->error);
        exit;
    }
}

//GERANDO O PDF

//print_r ($_POST['equip']);
//exit();

if ($_POST['equip'] == NULL) {
     //SIM TODOS OS EQUIPAMENTOS

     
    //LIBERAR REMOÇÃO DO EQUIPAMENTO AO USUÁRIO
    $updateLiberar = "UPDATE manager_inventario_equipamento SET liberado_rh = 1 WHERE id_funcionario = ".$id_fun."";

    if(!$resultLiberar = $conn->query($updateLiberar)){
        printf("Erro[1]: %s\n", $conn->error);
    }

    //LEVANDO PARA GERAR O PDF
     if ($_SESSION["perfil"] == 1) {

        header('location: checkpdftecnicos.php?id_fun='.$id_fun.'');

    } else {        

        header('location: checkpdftecnicos.php?id_fun='.$id_fun.'');
    }

   
} else {
    
     //NÃO É TODOS OS EQUIPAMENTOS

     $equip = " WHERE MIE.id_equipamento in (";

     $qte = count($_POST['equip']);
 
     $cont = 1;
 
     foreach ($_POST['equip'] as $id_equipamento) {
         $equip .= $id_equipamento;
 
         if ($qte == $cont) {
             $equip .= ")";
         } else {
             $equip .= ",";
         }
 
         $cont++;
     }

     //LIBERAR REMOÇÃO DO EQUIPAMENTO AO USUÁRIO
    $updateLiberar = "UPDATE manager_inventario_equipamento MIE SET MIE.liberado_rh = 1 ".$equip."";

    if(!$resultLiberar = $conn->query($updateLiberar)){
        printf("Erro[1]: %s\n", $conn->error);
    }
      
 
     if ($_SESSION["perfil"] == 1) {
         header('Location: checkpdftecnicos.php?query=' . $equip . '');
     } else {
         header('Location: checkpdftecnicos.php?query=' . $equip . '');
     }
   
}
