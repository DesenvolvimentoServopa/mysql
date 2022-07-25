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


//SALVANDO OBSERVAÇÃO
if($_POST['msn'] != NULL){
    $insertOBS = "INSERT INTO manager_inventario_obs (id_funcionario, usuario, obs, data_criacao) 
    VALUES ('".$id_fun."', '".$_SESSION['id']."', '".$_POST['msn']."', '".$dataHoje."')";

    if(!$resultOBS = $conn->query($insertOBS)){
        printf("Error[1]: %s\n", $conn->error);
        exit;
    }
}

//GERANDO O TERMO

if ($_POST['equip'] == NULL) {

        header('location: termogeral.php?id_fun='.$id_fun.'');

} else {
    
     //não é todos os equipamentos
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
         header('Location: termogeral.php?query=' . $equip . '');
}


