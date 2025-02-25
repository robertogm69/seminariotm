<?php
include '../includes/templates/nav.php';    

require '../includes/config/conexiondb.php';
$con = conectarDB();

// Obtener el id de la semblanza a eliminar del URL
$id = $_GET['id'];

// Eliminar la semblanza del registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$query = "DELETE FROM semblanzas WHERE id = $id";
$resultado = mysqli_query($con, $query);

if ($resultado) {
    header('Location: tablasemblanza.php?resultado=3');
    exit;
   
} else {
    echo "Error al eliminar la semblanza: " . mysqli_error($con);
}
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Registro</title>
    <link rel="stylesheet" href="../css/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">

        <script src="https://www.google.com/recaptcha/api.js?render=6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s"></script>
</head>
<body>

<main class="contenedor_imagen">
    <div class="content-area">
        <div class="contenedor">
            <img src="../img/logoinah.png" alt="Logo INAH">
            <h3 class="centrar-texto">Eliminar Semblanza</h3>
            <div class='contenedor-eliminar fondo-imagen-elimina'>
                <h2>¿Está seguro que desea eliminar esta semblanza?</h2>
                <form method='POST'>
                    <input type='submit' value='Eliminar'>
                    <a href='tablasemblanza.php'>Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="../js/modernizr.js"></script>
</body>
</html>
<?php
include '../includes/templates/footer.php';
mysqli_close($con);
?>
