<?php 
//  Verificar la sesión
    session_start();
    
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['email']) || $_SESSION['perfil_id'] != 1) {
        // Si no es superadministrador redirigir al login
        header("Location: ../index.php");
        exit;
    }

//  Iniciar la sesión
    $resultado = $_GET['resultado'] ?? null;


//  Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

include '../includes/templates/nav.php';

$errores = [];   // Arreglo vacio

    $nombre = '';
    $apellido1 = '' ;
    $apellido2 = '';
    $email = '';
    $password = '';
    $perfil_id = '';

    //  Obtener los perfiles desde la base de datos
    $queryPerfiles = "SELECT * FROM perfiles";
    $resultadoPerfiles = mysqli_query($con, $queryPerfiles);

// Ejecutar el código después de que el usuario envía el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']) ;
    $apellido1 = mysqli_real_escape_string($con, $_POST['apellido1']) ;
    $apellido2 = mysqli_real_escape_string($con, $_POST['apellido2']);
    $email = mysqli_real_escape_string($con, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) );
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $perfil_id = mysqli_real_escape_string($con, $_POST['perfil_id']);
    
    
    //Verificar si el email ya existe
    $query = "SELECT email FROM usuarios WHERE email = '$email'";
    $resultadoConsulta = mysqli_query($con, $query);
    if (mysqli_num_rows($resultadoConsulta) > 1) {
        $errores[] = "El email ya esta registrado";
    }

    //Validar que no haya campos vacios    
         
    if(!$nombre) {
        $errores[] = "Se debe añadir un nombre o nombres";
    }

    if(!$apellido1) {
        $errores[] = "Se debe añadir el primer apellido";
    }

    if(!$apellido2) {
        $errores[] = "Se debe añadir el segundo apellido";
    }
    
    if(!$email) {
        $errores[] =  "El email es obligatorio y no puede estar vacio";    
    }

    if(!$password) {
        $errores[] = "La contraseña es obligatoria";
    } else {
        $password = md5($password);
    }
    if(!$perfil_id) {
        $errores[] = "Se debe seleccionar un perfil";
    }


    //Revisar que el array de errores este vacio
    if(empty($errores)) {

    //Insertar en la base de datos
    $query = "INSERT INTO usuarios (nombre, apellido1, apellido2, email, password, perfil_id, activo) VALUES (
        '$nombre', '$apellido1', '$apellido2', '$email', '$password', '$perfil_id', 1) ";


    $resultado = mysqli_query($con, $query);

    
        if($resultado) {
     
           // Redireccionar al usuario
           header('Location: ./registro.php?resultado=1');
        }    
    }

}

// Obtener los usuarios desde la base de datos
$queryUsuarios = "SELECT * FROM usuarios";
$resultadoUsuarios = mysqli_query($con, $queryUsuarios);

?>
    
    <!DOCTYPE html>
	<head>
		<title>Formulario de Registro</title>
		<link rel="stylesheet" href="../css/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://www.google.com/recaptcha/api.js?render=6LeBAHIqAAAAANoVzJSBqOp_LVI0_8gH4-Kmtv7s"></script>
        </head>

        <body>
        <h3 class="centrar-texto">Registro de Usuario</h4>
            <div class="contenedor-principal">
                <div class="contenedor-flex">
                <nav class="vertical-menu">
                    <ul>
                        <li><a href="../semblanza/administrar_semblanzas.php">Administrar Semblanzas</a></li>
                        <li><a href="../video/administrar_videos.php">Administrar Videos</a></li>
                        <li><a href="../historico/administrar_historico.php">Administrar Otros Ciclos</a></li>
                        <li><a href="tablausuarios.php">Usuarios Registrados</a></li>
                    </ul>
                </nav>
        
        <div class="formulario-registro-contenedor">            
       <?php if (intval($resultado) === 1): ?>
         <p class="alerta correcto">Usuario registrado correctamente</p>
       <?php elseif (intval($resultado) === 2): ?>
         <p class="alerta correcto">Usuario editado correctamente</p>
        <?php elseif (intval($resultado) === 3): ?>
        <p class="alerta correcto">Usuario eliminado correctamente</p>
        <?php endif; ?>        
               
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

            <!-- Formulario de Registro -->             
        <form  class="formulario-registro-contenedor"  method="POST" action="registro.php">           
        <div class="campo">
        <label class="campo__label" for="nombre">Nombre</label>
        <input 
            class="campo__field"
            type="text" 
            name="nombre";
            placeholder="Tu Nombre"
            id="nombre"
            value="<?php echo $nombre; ?>">
            
    </div>
	<div class="campo">
        <label class="campo__label" for="apellido1">Primer Apellido</label>
        <input 
            class="campo__field"
            type="text" 
            name="apellido1"
            placeholder="apellido1"
            id="apellido1"
            value="<?php echo $apellido1; ?>">
    </div>
	<div class="campo">
        <label class="campo__label" for="apellido2">Segundo Apellido</label>
        <input 
            class="campo__field"
            name="apellido2"
            type="text" 
            placeholder="apellido2"
            id="apellido2"
            value="<?php echo $apellido2; ?>">
    </div>
    <div class="campo">
        <label class="campo__label" for="email">E-mail</label>
        <input 
            class="campo__field"    
            type="email" 
            name="email"
            placeholder="Tu E-mail" 
            id="email"
            value="<?php echo $email; ?>">
    </div>
	<div class="campo">
        <label class="campo__label" for="password">Contraseña</label>
        <input 
            class="campo__field"    
            type="password" 
            name="password"
            autocomplete="current-password"
            placeholder="password" 
            id="password" >            
       </div>        
       <div class="campo">
                <label class="campo__label" for="perfil_id">Perfil</label>
                <select class="campo__field" name="perfil_id" id="perfil_id">
                <option value="">-- Seleccione --</option>
                <?php while($perfil = mysqli_fetch_assoc($resultadoPerfiles)): ?>
                <option value="<?php echo $perfil['id']; ?>" <?php echo $perfil_id == $perfil['id'] ? 'selected' : ''; ?>>
                <?php echo $perfil['nombre']; ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>         
    <div class="campo">
        <input type="submit" value="Enviar" class="boton boton--primario">
        <a href="logout.php" class="boton boton--primario">Salir de Sesion</a> 
        <a href="../index.php" class="boton boton--secundario">Volver</a>        
    </div> 
</form>
</div>
</div>
		<script src="../js/modernizr.js"></script>         
</body>	
</html>

<?php
include '../includes/templates/footer.php';
?>	
