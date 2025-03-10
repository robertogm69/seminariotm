<?php
//  Importar la conexion
require '../includes/config/conexiondb.php';
$con = conectarDB();

include '../includes/templates/nav.php';

// Obtener el número de página actual
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Si no hay nada en el GET, la página actual es 1
$limit = 3; // Número de usuarios por página 
$offset = ($page - 1) * $limit; // Se calcula el numero de pagina menos 1 por el limite de usuarios

// Obtener el número total de usuarios
$totalUsuariosQuery = "SELECT COUNT(*) as total FROM usuarios";
$totalUsuariosResult = mysqli_query($con, $totalUsuariosQuery);
$totalUsuarios = mysqli_fetch_assoc($totalUsuariosResult)['total'];
$totalPages = ceil($totalUsuarios / $limit);

// Obtener los usuarios desde la base de datos
$queryUsuarios = "SELECT * FROM usuarios LIMIT $limit OFFSET $offset";
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
        <?php while($usuario = mysqli_fetch_assoc($resultadoUsuarios)): ?> 
                        <tr>
                            <td><?php echo $usuario['id']; ?></td>
                            <td><?php echo $usuario['nombre']; ?></td>
                            <td><?php echo $usuario['apellido1']; ?></td>
                            <td><?php echo $usuario['apellido2']; ?></td>
                            <td><?php echo $usuario['email']; ?></td>
                            <td><?php echo $usuario['perfil_id']; ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $usuario['id']; ?>" class="boton boton-amarillo">Editar</a>
                                <a href="eliminar.php?id=<?php echo $usuario['id']; ?>" class="boton boton-rojo">Eliminar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>            
    </tbody>
</table>
<div class="paginacion">
                    <?php if($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="boton boton--secundario">&laquo; Anterior</a>
                    <?php endif; ?>
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="boton boton--secundario"><?php echo $i; ?></a>
                    <?php endfor; ?>
                    <?php if($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="boton boton--secundario">Siguiente &raquo;</a>
                    <?php endif; ?>
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