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
    <title>Detalles financiamiento</title>
    <link rel="stylesheet" href="style/styles.css">
    <style>
        body{
            line-height:150%; 
        }
    </style>
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
                    //session_start();
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <?php include "c_verfinanciador.php"; ?>
</body>