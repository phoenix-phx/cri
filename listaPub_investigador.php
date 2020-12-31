<!DOCTYPE html>
<html>
<head>
    <title>Mis Publicaciones</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
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
        <h1 class="aLeft title" >Mis Publicaciones</h1> 
        <div style="padding-top:35px;padding-bottom:25px">
            <button class="button aRight" style="font-size:18px;" onclick="document.location='nueva_publicacion.php'">+ Publicacion nueva</button>
        </div>
    </div>
    <br><br><br>
    <?php include "c_listapub.php"?>
</body>
</html>
