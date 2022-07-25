<?php

if(isset($_FILES['modeloNota']['name'])){

   $location = "../modelo-nota/";

   /* Getting file name */
   $filename = $_FILES['modeloNota']['name'];

   $newname = $nomearquivo;
  

   $extension  = pathinfo($_FILES["modeloNota"]["name"], PATHINFO_EXTENSION);
   $target_file = $location . basename("not_".$newname.".".$extension);


   /* Upload file */
   if(move_uploaded_file($_FILES['modeloNota']['tmp_name'],$target_file)){
      $response = $target_file;

      $insertAnexoNota = "INSERT INTO cad_anexos
            (ID_LANCARNOTA,
            url_nota)
            VALUES
            ($idlancnota,
            '$target_file');";

            //echo $insertAnexoNota;

      $result = $conn->query($insertAnexoNota);
   }

   echo $target_file;

}else{
   echo "errooooo";
}



if(isset($_FILES['modeloBol']['name'])){

   $location = "../modelo-boleto/";

   /* Getting file name */
   $filename = $_FILES['modeloBol']['name'];

   if (isset($_POST['anexoname'])) {
      $newname = $_POST['anexoname'];
   }else{
      $newname = $nomearquivo;
   }


   $extension  = pathinfo($_FILES["modeloBol"]["name"], PATHINFO_EXTENSION);
   $target_file = $location . basename("bol_".$newname.".".$extension);


   /* Upload file */
   if(move_uploaded_file($_FILES['modeloBol']['tmp_name'],$target_file)){
      $response = $target_file;

      $insertAnexoBol = "INSERT INTO cad_anexos
            (ID_LANCARNOTA,
            url_nota)
            VALUES
            ($idlancnota,
            '$target_file');";

            //echo $insertAnexoBol;

      $result = $conn->query($insertAnexoBol);
   }

   echo $target_file;

}else{
   echo "errooooo";
}




if(isset($_FILES['outrosAnexos']['name'])){

   $location = "../outros-anexos/";

   /* Getting file name */
   $filename = $_FILES['outrosAnexos']['name'];

   if (isset($_POST['anexoname'])) {
      $newname = $_POST['anexoname'];
   }else{
      $newname = $nomearquivo;
   }

   $extension  = pathinfo($_FILES["outrosAnexos"]["name"], PATHINFO_EXTENSION);
   $target_file = $location . basename("ane_".$newname.".".$extension);


   /* Upload file */
   if(move_uploaded_file($_FILES['outrosAnexos']['tmp_name'],$target_file)){
      $response = $target_file;

      $insertAnexoOut = "INSERT INTO cad_anexos
            (ID_LANCARNOTA,
            url_nota)
            VALUES
            ($idlancnota,
            '$target_file');";

            //echo $insertRateioNota;

      $result = $conn->query($insertAnexoOut);
   }

   echo $target_file;

}else{
   echo "errooooo";
}





?>