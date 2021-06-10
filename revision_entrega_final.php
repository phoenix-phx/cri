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
    <title>Revisar Investigaci&oacute;n</title>
    <link rel="stylesheet" href="style/styles.css">
    <?php require_once "c_revisionentrega.php"?>
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
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div style="padding-left:5%;padding-right:5%;"> 
    <h1>Revisi&oacute;n de Documento</h1>
    </div>
    <div style="padding-left:7%;padding-right:5%">
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
    <form method="post" action="c_revisionentregaPost.php?pub_id=<?php echo($_REQUEST['pub_id']) ?>">
        <h3 class="inst"><i>Datos del env&iacute;o</i></h3>
        C&oacute;digo Publicaci&oacute;n:
        <input class="textInput" name="nombre" id="nombre" disabled="disabled" type="text" value="<?php echo($codigo) ?>"><br><br>
        
        Titulo Publicaci&oacute;n:
        <input class="textInput" name="nombre" id="nombre" disabled="disabled" type="text" value="<?php echo($titulo) ?>"><br><br>

        Descripci&oacute;n del env&iacute;o:<br>
        <textarea class="textInput" name="obsRevEF" rows="8" cols="100" disabled="disabled"><?php echo $descripcion; ?></textarea><br><br>
        
        Archivo Adjunto:<br>
        <?php echo $linky; ?><br><br>

        <h3 class="inst"><i>Escriba una retroalimentación a continuación. Debe ingresar todos los datos obligatorios (<span class="must">*</span>)</i></h3>
        Observaciones:<span class="must">*</span><br><br>
        <div align="center">
        <textarea class="textInput" name="obsRevEF" rows="4" cols="100" placeholder="Escribe la retroalimentaci&oacute;n aqui"></textarea><br>
        <input class="button" type="submit" value="Enviar Revisi&oacute;n">
        <input class="button" type="submit" name="cancel" value="Cancelar" />
        </div>
    </form>
    </div>
</body>
</html>