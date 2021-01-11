<!DOCTYPE html>
<html>
<head>
    <title>Investigaci&oacute;n cerrada</title>
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
                Unidad de Investigaci&oacute;n UCB
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
        <h1 class="title">Investigaci&oacute;n cerrada</h1>
        <p style="font-size:25px;width:800px;text-align:left;">Se ha registrado la finalizaci&oacute;n de esta investigaci&oacute;n. Por favor comuniquese con la 
        Direcci&oacute;n Administrativa Financiera (DAF) o la Coordinaci&oacute;n Regional de Investigaci&oacute;n
        (CRI) para mas informaci&oacute;n.</p>
        <button class="button" onclick="document.location='home_investigador.php'">Volver al inicio</button>
    </div>
</body>
</html>