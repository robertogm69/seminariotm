<?php
//  Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

include '../includes/templates/nav.php';



// Obtener los usuarios desde la base de datos
$queryUsuarios = "SELECT * FROM usuarios";
$resultadoUsuarios = mysqli_query($con, $queryUsuarios);

?>
    
    <!DOCTYPE html>
	<head>
		<title>Usuarios Registrados</title>
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
        <h3>Usuarios Registrados</h3>   
        <table id="usuarios" class="usuarios">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <script>
            // Cargar los usuarios con AJAX    
                function cargarUsuarios() {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'obtener_usuarios.php', true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        const usuarios = JSON.parse(this.responseText);
                        let output = '';
                        usuarios.forEach(function(usuario) {
                          output += `
                                <tr>
                                <td>${usuario.id}</td>
                                <td>${usuario.nombre}</td>
                                <td>${usuario.apellido1}</td>
                                <td>${usuario.apellido2}</td>
                                <td>${usuario.email}</td>
                                <td>${usuario.perfil_id}</td>
                                <td>
                                    <a href="editar.php?id=${usuario.id}" class="boton boton-amarillo">Editar</a>
                                    <a href="eliminar.php?id=${usuario.id}" class="boton boton-rojo">Eliminar</a>
                                </td>
                            </tr>
                        `;
                    });
                    document.querySelector('#usuarios tbody').innerHTML = output;
                  } else {
                    console.error('Error al cargar usuarios:', this.statusText);
                  }
              }
                xhr.send();
            }
           // Cargar usuarios al cargar la página
             document.addEventListener('DOMContentLoaded', cargarUsuarios);

          // Refrescar usuarios cada 5 segundos
             setInterval(cargarUsuarios, 5000);
        </script>            
    </tbody>
</table>
<div class="campo">       
       <a href="registro.php" class="boton boton--secundario">Volver</a>            
        </div>
</div>
</div>
</div>
</div>
		<script src="../js/modernizr.js"></script>  
</main>       
</body>	
</html>

<?php
include '../includes/templates/footer.php';
?>	