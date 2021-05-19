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
                <option value="Instituto de Investigaciones Socio Economicas">Instituto de Investigaciones Socio Economicas</option>
                <option value="Instituto de Investigaciones en Ciencias del Comportamiento">Instituto de Investigaciones en Ciencias del Comportamiento</option>
                <option value="Instituto de Estudios en Etica Profesional">Instituto de Estudios en Etica Profesional</option>
                <option value="Instituto para la Democracia">Instituto para la Democracia</option>
                <option value="Servicio en Capacitacion en Raio y Television">Servicio en Capacitacion en Raio y Television</option>
                <option value="Intituto de Investigaciones Aplicadas">Intituto de Investigaciones Aplicadas</option>
                <option value="Instituto de Investigaciones sobre Asentamientos Humanos">Instituto de Investigaciones sobre Asentamientos Humanos</option>
                <option value="Centro de Investigacion en Agua, Energia y Sotenibilidad">Centro de Investigacion en Agua, Energia y Sotenibilidad</option>
                <option value="Centro de Investigacion en Turismo">Centro de Investigacion en Turismo</option>
                <option value="Centro de Investigacion en Diseno">Centro de Investigacion en Diseno</option>
                <option value="Centro de Investigacion en Cadena de Suministros">Centro de Investigacion en Cadena de Suministros</option>
                <option value="Centro de Investigacion Desarrollo e Innovacion en Mecatronica">Centro de Investigacion Desarrollo e Innovacion en Mecatronica</option>
                <option value="Centro de Investigacion Boliviano de Estudios Sociales">Centro de Investigacion Boliviano de Estudios Sociales</option>
                <option value="Unidades de Investigacion Experimental">Unidades de Investigacion Experimental</option>
                <option value="Centro de Investigacion en Ingenieria Comercial">Centro de Investigacion en Ingenieria Comercial</option>
                <option value="Centro de investigacion e Innovacion del Departamento de Administracion de Empresas">Centro de investigacion e Innovacion del Departamento de Administracion de Empresas</option>
                <option value="Grupo de Investigacion BIOMA">Grupo de Investigacion BIOMA</option>
                <option value="Grupo de Investigacion Base/Aplicada Ingenieria Civil">Grupo de Investigacion Base/Aplicada Ingenieria Civil</option>
                <option value="Grupo de Investigacion Telecomunicaciones">Grupo de Investigacion Telecomunicaciones</option>
                <option value="Sociedad Cientifica Estudiantil de Administracion de Empresas">Sociedad Cientifica Estudiantil de Administracion de Empresas</option>
                <option value="Sociedad Cientifica Estudiantil de Derecho">Sociedad Cientifica Estudiantil de Derecho</option>
                <option value="Sociedad Cientifica Estudiantil de Ing. Ambiental">Sociendad Cientifica Esutdiantil de Ing. Ambiental</option>
                <option value="Sociedad Cientifica Estudiantil de Ingenieria Comercial">Sociedad Cientifica Estudiantil de Ingenieria Comercial</option>
                <option value="Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas">Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas</option>
                <option value="Sociedad Cientifica de Comunicacion Social">Sociedad Cientifica de Comunicacion Social</option>
                <option value="Sociedad Cientifica de Psicologia">Sociedad Cientifica de Psicologia</option>
                <option value="Sociedad Cientifica Estudiantil de Economia">Sociedad Cientifica Estudiantil de Economia</option>
                <option value="Sociedad Cientifica de la Carrera de Arquitectura">Sociedad Cientifica de la Carrera de Arquitectura</option>
                <option value="Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA">Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA</option>
                <option value="Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO">Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO</option>
                <option value="Sociedad Cientifica Estudiantil de Administracion Turistica">Sociedad Cientifica Estudiantil de Administracion Turistica</option>
                <option value="Sociedad Cientifica de Investigacion de Ingenieria Civil">Sociedad Cientifica de Investigacion de Ingenieria Civil</option>
                <option value="Sociedad Cientifica Estudinatil de Ingenieria Industrial">Sociedad Cientifica Estudinatil de Ingenieria Industrial</option>
                <option value="Sociedad Cientifica de ingenieria Quimica 'Jovenes para la Ciencia'">Sociedad Cientifica de ingenieria Quimica 'Jovenes para la Ciencia'</option>
                <option value="Sociedad Cientifica de Ingenieria Mecatronica">Sociedad Cientifica de Ingenieria Mecatronica</option>
                <option value="Sociedad Cientifica de Ingenieria Mecatronica">Sociedad Cientifica de Ingenieria Mecatronica</option>
                <option value="Sociedad Cientifica de Contaduria Publica">Sociedad Cientifica de Contaduria Publica</option>
                <option value="Sociedad Cientifica de Ingenieria de Telecomunicaciones">Sociedad Cientifica de Ingenieria de Telecomunicaciones</option>
                <option value="Sociedad Cientifica de Ciencias Politicas">Sociedad Cientifica de Ciencias Politicas</option>
                <option value="Sociedad Cientifica de Ingenieria Biomedica">Sociedad Cientifica de Ingenieria Biomedica</option>                
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

