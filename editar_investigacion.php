<?php 
session_start();
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos']) || $_SESSION['permisos'] != 'investigador'){
    die('No ha iniciado sesion');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Investigacion</title>
    <?php require_once "c_editarinv.php"?>
    <script src="script/s_editar_investigacion.js"></script>
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
        <h1>Editar investigaci&oacute;n</h1>
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
        <h3><i>Para registrar los cambios debe ingresar todos los datos obligatorios (<span class="must">*</span>)</i></h3>
        <form action="c_editarinvPost.php?inv_id=<?php echo($_REQUEST['inv_id']) ?>" method="post">
            
            <label for="code">C&oacute;digo:<span class="must">*</span> </label> 
            <input class="textInput" name="code" id="code" type="text" disabled="disabled" value="<?php echo($codigo) ?>"><br>
            
            <label for="tituloCI">Titulo:<span class="must">*</span> </label>
            <input class="textInput" name="invTituloCI" id="tituloCI" type="text" value="<?php echo($titulo) ?>"><br>
            
            <label for="nombreCortoCI">Nombre corto:<span class="must">*</span></label>
            <input class="textInput" name="invNomCortoCI" id="nombreCortoCI" type="text" value="<?php echo($nombre_corto) ?>"><br>
            
            <label for="resumenCI">Resumen:<span class="must">*</span></label><br>
            <textarea class="textInput" name="resumenCI" id="resumenCI" rows="4" cols="100"><?php echo($resumen) ?></textarea><br><br>
            
            <label for="fi">Fecha de Inicio (aaaa-mm-dd):</label>
            <input class="xstextInput" name="fechaInicioCI" id="fi" type="date" value="<?php echo($fecha_inicio) ?>"><br>
            
            <label for="fechaFinCI">Fecha de finalizaci&oacute;n (aaaa-mm-dd):</label>
            <input class="xstextInput" name="fechaFinCI" id="fechaFinCI" type="date" value="<?php echo($fecha_fin) ?>"><br>
            
            <label for="linInvCI">Linea de Investigaci&oacute;n:<span class="must">*</span></label>
            <select name="linInvCI" id="tLineaI">
                <option value="">Ninguno</option>
                <option value="Familia y Comunidad"
                    <?php if($linea === 'Familia y Comunidad') echo 'selected="selected"';?> >
                    Familia y Comunidad</option>
                <option value="Etica y moral"
                    <?php if($linea === 'Etica y moral') echo 'selected="selected"';?> >
                    &Eacute;tica y moral</option>
                <option value="Desarrollo humano integral: Derechos humanos, salud y educacion"
                    <?php if($linea === 'Desarrollo humano integral: Derechos humanos, salud y educacion') echo 'selected="selected"';?> >
                    Desarrollo humano integral: Derechos humanos, salud y educación</option>
                <option value="Ciencia, tecnologia e innovacion"
                    <?php if($linea === 'Ciencia, tecnologia e innovacion') echo 'selected="selected"';?> >
                    Ciencia, tecnología e innovación</option>
                <option value="Crecimiento equitativo, desarrollo inclusivo, emprendimiento y productividad"
                    <?php if($linea === 'Crecimiento equitativo, desarrollo inclusivo, emprendimiento y productividad') echo 'selected="selected"';?> >
                    Crecimiento equitativo, desarrollo inclusivo, emprendimiento y productividad</option>
                <option value="Medio ambiente, recursos naturales y energias"
                    <?php if($linea === 'Medio ambiente, recursos naturales y energias') echo 'selected="selected"';?> >
                    Medio ambiente, recursos naturales y energías</option>
                <option value="Culturas y patrimonio"
                    <?php if($linea === 'Culturas y patrimonio') echo 'selected="selected"';?> >
                    Culturas y patrimonio</option>
                <option value="Institucionalidad, relaciones internacionales y soberania"
                    <?php if($linea === 'Institucionalidad, relaciones internacionales y soberania') echo 'selected="selected"';?> >
                    Institucionalidad, relaciones internacionales y soberanía<option>
            </select>
            <br><br>

            <label for="uniInvCI">Unidad de Investigaci&oacute;n:<span class="must">*</span></label>
            <select name="uniInvCI" id="uniInvCI">
                <option value="">Ninguno</option>
                <option value="Familia y Comunidad" 
                    <?php if($unidad === 'Familia y Comunidad') echo 'selected="selected"'; ?>>
                    Familia y Comunidad</option>
                <option value="Instituto de Investigaciones Socio Economicas"
                    <?php if($unidad === 'Instituto de Investigaciones Socio Economicas') echo 'selected="selected"'; ?>>
                    Instituto de Investigaciones Socio Economicas</option>
                <option value="Instituto de Investigaciones en Ciencias del Comportamiento"
                    <?php if($unidad === 'Instituto de Investigaciones en Ciencias del Comportamiento') echo 'selected="selected"';?> >
                    Instituto de Investigaciones en Ciencias del Comportamiento</option>
                <option value="Instituto de Estudios en Etica Profesional"
                    <?php if($unidad === 'Instituto de Estudios en Etica Profesional') echo 'selected="selected"';?> >
                    Instituto de Estudios en Etica Profesional</option>
                <option value="Instituto para la Democracia"
                    <?php if($unidad === 'Instituto para la Democracia') echo 'selected="selected"';?> >
                    Instituto para la Democracia</option>
                <option value="Servicio en Capacitacion en Raio y Television"
                    <?php if($unidad === 'Servicio en Capacitacion en Raio y Television') echo 'selected="selected"';?> >
                    Servicio en Capacitacion en Raio y Television</option>
                <option value="Intituto de Investigaciones Aplicadas"
                    <?php if($unidad === 'Intituto de Investigaciones Aplicadas') echo 'selected="selected"';?> >
                    Intituto de Investigaciones Aplicadas</option>
                <option value="Instituto de Investigaciones sobre Asentamientos Humanos"
                    <?php if($unidad === 'Instituto de Investigaciones sobre Asentamientos Humanos') echo 'selected="selected"';?> >
                    Instituto de Investigaciones sobre Asentamientos Humanos</option>
                <option value="Centro de Investigacion en Agua, Energia y Sotenibilidad"
                    <?php if($unidad === 'Centro de Investigacion en Agua, Energia y Sotenibilidad') echo 'selected="selected"';?> >
                    Centro de Investigacion en Agua, Energia y Sotenibilidad</option>
                <option value="Centro de Investigacion en Turismo"
                    <?php if($unidad === 'Centro de Investigacion en Turismo') echo 'selected="selected"';?> >
                    Centro de Investigacion en Turismo</option>
                <option value="Centro de Investigacion en Diseno"
                    <?php if($unidad === 'Centro de Investigacion en Diseno') echo 'selected="selected"';?> >
                    Centro de Investigacion en Diseno</option>
                <option value="Centro de Investigacion en Cadena de Suministros"
                    <?php if($unidad === 'Centro de Investigacion en Cadena de Suministros') echo 'selected="selected"';?> >
                    Centro de Investigacion en Cadena de Suministros</option>
                <option value="Centro de Investigacion Desarrollo e Innovacion en Mecatronica"
                    <?php if($unidad === 'Centro de Investigacion Desarrollo e Innovacion en Mecatronica') echo 'selected="selected"';?> >
                    Centro de Investigacion Desarrollo e Innovacion en Mecatronica</option>
                <option value="Centro de Investigacion Boliviano de Estudios Sociales"
                    <?php if($unidad === 'Centro de Investigacion Boliviano de Estudios Sociales') echo 'selected="selected"';?> >
                    Centro de Investigacion Boliviano de Estudios Sociales</option>
                <option value="Unidades de Investigacion Experimental"
                    <?php if($unidad === 'Unidades de Investigacion Experimental') echo 'selected="selected"';?> >
                    Unidades de Investigacion Experimental</option>
                <option value="Centro de Investigacion en Ingenieria Comercial"
                    <?php if($unidad === 'Centro de Investigacion en Ingenieria Comercial') echo 'selected="selected"';?> >
                    Centro de Investigacion en Ingenieria Comercial</option>
                <option value="Centro de investigacion e Innovacion del Departamento de Administracion de Empresas"
                    <?php if($unidad === 'Centro de investigacion e Innovacion del Departamento de Administracion de Empresas') echo 'selected="selected"';?> >
                    Centro de investigacion e Innovacion del Departamento de Administracion de Empresas</option>
                <option value="Grupo de Investigacion BIOMA"
                    <?php if($unidad === 'Grupo de Investigacion BIOMA') echo 'selected="selected"';?> >
                    Grupo de Investigacion BIOMA</option>
                <option value="Grupo de Investigacion Base/Aplicada Ingenieria Civil"
                    <?php if($unidad === 'Grupo de Investigacion Base/Aplicada Ingenieria Civil') echo 'selected="selected"';?> >
                    Grupo de Investigacion Base/Aplicada Ingenieria Civil</option>
                <option value="Grupo de Investigacion Telecomunicaciones"
                    <?php if($unidad === 'Grupo de Investigacion Telecomunicaciones') echo 'selected="selected"';?> >
                    Grupo de Investigacion Telecomunicaciones</option>
                <option value="Sociedad Cientifica Estudiantil de Administracion de Empresas"
                    <?php if($unidad === 'Sociedad Cientifica Estudiantil de Administracion de Empresas') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Administracion de Empresas</option>
                <option value="Sociedad Cientifica Estudiantil de Derecho"
                    <?php if($unidad === 'Sociedad Cientifica Estudiantil de Derecho') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Derecho</option>
                <option value="Sociedad Cientifica Estudiantil de Ing. Ambiental"
                    <?php if($unidad === 'Sociedad Cientifica Estudiantil de Ing. Ambiental') echo 'selected="selected"';?> >
                    Sociendad Cientifica Esutdiantil de Ing. Ambiental</option>
                <option value="Sociedad Cientifica Estudiantil de Ingenieria Comercial"
                    <?php if($unidad === 'Sociedad Cientifica Estudiantil de Ingenieria Comercial') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Ingenieria Comercial</option>
                <option value="Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas"
                    <?php if($unidad === 'Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas</option>
                <option value="Sociedad Cientifica de Comunicacion Social"
                    <?php if($unidad === 'Sociedad Cientifica de Comunicacion Social') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Comunicacion Social</option>
                <option value="Sociedad Cientifica de Psicologia"
                    <?php if($unidad === 'Sociedad Cientifica de Psicologia') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Psicologia</option>
                <option value="Sociedad Cientifica Estudiantil de Economia"
                    <?php if($unidad === 'Sociedad Cientifica Estudiantil de Economia') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Economia</option>
                <option value="Sociedad Cientifica de la Carrera de Arquitectura"
                    <?php if($unidad === 'Sociedad Cientifica de la Carrera de Arquitectura') echo 'selected="selected"';?> >
                    Sociedad Cientifica de la Carrera de Arquitectura</option>
                <option value="Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA"
                    <?php if($unidad === 'Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA</option>
                <option value="Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO"
                    <?php if($unidad === 'Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO</option>
                <option value="Sociedad Cientifica Estudiantil de Administracion Turistica"
                    <?php if($unidad === 'Sociedad Cientifica Estudiantil de Administracion Turistica') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Administracion Turistica</option>
                <option value="Sociedad Cientifica de Investigacion de Ingenieria Civil"
                    <?php if($unidad === 'Sociedad Cientifica de Investigacion de Ingenieria Civil') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Investigacion de Ingenieria Civil</option>
                <option value="Sociedad Cientifica Estudinatil de Ingenieria Industrial"
                    <?php if($unidad === 'Sociedad Cientifica Estudinatil de Ingenieria Industrial') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudinatil de Ingenieria Industrial</option>
                <option value="Sociedad Cientifica de ingenieria Quimica 'Jovenes para la Ciencia'"
                    <?php if($unidad === 'Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'') echo 'selected="selected"';?> >
                    Sociedad Cientifica de ingenieria Quimica 'Jovenes para la Ciencia'</option>
                <option value="Sociedad Cientifica de Ingenieria Mecatronica"
                    <?php if($unidad === 'Sociedad Cientifica de Ingenieria Mecatronica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria Mecatronica</option>
                <option value="Sociedad Cientifica de Ingenieria Mecatronica"
                    <?php if($unidad === 'Sociedad Cientifica de Ingenieria Mecatronica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria Mecatronica</option>
                <option value="Sociedad Cientifica de Contaduria Publica"
                    <?php if($unidad === 'Sociedad Cientifica de Contaduria Publica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Contaduria Publica</option>
                <option value="Sociedad Cientifica de Ingenieria de Telecomunicaciones"
                    <?php if($unidad === 'Sociedad Cientifica de Ingenieria de Telecomunicaciones') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria de Telecomunicaciones</option>
                <option value="Sociedad Cientifica de Ciencias Politicas"
                    <?php if($unidad === 'Sociedad Cientifica de Ciencias Politicas') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ciencias Politicas</option>
                <option value="Sociedad Cientifica de Ingenieria Biomedica"
                    <?php if($unidad === 'Sociedad Cientifica de Ingenieria Biomedica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria Biomedica</option>                
            </select>
        <br>

            <input type="hidden" name="inv_id" value="<?php echo $inv_id ?>">
            
            <h3><i>A continuaci&oacute;n, indica los detalles del investigador principal:</i></h3>
            <fieldset>
                <legend>INVESTIGADOR PRINCIPAL<span class="must">*</span></legend>
                <div id="InvP">
                    <label for="nomInvPCI">Nombre:<span class="must">*</span></label>
                    <input type="hidden" name="pautor_id" value="<?php echo($pautor_id) ?>">
                    <input class="textInput"name="nomInvPCI" id="nomInvPCI" type="text" value="<?php echo($pnombre) ?>"><br>
                    
                    <input name="univIP" id="rPUniCI" type="radio" onclick="perteneceInvP()" value="interno" <?php if($tipo_filiacion === 'interno'){
                        echo 'checked="checked"';
                    } ?> > 
                    <label for="rPUniCI">Pertenece a la Universidad Cat&oacute;lica Boliviana</label><br>
                    
                    <input name="univIP" id="rOUniCI" type="radio" onclick="noPerteneceInvP()" value="externo" <?php if($tipo_filiacion === 'externo'){
                        echo 'checked="checked"';
                    } ?> >

                    <label for="rOUniCI">Pertenece a otra Universidad</label><br>
                    
                    <?php 
                    if($tipo_filiacion === 'externo'){
                        echo '<div id="divi">';
                        echo "Universidad:<span class='must'>*</span>";
                        echo "<br>";
                        echo '<input class="stextInput" id="uniIPCI" name="uniIPCI" type="text" value="'. $universidad . '">';
                        echo "</div>";
                    }
                    else if($tipo_filiacion === 'interno'){
                        echo '<div id="divi">';
                        echo "Unidad de Investigaci&oacute;n:<span class='must'>*</span>";
                        echo "<br>";

                        echo '<select name="uniInvPCI" id="uniInvPCI">';
                        echo '<option value="">Ninguno</option>';
                        if($unidad_investigacion === 'Familia y Comunidad') echo 'selected="selected"';
                        echo '>Familia y Comunidad</option>';
                        echo '<option value="Instituto de Investigaciones Socio Economicas"';
                        if($unidad_investigacion === 'Instituto de Investigaciones Socio Economicas') echo 'selected="selected"';
                        echo '>Instituto de Investigaciones Socio Economicas</option>';
                        echo '<option value="Instituto de Investigaciones en Ciencias del Comportamiento"';
                        if($unidad_investigacion === 'Instituto de Investigaciones en Ciencias del Comportamiento') echo 'selected="selected"';
                        echo '>Instituto de Investigaciones en Ciencias del Comportamiento</option>';
                        echo '<option value="Instituto de Estudios en Etica Profesional"';
                        if($unidad_investigacion === 'Instituto de Estudios en Etica Profesional') echo 'selected="selected"';
                        echo '>Instituto de Estudios en Etica Profesional</option>';
                        echo '<option value="Instituto para la Democracia"';
                        if($unidad_investigacion === 'Instituto para la Democracia') echo 'selected="selected"';
                        echo '>Instituto para la Democracia</option>';
                        echo '<option value="Servicio en Capacitacion en Raio y Television"';
                        if($unidad_investigacion === 'Servicio en Capacitacion en Raio y Television') echo 'selected="selected"';
                        echo '>Servicio en Capacitacion en Raio y Television</option>';
                        echo '<option value="Intituto de Investigaciones Aplicadas"';
                        if($unidad_investigacion === 'Intituto de Investigaciones Aplicadas') echo 'selected="selected"';
                        echo '>Intituto de Investigaciones Aplicadas</option>';
                        echo '<option value="Instituto de Investigaciones sobre Asentamientos Humanos"';
                        if($unidad_investigacion === 'Instituto de Investigaciones sobre Asentamientos Humanos') echo 'selected="selected"';
                        echo '>Instituto de Investigaciones sobre Asentamientos Humanos</option>';
                        echo '<option value="Centro de Investigacion en Agua, Energia y Sotenibilidad"';
                        if($unidad_investigacion === 'Centro de Investigacion en Agua, Energia y Sotenibilidad') echo 'selected="selected"';
                        echo '>Centro de Investigacion en Agua, Energia y Sotenibilidad</option>';
                        echo '<option value="Centro de Investigacion en Turismo"';
                        if($unidad_investigacion === 'Centro de Investigacion en Turismo') echo 'selected="selected"';
                        echo '>Centro de Investigacion en Turismo</option>';
                        echo '<option value="Centro de Investigacion en Diseno"';
                        if($unidad_investigacion === 'Centro de Investigacion en Diseno') echo 'selected="selected"';
                        echo '>Centro de Investigacion en Diseno</option>';
                        echo '<option value="Centro de Investigacion en Cadena de Suministros"';
                        if($unidad_investigacion === 'Centro de Investigacion en Cadena de Suministros') echo 'selected="selected"';
                        echo '>Centro de Investigacion en Cadena de Suministros</option>';
                        echo '<option value="Centro de Investigacion Desarrollo e Innovacion en Mecatronica"';
                        if($unidad_investigacion === 'Centro de Investigacion Desarrollo e Innovacion en Mecatronica') echo 'selected="selected"';
                        echo '>Centro de Investigacion Desarrollo e Innovacion en Mecatronica</option>';
                        echo '<option value="Centro de Investigacion Boliviano de Estudios Sociales"';
                        if($unidad_investigacion === 'Centro de Investigacion Boliviano de Estudios Sociales') echo 'selected="selected"';
                        echo '>Centro de Investigacion Boliviano de Estudios Sociales</option>';
                        echo '<option value="Unidades de Investigacion Experimental"';
                        if($unidad_investigacion === 'Unidades de Investigacion Experimental') echo 'selected="selected"';
                        echo '>Unidades de Investigacion Experimental</option>';
                        echo '<option value="Centro de Investigacion en Ingenieria Comercial"';
                        if($unidad_investigacion === 'Centro de Investigacion en Ingenieria Comercial') echo 'selected="selected"';
                        echo '>Centro de Investigacion en Ingenieria Comercial</option>';
                        echo '<option value="Centro de investigacion e Innovacion del Departamento de Administracion de Empresas"';
                        if($unidad_investigacion === 'Centro de investigacion e Innovacion del Departamento de Administracion de Empresas') echo 'selected="selected"';
                        echo '>Centro de investigacion e Innovacion del Departamento de Administracion de Empresas</option>';
                        echo '<option value="Grupo de Investigacion BIOMA"';
                        if($unidad_investigacion === 'Grupo de Investigacion BIOMA') echo 'selected="selected"';
                        echo '>Grupo de Investigacion BIOMA</option>';
                        echo '<option value="Grupo de Investigacion Base/Aplicada Ingenieria Civil"';
                        if($unidad_investigacion === 'Grupo de Investigacion Base/Aplicada Ingenieria Civil') echo 'selected="selected"';
                        echo '>Grupo de Investigacion Base/Aplicada Ingenieria Civil</option>';
                        echo '<option value="Grupo de Investigacion Telecomunicaciones"';
                        if($unidad_investigacion === 'Grupo de Investigacion Telecomunicaciones') echo 'selected="selected"';
                        echo '>Grupo de Investigacion Telecomunicaciones</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Administracion de Empresas"';
                        if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Administracion de Empresas') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Administracion de Empresas</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Derecho"';
                        if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Derecho') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Derecho</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Ing. Ambiental"';
                        if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Ing. Ambiental') echo 'selected="selected"';
                        echo '>Sociendad Cientifica Esutdiantil de Ing. Ambiental</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Ingenieria Comercial"';
                        if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Ingenieria Comercial') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Ingenieria Comercial</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas"';
                        if($unidad_investigacion === 'Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas</option>';
                        echo '<option value="Sociedad Cientifica de Comunicacion Social"';
                        if($unidad_investigacion === 'Sociedad Cientifica de Comunicacion Social') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Comunicacion Social</option>';
                        echo '<option value="Sociedad Cientifica de Psicologia"';
                        if($unidad_investigacion === 'Sociedad Cientifica de Psicologia') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Psicologia</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Economia"';
                        if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Economia') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Economia</option>';
                        echo '<option value="Sociedad Cientifica de la Carrera de Arquitectura"';
                        if($unidad_investigacion === 'Sociedad Cientifica de la Carrera de Arquitectura') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de la Carrera de Arquitectura</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA"';
                        if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO"';
                        if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Administracion Turistica"';
                        if($unidad_investigacion === 'Sociedad Cientifica Estudiantil de Administracion Turistica') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Administracion Turistica</option>';
                        echo '<option value="Sociedad Cientifica de Investigacion de Ingenieria Civil"';
                        if($unidad_investigacion === 'Sociedad Cientifica de Investigacion de Ingenieria Civil') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Investigacion de Ingenieria Civil</option>';
                        echo '<option value="Sociedad Cientifica Estudinatil de Ingenieria Industrial"';
                        if($unidad_investigacion === 'Sociedad Cientifica Estudinatil de Ingenieria Industrial') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudinatil de Ingenieria Industrial</option>';
                        echo '<option value="Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'"';
                        if($unidad_investigacion === 'Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'</option>';
                        echo '<option value="Sociedad Cientifica de Ingenieria Mecatronica"';
                        if($unidad_investigacion === 'Sociedad Cientifica de Ingenieria Mecatronica') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Ingenieria Mecatronica</option>';
                        echo '<option value="Sociedad Cientifica de Ingenieria Mecatronica"';
                        if($unidad_investigacion === 'Sociedad Cientifica de Ingenieria Mecatronica') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Ingenieria Mecatronica</option>';
                        echo '<option value="Sociedad Cientifica de Contaduria Publica"';
                        if($unidad_investigacion === 'Sociedad Cientifica de Contaduria Publica') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Contaduria Publica</option>';
                        echo '<option value="Sociedad Cientifica de Ingenieria de Telecomunicaciones"';
                        if($unidad_investigacion === 'Sociedad Cientifica de Ingenieria de Telecomunicaciones') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Ingenieria de Telecomunicaciones</option>';
                        echo '<option value="Sociedad Cientifica de Ciencias Politicas"';
                        if($unidad_investigacion === 'Sociedad Cientifica de Ciencias Politicas') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Ciencias Politicas</option>';
                        echo '<option value="Sociedad Cientifica de Ingenieria Biomedica"';
                        if($unidad_investigacion === 'Sociedad Cientifica de Ingenieria Biomedica') echo 'selected="selected"';
                        echo 'Sociedad Cientifica de Ingenieria Biomedica</option>';
                        echo '</select>';
                        echo "<br>";
                        echo "Filiacion";
                        echo "<br>";
                        if($filiacion === 'docente'){
                            echo '<input id="rDocenteCI" name="rFiliacionIP" type="radio" value="docente" checked="checked">';
                            echo "Docente";
                            echo "<br>";

                            echo '<input id="rEstudianteCI" name="rFiliacionIP" type="radio" value="estudiante">';
                            echo "Estudiante";
                            echo "<br>";
                            
                            echo '<input id="rAdminCI" name="rFiliacionIP" type="radio" value="administrativo">';
                            echo "Administrativo";
                            echo "<br>";
                        }
                        else if($filiacion === 'estudiante'){
                            echo '<input id="rDocenteCI" name="rFiliacionIP" type="radio" value="docente">';
                            echo "Docente";
                            echo "<br>";

                            echo '<input id="rEstudianteCI" name="rFiliacionIP" type="radio" value="estudiante" checked="checked">';
                            echo "Estudiante";
                            echo "<br>";
                            
                            echo '<input id="rAdminCI" name="rFiliacionIP" type="radio" value="administrativo">';
                            echo "Administrativo";
                            echo "<br>";
                        }
                        else if($filiacion === 'administrativo'){
                            echo '<input id="rDocenteCI" name="rFiliacionIP" type="radio" value="docente">';
                            echo "Docente";
                            echo "<br>";

                            echo '<input id="rEstudianteCI" name="rFiliacionIP" type="radio" value="estudiante">';
                            echo "Estudiante";
                            echo "<br>";
                            
                            echo '<input id="rAdminCI" name="rFiliacionIP" type="radio" value="administrativo" checked="checked">';
                            echo "Administrativo";
                            echo "<br>";
                        }
                        echo "</div>";
                    }
                    ?>

                </div>
            </fieldset>

            <h3><i>Ahora, indica los detalles de los investigadores de colaboraci&oacute;n (si existen):</i></h3>
            <?php
            
                echo '<fieldset>
                        <script> var i = ' . count($investigadores) . ';</script>            
                        <h3>
                        Investigadores de colaboraci&oacute;n 
                        <button class="button" onclick="addItemInv()"> + </button>
                        </h3>';
                echo '<div id="InvS">';
                if(count($investigadores) !== 0){
                    for ($i=0; $i < count($investigadores); $i++) {
                        echo '<div id="dICI' . ($i) . '">
                                Nombre:<span class="must">*</span><input class="stextInput" name="nomInvSCI' . ($i) . '" id="nomInvSCI' . ($i) . '" value="' . $investigadores[$i]['nombre'] . '" type="text" />
                                <button id="bICI' .  ($i) . '" class="button" onclick="removeItemInv(' . ($i) . ')"> - </button><br>';
                        if($investigadores[$i]['tipo_filiacion'] == 'interno'){
                            echo '<input name="rPUniCI' . ($i) . '" id="rPUniCI' . ($i) . '" type="radio" value="interno" onclick="Select(' . ($i) . ')" checked>
                                    Pertenece a la Universidad Cat&oacute;lica Boliviana<br>
                                <input name="rPUniCI' . ($i) . '" id="rOUniCI' . ($i) . '" type="radio" value="externo" onclick="noSelect(' . ($i) . ')" >
                                Pertenece a otra Universidad<br>
                                <div id="divi' . ($i) . '">
                                Unidad de Investigaci&oacute;n:<span class="must">*</span><br>';
                        echo '<select name="uniInvSCI' . ($i) . '" id="uniInvSCI' . ($i) .'">';
                        echo '<option value="">Ninguno</option>';
                        echo '<option value="Familia y Comunidad"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Familia y Comunidad') echo 'selected="selected"';
                        echo '>Familia y Comunidad</option>';
                        echo '<option value="Instituto de Investigaciones Socio Economicas"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Instituto de Investigaciones Socio Economicas') echo 'selected="selected"';
                        echo '>Instituto de Investigaciones Socio Economicas</option>';
                        echo '<option value="Instituto de Investigaciones en Ciencias del Comportamiento"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Instituto de Investigaciones en Ciencias del Comportamiento') echo 'selected="selected"';
                        echo '>Instituto de Investigaciones en Ciencias del Comportamiento</option>';
                        echo '<option value="Instituto de Estudios en Etica Profesional"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Instituto de Estudios en Etica Profesional') echo 'selected="selected"';
                        echo '>Instituto de Estudios en Etica Profesional</option>';
                        echo '<option value="Instituto para la Democracia"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Instituto para la Democracia') echo 'selected="selected"';
                        echo '>Instituto para la Democracia</option>';
                        echo '<option value="Servicio en Capacitacion en Raio y Television"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Servicio en Capacitacion en Raio y Television') echo 'selected="selected"';
                        echo '>Servicio en Capacitacion en Raio y Television</option>';
                        echo '<option value="Intituto de Investigaciones Aplicadas"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Intituto de Investigaciones Aplicadas') echo 'selected="selected"';
                        echo '>Intituto de Investigaciones Aplicadas</option>';
                        echo '<option value="Instituto de Investigaciones sobre Asentamientos Humanos"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Instituto de Investigaciones sobre Asentamientos Humanos') echo 'selected="selected"';
                        echo '>Instituto de Investigaciones sobre Asentamientos Humanos</option>';
                        echo '<option value="Centro de Investigacion en Agua, Energia y Sotenibilidad"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Centro de Investigacion en Agua, Energia y Sotenibilidad') echo 'selected="selected"';
                        echo '>Centro de Investigacion en Agua, Energia y Sotenibilidad</option>';
                        echo '<option value="Centro de Investigacion en Turismo"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Centro de Investigacion en Turismo') echo 'selected="selected"';
                        echo '>Centro de Investigacion en Turismo</option>';
                        echo '<option value="Centro de Investigacion en Diseno"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Centro de Investigacion en Diseno') echo 'selected="selected"';
                        echo '>Centro de Investigacion en Diseno</option>';
                        echo '<option value="Centro de Investigacion en Cadena de Suministros"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Centro de Investigacion en Cadena de Suministros') echo 'selected="selected"';
                        echo '>Centro de Investigacion en Cadena de Suministros</option>';
                        echo '<option value="Centro de Investigacion Desarrollo e Innovacion en Mecatronica"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Centro de Investigacion Desarrollo e Innovacion en Mecatronica') echo 'selected="selected"';
                        echo '>Centro de Investigacion Desarrollo e Innovacion en Mecatronica</option>';
                        echo '<option value="Centro de Investigacion Boliviano de Estudios Sociales"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Centro de Investigacion Boliviano de Estudios Sociales') echo 'selected="selected"';
                        echo '>Centro de Investigacion Boliviano de Estudios Sociales</option>';
                        echo '<option value="Unidades de Investigacion Experimental"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Unidades de Investigacion Experimental') echo 'selected="selected"';
                        echo '>Unidades de Investigacion Experimental</option>';
                        echo '<option value="Centro de Investigacion en Ingenieria Comercial"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Centro de Investigacion en Ingenieria Comercial') echo 'selected="selected"';
                        echo '>Centro de Investigacion en Ingenieria Comercial</option>';
                        echo '<option value="Centro de investigacion e Innovacion del Departamento de Administracion de Empresas"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Centro de investigacion e Innovacion del Departamento de Administracion de Empresas') echo 'selected="selected"';
                        echo '>Centro de investigacion e Innovacion del Departamento de Administracion de Empresas</option>';
                        echo '<option value="Grupo de Investigacion BIOMA"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Grupo de Investigacion BIOMA') echo 'selected="selected"';
                        echo '>Grupo de Investigacion BIOMA</option>';
                        echo '<option value="Grupo de Investigacion Base/Aplicada Ingenieria Civil"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Grupo de Investigacion Base/Aplicada Ingenieria Civil') echo 'selected="selected"';
                        echo '>Grupo de Investigacion Base/Aplicada Ingenieria Civil</option>';
                        echo '<option value="Grupo de Investigacion Telecomunicaciones"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Grupo de Investigacion Telecomunicaciones') echo 'selected="selected"';
                        echo '>Grupo de Investigacion Telecomunicaciones</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Administracion de Empresas"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica Estudiantil de Administracion de Empresas') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Administracion de Empresas</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Derecho"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica Estudiantil de Derecho') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Derecho</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Ing. Ambiental"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica Estudiantil de Ing. Ambiental') echo 'selected="selected"';
                        echo '>Sociendad Cientifica Esutdiantil de Ing. Ambiental</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Ingenieria Comercial"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica Estudiantil de Ingenieria Comercial') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Ingenieria Comercial</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas</option>';
                        echo '<option value="Sociedad Cientifica de Comunicacion Social"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica de Comunicacion Social') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Comunicacion Social</option>';
                        echo '<option value="Sociedad Cientifica de Psicologia"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica de Psicologia') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Psicologia</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Economia"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica Estudiantil de Economia') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Economia</option>';
                        echo '<option value="Sociedad Cientifica de la Carrera de Arquitectura"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica de la Carrera de Arquitectura') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de la Carrera de Arquitectura</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO</option>';
                        echo '<option value="Sociedad Cientifica Estudiantil de Administracion Turistica"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica Estudiantil de Administracion Turistica') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudiantil de Administracion Turistica</option>';
                        echo '<option value="Sociedad Cientifica de Investigacion de Ingenieria Civil"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica de Investigacion de Ingenieria Civil') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Investigacion de Ingenieria Civil</option>';
                        echo '<option value="Sociedad Cientifica Estudinatil de Ingenieria Industrial"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica Estudinatil de Ingenieria Industrial') echo 'selected="selected"';
                        echo '>Sociedad Cientifica Estudinatil de Ingenieria Industrial</option>';
                        echo '<option value="Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'</option>';
                        echo '<option value="Sociedad Cientifica de Ingenieria Mecatronica"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica de Ingenieria Mecatronica') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Ingenieria Mecatronica</option>';
                        echo '<option value="Sociedad Cientifica de Ingenieria Mecatronica"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica de Ingenieria Mecatronica') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Ingenieria Mecatronica</option>';
                        echo '<option value="Sociedad Cientifica de Contaduria Publica"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica de Contaduria Publica') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Contaduria Publica</option>';
                        echo '<option value="Sociedad Cientifica de Ingenieria de Telecomunicaciones"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica de Ingenieria de Telecomunicaciones') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Ingenieria de Telecomunicaciones</option>';
                        echo '<option value="Sociedad Cientifica de Ciencias Politicas"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica de Ciencias Politicas') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Ciencias Politicas</option>';
                        echo '<option value="Sociedad Cientifica de Ingenieria Biomedica"';
                        if($investigadores[$i]['unidad_investigacion'] === 'Sociedad Cientifica de Ingenieria Biomedica') echo 'selected="selected"';
                        echo '>Sociedad Cientifica de Ingenieria Biomedica</option>';
                        echo '</select><br>';
                                echo 'Filiaci&oacute;n:<span class="must">*</span><br>';

                            if($investigadores[$i]['filiacion'] == 'docente'){   
                                echo '<input name="rFiliacionIS' . ($i) . '" id="rDocenteCI' . ($i) . '" type="radio" value="docente" checked>
                                Docente<br>
                                <input name="rFiliacionIS' . ($i) . '" id="rEstudianteCI' . ($i) . '" type="radio" value="estudiante" >
                                Estudiante<br>
                                <input name="rFiliacionIS' . ($i) . '" id="rAdminCI' . ($i) . '" type="radio" value="administrativo" > 
                                Administrativo<br>'; 
                                
                            }
                            else if($investigadores[$i]['filiacion'] == 'estudiante'){
                                echo '<input name="rFiliacionIS' . ($i) . '" id="rDocenteCI' . ($i) . '" type="radio" value="docente" >
                                Docente<br>
                                <input name="rFiliacionIS' . ($i) . '" id="rEstudianteCI' . ($i) . '" type="radio" value="estudiante" checked>
                                Estudiante<br>
                                <input name="rFiliacionIS' . ($i) . '" id="rAdminCI' . ($i) . '" type="radio" value="administrativo" > 
                                Administrativo<br>';
                                
                            }
                            else{
                                echo '<input name="rFiliacionIS' . ($i) . '" id="rDocenteCI' . ($i) . '" type="radio" value="docente" >
                                Docente<br>
                                <input name="rFiliacionIS' . ($i) . '" id="rEstudianteCI' . ($i) . '" type="radio" value="estudiante" >
                                Estudiante<br>
                                <input name="rFiliacionIS' . ($i) . '" id="rAdminCI' . ($i) . '" type="radio" value="administrativo" checked>
                                Administrativo<br>';
                            }
                            echo '</div>';
                        }
                        else{
                            echo '<input name="rPUniCI' . ($i) . '" id="rPUniCI' . ($i) . '" type="radio" value="interno" onclick="Select(' . ($i) . ')" >
                                    Pertenece a la Universidad Cat&oacute;lica Boliviana<br>
                                <input name="rPUniCI' . ($i) . '" id="rOUniCI' . ($i) . '" type="radio" value="externo" onclick="noSelect(' . ($i) . ')" checked>
                                Pertenece a otra Universidad<br>
                                <div id="divi' . ($i) . '">
                                Universidad:<span class="must">*</span><br>
                                <input class="stextInput" name="uniISCI' . ($i) . '" id="uniISCI' . ($i) . '" value="' . ($investigadores[$i]['universidad']) . '" type="text" >';
                            echo '</div>';
                        }
                        echo '</div>';                    
                    }
                    
                }
                echo '</div>';
            echo '</fieldset>';
        ?>
            <h3><i>A continuaci&oacute;n, ingresa los detalles del financiamiento:</i></h3>
            <fieldset id="financiamiento">
                <?php 
                if($nombre_financiador === 'alv'){
                    echo '<input type="hidden" name="financiador_id" value="' . $financiador_id . '">';
                }
                if($nombre_financiador !== 'No Existe' && $nombre_financiador !== 'alv'){
                    echo '<input type="hidden" name="financiador_id" value="' . $financiador_id . '">';
                }
                ?>
                <legend>FINANCIAMIENTO<span class="must">*</span></legend>
                <h4>Existe:<span class="must">*</span></h4>
                <input name="rExisteFI" id="rSiExisteFCI" type="radio" value="si" onclick="existFinan()" <?php if($nombre_financiador !== 'No Existe' && $nombre_financiador !== 'alv'){
                    echo 'checked="checked"';
                } ?>>
                <label for="rSiExisteFCI">Si</label><br>
                
                <input name="rExisteFI" id="rNoExisteFCI" type="radio" value="no" onclick="noexistFinan()" <?php if($nombre_financiador === 'No Existe' || $nombre_financiador === 'alv'){
                    echo 'checked="checked"';
                } ?>>
                <label for="rNoExisteFCI">No</label><br>
                <?php 
                if($nombre_financiador === 'alv'){
                    echo '<input type="hidden" name="financiador_id" value="' . $financiador_id . '">';
                }
                if($nombre_financiador !== 'No Existe' && $nombre_financiador !== 'alv'){
                    echo '<div id="existe">';
                    echo '<input type="hidden" name="financiador_id" value="' . $financiador_id . '">';
                    echo "Tipo Financiador";
                    echo "<br>";
                    echo '<input id="rTipoFIntCI" name="rTipoFr" type="radio" value="interno" onclick="tipoInter()" ';
                    if($tipo_financiador == 'interno'){
                        echo 'checked="checked">';
                    }
                    else{
                        echo '>';
                    }
                    echo "Interno";
                    echo "<br>";

                    echo '<input id="rTipoFEntCI" name="rTipoFr" type="radio" value="externo" onclick="tipoExtern()" ';
                    if($tipo_financiador == 'externo'){
                        echo 'checked="checked">';
                    }
                    else{
                        echo '>';
                    }
                    echo "Externo";
                    echo "<br>";
                    if($tipo_financiador == 'externo'){
                        echo '<div id="nomFin">';
                        echo 'Nombre Financiador:<span class="must">*</span>';
                        echo '<input class="stextInput" id="nombreFinanciador" name="nombreFinanciador" type="text" value="' . $nombre_financiador . '">';
                        echo "</div>";
                        echo '<br>';
                    }
                    
                    echo "Tipo Financiamiento";
                    echo "<br>";
                    echo '<input id="rTipoMCI" name="rTipoFI" type="radio" value="monetario" onclick="tipoMont()" ';
                    if($tipo_financiamiento === 'monetario'){
                        echo 'checked="checked">';
                        echo "Monetario";
                        echo "<br>";
                    }
                    else{
                        echo ">";
                        echo "Monetario";
                        echo "<br>";
                    }
                    echo '<input id="rTipoOCI" name="rTipoFI" type="radio" value="otro" onclick="tipoOtro()" ';
                    if($tipo_financiamiento !== 'monetario'){
                        echo 'checked="checked">';
                    }
                    else{
                        echo ">";
                    }
                    echo "Otro";
                    echo "<br>";
                    if($tipo_financiamiento === 'monetario'){
                        echo '<div id="montFin">';
                        echo 'Monto:<span class="must">*</span>';
                        echo '<input class="xstextInput" id="monto" name="monto" type="text" value="' . $monto . '"> Bs.';
                        echo "</div>";
                    }

                    echo 'Observaciones';
                    echo '<br>';
                    echo '<textarea class="textInput" id="obsTipoFOCI" name="obsTipoFOCI" rows="4" cols="100">';
                    if(isset($observaciones)){
                        echo $observaciones;
                    }
                    echo '</textarea>';
                    echo "<br>";
                    echo "</div>";
                }
                ?>
            </fieldset>
            
            <!--Agregar actividades-->
            <h3><i>Finalmente, indica las actividades planificadas para la investigaci&oacute;n:</i></h3>
            <?php
            echo '<fieldset>
            <script> var  actividad = ' . count($actividades) . ';</script>
            <h3>
            Actividades
            <button class="button" onclick="addItemAct()"> + </button>
            </h3>';
            echo '<div id="Act">';
            if(count($actividades) !== 0){
                
                for ($i=0; $i < count($actividades); $i++) {
                    echo '<div id="dA' . ($i) . '">
                        Nombre
                        <input class="stextInput" name="nomActCI' . ($i) . '" id="nomActCI' . ($i) . '" type="text" value="' . $actividades[$i]['nombre'] . '">
                        <button class="button" id="bA' . ($i) . '" onclick="removeItemAct('. ($i) .')"> - </button><br>
                        Fecha inicio
                        <input class="xstextInput" name="FIActCI' . ($i) . '" id="FIActCI' . ($i) . '" type="date" value="' . $actividades[$i]['fecha_inicio'] . '"><br>
                        Fecha final 
                        <input class="xstextInput" name="FFActCI' . ($i) . '" id="FFActCI' . ($i) . '" type="date" value="' . $actividades[$i]['fecha_final'] . '"><br>
                        </div>';
                }
                
            }
            echo '</div>';
            echo '</fieldset>';
        ?>
            <div align="center">
                <input class="button" style="margin-right:20px;" type="submit" value="Guardar">
                <input class="button" type="submit" name="cancel" value="Cancelar" />
            </div> 
        </form>
    </div>
</body>
</html>