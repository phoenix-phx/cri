<!DOCTYPE html>
<html>
<head>
	<title>Login Investigador</title>
    <?php require_once "c_acceso.php"?>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <div style="height:50px;"></div>
    <div align="center"><img src="imagenes/LogoU_nombre.png" ></div>
    <h1 align="center">Ingreso al Sistema para Investigadores</h1>
    
    <h3 align="center">Coloca tu usuario y contrase&ntilde;a para poder ingresar</h3><br>
    <?php
    if (isset($_SESSION['error'])) {
        echo ('<div align="center" style="color:red;">'.htmlentities($_SESSION['error'])."</div><br>\n");
        unset($_SESSION['error']);
    }
    ?>
    <div align="center">
        <div align="center" class="container" style="width:380px;height:230px;" >
            <form action="c_acceso.php?modo=investigador" method="POST">
                <br>
                <div align="left" style="padding-left:47px;"><label for="user">Usuario:<br></label></div>
                <input id="user" name="user" type="text" class="textInput" style="width:75%;"><br><br>
                <div align="left" style="padding-left:47px;"><label for="pass">Contrase&ntilde;a:<br></label></div>
                <input id="pass" name="pass" type="password" class="textInput"  style="width:75%;"><br><br>
                <button class="button" style="width:78%;height:padding:5px;">Ingresar</button>
            </form>
        </div>
        <br>
        <a style="color: blue;" href="login_administrativo.php?modo=administrativo">Ingreso administrativo</a>
    </div>
    

</body>
</html>