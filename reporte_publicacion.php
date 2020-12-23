<!DOCTYPE html>
<html>
<head></head>
<body>
    <h1>Reportes de Publicacion</h1>
    <h3><i>Ajuste los filtros para obtener resultados</i></h3>
    <form action="c_reportepub.php" method="post">
        Unidad de Investigacion: <input name="uniInvRP" type="text" value="Todos">
        Investigador: <input name="nomInvRP" type="text" value="Todos"><br>
        Estado: <select name="estadoRP">
            <option value="Todos">Todos</option>
            <option value="Abierto">Abierto</option>
            <option value="Cerrado">Cerrado</option>           
        </select>
        Tipo publicacion: <select name="tipoCP" id="tipoCP">
            <option value="Todos">Todos</option>
            <option value="Articulo">Articulo</option>
            <option value="Acta">Acta</option>
            <option value="Libro">Libro</option>
            <option value="Capitulo de libro">Capitulo de libro</option>
            <option value="Patente">Patente</option>
            <option value="Otro">Otro</option>
        </select><br>
        <input type="submit" value="Buscar">
    </form>
</body>
</html>