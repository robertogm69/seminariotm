<?php
    
include '../includes/templates/nav.php';
// Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

$errores = [];   // Arreglo vacio

$sesion_mat = '';
$descrip_mat = '';
$archivo_mat = '';

$resultado = null; // Inicializar la variable resultado

// Verificar si las claves existen en $_POST antes de usarlas
if (isset($_POST['sesion_mat'])) {
    $sesion_mat = mysqli_real_escape_string($con, $_POST['sesion_mat']); // Evitar inyección SQL
}
if (isset($_POST['descrip_mat'])) {
    $descrip_mat = mysqli_real_escape_string($con, $_POST['descrip_mat']); // Evitar inyección SQL
}

    

    // Validar que no haya campos vacíos
    if (!$sesion_mat) {
        $errores[] = "El campo sesión es obligatorio";
    }
    if (!$descrip_mat) {
        $errores[] = "El campo descripción es obligatorio";
    }
    
    

    // Administrar la subida de archivos

   // Administrar la subida de archivos
// Administrar la subida de archivos
if (isset($_FILES['archivo_mat']) && $_FILES['archivo_mat']['error'] === UPLOAD_ERR_OK) {  // Verificar si se subió un archivo
    $fileTmpPath = $_FILES['archivo_mat']['tmp_name']; // Obtener la ruta temporal del archivo
    $fileName = $_FILES['archivo_mat']['name'];
    $fileSize = $_FILES['archivo_mat']['size'];
    $fileType = $_FILES['archivo_mat']['type'];
    $fileNameCmps = explode(".", $fileName); // Obtener el nombre del archivo
    $fileExtension = strtolower(end($fileNameCmps)); // Obtener la extensión del archivo

    // Validar el tipo de archivo
    $allowedfileExtensions = array('pdf', 'jpg', 'jpeg', 'png', 'gif');
    if (!in_array($fileExtension, $allowedfileExtensions)) {
        $errores[] = "Tipo de archivo no permitido. Solo se permiten archivos PDF e imágenes.";
    }

    // Limitar el tamaño del archivo (por ejemplo, 5MB)
    if ($fileSize > 5242880) {
        $errores[] = "El archivo es demasiado grande. El tamaño máximo permitido es de 5MB.";
    }

    // Sanitize the file name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    // Ruta de almacenamiento
    $uploadFileDir = '../upload_material/';
    $dest_path = $uploadFileDir . $newFileName;

    if (empty($errores)) {
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $archivo_mat = $newFileName;
        } else {
            $errores[] = "Error al mover el archivo subido.";
        }
    }
} else {
    $errores[] = "El campo archivo es obligatorio";
}

if (empty($errores)) {
    $query = "INSERT INTO materiales (sesion_mat, descrip_mat, archivo_mat) VALUES ('$sesion_mat', '$descrip_mat', '$archivo_mat')";

    $resultado = mysqli_query($con, $query);

    if ($resultado) {          
        // Redireccionar a la página de resultados
        header('Location: administrar_material.php?resultado=1');
        exit;
    } else {
        $errores[] = "Error al insertar los datos: " . mysqli_error($con);
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Materiales</title>
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
        <h3 class="centrar-texto">Administrar Materiales/Registrar Materiales</h3> 
        <div class="contenedor-principal">
        <div class="contenedor-flex">   
        <nav class="vertical-menu">   
            <ul>
                <li><a href="../material/tablamaterial.php">Editar / Eliminar Materiales</a></li>                        
            </ul>
        </nav>

        <div class="formulario-material-contenedor">            
       <?php if (isset($_GET['resultado']) && intval($_GET['resultado']) === 1): ?>
         <p class="alerta correcto">Material registrado correctamente</p>
         <?php endif; ?>        
               
         <div id="alertContainer"></div>
                        
    <form id="materialForm" enctype="multipart/form-data" class="formulario-material-contenedor" method="POST" action="administrar_material.php">
        <div class="campo">
        <label class="campo__label" for="sesion_mat">Sesión</label>
        <input 
            class="campo__field"
            type="text"
            id="sesion_mat" 
            name="sesion_mat"
            value="<?php echo $sesion_mat; ?>" >       
        </div>

        <div class="campo">
        <label class="campo__label" for="descrip_mat">Descripción</label>        
        <textarea class="campo__field"
               id="descrip_mat"
               name="descrip_mat"><?php echo $descrip_mat ?></textarea>     
        </div>
        
        <div class="campo">
        <label class="campo__label" for="archivo_mat">Archivo</label>
        <input class="campo__field"
               type="file"
               id="archivo_mat" 
               name="archivo_mat">     
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('materialForm');
    const alertContainer = document.getElementById('alertContainer');
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el envío del formulario por defecto

        const sesion_mat = document.getElementById('sesion_mat').value.trim();
        const descrip_mat = document.getElementById('descrip_mat').value.trim();        
        const archivo_mat = document.getElementById('archivo_mat').value;
        let errores = [];

        if (!sesion_mat) {
            errores.push("El campo sesión es obligatorio");
        }        
        if (!descrip_mat) {
            errores.push("El campo descripción es obligatorio");
        }

        if (!archivo_mat) {
            errores.push("El campo archivo es obligatorio");
        }
         
        if (errores.length > 0) {
            mostrarErrores(errores);
        } else {
            form.submit(); // Enviar el formulario si no hay errores
        }
    });

    function mostrarErrores(errores) {            
        alertContainer.innerHTML = ''; // Limpiar alertas anteriores
        const alertDiv = document.createElement('div');
        alertDiv.classList.add('alerta', 'error');
        alertDiv.innerHTML = errores.join('<br>');
        alertContainer.appendChild(alertDiv);

        alertContainer.style.opacity = '1'; // Asegurarse de que la alerta sea visible
        setTimeout(() => {            
            alertContainer.style.transition = 'opacity 1s';    
            alertContainer.style.opacity = '0';
            setTimeout(() => alertContainer.innerHTML = '', 1000);
        }, 4000);
    }

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
<script src="../js/modernizr.js"></script> 
</body>
</html>
<?php include '../includes/templates/footer.php'; ?>