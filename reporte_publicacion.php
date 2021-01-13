<!DOCTYPE html>
<html>
<head>
    <title>Reporte Publicaci&oacute;n</title>
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
                Unidad de Investigaci&oacute;n UCB
            </a>
            <a class="aRight textIblue">
                <?php 
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div style="padding-right:10%;padding-left:10%;">
    
        <h1>Reportes de Publicaci&oacute;n</h1>
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
            <label for="uniInvRP">Unidad de Investigaci&oacute;n:</label> 
            <input class="xstextInput" style="margin:10px;" name="uniInvRP" id="uniInvRP" type="text" value="Todos">
            <label for="nomInvRP" style="padding-left:40px;">Investigador:</label> 
            <input class="xstextInput" style="margin-left:30px;"name="nomInvRP" id="nomInvRP" type="text" value="Todos"><br>
            <label for="estadoRP" style="padding-right:130px;">Estado:</label>    
            <select name="estadoRP" id="estadoRP">
                <option value="Todos">Todos</option>
                <option value="En Curso">En Curso</option>
                <option value="Cerrado">Terminado</option>           
            </select>
            <label for="tipoCP" style="padding-right:2px;padding-left:258px;">Tipo publicaci&oacute;n:</label>
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
            <br>
            </div>
        <?php 

        if (!isset($_SESSION['resultados'])) {
            $pub = new Publicacion();
            $c = 'SELECT count(*) AS conteo
                  FROM publicacion';
            $_SESSION['numeros'] = $pub->counting($c, '', 'Ninguno', $pdo);

            $sql = 'SELECT substring(codigo,1,25) as codigo, substring(titulo,1,25) as titulo, tipo, idPub 
                FROM publicacion';
            $_SESSION['resultados'] = $pub->reporte($sql, '', 'Ninguno', $pdo);
        }

        echo '<div style="padding-left:11%;"> Total de publicaciones registradas: ';
        echo $_SESSION['numeros']['conteo'] . "</div>";
        echo "<br> <br> <br>";

        if(isset($_SESSION['resultados']) && count($_SESSION['resultados']) !== 0){
            echo'<div style="padding-left:5%;padding-right:5%;">' . "\n";
            echo '<div role="cabecera" align="center"> 
                <div class="aLeft" style="width:310px;">C&Oacute;DIGO</div> 
                <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
                <div class="aLeft" style="width:250px;">TIPO PUBLICACI&Oacute;N</div>
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
        }
        if(isset($_SESSION['resultados'])){
            unset($_SESSION['resultados']);
        }

        if(isset($_SESSION['numeros'])){
            unset($_SESSION['numeros']);
        }
        echo "<br />";  
        ?>
        </form>
    </div>
</body>
</html>