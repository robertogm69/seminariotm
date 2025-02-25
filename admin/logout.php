<?php
session_start();

// Verificar si el usuario está autenticado
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Conexión a la base de datos
    require '../includes/config/conexiondb.php';
    $con = conectarDB();

    
    // Actualizar el estado del usuario 'activo' a 0
    $query = "UPDATE usuarios SET activo = 0 WHERE email = '$email'";
    if (mysqli_query($con, $query)) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error actualizando el usuario: " . mysqli_error($con);
    }

    // Cerrar la conexión
    mysqli_close($con);

    // Destruir la sesión
    session_destroy();

    // Redireccionar al usuario a la página de inicio de sesión
    header("Location: login.php");
    exit();
} else {  
    // Si no hay sesión iniciada, redireccionar al usuario a la página principal
    header("Location: ../index.php");
    exit();
}
?>