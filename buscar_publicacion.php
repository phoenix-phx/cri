<!DOCTYPE html>
<html>
<head>
    <title>Buscar Publicacion</title>
    <?php session_start(); ?>
</head>
<body>
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
    <form action="c_busquedapub.php" method="post">
        Filtrar por: <select name="filtroBP" id="filtroBP">
            <option value="Ninguno">Ninguno</option>
            <option value="Unidad de Investigacion">Unidad de Investigacion</option>
            <option value="Nombre">Nombre</option>
            <option value="Codigo">Codigo</option>
            <option value="Tipo">Tipo</option>
        </select>
        <input name="txtFiltroBP" id="txtFiltroBP" type="text" placeholder="Ingrese la busqueda aqui" size="40"><br>
        <input type="submit" value="buscar">
    </form>
    <i>Resultados:</i>
</body>
</html>
