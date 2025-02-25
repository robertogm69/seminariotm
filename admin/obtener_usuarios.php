<?php
require '../includes/config/conexiondb.php';
$con = conectarDB();

$queryUsuarios = "SELECT * FROM usuarios";
$resultadoUsuarios = mysqli_query($con, $queryUsuarios);

$usuarios = [];
while ($usuario = mysqli_fetch_assoc($resultadoUsuarios)) {
    $usuarios[] = $usuario;
}

echo json_encode($usuarios);
?>
