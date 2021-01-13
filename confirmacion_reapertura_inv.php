<!DOCTYPE html>
<html>
<head>
	<title>Reabrir Investigaci&oacute;n</title>
    <link rel="stylesheet" href="style/styles.css">
    <?php session_start();?>
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
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div align="center">
        <h1 class="title">Reabrir Investigaci&oacute;n</h1>
        <p style="font-size:25px;width:365px;text-align:left;">Desea reabrir esta investigaci&oacute;n.
        </p>
        <button class="button" onclick="document.location='c_confirmacion_reapertura_inv.php?inv_id=<?php echo ($_REQUEST['inv_id'])?>'">Reabrir</button>
        <button class="button" onclick="document.location='detalles_investigacion_admin.php?inv_id=<?php echo ($_REQUEST['inv_id'])?>'">Volver</button>
    </div>
</body>
</html>