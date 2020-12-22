<!DOCTYPE html>
<html>
<head>
	<title>Login Administrativo</title>
    <?php require_once "c_acceso.php"?>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body> 
    <div align="center"><img src="imagenes/LogoU_nombre.png" ></div>
    <h1 align="center">Ingreso al sistema para administrativos</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo ('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <h3 align="center">Coloca tu usuario y contrase&ntilde;a para poder ingresar</h3><br>
    <div align="center">
        <div align="center" class="container" style="width:380px;height:200px;" >
            <form action="c_acceso.php?modo=administrativo" method="POST">
                <br>
                <div align="left" style="padding-left:47px;"><label for="user">Usuario:<br></label></div>
                <input id="user" name="user" type="text" class="textInput"><br><br>
                <div align="left" style="padding-left:47px;"><label for="pass">Contrase&ntilde;a:<br></label></div>
                <input id="pass" name="pass" type="password" class="textInput"><br><br><br>
                <button class="button" style="width:75%;">Ingresar</button>
            </form>
        </div>
        <br>
        <a style="color:blue;" href="login_investigador.php?modo=investigador">Ingreso investigadores</a>
    </div>
</body>
</html>
