<?php 

    // echo "<pre>";
    // var_dump($_GET);
    // echo "<pre>";
    // exit;

    $resultado = $_GET['resultado'] ?? null;

    //var_dump($resultado);

//  Importar la conexion
require 'includes/config/conexiondb.php';
$con = conectarDB();

include 'includes/templates/header.php';


$errores = [];   // Arreglo vacio

    $nombre = '';
    $apellido1 = '' ;
    $apellido2 = '';
    $email = '';
    $password = '';

// Ejecutar el código después de que el usuario envía el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {
   // echo "<pre>";
   // var_dump($_POST);
  //   echo "</pre>";

    $nombre = mysqli_real_escape_string($con, $_POST['nombre']) ;
    $apellido1 = mysqli_real_escape_string($con, $_POST['apellido1']) ;
    $apellido2 = mysqli_real_escape_string($con, $_POST['apellido2']);
    $email = mysqli_real_escape_string($con, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) );
    $password = mysqli_real_escape_string($con, $_POST['password']);
    //$password = md5($password, PASSWORD_DEFAULT); 
   $password = password_hash($password, PASSWORD_DEFAULT);
  

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
    }


    // echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";

   // exit;

    //Revisar que el array de errores este vacio

    if(empty($errores)) {
    //Insertar en la base de datos
    $query = " INSERT INTO usuarios (nombre, apellido1, apellido2, email, password ) VALUES (
    '$nombre', '$apellido1', '$apellido2', '$email', '$password' ) ";

    //echo $query;

    $resultado = mysqli_query($con, $query);

        if($resultado) {
           // echo "Insertado correctamente";

           // Redireccionar al usuario
           header('Location: registro.php?resultado=1');
        }    
    }
}

// Incluye el header
//require 'includes/funciones.php';
//incluirTemplate('header');

?>


	<head>
		<title>Formulario de Registro</title>
		<link rel="stylessheet" href="css/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&
                display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
	</head>
   

<main class="contenedor">
       <h3 class="centrar-texto">Registro de Usuario</h3>

       <?php if( intval( $resultado ) === 1): ?>
            <p class="alerta correcto">Usuario registrado correctamente</p>
        <?php endif; ?>

        <a href="index.php" class="boton boton--secundario">Volver</a>
       
         <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
            </div>
            <?php endforeach; ?>

       
 <form class="formulario" method="POST" action="registro.php">

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
            placeholder="password" 
            id="password">
            
       </div>
        
    <div class="campo">
        <input type="submit" value="Enviar" class="boton boton--primario">
    </div>

	<!-- <div class="campo">
        <input type="submit" value="Volver" class="boton boton--secundario">	 -->
        
    </div>
    

</form>     

    </main>	
        
		<script src="js/modernizr.js"></script>      
        <!-- <script src="js/script.js"></script> -->
	</body>		
	</html>
