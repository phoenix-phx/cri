<!DOCTYPE html>
<html>
<head>
    <title>Buscar Publicacion</title>
    <?php 
        require_once "c_busquedapub.php";
        require_once "Publicacion.php";
    ?>
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
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div style="padding-right:10%;padding-left:10%;">
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
            <div align="center">
            Filtrar por: <select name="filtroBP" id="filtroBP">
                <option value="Ninguno">Ninguno</option>
                <option value="Unidad de Investigacion">Unidad de Investigacion</option>
                <option value="Nombre">Nombre</option>
                <option value="Codigo">Codigo</option>
                <option value="Tipo">Tipo</option>
            </select>
            <input class="stextInput" style="margin:20px;" name="txtFiltroBP" id="txtFiltroBP" type="text" placeholder="Ingrese la busqueda aqui" size="40">
            </div>
            <br>
            <div align="center"><input class="button" type="submit" value="Buscar"></div>
        </form>
        <h3><i>Resultados:</i></h3>
        <br><br>
        </div>
        <?php 
        if (!isset($_SESSION['resultados'])) {
            $pub = new Publicacion();
            $_SESSION['resultados'] = $pub->busqueda('Ninguno', '', $pdo);
        }

        if(isset($_SESSION['resultados']) && count($_SESSION['resultados']) !== 0){
            echo'<div style="padding-left:5%;padding-right:5%;">' . "\n";
            echo '<div role="cabecera" align="center"> 
                <div class="aLeft" style="width:320px;">CODIGO</div> 
                <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
                <div class="aLeft" style="width:250px;">TIPO PUBLICACION</div>
                </div><br><br>
            </div>';
            echo '<div style="padding-left:4%;padding-right:4%;">';
            for ($i=0; $i < count($_SESSION['resultados']); $i++) { 

                echo '<div role="fila" class="container" 
	            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
	            <div class="aLeft" style="width:320px;">' . htmlentities($_SESSION['resultados'][$i]['codigo']) . '</div> 
	            <div class="aLeft" style="width:500px;">' . htmlentities($_SESSION['resultados'][$i]['titulo']) . '</div> 
	            <div class="aLeft" style="width:250px;">' . htmlentities($_SESSION['resultados'][$i]['tipo']) . '</div>
	            <a class="link" target="_blank" href="detalles_publicacion_admin.php?pub_id='.$_SESSION['resultados'][$i]['idPub'].'">&gt&gt</a>';
	            echo "</div>";
	            echo '<br><br>';
            }
            echo '</div>';
            if(isset($_SESSION['resultados'])){
                unset($_SESSION['resultados']);
            }

            if(isset($_SESSION['numeros'])){
                unset($_SESSION['numeros']);
            }
        }
        else if (isset($_SESSION['resultados']) && count($_SESSION['resultados']) === 0) {
            echo "No se encontraron resultados a su busqueda";
            if(isset($_SESSION['resultados'])){
                unset($_SESSION['resultados']);
            }

            if(isset($_SESSION['numeros'])){
                unset($_SESSION['numeros']);
            }
        }
        echo "<br />";  
        ?>
</body>
</html>
