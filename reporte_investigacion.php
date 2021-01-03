<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Investigaciones</title>
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
        <h1>Reportes de Investigacion</h1>
        <h3><i>Ajuste los filtros y presione buscar para obtener resultados</i></h3>
        <form action="c_reporteinv.php" method="post"> 
            <label for="uniInvRI">Unidad de Investigacion:</label> 
            <input class="xstextInput" style="margin:10px;" name="uniInvRI" id="uniInvRI" type="text" value="Todos">
            <label for="nomInvRI" style="padding-left:40px;">Investigador:</label> 
            <input class="xstextInput" style="margin-left:30px;"name="nomInvRI" id="nomInvRI" type="text" value="Todos"><br>
            <label for="estadoRI" style="padding-right:130px;">Estado:</label>    
            <select name="estadoRI" id="estadoRI">
                <option value="Todos">Todos</option>
                <option value="En Curso">En curso</option>
                <option value="Cerrado">Cerrado</option>           
            </select>
            <label for="estadoRI" style="padding-right:7px;padding-left:270px;">Financiamiento:</label>
            <select name="financiamientoRI">
                <option value="Todos">Todos</option>
                <option value="Interno">Interno</option>
                <option value="Externo">Externo</option>           
            </select><br>
            <label for="anioCreacionRI" style="margin-right:60px;">Año de creacion:</label>
            <input class="xstextInput" name="anioCreacionRI" id="anioCreacionRI" type="text" value="Todos">
            <br><br><br>
            <div align="center"><input class="button" type="submit" value="Buscar"></div>
        </form>
        <h3><i>Resultados:</i></h3>
    </div>
</body>
</html>