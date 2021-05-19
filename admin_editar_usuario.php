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

            <h3>Curriculum</h3>
            <?php 
            if($state){
                $doc = $us->loadCV($_REQUEST['user_id'], $pdo);
                echo '<span> Curriculum Actual: </span><br>';
            echo '<a target="_blank" href="view_CV.php?user_id='.$_REQUEST['user_id'].'">'.$doc['nombre'].'</a><br><br>';

            }
            ?>
            <?php 
            if($_SESSION['idUsuario'] === $_REQUEST['user_id']){
                                echo '<span> Actualizar Curriculum: </span><br>';

                echo '<a href="subir_CV.php?user_id='.$_REQUEST['user_id'].'">Subir CV...</a>
                    <br>';
            }
            ?>
            
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
            <select name="tUnidadI" id="tUnidadI">
                <option value="">Ninguno</option>
                <option value="Familia y Comunidad" 
                    <?php if($unidad_investigacion === 'Familia y Comunidad') echo 'selected="selected"'; ?>>
                    Familia y Comunidad</option>
                <option value="Instituto de Investigaciones Socio Economicas"
                    <?php if($unidad_investigacion === 'Instituto de Investigaciones Socio Economicas') echo 'selected="selected"'; ?>>
                    Instituto de Investigaciones Socio Economicas</option>
                <option value="Instituto de Investigaciones en Ciencias del Comportamiento"
                    <?php if($unidad_investigacion === 'Instituto de Investigaciones en Ciencias del Comportamiento') echo 'selected="selected"';?> >
                    Instituto de Investigaciones en Ciencias del Comportamiento</option>
                <option value="Instituto de Estudios en Etica Profesional"
                    <?php if($unidad_investigacion === 'Instituto de Estudios en Etica Profesional') echo 'selected="selected"';?> >
                    Instituto de Estudios en Etica Profesional</option>
                <option value="Instituto para la Democracia"
                    <?php if($unidad_investigacion === 'Instituto para la Democracia') echo 'selected="selected"';?> >
                    Instituto para la Democracia</option>
                <option value="Servicio en Capacitacion en Raio y Television"
                    <?php if($unidad_investigacion === 'Servicio en Capacitacion en Raio y Television') echo 'selected="selected"';?> >
                    Servicio en Capacitacion en Raio y Television</option>
                <option value="Intituto de Investigaciones Aplicadas"
                    <?php if($unidad_investigacion === 'Intituto de Investigaciones Aplicadas') echo 'selected="selected"';?> >
                    Intituto de Investigaciones Aplicadas</option>
                <option value="Instituto de Investigaciones sobre Asentamientos Humanos"
                    <?php if($unidad_investigacion === 'Instituto de Investigaciones sobre Asentamientos Humanos') echo 'selected="selected"';?> >
                    Instituto de Investigaciones sobre Asentamientos Humanos</option>
                <option value="Centro de Investigacion en Agua, Energia y Sotenibilidad"
                    <?php if($unidad_investigacion === 'Centro de Investigacion en Agua, Energia y Sotenibilidad') echo 'selected="selected"';?> >
                    Centro de Investigacion en Agua, Energia y Sotenibilidad</option>
                <option value="Centro de Investigacion en Turismo"
                    <?php if($unidad_investigacion === 'Centro de Investigacion en Turismo') echo 'selected="selected"';?> >
                    Centro de Investigacion en Turismo</option>
                <option value="Centro de Investigacion en Diseno"
                    <?php if($unidad_investigacion === 'Centro de Investigacion en Diseno') echo 'selected="selected"';?> >
                    Centro de Investigacion en Diseno</option>
                <option value="Centro de Investigacion en Cadena de Suministros"
                    <?php if($unidad_investigacion === 'Centro de Investigacion en Cadena de Suministros') echo 'selected="selected"';?> >
                    Centro de Investigacion en Cadena de Suministros</option>
                <option value="Centro de Investigacion Desarrollo e Innovacion en Mecatronica"
                    <?php if($unidad_investigacion === 'Centro de Investigacion Desarrollo e Innovacion en Mecatronica') echo 'selected="selected"';?> >
                    Centro de Investigacion Desarrollo e Innovacion en Mecatronica</option>
                <option value="Centro de Investigacion Boliviano de Estudios Sociales"
                    <?php if($unidad_investigacion === 'Centro de Investigacion Boliviano de Estudios Sociales') echo 'selected="selected"';?> >
                    Centro de Investigacion Boliviano de Estudios Sociales</option>
                <option value="Unidades de Investigacion Experimental"
                    <?php if($unidad_investigacion === 'Unidades de Investigacion Experimental') echo 'selected="selected"';?> >
                    Unidades de Investigacion Experimental</option>
                <option value="Centro de Investigacion en Ingenieria Comercial"
                    <?php if($unidad_investigacion === 'Centro de Investigacion en Ingenieria Comercial') echo 'selected="selected"';?> >
                    Centro de Investigacion en Ingenieria Comercial</option>
                <option value="Centro de investigacion e Innovacion del Departamento de Administracion de Empresas"
                    <?php if($unidad_investigacion === 'Centro de investigacion e Innovacion del Departamento de Administracion de Empresas') echo 'selected="selected"';?> >
                    Centro de investigacion e Innovacion del Departamento de Administracion de Empresas</option>
                <option value="Grupo de Investigacion BIOMA"
                    <?php if($unidad_investigacion === 'Grupo de Investigacion BIOMA') echo 'selected="selected"';?> >
                    Grupo de Investigacion BIOMA</option>
                <option value="Grupo de Investigacion Base/Aplicada Ingenieria Civil"
                    <?php if($unidad_investigacion === 'Grupo de Investigacion Base/Aplicada Ingenieria Civil') echo 'selected="selected"';?> >
                    Grupo de Investigacion Base/Aplicada Ingenieria Civil</option>
                <option value="Grupo de Investigacion Telecomunicaciones"
                    <?php if($unidad_investigacion === 'Grupo de Investigacion Telecomunicaciones') echo 'selected="selected"';?> >
                    Grupo de Investigacion Telecomunicaciones</option>
                <option value="Sociedad Cientifica Estudiantil de Administracion de Empresas"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Administracion de Empresas') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Administracion de Empresas</option>
                <option value="Sociedad Cientifica Estudiantil de Derecho"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Derecho') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Derecho</option>
                <option value="Sociedad Cientifica Estudiantil de Ing. Ambiental"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Ing. Ambiental') echo 'selected="selected"';?> >
                    Sociendad Cientifica Esutdiantil de Ing. Ambiental</option>
                <option value="Sociedad Cientifica Estudiantil de Ingenieria Comercial"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Ingenieria Comercial') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Ingenieria Comercial</option>
                <option value="Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas</option>
                <option value="Sociedad Cientifica de Comunicacion Social"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica de Comunicacion Social') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Comunicacion Social</option>
                <option value="Sociedad Cientifica de Psicologia"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica de Psicologia') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Psicologia</option>
                <option value="Sociedad Cientifica Estudiantil de Economia"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Economia') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Economia</option>
                <option value="Sociedad Cientifica de la Carrera de Arquitectura"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica de la Carrera de Arquitectura') echo 'selected="selected"';?> >
                    Sociedad Cientifica de la Carrera de Arquitectura</option>
                <option value="Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA</option>
                <option value="Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO</option>
                <option value="Sociedad Cientifica Estudiantil de Administracion Turistica"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Administracion Turistica') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Administracion Turistica</option>
                <option value="Sociedad Cientifica de Investigacion de Ingenieria Civil"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica de Investigacion de Ingenieria Civil') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Investigacion de Ingenieria Civil</option>
                <option value="Sociedad Cientifica Estudinatil de Ingenieria Industrial"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica Estudinatil de Ingenieria Industrial') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudinatil de Ingenieria Industrial</option>
                <option value="Sociedad Cientifica de ingenieria Quimica 'Jovenes para la Ciencia'"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'') echo 'selected="selected"';?> >
                    Sociedad Cientifica de ingenieria Quimica 'Jovenes para la Ciencia'</option>
                <option value="Sociedad Cientifica de Ingenieria Mecatronica"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica de Ingenieria Mecatronica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria Mecatronica</option>
                <option value="Sociedad Cientifica de Ingenieria Mecatronica"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica de Ingenieria Mecatronica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria Mecatronica</option>
                <option value="Sociedad Cientifica de Contaduria Publica"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica de Contaduria Publica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Contaduria Publica</option>
                <option value="Sociedad Cientifica de Ingenieria de Telecomunicaciones"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica de Ingenieria de Telecomunicaciones') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria de Telecomunicaciones</option>
                <option value="Sociedad Cientifica de Ciencias Politicas"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica de Ciencias Politicas') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ciencias Politicas</option>
                <option value="Sociedad Cientifica de Ingenieria Biomedica"
                    <?php if($unidad_investigacion === 'Sociedad Cientifica de Ingenieria Biomedica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria Biomedica</option>            
            </select>
        <br>
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

