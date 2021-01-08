<!DOCTYPE html>
<html>
<head>
    <title>Revisar Investigaci&oacute;n</title>
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
                Unidad de Investigaci&oacute;n UCB
            </a>
            <a class="aRight textIblue">
                <?php 
                    //session_start();
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div style="padding-left:5%;padding-right:5%;"> 
    <h1>Revisi&oacute;n de Entrega Final</h1>
    </div>
    <div style="padding-left:7%;padding-right:5%">
    <?php include "c_revisionentrega"?>
    <form>
        Observaciones:<br>
        <div align="center">
        <textarea class="textInput" name="obsRevEF" rows="4" cols="100" placeholder="Escribe la retroalimentaci&oacute;n aqui"></textarea><br>
        <input class="button" type="submit" value="Enviar Revisi&oacute;n"></div>
    </form>
    </div>
</body>
</html>