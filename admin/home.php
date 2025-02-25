<?php
include '../includes/templates/nav.php';

//  Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

?>

<html>
	<head> 
		<title>.: INICIO :.</title>
		<link rel="stylessheet" href="../css/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&
                display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">

        <script src="https://www.google.com/recaptcha/api.js?render=6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s"></script>

	</head>
	<body>
<div> 
	<main class="contenedor">
		<h1>Bienvenido(a) al Seminario Permanente del Templo Mayor</h1>

		<a href="index.php" class="boton boton--secundario">Volver</a>
		
       
    	 <a href="logout.php" class="boton boton--primario">Salir de Sesion</a>       
		</main>

</div>

<script>
        let timeout;

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(logout, 300000);  // 5 minutos de inactividad
        }

        function logout() {
            // Hacer una solicitud AJAX para cerrar la sesión
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "logout.php", true);
            xhr.send();

            // Redirigir al usuario a la página de inicio de sesión
            window.location.href = "login.php";
        }

        // Detectar eventos de actividad del usuario
        window.onload = resetTimer;
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
    </script>

	</body>
</html>