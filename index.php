<?php
include 'includes/templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $secretKey = '6LeBAHIqAAAAAIZjOcwevGMC4dH04HbqF1ikeeFy'; 
    $token = $_POST['g-recaptcha-response'];

    // Verifica el token con Google
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$token");
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        echo "Error en la verificación de reCAPTCHA. Intenta nuevamente.";
    } else {
        // Aquí puedes procesar el registro
        echo "Registro exitoso.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema Web de Seminarios del Templo Mayor INAH">   
	<title>Seminario Permanente del Templo Mayor</title>
	<link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s"></script>
</head>
<body>
    

<div class="conten-menu-principal">
<nav class="vertical-menu">
                <ul>
                <ul>
                    <li><a href="../consulta/introduccion.php">Introducción</a></li>
                    <li class="submenu">
                        <a href="#">Sesiones <span class="triangule">&#9660;</span></a>
                        <ul>
                            <li><a href="../semblanza/semblanzas.php">Semblanzas</a></li>
                            <li><a href="videos_sesiones.php">Videos de Sesiones</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#">Materiales <span class="triangule">&#9660;</span></a>
                        <ul>
                            <li><a href="material1.php">Material 1</a></li>
                            <li><a href="material2.php">Material 2</a></li>
                            <!-- Agregar más opciones de materiales según sea necesario -->
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#">Ciclos Pasados <span class="triangule">&#9660;</span></a>
                        <ul>
                            <li><a href="recursos1.php">Recurso 1</a></li>
                            <li><a href="recursos2.php">Recurso 2</a></li>
                            <li><a href="recursos2.php">Recurso 3</a></li>
                            <!-- Agregar más opciones de recursos según sea necesario -->
                        </ul>                              
                    <?php if(!isset($_SESSION["email_id"])):?>
                        <li><a href="admin/login.php">Iniciar Sesión</a></li>
                    <?php else:?>
                        <li><a href="logout.php">Cerrar Sesión</a></li>
                    <?php endif;?>
            </ul>
       </nav>        


       <script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('registration-form');
        if (form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Evita el envío del formulario

                grecaptcha.execute('6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s', {action: 'submit'}).then(function(token) {
                    // Agrega el token a un campo oculto
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'g-recaptcha-response';
                    input.value = token;
                    form.appendChild(input);

                    // Envía el formulario
                    form.submit();
                });
            });
        }
    });
</script>

<div class="content-area">
    <div class="contenedor"></div>
<div class="contenedor contenido-principal">
     <main>
          <img src="img/logoInah.png" alt="Logo INAH">
        <h1>Bienvenido(a) al Seminario Permanente del Templo Mayor</h1>
        <p>Explora nuestro contenido y recursos relacionados con el Templo Mayor.</p>
    </main>
  </div>
  </div>
  <script src="js/modernizr.js"></script>  
</body>
</html>


<?php
include 'includes/templates/footer.php';
?>

