<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Investigaciones</title>
    <link rel="stylesheet" href="style/styles.css">
    <?php 
    require_once "c_reporteinv.php";
    require_once "Investigacion.php";
     ?>
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
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div style="padding-right:10%;padding-left:10%;">
        <h1>Reportes de Investigacion</h1>
        <h3><i>Ajuste los filtros y presione buscar para obtener resultados</i></h3>
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
        <br> <br>
        <?php 

        if (!isset($_SESSION['resultados'])) {
            $inv = new Investigacion();
            $c = 'SELECT count(*) AS conteo
                  FROM investigacion';
            $_SESSION['numeros'] = $inv->counting($c, '', 'Ninguno', $pdo);

            $sql = 'SELECT codigo, nombre_corto, unidad_investigacion, idInv 
                    FROM investigacion';    
            $_SESSION['resultados'] = $inv->reporte($sql, '', 'Ninguno', $pdo); 
        }

        echo "<span> Total de investigaciones registradas: </span>";
        echo $_SESSION['numeros']['conteo'];
        echo "<br/> <br/> <br/>";

        if(isset($_SESSION['resultados']) && count($_SESSION['resultados']) !== 0){
            echo '<div role="table">' . "\n";
            echo '<div role="cabecera"> <span>Codigo</span> </div>';
            echo '<div role="cabecera"> <span>Nombre Corto</span> </div>';
            echo '<div role="cabecera"> <span>Unidad de Investigacion</span> </div>';
            for ($i=0; $i < count($_SESSION['resultados']); $i++) { 
                echo '<div role="fila">';
                echo '<div role="celda"> <span>' . htmlentities($_SESSION['resultados'][$i]['codigo']) . '</span> </div>';
                echo '<div role="celda"> <span>' . htmlentities($_SESSION['resultados'][$i]['nombre_corto']) . '</span> </div>';
                echo '<div role="celda"> <span>' . htmlentities($_SESSION['resultados'][$i]['unidad_investigacion']) . '</span> </div>';
                echo '<a href="detalles_investigacion_admin.php?inv_id='.$_SESSION['resultados'][$i]['idInv'].'">&gt&gt</a>'; echo "</td>";
                echo "</div>\n";

                echo "</div>";
                echo "<br /> <br />";
            }
        }
        echo "<br />";  
        ?>
    </div>
</body>
</html>