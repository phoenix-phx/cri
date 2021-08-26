<!DOCTYPE html>
<html>
<head>
    <title>Publicaci&oacute;n cerrada</title>
    <link rel="stylesheet" href="style/styles.css">
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
                    session_start();
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div align="center">
        <h1 class="title">Publicaci&oacute;n cerrada</h1>
        <p style="font-size:25px;width:570px;text-align:left;">Se ha registrado la finalizaci&oacute;n de esta publicaci&oacute;n.
        </p>
        <button class="button" onclick="document.location='home_investigador.php'">Volver al inicio</button>
    </div>
</body>
</html>