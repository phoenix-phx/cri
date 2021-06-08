<?php 
session_start();
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos']) || $_SESSION['permisos'] != 'investigador'){
    die('No ha iniciado sesion');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Subir Documento</title>
	<?php //include "c_subirentrega.php" ?>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <!-- header -->
    <div class="bar" style="height: 50px; background-color: #0b1f3f;">
        <a href="home_investigador.php" class="aLeft textIblue">
            <img src="imagenes/LogoU.png" style="height: 50px;">
        </a>
        <div style="padding-top: 15px; padding-bottom: 15px;padding-right:50px;">
            <a href="home_investigador.php" class="aLeft textIblue">
                UCB - SCI
            </a>
            <a class="aRight textIblue">
                <?php 
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div style="padding-left:5%; padding-right:5%;">
    <h1>Documento final</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo ('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <h3><i>Para registrar el documento debe ingresar todos los datos obligatorios (<span class="must">*</span>)</i></h3>
    <form action="c_subirentrega.php?pub_id=<?php echo $_REQUEST['pub_id']?>" method="post" enctype="multipart/form-data">
        Archivo:<span class="must">*</span><br><br>
        <div>
            <input type="file" name="archivoEntregaF" />
            <!-- <span><img src="imagenes/icons/submit_file.png" style="height:40px;"></span> -->
        </div><br>
        Descripci&oacute;n del env&iacute;o:<span class="must">*</span><br><br>
        <textarea class="textInput" name="descripcionEnvio" rows="5" cols="100" placeholder="Escribe una pequeña descripci&oacute;n"></textarea><br>
        <div align="center">
            <input class="button" style="margin-right:20px;" type="submit" value="Enviar">
            <input class="button" type="submit" name="cancel" value="Cancelar" />
        </div>
    </form>
    </div>
</body>
</html>