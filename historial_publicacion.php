<!DOCTYPE html>
<html>
<head>
    <title>Historial Publicacion</title>
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
                Unidad de Investigacion UCB
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
        <h2>Historial de Publicacion</h2>
        <?php include "c_historialpub.php"; ?> 
    </div>
</body>
</html>