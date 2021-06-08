<?php 
session_start();
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos']) || $_SESSION['permisos'] != 'investigador'){
    die('No ha iniciado sesion');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detalles de Investigacion</title>
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
    <!-- Titulo y botones -->
    <div style="padding-left:5%;padding-right:5%;">
        <h1 class="aLeft" style="font-size:40px;">Detalles</h1>
        <div style="padding-top:30px;padding-bottom:30px">
            <?php $cad = $_REQUEST['inv_id'] ?>
            <button class="button aRight" onclick="document.location='editar_investigacion.php?inv_id=<?php echo $cad ?>'">Editar</button>
            <?php  $cad = 'cerrar_confirmacion.php?inv_id='.$_REQUEST['inv_id']?>
            <button class="button aRight" style="margin-right:20px;" onclick="document.location='<?php echo $cad; ?>'">Cerrar Investigaci&oacute;n</button>
            <?php //TODO: no mostrar opcion CERRAR INVESTIGACION si ya esta cerrada ?>
        </div>
    </div>
    <br>
    <!-- Detalles -->
    <div style="padding-left:5%;padding-right:5%;font-size:17px;" align="left">
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
        <?php include "c_vistainvestigacion.php"?>
    </div>
</body>
</html>