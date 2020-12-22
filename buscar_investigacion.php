<!DOCTYPE html>
<html>
<head>
    <title>Buscar Investigacion</title>
</head>
<body>
    <h1>Buscar Investigaciones</h1>
    <h3><i>Elija el filtro e ingrese la busqueda</i></h3>
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
