<!DOCTYPE html>
<html>
<head>
    <title>Detalles de Investigacion</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <!-- header -->
    <div class="bar" style="height: 50px; background-color: #0b1f3f;">
        <a href="home_investigador.php" class="aLeft textIblue">
            <img src="imagenes/LogoU.png" style="height: 50px;">
        </a>
        <div style="padding-top: 15px; padding-bottom: 15px;">
            <a href="home_investigador.php" class="aLeft textIblue">
                Unidad de Investigacion UCB
            </a>
            <a href="" class="aRight textIblue">
                <!-- Agregar usuario -->
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
            <button class="button aRight"  onclick="document.location='<?php echo $cad; ?>'">Cerrar</button>
        </div>
    </div>
    <br><br><br>
    <!-- Detalles -->
    <div style="padding-left:5%;padding-right:5%;font-size:17px;" align="left">
        <?php include "c_vistainvestigacion.php"?>
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
    </div>
</body>
</html>