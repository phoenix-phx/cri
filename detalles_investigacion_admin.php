<!DOCTYPE html>
<html>
<head>
	<title>Detalles Investigacion</title>
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
                Unidad de Investigacion UCB
            </a>
            <a class="aRight textIblue">
                <?php 
                    session_start();
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <!-- Titulo y botones -->
    <div style="padding-left:5%;padding-right:5%;">
        <h1 class="aLeft" style="font-size:40px;">Detalles</h1>
        <div style="padding-top:30px;padding-bottom:30px">
            <button class="button aRight" onclick="document.location='c_historialinv.php?inv_id=<?php echo($_REQUEST['inv_id']) ?>'">Ver Historial de Investigacion</button>
        </div>
    </div>
    <br><br><br>

    <div style="padding-left:5%;padding-right:5%;font-size:17px;" align="left">
        <?php include "c_vistainvestigacion.php"?>
    </div>
</body>
</html>