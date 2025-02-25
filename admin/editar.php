<?php
include '../includes/templates/nav.php';
// Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

$id = $_GET['id'];
$query = "SELECT * FROM usuarios WHERE id = $id";
$resultado = mysqli_query($con, $query);
$usuario = mysqli_fetch_assoc($resultado);

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $apellido1 = mysqli_real_escape_string($con, $_POST['apellido1']);
    $apellido2 = mysqli_real_escape_string($con, $_POST['apellido2']);
    $email = mysqli_real_escape_string($con, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $perfil_id = mysqli_real_escape_string($con, $_POST['perfil_id']);

    if (!$nombre) {
        $errores[] = "El nombre es obligatorio";
    }
    if (!$apellido1) {
        $errores[] = "El primer apellido es obligatorio";
    }
    if (!$apellido2) {
        $errores[] = "El segundo apellido es obligatorio";
    }
    if (!$email) {
        $errores[] = "El email es obligatorio";
    }
    if (!$perfil_id) {
        $errores[] = "El perfil es obligatorio";
    }

    if (empty($errores)) {
        $query = "UPDATE usuarios SET nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', email = '$email', perfil_id = '$perfil_id' WHERE id = $id";
        $resultado = mysqli_query($con, $query);

        if ($resultado) {
            
            header('Location: registro.php?resultado=2');
        }
    }
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Registro</title>
    <link rel="stylessheet" href="../css/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">

        <script src="https://www.google.com/recaptcha/api.js?render=6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s"></script>

</head>
<body>

<main class="contenedor_imagen">
       <h3 class="centrar-texto">Editar Usuario</h3>
        <div class="contenedor"></div>
      
    <?php foreach ($errores as $error): ?>
        <p class="alerta error"><?php echo $error; ?></p>
    <?php endforeach; ?>


    <form method="POST" class="formulario">
        <fieldset>
            <legend>Información Personal</legend>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>">

            <label for="apellido1">Primer Apellido:</label>
            <input type="text" id="apellido1" name="apellido1" value="<?php echo $usuario['apellido1']; ?>">

            <label for="apellido2">Segundo Apellido:</label>
            <input type="text" id="apellido2" name="apellido2" value="<?php echo $usuario['apellido2']; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>">

            <label for="perfil_id">Perfil:</label>
            <select id="perfil_id" name="perfil_id">
                <option value="">-- Seleccione --</option>
                <?php
                $queryPerfiles = "SELECT * FROM perfiles";
                $resultadoPerfiles = mysqli_query($con, $queryPerfiles);
                while ($perfil = mysqli_fetch_assoc($resultadoPerfiles)): ?>
                    <option <?php echo $usuario['perfil_id'] === $perfil['id'] ? 'selected' : ''; ?> value="<?php echo $perfil['id']; ?>"><?php echo $perfil['nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </fieldset>
        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
        <a href="registro.php" class="boton boton--secundario">Volver</a>
    </form>
</div>
</div>
</main>

<script src="../js/modernizr.js"></script>
</body>
</html>
<?php include '../includes/templates/footer.php'; ?>