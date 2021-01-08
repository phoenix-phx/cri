<!DOCTYPE html>
<html>
<head>
    <title>Crear Usuario</title>
    <?php require_once "c_crearusuario.php"?>
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
                Unidad de Investigaci&oacute;n UCB
            </a>
            <a class="aRight textIblue">
                <?php 
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div style="padding-left:5%;padding-right:5%;">

        <h1>Registrar Usuario</h1>
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
        <form action="c_crearusuario.php" method="post" >
            <label for="nombre">Nombre: </label>
            <input class="textInput" name="nombre" id="nombre" type="text"><br>

            <label for="correo">Correo:</label>
            <input class="textInput" name="correo" id="correo" type="text"><br>

            <label for="celular">Celular:</label>
            <input class="textInput" name="celular" id="celular" type="text"><br>

            <label for="telefono">Tel&eacute;fono:</label>
            <input class="textInput" name="telefono" id="telefono" type="text"><br>
            
            <h3>Filiaci&oacute;n</h3>
            <input type="radio" name="rbfiliacion" id="rbdocente" value="docente">
            <label for="rbdocente">Docente</label><br>
            <input type="radio" name="rbfiliacion" id="rbestudiante" value="estudiante">
            <label for="rbestudiante">Estudiante</label><br>
            <input type="radio" name="rbfiliacion" id="rbadmin" value="administrativo">
            <label for="rbadmin">Administrativo</label><br>
            <label for="tUnidadI">Unidad de Investigaci&oacute;n</label>
            <input class="stextInput" type="text" name="tUnidadI" id="tUnidadI"><br>
            <h4>Permisos</h4>
            <input type="radio" name="rbpermisos" id="rbinvestigador" value="investigador">
            <label for="rbinvestigador">Investigador</label><br>
            <input type="radio" name="rbpermisos" id="rbadminp" value="administrativo">
            <label for="rbadminp">Administrativo</label><br>
            <br><br>
            <div align="center">
                <input class="button" style="margin-right:20px;" type="submit" value="Crear Usuario">
                <input class="button" type="submit" name="cancel" value="Cancelar" />
            </div>
            
        </form>
    </div>
        <!--Agregar footer-->
</body>
    
</html>

