<!DOCTYPE html>
<html>
<head></head>
<body>
    <h1>Reportes de Investigacion</h1>
    <h3><i>Ajuste los filtros para obtener resultados</i></h3>
    <form> 
        Unidad de Investigacion: <input name="uniInvRI" type="text" value="Todos">
        Investigador: <input name="nomInvRI" type="text" value="Todos"><br>
        Estado: <select name="estadoRI">
            <option value="Todos">Todos</option>
            <option value="Abierto">Abierto</option>
            <option value="Cerrado">Cerrado</option>           
        </select>
        Financiamiento: <select name="financiamientoRI">
            <option value="Todos">Todos</option>
            <option value="Interno">Interno</option>
            <option value="Externo">Externo</option>           
        </select><br>
        Año de creacion: <input name="anioCreacionRI" type="text" value="Todos"><br>
        <input type="submit" value="Buscar">
    </form>
</body>
</html>