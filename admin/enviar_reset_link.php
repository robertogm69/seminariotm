<?php
require '../includes/templates/nav.php';
// Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/PHPMailer/src/SMTP.php';


// Ejecutar el código después de que el usuario envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($con, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));

    if (!$email) {
        echo "Dirección de correo electrónico no válida.";
    } else {
        // Generar un token unico de restablecimiento de contraseña
        $token = bin2hex(random_bytes(50));
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Actualizar el token de restablecimiento en la base de datos
        $query = "UPDATE usuarios SET reset_token = '$token', reset_token_expira = '$expira' WHERE email = '$email'"; 
        mysqli_query($con, $query);

        // Almacena el token y el tiempo de vencimiento en la base de datos.
        $resetLink = "http://localhost:3000/admin/reset_password.php?token=$token";

        // Función para enviar el correo electrónico
    function sendResetEmail($email, $resetLink) {        
        // Configurar PHPMailer
        $mail = new PHPMailer(true);
        

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Cambia esto por tu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'seminariostmcorreo@gmail.com'; // Cambia esto por tu correo
            $mail->Password = 'phrgldcpmnwpslug'; // Cambia esto por tu contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('seminariostmcorreo@gmail.com', 'Roberto M Garcia Martinez');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Restablecer Password';
            $mail->Body = "Haga clic en el siguiente enlace para restablecer su password: <a href='$resetLink'>Restablecer Password</a>"; 

            $mail->send();
            echo "Se ha enviado un enlace para restablecer la contraseña a su correo electrónico."; 
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
    sendResetEmail($email, $resetLink);
    }
}
?>
     
<head>
		<title>Solicitud restablecer contraseñas</title>
		<link rel="stylesheet" href="../css/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">

        <script src="https://www.google.com/recaptcha/api.js?render=6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s"></script>

      
    
    <meta charset="UTF-8">
    <title>Solicitar Restablecimiento de Contraseña</title>
</head>

<body>
<main class="contenedor_imagen">
    <div class="formulario__imagen"> 
        <h3 class="centrar-texto">Restablecer Contraseña</h3>
        <a href="login.php" class="boton boton--secundario">Volver</a>  
    
    <form class="formulario-contenedor" method="POST" action="enviar_reset_link.php">
    <div class="campo">
    <label class="campo__label" for="email">E-mail</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Enviar enlace para restablecer contraseña</button>
    </div>
    </form>
    </main>	    
<script src="../js/modernizr.js"></script>
</body>
</html>
<?php include '../includes/templates/footer.php'; ?>