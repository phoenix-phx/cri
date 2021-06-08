<?php 
session_start();
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos']) || $_SESSION['permisos'] != 'investigador'){
    die('No ha iniciado sesion');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mis Investigaciones</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    
    <?php
    if (isset($_SESSION['error'])) {
        echo ('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo ('<p style="color:green;">'.htmlentities($_SESSION['success'])."</p>\n");
        unset($_SESSION['success']);
    }
    ?>
    <!-- header --> 
    <div class="bar" style="height: 50px; background-color: #0b1f3f;">
        <a href="home_investigador.php" class="aLeft textIblue">
            <img src="imagenes/LogoU.png" style="height: 50px;">
        </a>
        <div style="padding-top: 15px; padding-bottom: 15px;padding-right:50px;">
            <a href="home_investigador.php" class="aLeft textIblue">
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
        <h1 class="aLeft" style="font-size:40px;">Mis Investigaciones</h1> 
        <div style="padding-top:35px;padding-bottom:25px">
            <button class="button aRight" style="font-size:18px;" onclick="document.location='nueva_investigacion.php'">+ Investigaci&oacute;n nueva</button>
        </div>
    </div>
    <br><br><br>
    
    <?php include "c_listainv.php"?>
</body>
</html>
