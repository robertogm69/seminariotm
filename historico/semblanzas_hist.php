
<?php
include '../includes/templates/nav.php';
require '../includes/config/conexiondb.php';
$con = conectarDB();

$query = "SELECT * FROM historico_semblanzas";
$result = mysqli_query($con, $query);
$semblanzas = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semblanzas Ciclos Pasados</title>
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
        <h3 class="centrar-texto">Semblanzas Ciclos Pasados</h3> 
        <div class="contenedor-principal">
        
          
    <!-- Mostrar semblanzas -->
    <div class="semblanzas-list">
            <?php foreach ($semblanzas as $semblanza): ?>
            <?php 
            // Validar y sanitizar los datos
            $sesion = htmlspecialchars($semblanza['sesion'], ENT_QUOTES, 'UTF-8');
            $nombre = htmlspecialchars($semblanza['nombre'], ENT_QUOTES, 'UTF-8');
            $descripcion = htmlspecialchars($semblanza['descripcion'], ENT_QUOTES, 'UTF-8');
            $imagen = htmlspecialchars($semblanza['imagen'], ENT_QUOTES, 'UTF-8');
            $imagenPath = "../uploads/$imagen";

            // Verificar si la imagen existe
            if (!file_exists($imagenPath)) {
                $imagenPath = "../img/default.png"; // Imagen por defecto si no existe
            }
            ?>
                 <div class="semblanza-item">
                <p class="sesion-label"><?php echo $sesion; ?></p>                
                <img src="<?php echo $imagenPath; ?>" alt="<?php echo $nombre; ?>" class="small-image" data-sesion="<?php echo $sesion; ?>" data-nombre="<?php echo $nombre; ?>" data-descripcion="<?php echo $descripcion; ?>">
              </div>
            <?php endforeach; ?>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <img src="" alt="Imagen de la semblanza">
                <div class="text">
                    <h3 id="modalNombre"></h3>
                    <p id="modalDescripcion"></p>
                    <p id="modalSesion"></p>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
</main>

<script src="../js/modernizr.js">

</script>
</body>
</html>
<?php include '../includes/templates/footer.php'; ?>