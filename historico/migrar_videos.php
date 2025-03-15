<?php
include '../includes/templates/nav.php';

//conexion a la base de datos
require '../includes/config/conexiondb.php';
$con = conectarDB();

// Migración de videos a la tabla histórico_videos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "INSERT INTO historico_videos (sesion_vid, fecha_vid, descripcion_vid, nombre_pon, fuente_vid, url_video)
              SELECT sesion_vid, fecha_vid, descripcion_vid, nombre_pon, fuente_vid, url_video FROM videos";
    $resultado = mysqli_query($con, $query);

    if ($resultado) {
        echo "<script>alert('Migración de videos completada exitosamente');</script>";
    } else {
        echo "<script>alert('Error en la migración de videos: " . mysqli_error($con) . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos Ciclos Pasados</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s"></script>
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>
<div class="conten-menu-principal">
<?php include '../includes/templates/menu.php';?>
<main class="contenedor_imagen">
    <div class="content-area">
    <div class="contenedor"></div>
    <div class="formulario__imagen">
        <img src="../img/logoInah.png" alt="Logo INAH">
        <h3 class="centrar-texto">Migración de Videos a Ciclos Pasados</h3> 
        <div class="contenedor-principal">
        <form method="POST">
            <button type="submit">Migrar Videos a Ciclos Pasados</button>
        </form>        
        </div>
    </div>
</main>
</div> 
      
  

<script src="../js/modernizr.js">

</script>
</body>
</html>
<?php include '../includes/templates/footer.php'; ?>