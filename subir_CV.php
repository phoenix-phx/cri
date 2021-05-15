<!DOCTYPE html>
<html>
<head>
	<title>Subir CV</title>
	<?php include "c_subirCV.php" ?>
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
                Unidad de Investigaci&oacute;n UCB
            </a>
            <a class="aRight textIblue">
                <?php 
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div style="padding-left:5%; padding-right:5%;">
    <h1>Curriculum Vitae</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo ('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <h3><i>Utilice el siguiente campo para subir su CV como un documento PDF (<span class="must">*</span>)</i></h3>
    <form action="c_subirCV.php?user_id=<?php echo $_REQUEST['user_id']?>" method="post" enctype="multipart/form-data">
        Archivo:<span class="must">*</span><br><br>
        <div>
            <input type="file" name="archivoEntregaF" />
            <input type="hidden" name="subido" />
            
            <!-- <span><img src="imagenes/icons/submit_file.png" style="height:40px;"></span> -->
        </div><br>
        <div align="center">
            <input class="button" style="margin-right:20px;" type="submit" value="Enviar">
            <input class="button" type="submit" name="cancel" value="Cancelar" />
        </div>
    </form>
    </div>
</body>
</html>