<!DOCTYPE html>
<html>
<head>
    <title>Reporte publicacion</title>
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
    
        <h1>Reportes de Publicacion</h1>
        <h3><i>Ajuste los filtros para obtener resultados</i></h3>
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
            <br> <br>
        <?php 

        if (!isset($_SESSION['resultados'])) {
            $pub = new Publicacion();
            $c = 'SELECT count(*) AS conteo
                  FROM publicacion';
            $_SESSION['numeros'] = $pub->counting($c, '', 'Ninguno', $pdo);

            $sql = 'SELECT codigo, titulo, tipo, idPub 
                    FROM publicacion';    
            $_SESSION['resultados'] = $pub->reporte($sql, '', 'Ninguno', $pdo);
        }

        echo "<span> Total de publicaciones registradas: </span>";
        echo $_SESSION['numeros']['conteo'];
        echo "<br> <br> <br>";

        if(isset($_SESSION['resultados']) && count($_SESSION['resultados']) !== 0){
            echo '<div role="table">' . "\n";
            echo '<div role="cabecera"> <span>Codigo</span> </div>';
            echo '<div role="cabecera"> <span>Nombre Corto</span> </div>';
            echo '<div role="cabecera"> <span>Unidad de Investigacion</span> </div>';
            for ($i=0; $i < count($_SESSION['resultados']); $i++) { 
                echo '<div role="fila">';
                echo '<div role="celda"> <span>' . htmlentities($_SESSION['resultados'][$i]['codigo']) . '</span> </div>';
                echo '<div role="celda"> <span>' . htmlentities($_SESSION['resultados'][$i]['titulo']) . '</span> </div>';
                echo '<div role="celda"> <span>' . htmlentities($_SESSION['resultados'][$i]['tipo']) . '</span> </div>';
                echo '<a href="detalles_publicacion_admin.php?pub_id='.$_SESSION['resultados'][$i]['idPub'].'">&gt&gt</a>'; echo "</td>";
                echo "</div>\n";

                echo "</div>";
                echo "<br /> <br />";
            }
        }
        echo "<br />";  
        ?>
        </form>
    </div>
</body>
</html>