<!DOCTYPE html>
<html>
<head>
    <title>Ver Publicacion</title>
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
    
    <div style="padding-left:5%;padding-right:5%;">
        <h1 class="aLeft" style="font-size:40px;">Detalles</h1>
        <div style="padding-top:30px;padding-bottom:30px">
            <button class="button aRight" style="font-size:18px;" onclick="document.location='editar_publicacion.php?pub_id=<?php echo $_REQUEST['pub_id']?>'">Editar</button>
            <button class="button aRight" style="font-size:18px;"  onclick="document.location='subir_entrega_final.php?pub_id=<?php echo $_REQUEST['pub_id']?>'">Subir Entrega Final</button>
        </div>
    </div>
    <br><br><br>
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
    <?php include "c_vistapublicacion.php" ?>
    </div>
</body>
</html>