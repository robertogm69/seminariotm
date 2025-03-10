<?php
include '../includes/templates/nav.php';

require '../includes/config/conexiondb.php';
$con = conectarDB();

$id = $_GET['id'];
$query = "SELECT * FROM materiales WHERE id = $id";
$resultado = mysqli_query($con, $query);
$material = mysqli_fetch_assoc($resultado);

// Verificar si las claves existen en el array $material
$nombreArchivo = isset($material['archivo_mat']) ? $material['archivo_mat'] : ''; // Nombre del archivo actual

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sesion_mat = mysqli_real_escape_string($con, $_POST['sesion_mat']); // Evitar inyección SQL
    $descrip_mat = mysqli_real_escape_string($con, $_POST['descrip_mat']); // Evitar inyección SQL
    
    $archivo = isset($_FILES['archivo_mat']) ? $_FILES['archivo_mat'] : null; // Archivo PDF

    // Definir tipos de archivo permitidos y tamaño máximo
    $allowedFileTypes = ['application/pdf']; 
    $maxFileSize = 2 * 1024 * 1024; // 2 MB

    // Manejar la carga del archivo PDF
    if ($archivo && $archivo['error'] === UPLOAD_ERR_OK) {
        if (!in_array($archivo['type'], $allowedFileTypes)) { // Verificar si el tipo de archivo es permitido
            echo "Error: Tipo de archivo no permitido.";
            exit;
        }
        if ($archivo['size'] > $maxFileSize) {
            echo "Error: El archivo es demasiado grande.";
            exit;
        }
        $carpetaArchivos = '../upload_material/';
        if (!is_dir($carpetaArchivos)) {
            mkdir($carpetaArchivos, 0755, true);
        }
        $nombreArchivo = $archivo['name'];
        move_uploaded_file($archivo['tmp_name'], $carpetaArchivos . $nombreArchivo);
    }

    // Actualizar la base de datos con el nuevo archivo si se ha subido
    $query = "UPDATE materiales SET sesion_mat = '$sesion_mat', descrip_mat = '$descrip_mat', archivo_mat = '$nombreArchivo' WHERE id = $id";
    $resultado = mysqli_query($con, $query);

    if ($resultado) {
        header('Location: editar_material.php?id=' . $id . '&success=1');
        exit;
    } else {
        echo "Error al actualizar el material: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Material</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">    
</head>
<body>
    <main class="contenedor_imagen">
        <div class="content-area">
        <div class="contenedor">
        <img src="../img/logoinah.png" alt="Logo INAH">
            <h3 class="centrar-texto">Editar Material</h3>            
            <form method="POST" class="formulario-material-contenedor" enctype="multipart/form-data">
                <div class="campo">
                    <label class="campo__label" for="sesion">Sesión:</label>
                    <input class="campo__field"
                           type="text"
                           id="sesion_mat"
                           name="sesion_mat"
                           value="<?php echo $material['sesion_mat']; ?>">
                </div>
                <div class="campo">
                    <label class="campo__label" for="nombre">Descripción:</label>
                    <input class="campo__field"
                           type="text"
                           id="descrip_mat"
                           name="descrip_mat"
                           value="<?php echo $material['descrip_mat']; ?>">
                </div>
                
                <div class="campo">
                    <label class="campo__label" for="archivo_mat">Archivo PDF:</label>
                    <?php if (!empty($nombreArchivo)): ?>
                        <a href="../upload_material/<?php echo $nombreArchivo; ?>" target="_blank">Ver archivo actual</a> <!-- Enlace para ver el archivo actual -->
                        <input class="campo__field" type="file" id="archivo_mat" name="archivo_mat">
                    <?php else: ?>
                        <input class="campo__field" type="file" id="archivo_mat" name="archivo_mat">
                    <?php endif; ?>
                </div>

                <div>
                    <button type="submit">Actualizar</button>
                    <button type="button" onclick="location.href='tablamaterial.php'">Cancelar</button>
                    <button type="button" onclick="location.href='../material/administrar_material.php'">Volver</button>
                </div>
            </form>
        </div>
    </main>
    <script src="../js/modernizr.js"></script> 
    
</body>
</html>
<?php
include '../includes/templates/footer.php';
mysqli_close($con);
?>