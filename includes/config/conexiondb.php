<?php 
function conectarDB() : mysqli {
    $con = mysqli_connect ('localhost', 'root', 'root', 'seminario_tm');
      
   if(!$con) {
        echo "Error no se pudo conectar";
        exit;
   }
      return $con;
  }
   
