<?php 
session_start();
// security control
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( $_SESSION['permisos'] !== "administrativo"){
    die('Acceso denegado');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Buscar Investigaci&oacute;n</title>
    <link rel="stylesheet" href="style/styles.css">
    <?php 
    //require_once "c_busquedainv.php";
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
                UCB - SCI
            </a>
            <a class="aRight textIblue">
                <?php 
                    //session_start();
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div style="padding-right:10%;padding-left:10%;">
        <h1>Buscar Investigaciones</h1>
        <h3><i>Elija el filtro e ingrese la b&uacute;squeda</i></h3>
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
            <div align="center">
            Filtrar por: 
            <select name="filtroBI" id="filtroBI">
                <option value="Ninguno">Ninguno</option>
                <option value="Unidad de Investigacion">Unidad de Investigaci&oacute;n</option>
                <option value="Nombre Investigacion">Nombre Investigaci&oacute;n</option>
                <option value="Codigo Investigacion">Codigo Investigaci&oacute;n</option>
                <option value="Nombre Investigador">Nombre Investigador</option>
            </select>
            <input class="stextInput" style="margin:20px;"name="txtFiltroBI" id="txtFiltroBI" type="text" placeholder="Ingrese la b&uacute;squeda aqui" size="40">
            </div>
            <br>
            <div align="center"><input class="button" type="submit" value="Buscar"></div>
        </form>
        <h3><i>Resultados:</i></h3>
    </div>
    <?php 
    if (!isset($_SESSION['resultados'])) {
        $inv = new Investigacion();
        $_SESSION['resultados'] = $inv->busqueda('Ninguno', '', $pdo);
    }

    if(isset($_SESSION['resultados']) && count($_SESSION['resultados']) !== 0){
        echo '<div style="padding-left:5%;padding-right:5%;">' . "\n";
        echo '<div role="cabecera" align="center"> 
            <div class="aLeft" style="width:320px;">C&Oacute;DIGO</div> 
            <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
            <div class="aLeft" style="width:250px;">UNIDAD DE INVESTIGACI&Oacute;N</div>
            </div><br><br>
        </div>';
        echo '<div style="padding-left:4%;padding-right:4%;">';
        for ($i=0; $i < count($_SESSION['resultados']); $i++) { 
            
            echo '<div role="fila" class="container" 
	            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
	                <div class="aLeft" style="width:320px;">' . htmlentities($_SESSION['resultados'][$i]['codigo']) . '</div> 
	                <div class="aLeft" style="width:500px;">' . htmlentities($_SESSION['resultados'][$i]['nombre_corto']) . '</div> 
	                <div class="aLeft" style="width:250px;">' . htmlentities($_SESSION['resultados'][$i]['unidad_investigacion']) . '</div>
	                <a class="link" target="_blank" href="detalles_investigacion_admin.php?inv_id='.$_SESSION['resultados'][$i]['idInv'].'">&gt&gt</a>
	                </div>';
	        echo "<br> <br>";    
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
        echo "<div align='center'> No se encontraron resultados a su busqueda</div>";
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
