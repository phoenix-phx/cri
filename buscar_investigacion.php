<!DOCTYPE html>
<html>
<head>
    <title>Buscar Investigacion</title>
    <?php 
    require_once "c_busquedainv.php";
    require_once "Investigacion.php";
    ?>
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
    <br> <br>
    <?php 
    if (!isset($_SESSION['resultados'])) {
        $inv = new Investigacion();
        $_SESSION['resultados'] = $inv->busqueda('Ninguno', '', $pdo);
    }

    if(isset($_SESSION['resultados']) && count($_SESSION['resultados']) !== 0){
        for ($i=0; $i < count($_SESSION['resultados']); $i++) { 
            echo '<div role="table">' . "\n";
            echo '<div role="cabecera"> <span>Codigo</span> </div>';
            echo '<div role="cabecera"> <span>Nombre Corto</span> </div>';
            echo '<div role="cabecera"> <span>Unidad de Investigacion</span> </div>';
                
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
    else if (isset($_SESSION['resultados']) && count($_SESSION['resultados']) === 0) {
        echo "No se encontraron resultados a su busqueda";
    }
    echo "<br />";  
    ?>
</body>
</html>
