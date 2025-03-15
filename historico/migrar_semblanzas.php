<?php
include '../includes/templates/nav.php';

// Conexion a la base de datos
require '../includes/config/conexiondb.php';
$con = conectarDB();

// Migrar las semblanzas a la tabla de historico
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "INSERT INTO historico_semblanzas (sesion, nombre, descripcion, imagen, ciclo, activo)
              SELECT sesion, nombre, descripcion, imagen, ciclo, activo FROM semblanzas";
    $resultado = mysqli_query($con, $query);


    // Verificar si la migración fue exitosa
    if ($resultado) {
        echo "<script>alert('Migración de semblanzas completada exitosamente');</script>";
    } else {
        echo "<script>alert('Error en la migración de semblanzas: " . mysqli_error($con) . "');</script>";
    }
}
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
        <form method="POST">
    <button type="submit">Migrar Semblanzas a Ciclos Pasados</button>
</form>
 </div>
</div>
</main>
</div> 

<!-- Modal -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("myModal");
    const modalImg = document.querySelector(".modal-content img");
    const modalNombre = document.getElementById("modalNombre");
    const modalDescripcion = document.getElementById("modalDescripcion");
    const modalSesion = document.getElementById("modalSesion");
    const images = document.querySelectorAll('.small-image');

    images.forEach(img => {
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            modalNombre.innerHTML = this.getAttribute('data-nombre');
            modalDescripcion.innerHTML = this.getAttribute('data-descripcion');
            modalSesion.innerHTML = this.getAttribute('data-sesion');
        }
    });

    modal.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    document.querySelector('.close').onclick = function() {
        modal.style.display = "none";
    }
});
</script> 

<script src="../js/modernizr.js">

</script>
</body>
</html>
<?php include '../includes/templates/footer.php'; ?>