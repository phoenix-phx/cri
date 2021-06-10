<?php 
session_start();
// security control
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( $_SESSION['permisos'] !== "administrativo"){
    die('Acceso denegado');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Publicaciones Registradas</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <!-- header -->
    <div class="bar" style="height: 50px; background-color: #0b1f3f;">
        <a href="home_administrativo.php" class="aLeft textIblue">
            <img src="imagenes/LogoU.png" style="height: 50px;">
        </a>
        <div style="padding-top: 15px; padding-bottom: 15px;padding-right:50px;">
            <a href="home_administrativo.php" class="aLeft textIblue">
                UCB - SCI
            </a>
            <a class="aRight textIblue">
                <?php 
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>

    <div style="padding-left:5%;padding-right:5%;">
        <h1 class="aLeft" style="font-size:40px;">Publicaciones</h1> 
        <div style="padding-top:35px;padding-bottom:25px">
            <button class="button aRight" style="font-size:18px;" onclick="document.location='buscar_publicacion.php'">Buscar Publicaci&oacute;n</button>
        </div>
    </div>
    <br><br><br>
    <?php include "c_listapub.php"?>
</body>
</html>
