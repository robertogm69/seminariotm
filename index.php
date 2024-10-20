<?php
       include 'includes/templates/header.php';

       
?>

<div class="contenedor contenido-principal">
        <main class=".navegacion">
            <h3>Registro de Usuarios</h3>

             <div class="entrada__imagen">
                   <picture>
                       <source loading="lazy" srcset="img/logoinah.jpg" type="image/webp"> 
                       <img loading="lazy" src="img/logoinah.jpg" alt="imagen">
                    </picture>                   
                  </div>
                  <div class="contenedor">
		              <h1>Bienvenido(a)</h1>
                </div>
                <div class="contenido-principal">
    <ul class="">
      <?php if(!isset($_SESSION["email_id"])):?>
      <li><a href="./registro.php">REGISTRO</a></li>
      <li><a href="./login.php">LOGIN</a></li>
    <?php else:?>
     // <li><a href="inicio/logout.php">SALIR</a></li>
    <?php endif;?>
    </ul>

</div>
               





    <?php
       include 'includes/templates/footer.php';
?>