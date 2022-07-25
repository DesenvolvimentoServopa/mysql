<?php
require_once('../conf/conexao.php');

session_start();
$_SESSION['id_workflow'];
$_SESSION['CNPJ'] ;
$_SESSION['IDPORTAL'] ;
$_SESSION['nome'] ;
$_SESSION['id_user'] = $_GET['id_user'];
$_SESSION['idwf'] = $_GET['idwf'];
    
$id_workflow = $_SESSION['id_workflow'];

$cnpj = $_SESSION['CNPJ'] ;

$idportal = $_SESSION['IDPORTAL'] ;

$nome = $_SESSION['nome'] ;

$id_user = $_SESSION['id_user'] ;

$idw = $_SESSION['idwf'] ;


    $delete = "DELETE FROM workflow_user WHERE id_workflow = $idportal";
    $result = $conn->query($delete);
   
    $delete = "DELETE FROM cad_workflow WHERE id_workflow = $id_workflow";
    $result = $conn->query($delete);

    $query = "INSERT INTO cad_workflow (CNPJ,nome,id_workflow,id_user) VALUE ('$cnpj','$nome','$id_workflow','$ID');";
    $result = $conn->query($query);
    $query = "SELECT * FROM cad_workflow ORDER BY ID DESC ";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $ultimo_id = $row['ID'];

        foreach($_GET['id_user'] AS $ID){
            
			
			 $query = "INSERT INTO workflow_user (id_user, id_workflow) VALUES ('$ID','$ultimo_id'); ";
			 $result = $conn->query($query);
            
        }
header('Location: ../front/Sucesso.html');
 $conn-close();
 

?>