<?php
include '../includes/templates/nav.php';
// Conectar a la base de datos
require '../includes/config/conexiondb.php';
$con = conectarDB();

// Ejecutar el código después de que el usuario envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token =isset($_POST['token']) ? mysqli_real_escape_string($con, $_POST['token']) : null;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($con, $_POST['password']) : null;
    
    if ($token && $password) {
        $query = "SELECT * FROM usuarios WHERE reset_token = '$token' AND reset_token_expira > NOW()";
        $result = mysqli_query($con, $query);
        
        if ($result->num_rows) {
            $hashedPassword = md5($password);
            $query = "UPDATE usuarios SET password = '$hashedPassword', reset_token = NULL, reset_token_expira = NULL WHERE reset_token = '$token'";
            mysqli_query($con, $query);
            
            echo "Su contraseña se ha restablecido correctamente.";
        } else {
            echo "Token no válido o caducado.";
        }
    } else {
        echo "Solicitud no válida.";
    }
}
?>

<head>
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s"></script>
</head>

<body>
<main class="contenedor_imagen">
    <div class="content-area">
    <div class="contenedor">
    <div class="formulario__imagen">
        <img src="../img/logoInah.png" alt="Logo INAH">
        <h3 class="centrar-texto">Restablecer Contraseña</h3>
        <a href="login.php" class="boton boton--secundario">Volver</a>
        <a href="logout.php" class="boton boton--primario">Salir de Sesion</a> 
        <form class="formulario" method="POST" action="reset_password.php">
            <div class="campo">
                <?php if (isset($_GET['token'])): ?>
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                <!--<?php // else: ?>
                    <p>Error: Token no proporcionado.</p> -->
                <?php endif; ?>
                <label class="campo__label" for="password">Nueva Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Restablecer Contraseña</button>
            </div>
            </div>
        </div>
        </form>
    </div>
    </main>
    <script src="../js/modernizr.js"></script>
</body>
</html>