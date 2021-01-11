<!DOCTYPE html>
<html>
<head>
   <title>Detalles Publicaci&oacute;n</title>
   <link rel="stylesheet" href="style/styles.css">
   <style>
        body{
            line-height:150%; 
        }
    </style>
    <?php session_start();
    include "c_vistapublicacion.php"?>
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
        
    <div style="padding-left:5%;padding-right:5%;" >
        <h1 class="aLeft" style="font-size:40px;">Detalles</h1>
        <div style="padding-top:30px;padding-bottom:30px">
            <button class="button aRight" onclick="document.location='historial_publicacion.php?pub_id=<?php echo($_REQUEST['pub_id']) ?>'">Ver Historial de Publicaci&oacute;n</button>
            <?php if ($est !== 'en curso'): ?>
            <button class="button aRight" style="margin-right:20px;" onclick="document.location='confirmacion_reapertura_pub.php?pub_id=<?php echo($_REQUEST['pub_id'])?>'"> Reabrir Publicaci&oacute;n </button>
            <?php endif ?>

            <?php if ($estado !== false): ?>
            <button class="button aRight" style="margin-right:20px;" onclick="document.location='revision_entrega_final.php?pub_id=<?php echo($_REQUEST['pub_id']) ?>'"> Revisar Documento Final</button>                
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
    echo '<div role="fila"> <span>RESUMEN: </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>UNIDAD DE INVESTIGACI&Oacute;N: </span> <span>' . $ui . ' </span></div>';
    echo '<div role="fila"> <span>TIPO PUBLICACI&Oacute;N: </span> <span>' . $tipo . ' </span></div>';
    if($flag){
        echo '<div role="fila"> <span>INVESTIGACI&Oacute;N ASOCIADA: </span> <span>' . $nombreInv . ' </span></div>';
    }
    else{
        echo '<div role="fila"> <span>INVESTIGACI&Oacute;N ASOCIADA: </span> <span><i>' . 'No existe investigaci&oacute;n asociada' . '</i></span></div>';
    }
    //autores
    echo "<br>";
    echo "<span><b>AUTORES</b></span>";
    echo '<span> <a href="ver_autor_admin.php?type=pub&pub_id='. $_REQUEST['pub_id'] . '">Ver detalles</a></span>';
    echo '<div role="fila" id="autores">';
    echo '<ul>';
    if($principal !== false){
        echo '<li>' . htmlentities($principal['nombre']) . ' </li>';
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

    // archivo final
    echo "<p><b>ENTREGA FINAL</b></p>";
    echo '<div role="fila" id="archivo" style="padding-left:10px;">';
    $estado = $pub->existsDoc($_REQUEST['pub_id'], $pdo);
    if($estado === false){
        echo '<span>No se ha registrado la entrega del documento final </span>';
    }
    else{
        echo '<span>Se ha registrado la entrega del documento final y esta listo para su revisi&oacute;n respectiva</span>';        
    }
    echo "</div>";
    ?>
    </div>
</body>
</html>