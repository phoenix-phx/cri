<!DOCTYPE html>
<html>
<head>
    <title>Historial Publicaci&oacute;n</title>
    <link rel="stylesheet" href="style/styles.css">
    <?php session_start(); ?>
</head>
<body>
    <!-- header -->
    <div class="bar" style="height: 50px; background-color: #0b1f3f;">
        <a href="home_administrativo.php" class="aLeft textIblue">
            <img src="imagenes/LogoU.png" style="height: 50px;">
        </a>
        <div style="padding-top: 15px; padding-bottom: 15px;padding-right:50px;">
            <a href="home_administrativo.php" class="aLeft textIblue">
                Unidad de Investigaci&oacute;n UCB
            </a>
            <a class="aRight textIblue">
                <?php 
                    //session_start();
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div align="center">
        <h2>Historial de Publicaci&oacute;n</h2>
        <?php include "c_historialpub.php"; ?> 
        <button class="button" onclick="document.location='detalles_publicacion_admin.php?pub_id=<?php echo($_REQUEST['pub_id']) ?>'">Volver</button>
    </div>
</body>
</html>