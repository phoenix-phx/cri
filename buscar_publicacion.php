<!DOCTYPE html>
<html>
<head>
    <title>Buscar Publicacion</title>
    <?php 
    require_once "c_busquedapub.php";
    require_once "Publicacion.php";
    ?>
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
    <br> <br>
    <?php 
    if (!isset($_SESSION['resultados'])) {
        $pub = new Publicacion();
        $_SESSION['resultados'] = $pub->busqueda('Ninguno', '', $pdo);
    }

    if(isset($_SESSION['resultados']) && count($_SESSION['resultados']) !== 0){
        for ($i=0; $i < count($_SESSION['resultados']); $i++) { 
            echo '<div role="table">' . "\n";
            echo '<div role="cabecera"> <span>Codigo</span> </div>';
            echo '<div role="cabecera"> <span>Titulo</span> </div>';
            echo '<div role="cabecera"> <span>Tipo</span> </div>';
            
            echo '<div role="fila">';
            echo '<div role="celda"> <span>' . htmlentities($_SESSION['resultados'][$i]['codigo']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($_SESSION['resultados'][$i]['titulo']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($_SESSION['resultados'][$i]['tipo']) . '</span> </div>';
            echo '<a href="detalles_publicacion_inv.php?pub_id='.$_SESSION['resultados'][$i]['idPub'].'">&gt&gt</a>'; echo "</td>";
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
