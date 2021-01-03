<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style/styles.css">

</head>
<body>
    <div align="center" class="center">
        <img src="imagenes/LogoU_nombre.png">    
        <h1>Bienvenido al sistema academico para Investigaciones UCB</h1>
        <h2>Selecciona una opcion para iniciar sesion</h2>
    </div>
    <br><br>
    <div style="padding-left: 330px; padding-right: 330px;">
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