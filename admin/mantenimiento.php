<?php
// Script para activar o desactivar el sistema de mantenimiento
session_start();

// Verificar si el usuario está autenticado y es superadministrador
if (!isset($_SESSION['email']) || $_SESSION['perfil_id'] != 1) {
    header("Location: ../index.php");
    exit;
}

// Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

include '../includes/templates/nav.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newStatus = $_POST['status'] === 'on' ? 'on' : 'off';
    $queryUpdate = "UPDATE system_status SET status = '$newStatus' WHERE id = 1";
    mysqli_query($con, $queryUpdate);
}

// Obtener el estado actual del sistema
$queryStatus = "SELECT status FROM system_status WHERE id = 1";
$resultStatus = mysqli_query($con, $queryStatus);
$systemStatus = mysqli_fetch_assoc($resultStatus)['status'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento del Sistema</title>
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
    <h1>Mantenimiento del Sistema</h1>
    <form method="POST" action="mantenimiento.php"  class="formulario">
        <label>
            <input type="radio" name="status" value="on" <?php echo $systemStatus === 'on' ? 'checked' : ''; ?>>
            Encendido
        </label>
        <label>
            <input type="radio" name="status" value="off" <?php echo $systemStatus === 'off' ? 'checked' : ''; ?>>
            Apagado
        </label>
        <button type="submit">Guardar</button>
        <a href="registro.php" class="boton boton--secundario">Volver</a>
    </form>
    </div>
    </div>
</main>
</body>
</html>