<?php 

function conectarDB() : mysqli {
    $con = mysqli_connect ('localhost', 'root', 'rmgm1969', 'seminario_tm');
      
   if(!$con) {
        echo "Error no se pudo conectar";
        exit;
   }
      return $con;
  }
   
