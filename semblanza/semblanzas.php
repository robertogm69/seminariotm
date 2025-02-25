<?php
include '../includes/templates/nav.php';
// Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

// Obtener los datos de la tabla semblanzas
$query = "SELECT * FROM semblanzas";
$result = mysqli_query($con, $query);
$semblanzas = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Semblanzas</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s"></script>
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>

<main class="contenedor_imagen">
    <div class="content-area">
    <div class="contenedor"></div>
    <div class="formulario__imagen">
        <img src="../img/logoInah.png" alt="Logo INAH">
        <h3 class="centrar-texto">Semblanzas</h3> 
        <div class="contenedor-principal">
          
    <!-- Mostrar semblanzas -->
    <div class="semblanzas-list">
            <?php foreach ($semblanzas as $semblanza): ?>
                <div class="semblanza-item">
                    <img src="../uploads/<?php echo $semblanza['imagen']; ?>" alt="<?php echo $semblanza['nombre']; ?>" class="small-image" data-sesion="<?php echo $semblanza['sesion']; ?>" data-nombre="<?php echo $semblanza['nombre']; ?>" data-descripcion="<?php echo $semblanza['descripcion']; ?>">
                    <p><?php echo $semblanza['nombre']; ?></p>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal logic
    const modal = document.getElementById("myModal");
    const modalImg = document.querySelector(".modal-content img");
    const modalNombre = document.getElementById("modalNombre");
    const modalDescripcion = document.getElementById("modalDescripcion");
    const modalSesion = document.getElementById("modalSesion");
    const span = document.getElementsByClassName("close")[0];

    document.querySelectorAll('.small-image').forEach(img => {
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            modalNombre.innerHTML = this.getAttribute('data-nombre');
            modalDescripcion.innerHTML = this.getAttribute('data-descripcion');
            modalSesion.innerHTML = this.getAttribute('data-sesion');
        }
    });

    span.onclick = function() { 
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
</script>
<script src="../js/modernizr.js">



</script>
</body>
</html>
<?php include '../includes/templates/footer.php'; ?>