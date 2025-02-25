<?php 
session_start();

require '../includes/templates/nav.php';

//  Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

$errores = [];   // Arreglo vacio

// Ejecutar el código después de que el usuario envía el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {
      
    $email = mysqli_real_escape_string($con, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) );
    $password =mysqli_real_escape_string($con, $_POST['password']);
    
        
    if(!$email) {
        $errores[] =  "El email es obligatorio y no puede estar vacio";    
    }

    if(!$password) {
        $errores[] = "La contraseña es obligatoria";
    }

    if(empty($errores)) {

        // Revisar si el  usuario existe.
        $query = "SELECT u.*, p.nombre as perfil_nombre FROM usuarios u JOIN perfiles p ON
        u.perfil_id = p.id WHERE u.email = '{$email}'";                
        $resultado = mysqli_query($con, $query);      



        if( $resultado->num_rows ) {
            // Revisar si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado);

            $auth = md5($password) === $usuario['password'];
           
           if($auth) {
            
            // Iniciar sesión
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['perfil_id'] = $usuario['perfil_id'];
            $_SESSION['perfil_nombre'] = $usuario['perfil_nombre'];

            // Actulizar el estado activo a 1
            $updateQuery = "UPDATE usuarios SET activo = 1 WHERE email = '{$email}'";
            if (mysqli_query($con, $updateQuery)) {

            // Redireccionar al usuario segun su perfil.
            if ($usuario['perfil_id'] == 1) {
                header('Location: registro.php');
            } elseif ($usuario['perfil_id'] == 2) {
                header('Location: registro.php');
            } elseif ($usuario['perfil_id'] == 3) {
                header('Location: home.php');
            }
            exit;
            } else {
                echo "Error actualizando el estado activo: " . mysqli_error($con);
            }
            } else {
                $errores[] = "La contraseña es incorrecta";
            }
        } else {
            $errores[] = "El Usuario no existe";
                      
        }
    }
}
?>


<head>
		<title>Login Usuario</title>
		<link rel="stylesheet" href="../css/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">

        <script src="https://www.google.com/recaptcha/api.js?render=6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s"></script>
</head>
   
<body>       
<main class="contenedor_imagen">
    <div class="content-area">
    <div class="contenedor"></div>
    <div class="formulario__imagen">
        <img src="../img/logoInah.png" alt="Logo INAH">
        <h3 class="centrar-texto">Login de Usuario</h3>    
                  
       <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
            </div>
            <?php endforeach; ?>

            <script>
                // Esperar a que el DOM este cargado totalmente  
                document.addEventListener('DOMContentLoaded', function() {
                    // Selleccionar todas las alertas
                    const alertas = document.querySelectorAll('.alerta');
                    // Establecer temporizador para cada alerta
                    alertas.forEach(alerta => {
                        setTimeout(() => {
                            alerta.style.transition = 'opacity 1s'
                            alerta.style.opacity = '0';
                        //eliminar la alerta del DOM despues de 1 segundo que dura la transicion
                        setTimeout(() => alerta.remove(), 1000);
                        }, 4000);

                    });
                });
            </script>
                       
 <form class="formulario-contenedor" method="POST" action="login.php">
 
 <div class="campo">
        <label class="campo__label" for="email">E-mail</label>
        <input 
            class="campo__field"    
            type="email" 
            name="email"
            placeholder="Tu E-mail" 
            id="email">
    </div>
	<div class="campo">
        <label class="campo__label" for="password">Contraseña</label>
        <input 
            class="campo__field"    
            type="password" 
            name="password"
            placeholder="password" 
            id="password">
       </div>   
    
    <div class="campo">
       <input type="submit" value="Enviar"  class="boton boton--primario"> 
       <a href="../index.php" class="boton boton--secundario">Volver</a>            
        </div>
    </form>
    <div class="olvidar-password">
            <a href="enviar_reset_link.php">¿Ha olvidado su contraseña?</a>
        </div>
</main>	
<script src="../js/modernizr.js"></script>

</body>		
</html>
<?php
include '../includes/templates/footer.php';
?>