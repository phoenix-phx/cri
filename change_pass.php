<!DOCTYPE html>
<html>
<head>
    <title>Cambiar Contraseña</title>
    <?php require_once "c_password.php"?>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <!-- header -->
    <?php if ($_SESSION['permisos'] === 'investigador'): ?>
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
    <?php endif ?>
    <?php if ($_SESSION['permisos'] === 'administrativo'): ?>
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
    <?php endif ?>
    <div style="padding-left:5%;padding-right:5%;">
        <h1>Cambiar contraseña</h1>
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
        <form action="c_password.php?user_id=<?php echo($_REQUEST['user_id']) ?>" method="post" >
            <label for="pass">Ingrese su contraseña actual: </label>
            <input class="textInput" name="pass" id="pass" type="password"><br>

            <label for="npass">Ingrese la nueva contraseña:</label>
            <input class="textInput" name="npass" id="npass" type="password"><br>

            <label for="confir">Repita la nueva contraseña:</label>
            <input class="textInput" name="confir" id="confir" type="password"><br>

            <br><br>
            <div align="center">
                <input class="button" style="margin-right:20px;" type="submit" value="Cambiar Contraseña">
                <input class="button" type="submit" name="cancel" value="Cancelar" />
            </div>
            
        </form>
    </div>
        <!--Agregar footer-->
</body>
    
</html>

