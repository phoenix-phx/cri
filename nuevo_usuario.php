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
            <p class="inst"><i>Para una operacion correcta debe ingresar todos los datos obligatorios (<span class="must">*</span>)</i></p><br>

            <label for="nombre">Nombre:<span class="must">*</span> </label>
            <input class="textInput" name="nombre" id="nombre" type="text"><br>

            <label for="correo">Correo:<span class="must">*</span></label>
            <input class="textInput" name="correo" id="correo" type="text"><br>

            <label for="celular">Celular:</label>
            <input class="textInput" name="celular" id="celular" type="text"><br>

            <label for="telefono">Tel&eacute;fono:</label>
            <input class="textInput" name="telefono" id="telefono" type="text"><br>
            
            <h3>Filiaci&oacute;n<span class="must">*</span></h3>
            <input type="radio" name="rbfiliacion" id="rbdocente" value="docente">
            <label for="rbdocente">Docente</label><br>
            <input type="radio" name="rbfiliacion" id="rbestudiante" value="estudiante">
            <label for="rbestudiante">Estudiante</label><br>
            <input type="radio" name="rbfiliacion" id="rbadmin" value="administrativo">
            <label for="rbadmin">Administrativo</label><br>
            <label for="tUnidadI">Unidad de Investigaci&oacute;n:<span class="must">*</span></label>
            <select name="tUnidadI" id="tUnidadI">
                <option value="">Ninguno</option>
                <option value="Familia y Comunidad">Familia y Comunidad</option>
                <option value="Ética y moral">&Eacute;tica y moral</option>
                <option value="Desarrollo humano integral: Derechos humanos, salud y educacion">Desarrollo humano integral: Derechos humanos, salud y educación</option>
                <option value="Ciencia, tecnologia e innovacion">Ciencia, tecnología e innovación</option>
                <option value="Crecimiento equitativo, desarrollo inclusivo, emprendimiento y productividad">Crecimiento equitativo, desarrollo inclusivo, emprendimiento y productividad</option>
                <option value="Medio ambiente, recursos naturales y energias">Medio ambiente, recursos naturales y energías</option>
                <option value="Culturas y patrimonio">Culturas y patrimonio</option>
                <option value="Institucionalidad, relaciones internacionales y soberania">Institucionalidad, relaciones internacionales y soberanía<option>
            </select>
            <br>
            <h4>Permisos<span class="must">*</span></h4>
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

