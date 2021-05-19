<!DOCTYPE html>
<html>
<head>
	<title>Detalles Investigaci&oacute;n</title>
    <link rel="stylesheet" href="style/styles.css">
    <?php 
    session_start();
    include "c_vistainvestigacion.php"?>
    <style>
        body{
            line-height:150%; 
        }
    </style>
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
    <!-- Titulo y botones -->
    <div style="padding-left:5%;padding-right:5%;">
        <h1 class="aLeft" style="font-size:40px;">Detalles</h1>
        <div style="padding-top:30px;padding-bottom:30px">
            <button class="button aRight" onclick="document.location='historial_investigacion.php?inv_id=<?php echo($_REQUEST['inv_id']) ?>'">Ver Historial de Investigaci&oacute;n</button>
            <?php if ($est !== 'en curso'): ?>
                <button class="button aRight" style="margin-right:20px;" onclick="document.location='confirmacion_reapertura_inv.php?inv_id=<?php echo($_REQUEST['inv_id'])?>'"> Reabrir Investigaci&oacute;n </button>
            <?php endif ?>
        </div>
    </div>
    <br>

    <div style="padding-left:5%;padding-right:5%;font-size:17px;" align="left">
    <?php
    if (isset($_SESSION['error'])) {
        echo ('<br><div style="color:red;">'.htmlentities($_SESSION['error'])."</div>\n");
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo ('<br><div style="color:green;">'.htmlentities($_SESSION['success'])."</div>\n");
        unset($_SESSION['success']);
    }
    ?>  
        <?php 
        //datos generales
    echo "<p><b>DATOS GENERALES</b></p>";
    echo '<div role="container">' . "\n";
    echo '<div role="fila"> <span>C&Oacute;DIGO: </span> <span>' . $codigo . ' </span></div>';
    echo '<div role="fila"> <span>TITULO: </span> <span>' . $titulo . ' </span></div>';
    echo '<div role="fila"> <span>NOMBRE CORTO: </span> <span>' . $nc . ' </span></div>';
    echo '<div role="fila"> <span>LINEA DE INVESTIGACI&Oacute;N: </span> <span>' . $li . ' </span> <div>';
    echo '<div role="fila"> <span>UNIDAD DE INVESTIGACI&Oacute;N: </span> <span>' . $ui . ' </span></div>';
    echo '<div role="fila"> <span>RESUMEN: </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>FECHA INICIO: </span> <span>' . $finicio . ' </span></div>';
    echo '<div role="fila"> <span>FECHA FINAL: </span> <span>' . $ffinal . ' </span></div>';    

    //autores
    echo "<br>";
    echo "<span><b>INVESTIGADORES</b></span>";
    echo '<span> <a href="ver_autor_admin.php?type=inv&inv_id='. $_REQUEST['inv_id'] . '">Ver detalles</a></span>';
    echo '<div role="fila" id="autores">';
    echo '<ul>';
    if($principal !== false){
        echo '<li>' . htmlentities($principal['nombre']) . '</li>'; 
    }
    if(count($internos) !== 0){
        for ($i=0; $i < count($internos); $i++) {
            echo '<li>' . htmlentities($internos[$i]['nombre']) . '</li>'; 
        }
    }
    if(count($externos) !== 0){
        for ($i=0; $i < count($externos); $i++) {
            echo '<li>' . htmlentities($externos[$i]['nombre']) . '</li>'; 
        }
    }
    echo '</ul>';
    echo '</div>';

    //financiamiento
    echo "<p><b>FINANCIAMIENTO</b></p>";
    echo '<div role="fila" style="padding-left:10px;">';
    if($financiador !== false){
        echo '<span>' . htmlentities($financiador['nombre_financiador']) . ' </span> <span> <a href="detalles_financiador_admin.php?inv_id=' . $_REQUEST['inv_id'] . '&fin_id=' . $financiador['idFinanciador'] . '">Ver detalles</a></span>';
    }
    else{
        echo '<span>No existe financiamiento</span>';   
    }
    echo "</div>";

    //actividades
    echo "<p><b>ACTIVIDADES</b></p>";
    echo '<div role="fila" id="actividades">';
    if(count($actividades) !== 0){
        for ($i=0; $i < count($actividades); $i++) {
            echo '<div id="actividad' . ($i+1) .'">';
            echo '<p> <span>NOMBRE:</span> <span>' . htmlentities($actividades[$i]['nombre']) . '</span>';
            echo "<br>";
            echo '<span>FECHA INICIO: </span> <span>' . htmlentities($actividades[$i]['fecha_inicio']) . '</span>';
            echo "<br>";
            echo '<span>FECHA FINALIZACI&Oacute;N: </span> <span>' . htmlentities($actividades[$i]['fecha_final']) . '</span> <p>';
            echo "</div>";
        }
    }
    else{
        echo "<span>No se han registrado actividades</span>";
    }
    echo '</div>';

    //publicaciones
    echo '<br><p><b> PUBLICACIONES </b></p>';
    $estado = $inv->loadPubAsociadas($_SESSION['idUsuario'], $_SESSION['permisos'], $pdo);
    if($estado === false){
        echo 'No existen publicaciones asociadas registradas ';
    }
    echo '</div>';
         ?>
    </div>
</body>
</html>