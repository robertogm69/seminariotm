<?php
require '../includes/config/conexiondb.php';
$con = conectarDB();

include '../includes/templates/nav.php';

// Número de registros por página
$registros_por_pagina = 3;

// Página actual
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Obtener el número total de registros
$total_query = "SELECT COUNT(*) as total FROM semblanzas";
$total_resultado = mysqli_query($con, $total_query);
$total_registros = mysqli_fetch_assoc($total_resultado)['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Consulta con LIMIT y OFFSET
$query = "SELECT * FROM semblanzas LIMIT $registros_por_pagina OFFSET $offset";
$resultado = mysqli_query($con, $query);


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Semblanzas</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main class="contenedor_imagen">
        <div class="content-area">
        <div class="contenedor">
        <div class="formulario__imagen">
        <img src="../img/logoInah.png" alt="Logo INAH">        
            <h3 class="centrar-texto">Editar / Eliminar Semblanzas</h3>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Sesión</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Ciclo</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($semblanza = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $semblanza['sesion']; ?></td>
                        <td><?php echo $semblanza['nombre']; ?></td>
                        <td class="descripcion"><?php echo $semblanza['descripcion']; ?></td>
                        <td><img src="../uploads/<?php echo $semblanza['imagen']; ?>" alt="Imagen" width="50"></td>
                        <td><?php echo $semblanza['ciclo']; ?></td>
                        <td><?php echo $semblanza['activo'] ? 'Sí' : 'No'; ?></td>
                        <td>
                            <div class="botones-acciones">
                            <a href="editar_semblanza.php?id=<?php echo $semblanza['id']; ?>" class="boton boton-amarillo">Editar</a>
                            <a href="eliminar_semblanza.php?id=<?php echo $semblanza['id']; ?>" class="boton boton-rojo">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="paginacion">
                <?php if ($pagina_actual > 1): ?>
                    <a href="?pagina=<?php echo $pagina_actual - 1; ?>" class="boton boton--secundario">&laquo; Anterior</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <a href="?pagina=<?php echo $i; ?>" class="boton boton--secundario"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($pagina_actual < $total_paginas): ?>
                    <a href="?pagina=<?php echo $pagina_actual + 1; ?>" class="boton boton--secundario">Siguiente &raquo;</a>
                <?php endif; ?>
            </div>

            <div class="campo">       
       <a href="administrar_semblanzas.php" class="boton boton--secundario">Volver</a>            
        </div>
        </div>       
    </main>
    <script src="js/modernizr.js"></script> 
</body>
</html>
<?php
include '../includes/templates/footer.php';
?>	
<?php
mysqli_close($con);
?>
