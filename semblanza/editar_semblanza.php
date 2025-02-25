<?php
include '../includes/templates/nav.php';

require '../includes/config/conexiondb.php';
$con = conectarDB();


$id = $_GET['id'];
$query = "SELECT * FROM semblanzas WHERE id = $id";
$resultado = mysqli_query($con, $query);
$semblanza = mysqli_fetch_assoc($resultado);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sesion = mysqli_real_escape_string($con, $_POST['sesion']);
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($con, $_POST['descripcion']);
    $ciclo = mysqli_real_escape_string($con, $_POST['ciclo']);
    $activo = isset($_POST['activo']) ? 1 : 0;

    $imagen = $_FILES['imagen'];
    $nombreImagen = '';

    if ($imagen['error'] === UPLOAD_ERR_OK) {
        $carpetaImagenes = '../uploads/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes, 0755, true);
        }

        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
    }

    // Actualizar la base de datos con la nueva imagen si se ha subido una
    if ($nombreImagen) {
        $query = "UPDATE semblanzas SET sesion = '$sesion', nombre = '$nombre', descripcion = '$descripcion', ciclo = '$ciclo', activo = '$activo', imagen = '$nombreImagen' WHERE id = $id";
    } else {
        $query = "UPDATE semblanzas SET sesion = '$sesion', nombre = '$nombre', descripcion = '$descripcion', ciclo = '$ciclo', activo = '$activo' WHERE id = $id";
    }

    $resultado = mysqli_query($con, $query);

      if ($resultado) {
        header('Location: tablasemblanza.php');
        exit;
    } else {
        echo "Error al actualizar la semblanza: " . mysqli_error($con);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    // Definir tipos de archivo permitidos y tamaño máximo
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxFileSize = 2 * 1024 * 1024; // 2 MB

    // Manejar la carga de la imagen
    $imagen = $_FILES['imagen'];
    $nombreImagen = '';

    if ($imagen['error'] === UPLOAD_ERR_OK) {
        // Validar el tipo de archivo
        if (!in_array($imagen['type'], $allowedTypes)) {
            echo "Error: Tipo de archivo no permitido.";
            exit;
        }

        // Validar el tamaño del archivo
        if ($imagen['size'] > $maxFileSize) {
            echo "Error: El archivo es demasiado grande.";
            exit;
        }

        $carpetaImagenes = '../uploads/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes, 0755, true);
        }

        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
    }

    // Actualizar la base de datos con la nueva imagen si se ha subido una
    if ($nombreImagen) {
        $query = "UPDATE semblanzas SET sesion = '$sesion', nombre = '$nombre', descripcion = '$descripcion', ciclo = '$ciclo', activo = '$activo', imagen = '$nombreImagen' WHERE id = $id";
    } else {
        $query = "UPDATE semblanzas SET sesion = '$sesion', nombre = '$nombre', descripcion = '$descripcion', ciclo = '$ciclo', activo = '$activo' WHERE id = $id";
    }

    $resultado = mysqli_query($con, $query);
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
   
    // Manejar la carga de la imagen
    $imagen = $_FILES['imagen'];
    $nombreImagen = '';

    if ($imagen['error'] === UPLOAD_ERR_OK) {
        // Validar el tipo de archivo
        if (!in_array($imagen['type'], $allowedTypes)) {
            echo "Error: Tipo de archivo no permitido.";
            exit;
        }

        // Validar el tamaño del archivo
        if ($imagen['size'] > $maxFileSize) {
            echo "Error: El archivo es demasiado grande.";
            exit;
        }

        $carpetaImagenes = '../uploads/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes, 0755, true);
        }

        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
    } else {
        echo "Error al subir la imagen: " . $imagen['error'];
        exit;
    }

    // Actualizar la base de datos con la nueva imagen si se ha subido una
    if ($nombreImagen) {
        $query = "UPDATE semblanzas SET sesion = '$sesion', nombre = '$nombre', descripcion = '$descripcion', ciclo = '$ciclo', activo = '$activo', imagen = '$nombreImagen' WHERE id = $id";
    } else {
        $query = "UPDATE semblanzas SET sesion = '$sesion', nombre = '$nombre', descripcion = '$descripcion', ciclo = '$ciclo', activo = '$activo' WHERE id = $id";
    }

    $resultado = mysqli_query($con, $query);  
 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Semblanza</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">    
</head>
<body>
    <main class="contenedor_imagen">
        <div class="content-area">
        <div class="contenedor">
        <img src="../img/logoinah.png" alt="Logo INAH">
            <h3 class="centrar-texto">Editar Semblanza</h3>
            <form method="POST" class="formulario-semblanza-contenedor" enctype="multipart/form-data">
                <div class="campo">
                    <label class="campo__label" for="sesion">Sesión:</label>
                    <input class="campo__field"
                           type="text"
                           id="sesion"
                           name="sesion"
                           value="<?php echo $semblanza['sesion']; ?>">
                </div>
                <div class="campo">
                    <label class="campo__label" for="nombre">Nombre del Ponente:</label>
                    <input class="campo__field"
                           type="text"
                           id="nombre"
                           name="nombre"
                           value="<?php echo $semblanza['nombre']; ?>">
                </div>
                <div class="campo">
                    <label class="campo__label" for="descripcion">Descripción:</label>
                    <textarea class="campo__field"
                              id="descripcion"
                              name="descripcion"><?php echo $semblanza['descripcion']; ?></textarea>
                </div>

                <div class="campo">
                    <label class="campo__label" for="imagen">Imagen:</label>
                    <input class="campo__field"
                           type="file"
                           id="imagen"
                           name="imagen">
                    </div>

                <div class="campo">
                    <label class="campo__label" for="ciclo">Nombre del Ciclo:</label>
                    <input class="campo__field"
                           type="text" id="ciclo"
                           name="ciclo" value="<?php echo $semblanza['ciclo']; ?>">
                </div>
                <div class="campo">
                    <label class="campo__label" for="activo">Ciclo Activo:</label>
                    <input class="campo__field"
                           type="checkbox"
                           id="activo" 
                           name="activo" <?php echo $semblanza['activo'] ? 'checked' : ''; ?>>
                </div>
                <div>
                    <button type="submit">Actualizar</button>
                    <button type="button" onclick="location.href='tablasemblanza.php'">Cancelar</button>
                </div>
                </div>  
                </div>              
            </form>
        </div>
    </main>
    <script src="js/modernizr.js"></script> 
</body>
</html>
<?php
include '../includes/templates/footer.php';
?>
<?php
mysqli_close($con);
?>