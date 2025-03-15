<?php
include '../includes/templates/nav.php';
// Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

$query = "SELECT * FROM historico_videos";
$result = mysqli_query($con, $query);
$videos = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
        <h3 class="centrar-texto">Videos Ciclos Pasados</h3> 
        <div class="contenedor-principal">
        
          
    <!-- Mostrar videos -->
    <div class="videos-list">
            <?php foreach ($videos as $video): ?>
            <?php 
            // Validar y sanitizar los datos
            $sesion = htmlspecialchars($video['sesion_vid'], ENT_QUOTES, 'UTF-8');
            $fecha = htmlspecialchars($video['fecha_vid'], ENT_QUOTES, 'UTF-8');
            $descripcion = htmlspecialchars($video['descripcion_vid'], ENT_QUOTES, 'UTF-8');
            $nombre = htmlspecialchars($video['nombre_pon'], ENT_QUOTES, 'UTF-8');
            $fuente = htmlspecialchars($video['fuente_vid'], ENT_QUOTES, 'UTF-8');
            $url = htmlspecialchars($video['url_video'], ENT_QUOTES, 'UTF-8');
            ?>
                 <div class="video-item">
                <p class="sesion-label"><?php echo $sesion; ?></p>                
                <p class="fecha-label"><?php echo $fecha; ?></p>
                <p class="descripcion-label"><?php echo $descripcion; ?></p>
                <p class="nombre-label"><?php echo $nombre; ?></p>
                <p class="fuente-label"><?php echo $fuente; ?></p>
                <a href="<?php echo $url; ?>" target="_blank">Ver Video</a>
              </div>
            <?php endforeach; ?>
        </div>
        </div>
    </div>
    </div>
</div>
</main>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoLinks = document.querySelectorAll('.video-item a');

    videoLinks.forEach(link => {
        link.onclick = function(event) {
            const url = this.href;
            if (!url) {
                event.preventDefault();
                alert('URL del video no disponible');
            }
        }
    });
});
</script>


<script src="../js/modernizr.js">

</script>
</body>
</html>
<?php include '../includes/templates/footer.php'; ?>