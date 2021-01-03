<!DOCTYPE html>
<html>
<head>
    <title>Publicaciones Registradas</title>
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

    <div style="padding-left:5%;padding-right:5%;">
        <h1 class="aLeft" style="font-size:40px;">Publicaciones</h1> 
        <div style="padding-top:35px;padding-bottom:25px">
            <button class="button aRight" style="font-size:18px;" onclick="document.location='buscar_publicacion.php'">Buscar Publicacion</button>
        </div>
    </div>
    <br><br><br>
    <?php include "c_listapub.php"?>
</body>
</html>
