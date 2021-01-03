<!DOCTYPE html>
<html>
<head>
    <title>Reporte publicacion</title>
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
    
        <h1>Reportes de Publicacion</h1>
        <h3><i>Ajuste los filtros para obtener resultados</i></h3>
        <form action="c_reportepub.php" method="post">
            <label for="uniInvRP">Unidad de Investigacion:</label> 
            <input class="xstextInput" style="margin:10px;" name="uniInvRP" id="uniInvRP" type="text" value="Todos">
            <label for="nomInvRP" style="padding-left:40px;">Investigador:</label> 
            <input class="xstextInput" style="margin-left:30px;"name="nomInvRP" id="nomInvRP" type="text" value="Todos"><br>
            <label for="estadoRP" style="padding-right:130px;">Estado:</label>    
            <select name="estadoRP" id="estadoRP">
                <option value="Todos">Todos</option>
                <option value="Abierto">Entregado</option>
                <option value="Cerrado">No Entregado</option>           
            </select>
            <label for="tipoCP" style="padding-right:2px;padding-left:235px;">Tipo publicacion:</label>
            <select name="tipoCP" id="tipoCP">
                <option value="Todos">Todos</option>
                <option value="Articulo">Articulo</option>
                <option value="Acta">Acta</option>
                <option value="Libro">Libro</option>
                <option value="Capitulo de libro">Capitulo de libro</option>
                <option value="Patente">Patente</option>
                <option value="Otro">Otro</option>
            </select>
            <br><br><br>
            <div align="center"><input class="button" type="submit" value="Buscar"></div>
            
            <h3><i>Resultados:</i></h3>
        </form>
    </div>
</body>
</html>