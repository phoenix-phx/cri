<!DOCTYPE html>
<html>
<head>
    <title>Crear Usuario</title>
    <?php require_once "c_editarusuario.php"?>
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
        <h1>Editar Usuario</h1>
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
        <form action="c_editarusuario.php?user_id=<?php echo($_REQUEST['user_id']) ?>" method="post" >
            <p class="inst"><i>Para una operacion correcta debe ingresar todos los datos obligatorios (<span class="must">*</span>)</i></p>
            <h3>Datos Generales</h3>
            <label for="nombre"> Nombre:<span class="must">*</span></label>
            <input class="textInput" name="nombre" id="nombre" type="text" value="<?php echo($nombre) ?>"><br>

            <label for="correo">Correo:<span class="must">*</span></label>
            <input class="textInput" name="correo" id="correo" type="text" value="<?php echo($correo) ?>"><br>

            <label for="celular">Celular:</label>
            <input class="textInput" name="celular" id="celular" type="text" value="<?php if(strlen($celular) !== 0) echo($celular)?>"><br>

            <label for="telefono">Tel&eacute;fono:</label>
            <input class="textInput" name="telefono" id="telefono" type="text" value="<?php if(strlen($telefono) !== 0) echo($telefono)?>"><br>
            
            <h3>Datos de Sesi&oacute;n</h3>
            <label for="nombre">Nombre de Usuario: </label>
            <input class="textInput" name="user" id="user" type="text" disabled="disabled" value="<?php echo($user) ?>">
            <br><br>
            <?php 
            if($_SESSION['idUsuario'] === $_REQUEST['user_id']){
                echo '<a href="change_pass.php?user_id='.$_REQUEST['user_id'].'">Cambiar Contraseña</a>
                <br>';
            }
            ?>
            <h3>Filiaci&oacute;n<span class="must">*</span></h3>
            <input type="radio" name="rbfiliacion" id="rbdocente" value="docente" <?php if($filiacion === 'docente') echo 'checked="checked"'; ?>>
            <label for="rbdocente">Docente</label><br>
            <input type="radio" name="rbfiliacion" id="rbestudiante" value="estudiante" <?php if($filiacion === 'estudiante') echo 'checked="checked"'; ?>>
            <label for="rbestudiante">Estudiante</label><br>
            <input type="radio" name="rbfiliacion" id="rbadmin" value="administrativo" <?php if($filiacion === 'administrativo') echo 'checked="checked"'; ?>>
            <label for="rbadmin">Administrativo</label><br>
            <label for="tUnidadI">Unidad de Investigaci&oacute;n:<span class="must">*</span></label>
            <input class="stextInput" type="text" name="tUnidadI" id="tUnidadI" value="<?php echo($unidad_investigacion) ?>"><br>
            <h3>Permisos<span class="must">*</span></h3>
            <input type="radio" name="rbpermisos" id="rbinvestigador" value="investigador" <?php if($rol === 'investigador') echo 'checked="checked"'; ?>>
            <label for="rbinvestigador" >Investigador</label><br>
            <input type="radio" name="rbpermisos" id="rbadminp" value="administrativo" <?php if($rol === 'administrativo') echo 'checked="checked"'; ?>>
            <label for="rbadminp">Administrativo</label><br>
            <br><br>
            <div align="center">
                <input class="button" style="margin-right:20px;" type="submit" value="Actualizar Datos">
                <input class="button" type="submit" name="cancel" value="Cancelar" />
            </div>
            
        </form>
    </div>
        <!--Agregar footer-->
</body>
    
</html>

