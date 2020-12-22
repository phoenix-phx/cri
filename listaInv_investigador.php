<!DOCTYPE html>
<html>
<head>
    <title>Mis Investigaciones</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
<<<<<<< HEAD
    <h1>Mis Investigaciones</h1> 
    <button onclick="document.location='nueva_investigacion.php'">+ Investigacion nueva</button>
    <br>
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
=======
    <!-- Header -->
    <div class="bar" style="height: 50px; background-color: #0b1f3f;">
        <a href="home_investigador.php" class="aLeft textIblue">
            <img src="imagenes/LogoU.png" style="height: 50px;">
        </a>
        <div style="padding-top: 15px; padding-bottom: 15px;">
            <a href="home_investigador.php" class="aLeft textIblue">
                Unidad de Investigacion UCB
            </a>
            <a href="" class="aRight textIblue">
                <!-- Agregar Usuario -->
            </a>
        </div>
    </div>
    <!-- /// -->


    <div style="padding-left:5%;padding-right:5%;">
        <h1 class="aLeft">Mis Investigaciones</h1> 
        <div style="padding-top:25px;padding-bottom:25px">
            <button class="button aRight" style="font-size:18px;" onclick="document.location='nueva_investigacion.php'">+ Investigacion nueva</button>
        </div>
    </div>

>>>>>>> 6997f37a27bdcff1a59abc1ff3afb3ef981c4aed
    <?php include "c_listainv.php"?>
</body>
</html>
