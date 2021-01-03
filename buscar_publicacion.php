<!DOCTYPE html>
<html>
<head>
    <title>Buscar Publicacion</title>
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
    <div style="padding-right:10%;padding-left:10%;">
        <h1>Buscar Publicaciones</h1>
        <h3><i>Elija el filtro e ingrese la busqueda</i></h3>
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
        <form action="c_busquedapub.php" method="post" align="center">
            Filtrar por: <select name="filtroBP" id="filtroBP">
                <option value="Ninguno">Ninguno</option>
                <option value="Unidad de Investigacion">Unidad de Investigacion</option>
                <option value="Nombre">Nombre</option>
                <option value="Codigo">Codigo</option>
                <option value="Tipo">Tipo</option>
            </select>
            <input class="stextInput" style="margin:20px;" name="txtFiltroBP" id="txtFiltroBP" type="text" placeholder="Ingrese la busqueda aqui" size="40"><br>
            <input class="button" type="submit" value="buscar">
        </form>
        <h3><i>Resultados:</i></h3>
    </div>
</body>
</html>
