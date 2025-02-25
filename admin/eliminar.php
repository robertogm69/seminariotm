<?php
include '../includes/templates/nav.php';
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
    <div class="formulario__imagen">
       <img src="../img/logoinah.png" alt="Logo INAH">
       <h3 class="centrar-texto">Eliminar Usuario</h3>
    


<?php
require '../includes/config/conexiondb.php';
$con = conectarDB();

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "DELETE FROM usuarios WHERE id = $id";
    $resultado = mysqli_query($con, $query);

    if ($resultado) {
        
        header('Location: registro.php?resultado=3');
        exit;
    }
} else {
    // Mostrar formulario de confirmación
    echo "<div class='contenedor-eliminar fondo-imagen-elimina'>";
    echo "<h2>¿Está seguro que desea eliminar este registro?</h2>";
    echo "<form method='POST'>";    echo "<input type='submit' value='Eliminar'>";
    echo "<a href='registro.php'>Cancelar</a>";
    echo "</form>";
    echo "</div>";   
}
?>
</div>
</main>

<script src="../js/modernizr.js"></script>
</body>
</html>

<?php
include '../includes/templates/footer.php';
?>