<!DOCTYPE html>
<html>
<head>
	<title>Login Administrativo</title>
</head>
<body>
    <div align="center"><img src="LogoU_nombre.png" ></div>
    <h1 align="center">Ingreso al sistema para investigadores</h1>
    <h3 align="center">Coloca tu usuario y contrase&ntilde;a para poder ingresar</h3>
    <div align="center">
        <div align="left" style="border: 3px solid black; height: 150px; width: 300px; padding-left: 60px; padding-top: 30px;" >
            <form action="c_acceso.php" method="POST">
                <label for="user">Usuario:<br></label>
                <input id="user" name="user" type="text"><br><br>
                <label for="pass">Contrase&ntilde;a:<br></label>
                <input id="pass" name="pass" type="password"><br>
                <button>Ingresar</button>
            </form>
        </div>
        <a href="login_administrativo.html">Ingreso administrativo</a>
    </div>
    

</body>
</html>