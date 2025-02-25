<?php

include '../includes/templates/nav.php';
// Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

$errores = [];   // Arreglo vacio

$sesion = '';
$nombre = '';
$descripcion = '';
$ciclo = '';
$activo = isset($_POST['activo']) ? 1 : 0;
$resultado = null; // Inicializar la variable resultado


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Manejar la subida de la imagen
$imagen = $_FILES['imagen']['name'];
$imagen_tmp = $_FILES['imagen']['tmp_name'];
$imagen_folder = '../uploads/' . $imagen;


if (move_uploaded_file($imagen_tmp, $imagen_folder)) {

    $sesion = mysqli_real_escape_string($con, $_POST['sesion']); // Evitar inyección SQL
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']); // Evitar inyección SQL
    $descripcion = mysqli_real_escape_string($con, $_POST['descripcion']); // Evitar inyección SQL
    $ciclo = mysqli_real_escape_string($con, $_POST['ciclo']); // Evitar inyección SQL

    // Validar que no haya campos vacíos
    if (!$sesion) {
        $errores[] = "El campo Sesión es obligatorio";
    }
    if (!$nombre) {
        $errores[] = "El campo Nombre es obligatorio";
    }
    if (!$descripcion) {
        $errores[] = "El campo Descripción es obligatorio";
    }
    if (!$ciclo) {
        $errores[] = "El campo Ciclo es obligatorio";
    }

    if (empty($errores)) {
    $query = "INSERT INTO semblanzas (sesion, nombre, descripcion, imagen, ciclo, activo) VALUES ('$sesion', '$nombre', '$descripcion', '$imagen', '$ciclo', '$activo')";

    $resultado = mysqli_query($con, $query);

    if ($resultado) {
        
        // Redireccionar a la página de resultados
        header('Location: administrar_semblanzas.php?resultado=1');
        exit;
        } else {
            $errores[] = "Error al insertar los datos: " . mysqli_error($con);
        }
    }
}

}
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
        <h3 class="centrar-texto">Administrar Semblanzas/Registrar Semblanzas</h3> 
        <div class="contenedor-principal">
        <div class="contenedor-flex">   
        <nav class="vertical-menu">   
            <ul>
                <li><a href="../semblanza/tablasemblanza.php">Editar / Eliminar Semblanzas</a></li>                        
            </ul>
        </nav>

        <div class="formulario-semblanza-contenedor">            
       <?php if (isset($_GET['resultado']) && intval($_GET['resultado']) === 1): ?>
         <p class="alerta correcto">Semblanza registrada correctamente</p>
         <?php endif; ?>        
               
         <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
            </div>
            <?php endforeach; ?>       
                        
    <form id="ponenteForm" enctype="multipart/form-data" class="formulario-semblanza-contenedor" method="POST" action="administrar_semblanzas.php">
        <div class="campo">
        <label class="campo__label" for="sesion">Sesión:</label>
        <input 
            class="campo__field"
            type="text"
            id="sesion" 
            name="sesion"
            value="<?php echo $sesion; ?>" >       
        </div>

        <div class="campo">
        <label class="campo__label" for="nombre">Nombre del Ponente:</label>        
        <input class="campo__field"
              type="text"
              id="nombre" 
              name="nombre"
              value="<?php echo $nombre; ?>" >     
        </div>
        
        <div class="campo">
        <label class="campo__label" for="descripcion">Descripción:</label>
        <textarea class="campo__field"
                id="descripcion"
                name="descripcion">
            <?php echo $descripcion; ?>
        </textarea>
        </div>
        
        <div class="campo">
        <label class="campo__label" for="imagen">Imagen:</label>
        <input class="campo__field"
              type="file"
              id="imagen"
              name="imagen"
              accept="image/*">
        </div>
        
        <div class="campo">
        <label class="campo__label" for="ciclo">Nombre del Ciclo:</label>
        <input class="campo__field"
               type="text"
               id="ciclo"
               name="ciclo">
               <?php echo $ciclo; ?>
        </div>

        <div class="campo">
        <label class="campo__label" for="activo">Ciclo Activo:</label>
        <input class="campo__field"
               type="checkbox"
               id="activo" 
               name="activo" 
               <?php echo $activo ? 'checked' : ''; ?>>
          </div>     

         <div> 
        <button type="submit">Enviar</button>
        <button type="button" onclick="location.href='../index.php'">Salir</button>
        <button type="button" onclick="location.href='../admin/registro.php'">Volver</button>
        <button type="reset">Limpiar</button>
         </div> 
    </form>
   </div>
</div>
</div>
</div>
</main>
    <script src="../js/modernizr.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('ponenteForm');
    form.addEventListener('submit', function(event) {
        const sesion = document.getElementById('sesion').value.trim();
        const nombre = document.getElementById('nombre').value.trim();
        const descripcion = document.getElementById('descripcion').value.trim();
        const ciclo = document.getElementById('ciclo').value.trim();
        let errores = [];

        if (!sesion) {
            errores.push("El campo Sesión es obligatorio");
        }
        if (!nombre) {
            errores.push("El campo Nombre es obligatorio");
        }
        if (!descripcion) {
            errores.push("El campo Descripción es obligatorio");
        }
        if (!ciclo) {
            errores.push("El campo Ciclo es obligatorio");
        }
       
        if (errores.length > 0) {
            event.preventDefault();
            const alertContainer = document.createElement('div');
            alertContainer.classList.add('alerta', 'error');
            alertContainer.innerHTML = errores.join('<br>');
            form.prepend(alertContainer);

            setTimeout(() => {
                alertContainer.style.transition = 'opacity 1s';
                alertContainer.style.opacity = '0';
                setTimeout(() => alertContainer.remove(), 1000);
            }, 4000);
        }
    });

     // Ocultar la alerta de éxito después de unos segundos
     const successAlert = document.querySelector('.alerta.correcto');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 1s';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 1000);
        }, 4000);
    }
});
</script>
</body>
</html>
<?php include '../includes/templates/footer.php'; ?>