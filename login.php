<?php 
//  Importar la conexion
require 'includes/config/conexiondb.php';
$con = conectarDB();

$errores = [];   // Arreglo vacio


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    
    $email = mysqli_real_escape_string($con, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) );
    $password =mysqli_real_escape_string($con, $_POST['password']);
    //$password = md5($password); 

        
    if(!$email) {
        $errores[] =  "El email es obligatorio y no puede estar vacio";    
    }

    if(!$password) {
        $errores[] = "La contraseña es obligatoria";
    }

    if(empty($errores)) {

        // Revisar si el  usuario existe.
        $query = "SELECT * FROM usuarios WHERE email = '{$email}'  ";
        $resultado = mysqli_query($con, $query);


     


        if( $resultado->num_rows ) {
            // Revisar si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado);

            header('Location: home.php?resultado=1');

            //var_dump($resultado['password']);

            // Verificar si el password existe
           $auth = password_verify($password, $usuario['password']);

            var_dump($auth);                
        } else{
            $errores[] = "El Usuario no existe";
        }

    }
}


// Incluye el header
//require 'includes/funciones.php';
//incluirTemplate('header');

?>


	<head>
		<title>Login Usuario</title>
		<link rel="stylessheet" href="css/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&
                display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
	</head>
   

<main class="contenedor">
       <h3 class="centrar-texto">Login de Usuario</h3>

       <a href="index.php" class="boton boton--secundario">Volver</a>
           
       <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
            </div>
            <?php endforeach; ?>

       
 <form class="formulario" method="POST" action="login.php">

 
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
        <input type="submit" value="Enviar" class="boton boton--primario">        
    </div>  

</form>     

    </main>	
        
		<script src="js/modernizr.js"></script>
        <!-- <script src="js/script.js"></script> -->
	</body>		
	</html>
        