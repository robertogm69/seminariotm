<?php
require '../includes/config/conexiondb.php';
$con = conectarDB();
    //Recibimos los datos enviados desde la app
$querySemblanzas = "SELECT * FROM semblanzas";
$resultadoSemblanzas = mysqli_query($con, $querySemblanzas);
    // Se Crea un array
$semblanzas = [];
while ($semblanza = mysqli_fetch_assoc($resultadoSemblanzas)) {
     $semblanzas[] = $semblanza;
}
    //Imprime el array en formato JSON
echo json_encode($semblanzas);
?>
