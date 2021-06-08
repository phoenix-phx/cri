<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style/styles.css">
    <title>UCB - SCI</title>
</head>
<body>
    <div style="height:50px;"></div>
    <div align="center" class="center">
        <img src="imagenes/LogoU_nombre.png">    
        <h1>Bienvenido a UCB - SCI: El sistema de soporte a la investigaci&oacute;n cient&iacute;fica</h1>
        <h2>Selecciona una opci&oacute;n para iniciar sesi&oacute;n</h2>
    </div>
    <br><br>
    <div style="padding-left: 30%; padding-right: 30%;">
        <a class="link" href="login_investigador.php?modo=investigador">
            <div class="container aLeft" style="width: 200px; padding: 3px;">
                <div align="center"><img src="imagenes/Investigador/investigador_login.jpg" style="height:160px;width:200px;"></div>
                <div align="center"><h2>Investigador</h2></div>
            </div>
        </a>
        <a class="link" href="login_administrativo.php?modo=administrativo">
            <div class="container aRight" style="width: 200px; padding: 3px;">
                <div align="center"><img src="imagenes/Administrativo/administrativo_login.jpg"  style="height:160px;width:200px;"></div>
                <div align="center"><h2>Administrativo</h2></div>
            </div>
        </a>
    </div>
</body>
</html>