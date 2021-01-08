<!DOCTYPE html>
<html>
<head>
    <title>Cronograma</title>
    <link rel="stylesheet" href="style/styles.css">
    <?php session_start(); ?>
</head>
<body> 
    <!-- header -->
    <div class="bar" style="height: 50px; background-color: #0b1f3f;">
        <a href="home_investigador.php" class="aLeft textIblue">
            <img src="imagenes/LogoU.png" style="height: 50px;">
        </a>
        <div style="padding-top: 15px; padding-bottom: 15px;padding-right:50px;">
            <a href="home_investigador.php" class="aLeft textIblue">
                Unidad de Investigaci&oacute;n UCB
            </a>
            <a class="aRight textIblue">
                <?php 
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <?php include "c_cronograma.php";?>     
    <div align="center"><button class="button" onclick="document.location='home_investigador.php'">Volver</button></div>
</body>
</html>
