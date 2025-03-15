<?php
include '../includes/templates/nav.php';
// Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();


$query = "SELECT * FROM historico_materiales";
$result = $con->query($query);

// Si tuvo éxito la consulta a la base de datos, entonces:  
if ($result) {
    $materiales = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $materiales = [];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Ciclos Pasados</title>
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
        <h3 class="centrar-texto">Material Ciclos Pasados</h3> 
        <div class="contenedor-principal">
        
          
    <!-- Mostrar materiales -->
    <div class="materiales-list">
            <?php foreach ($materiales as $material): ?>
            <?php 
            // Validar y sanitizar los datos
            $sesion = htmlspecialchars($material['sesion_mat'], ENT_QUOTES, 'UTF-8');
            $descripcion = htmlspecialchars($material['descrip_mat'], ENT_QUOTES, 'UTF-8');
            $archivo = htmlspecialchars($material['archivo_mat'], ENT_QUOTES, 'UTF-8');
            ?>
                 <div class="material-item">
                <p class="sesion-label"><?php echo $sesion; ?></p>                
                <p class="descripcion-label"><?php echo $descripcion; ?></p>
                <a href="../upload_material/<?php echo $archivo; ?>" target="_blank">Ver Material</a>
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
    const materialLinks = document.querySelectorAll('.material-item a');

    materialLinks.forEach(link => {
        link.onclick = function(event) {
            const url = this.href;
            if (!url) {
                event.preventDefault();
                alert('Archivo del material no disponible');
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