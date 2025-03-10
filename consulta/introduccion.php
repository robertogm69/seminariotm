<?php include '../includes/templates/nav.php'; 
// Importar la conexion
require '../includes/config/conexiondb.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducción</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s"></script>
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>  
<div class="main-container-intro">  
<?php include '../includes/templates/menu.php';?>
<main class="contenedor_imagen_intro">
<img src="../img/logoInah.png" alt="Logo INAH" class="logo-inah">
    <div class="content-area_intro">
    <div class="contenedor"></div>    
    <div class="formulario__imagen">        
      <div class="contenedor-intro">       
      <div class="contenedor-flex_intro">
        <img class="contenedor-imagen-intro" src="../img/tempmay10.jpg" alt="imagen Intro">
        <div class="contenedor-texto-intro">         
        <h3>Introducción</h3>
                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <h4>Objetivo</h4>
                <p>"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.</p>
                </div>
            </div>
        </div>
    </div>
</main>
        <script src="../js/modernizr.js"></script>
    </body>
</html>
<?php include '../includes/templates/footer.php'; ?>