<!DOCTYPE html>
<html>
<head>
    <title>Buscar Investigacion</title>
    <?php session_start(); ?>
</head>
<body>
    <h1>Buscar Investigaciones</h1>
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
    <form action="c_busquedainv.php" method="post">
        Filtrar por: 
        <select name="filtroBI" id="filtroBI">
            <option value="Ninguno">Ninguno</option>
            <option value="Unidad de Investigacion">Unidad de Investigacion</option>
            <option value="Nombre Investigacion">Nombre Investigacion</option>
            <option value="Codigo Investigacion">Codigo Investigacion</option>
            <option value="Nombre Investigador">Nombre Investigador</option>
        </select>
        <input name="txtFiltroBI" id="txtFiltroBI" type="text" placeholder="Ingrese la busqueda aqui" size="40"><br>
        <input type="submit" value="buscar">
    </form>
    <i>Resultados:</i>
</body>
</html>
