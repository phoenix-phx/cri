<!DOCTYPE html>
<html>
<head>
    <title>Confirmar Cierre</title>
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
    <h1 class="title">Cerrar investigacion</h1>
    <p style="font-size:18px;">Esta accion no puede deshacerse, Esta seguro que desea cerrar la investigacion?</p>
    <div style="height:30px;"></div>
    <div align="center"> 
        <button class="button" onclick="document.location='c_confirmacion_cierre.php?inv_id=<?php echo $_REQUEST['inv_id'] ?>'">Confirmar</button>
        <button class="button" onclick="document.location='detalles_investigacion_inv.php?inv_id=<?php echo $_REQUEST['inv_id'] ?>'">Cancelar</button>
    </div>
</body>
</html>