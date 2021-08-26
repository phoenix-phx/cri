<?php 
session_start();
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos']) || $_SESSION['permisos'] != 'investigador'){
    die('No ha iniciado sesion');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Publicaci&oacute;n</title>
    <?php require_once "c_editarpub.php"?>
    
    <script src="script/s_editar_publicacion.js"></script>
    <link rel="stylesheet" href="style/styles.css">
    <meta charset="utf-8">
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
    <form action="c_editarpubPost.php?pub_id=<?php echo($_REQUEST['pub_id']) ?>" method="post">
        <h1>Editar publicaci&oacute;n</h1>   
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

        <label for="code">C&oacute;digo:<span class="must">*</span></label>
        <input class="textInput" name="code" id="code" type="text" disabled="disabled" value="<?php echo($codigo) ?>"><br>

        <label for="tituloCP">Titulo:<span class="must">*</span></label>
        <input class="textInput" name="tituloCP" id="tituloCP" type="text" value="<?php echo($titulo) ?>"><br>

        <label for="resumenCP">Resumen:<span class="must">*</span></label><br>
        <textarea class="textInput" name="resumenCP" id="resumenCP" rows="4" cols="100"><?php echo $resumen ?></textarea><br><br>

        <label for="linInv">Linea de Investigaci&oacute;n:<span class="must">*</span></label>
        <select name="linInv" id="lInv">
        <option value="">Ninguno</option>
            <option value="Familia y Comunidad"
                <?php if($li === "Familia y Comunidad") echo 'selected="selected"'?>>
                Familia y Comunidad</option>
            <option value="Etica y moral"
                <?php if($li === "Etica y moral") echo 'selected="selected"'?>>
                &Eacute;tica y moral</option>
            <option value="Desarrollo humano integral: Derechos humanos, salud y educacion"
                <?php if($li === "Desarrollo humano integral: Derechos humanos, salud y educacion") echo 'selected="selected"'?>>
                Desarrollo humano integral: Derechos humanos, salud y educación</option>
            <option value="Ciencia, tecnologia e innovacion"
                <?php if($li === "Ciencia, tecnologia e innovacion") echo 'selected="selected"'?>>
                Ciencia, tecnología e innovación</option>
            <option value="Crecimiento equitativo, desarrollo inclusivo, emprendimiento y productividad"
                <?php if($li === "Crecimiento equitativo, desarrollo inclusivo, emprendimiento y productividad") echo 'selected="selected"'?>>
                Crecimiento equitativo, desarrollo inclusivo, emprendimiento y productividad</option>
            <option value="Medio ambiente, recursos naturales y energias"
                <?php if($li === "Medio ambiente, recursos naturales y energias") echo 'selected="selected"'?>>
                Medio ambiente, recursos naturales y energías</option>
            <option value="Culturas y patrimonio"
                <?php if($li === "Culturas y patrimonio") echo 'selected="selected"'?>>
                Culturas y patrimonio</option>
            <option value="Institucionalidad, relaciones internacionales y soberania"
                <?php if($li === "Institucionalidad, relaciones internacionales y soberania") echo 'selected="selected"'?>>
                Institucionalidad, relaciones internacionales y soberanía<option>
        </select>
        <br><br>

        <label for="uInvestigacion">Unidad de Investigaci&oacute;n:<span class="must">*</span></label>
        <select name="uInvestigacion" id="uInvestigacion">
                <option value="">Ninguno</option>
                <option value="Familia y Comunidad" 
                    <?php if($ui === 'Familia y Comunidad') echo 'selected="selected"'; ?>>
                    Familia y Comunidad</option>
                <option value="Instituto de Investigaciones Socio Economicas"
                    <?php if($ui === 'Instituto de Investigaciones Socio Economicas') echo 'selected="selected"'; ?>>
                    Instituto de Investigaciones Socio Economicas</option>
                <option value="Instituto de Investigaciones en Ciencias del Comportamiento"
                    <?php if($ui === 'Instituto de Investigaciones en Ciencias del Comportamiento') echo 'selected="selected"';?> >
                    Instituto de Investigaciones en Ciencias del Comportamiento</option>
                <option value="Instituto de Estudios en Etica Profesional"
                    <?php if($ui === 'Instituto de Estudios en Etica Profesional') echo 'selected="selected"';?> >
                    Instituto de Estudios en Etica Profesional</option>
                <option value="Instituto para la Democracia"
                    <?php if($ui === 'Instituto para la Democracia') echo 'selected="selected"';?> >
                    Instituto para la Democracia</option>
                <option value="Servicio en Capacitacion en Raio y Television"
                    <?php if($ui === 'Servicio en Capacitacion en Raio y Television') echo 'selected="selected"';?> >
                    Servicio en Capacitacion en Raio y Television</option>
                <option value="Intituto de Investigaciones Aplicadas"
                    <?php if($ui === 'Intituto de Investigaciones Aplicadas') echo 'selected="selected"';?> >
                    Intituto de Investigaciones Aplicadas</option>
                <option value="Instituto de Investigaciones sobre Asentamientos Humanos"
                    <?php if($ui === 'Instituto de Investigaciones sobre Asentamientos Humanos') echo 'selected="selected"';?> >
                    Instituto de Investigaciones sobre Asentamientos Humanos</option>
                <option value="Centro de Investigacion en Agua, Energia y Sotenibilidad"
                    <?php if($ui === 'Centro de Investigacion en Agua, Energia y Sotenibilidad') echo 'selected="selected"';?> >
                    Centro de Investigacion en Agua, Energia y Sotenibilidad</option>
                <option value="Centro de Investigacion en Turismo"
                    <?php if($ui === 'Centro de Investigacion en Turismo') echo 'selected="selected"';?> >
                    Centro de Investigacion en Turismo</option>
                <option value="Centro de Investigacion en Diseno"
                    <?php if($ui === 'Centro de Investigacion en Diseno') echo 'selected="selected"';?> >
                    Centro de Investigacion en Diseno</option>
                <option value="Centro de Investigacion en Cadena de Suministros"
                    <?php if($ui === 'Centro de Investigacion en Cadena de Suministros') echo 'selected="selected"';?> >
                    Centro de Investigacion en Cadena de Suministros</option>
                <option value="Centro de Investigacion Desarrollo e Innovacion en Mecatronica"
                    <?php if($ui === 'Centro de Investigacion Desarrollo e Innovacion en Mecatronica') echo 'selected="selected"';?> >
                    Centro de Investigacion Desarrollo e Innovacion en Mecatronica</option>
                <option value="Centro de Investigacion Boliviano de Estudios Sociales"
                    <?php if($ui === 'Centro de Investigacion Boliviano de Estudios Sociales') echo 'selected="selected"';?> >
                    Centro de Investigacion Boliviano de Estudios Sociales</option>
                <option value="Unidades de Investigacion Experimental"
                    <?php if($ui === 'Unidades de Investigacion Experimental') echo 'selected="selected"';?> >
                    Unidades de Investigacion Experimental</option>
                <option value="Centro de Investigacion en Ingenieria Comercial"
                    <?php if($ui === 'Centro de Investigacion en Ingenieria Comercial') echo 'selected="selected"';?> >
                    Centro de Investigacion en Ingenieria Comercial</option>
                <option value="Centro de investigacion e Innovacion del Departamento de Administracion de Empresas"
                    <?php if($ui === 'Centro de investigacion e Innovacion del Departamento de Administracion de Empresas') echo 'selected="selected"';?> >
                    Centro de investigacion e Innovacion del Departamento de Administracion de Empresas</option>
                <option value="Grupo de Investigacion BIOMA"
                    <?php if($ui === 'Grupo de Investigacion BIOMA') echo 'selected="selected"';?> >
                    Grupo de Investigacion BIOMA</option>
                <option value="Grupo de Investigacion Base/Aplicada Ingenieria Civil"
                    <?php if($ui === 'Grupo de Investigacion Base/Aplicada Ingenieria Civil') echo 'selected="selected"';?> >
                    Grupo de Investigacion Base/Aplicada Ingenieria Civil</option>
                <option value="Grupo de Investigacion Telecomunicaciones"
                    <?php if($ui === 'Grupo de Investigacion Telecomunicaciones') echo 'selected="selected"';?> >
                    Grupo de Investigacion Telecomunicaciones</option>
                <option value="Sociedad Cientifica Estudiantil de Administracion de Empresas"
                    <?php if($ui === 'Sociedad Cientifica Estudiantil de Administracion de Empresas') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Administracion de Empresas</option>
                <option value="Sociedad Cientifica Estudiantil de Derecho"
                    <?php if($ui === 'Sociedad Cientifica Estudiantil de Derecho') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Derecho</option>
                <option value="Sociedad Cientifica Estudiantil de Ing. Ambiental"
                    <?php if($ui === 'Sociedad Cientifica Estudiantil de Ing. Ambiental') echo 'selected="selected"';?> >
                    Sociendad Cientifica Esutdiantil de Ing. Ambiental</option>
                <option value="Sociedad Cientifica Estudiantil de Ingenieria Comercial"
                    <?php if($ui === 'Sociedad Cientifica Estudiantil de Ingenieria Comercial') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Ingenieria Comercial</option>
                <option value="Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas"
                    <?php if($ui === 'Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas</option>
                <option value="Sociedad Cientifica de Comunicacion Social"
                    <?php if($ui === 'Sociedad Cientifica de Comunicacion Social') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Comunicacion Social</option>
                <option value="Sociedad Cientifica de Psicologia"
                    <?php if($ui === 'Sociedad Cientifica de Psicologia') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Psicologia</option>
                <option value="Sociedad Cientifica Estudiantil de Economia"
                    <?php if($ui === 'Sociedad Cientifica Estudiantil de Economia') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Economia</option>
                <option value="Sociedad Cientifica de la Carrera de Arquitectura"
                    <?php if($ui === 'Sociedad Cientifica de la Carrera de Arquitectura') echo 'selected="selected"';?> >
                    Sociedad Cientifica de la Carrera de Arquitectura</option>
                <option value="Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA"
                    <?php if($ui === 'Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA</option>
                <option value="Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO"
                    <?php if($ui === 'Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO</option>
                <option value="Sociedad Cientifica Estudiantil de Administracion Turistica"
                    <?php if($ui === 'Sociedad Cientifica Estudiantil de Administracion Turistica') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudiantil de Administracion Turistica</option>
                <option value="Sociedad Cientifica de Investigacion de Ingenieria Civil"
                    <?php if($ui === 'Sociedad Cientifica de Investigacion de Ingenieria Civil') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Investigacion de Ingenieria Civil</option>
                <option value="Sociedad Cientifica Estudinatil de Ingenieria Industrial"
                    <?php if($ui === 'Sociedad Cientifica Estudinatil de Ingenieria Industrial') echo 'selected="selected"';?> >
                    Sociedad Cientifica Estudinatil de Ingenieria Industrial</option>
                <option value="Sociedad Cientifica de ingenieria Quimica 'Jovenes para la Ciencia'"
                    <?php if($ui === 'Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'') echo 'selected="selected"';?> >
                    Sociedad Cientifica de ingenieria Quimica 'Jovenes para la Ciencia'</option>
                <option value="Sociedad Cientifica de Ingenieria Mecatronica"
                    <?php if($ui === 'Sociedad Cientifica de Ingenieria Mecatronica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria Mecatronica</option>
                <option value="Sociedad Cientifica de Ingenieria Mecatronica"
                    <?php if($ui === 'Sociedad Cientifica de Ingenieria Mecatronica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria Mecatronica</option>
                <option value="Sociedad Cientifica de Contaduria Publica"
                    <?php if($ui === 'Sociedad Cientifica de Contaduria Publica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Contaduria Publica</option>
                <option value="Sociedad Cientifica de Ingenieria de Telecomunicaciones"
                    <?php if($ui === 'Sociedad Cientifica de Ingenieria de Telecomunicaciones') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria de Telecomunicaciones</option>
                <option value="Sociedad Cientifica de Ciencias Politicas"
                    <?php if($ui === 'Sociedad Cientifica de Ciencias Politicas') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ciencias Politicas</option>
                <option value="Sociedad Cientifica de Ingenieria Biomedica"
                    <?php if($ui === 'Sociedad Cientifica de Ingenieria Biomedica') echo 'selected="selected"';?> >
                    Sociedad Cientifica de Ingenieria Biomedica</option>                
            </select>
        <br>

        <label for="apaCP">Resumen:<!--<span class="must">*</span>--></label><br>
        <textarea class="textInput" name="apaCP" id="apa" rows="4" cols="100"><?php echo $apa ?></textarea><br>        

        <label for="invCP">Investigaci&oacute;n asociada (C&oacute;digo):</label><br> 
        <input class="textInput" name="invCP" id="invCP" type="text" <?php if(strlen($investigacion) !== 0) {echo 'value="'.$nombreInv.'"';}?>><br>
        <?php // TODO: procesar select si existe ?>

        <label for="tipoCP">Tipo publicaci&oacute;n:<span class="must">*</span></label>
        <select name="tipoCP" id="tipoCP">
            <option value="Ninguno">Ninguno</option>
            <option value="Articulo" <?php if($tipo === 'Articulo') echo 'selected="selected"'; ?>>Articulo</option>
            <option value="Acta" <?php if($tipo === 'Acta') echo 'selected="selected"'; ?>>Acta</option>
            <option value="Libro" <?php if($tipo === 'Libro') echo 'selected="selected"'; ?>>Libro</option>
            <option value="Capitulo de libro" <?php if($tipo === 'Capitulo de libro') echo 'selected="selected"'; ?>>Capitulo de libro</option>
            <option value="Patente" <?php if($tipo === 'Patente') echo 'selected="selected"'; ?>>Patente</option>
            <option value="Otro" <?php if($tipo === 'Otro') echo 'selected="selected"'; ?>>Otro</option>
        </select>
        <h3><i>A continuaci&oacute;n, indica los detalles del autor principal</i></h3>
        <fieldset>
        <legend>AUTOR PRINCIPAL<span class="must">*</span></legend>
        <div id="InvP">
            <input type="hidden" name="pautor_id" value="<?php echo($pautor_id) ?>">

            <label for="nomInvPCP">Nombre:<span class="must">*</span></label><br>
            <input class="textInput" name="nomInvPCP" id="nomInvPCP" type="text" value="<?php echo($pnombre) ?>"><br>

            <input name="rPUniCP" id="rPUniCP" type="radio" onclick="perteneceInvP()" value="interno" <?php if($tipo_filiacion === 'interno') echo 'checked="checked"'; ?>> 
            <label for="rPUniCP"> Pertenece a la Universidad Cat&oacute;lica Boliviana</label><br>
            <input name="rPUniCP" id="rOUniCP" type="radio" onclick="noPerteneceInvP()" value="externo" <?php if($tipo_filiacion === 'externo') echo 'checked="checked"'; ?>>
            <label for="rOUniCP">Pertenece a otra Universidad</label><br>
            <?php 
            if($tipo_filiacion === 'externo'){
                echo '<div id="divi">';
                echo '<label for="uniIPCP"> Universidad:<span class="must">*</span></label>';
                echo "<br>";
                echo '<input class="stextInput" id="uniIPCP" name="uniIPCP" type="text" value="'. $universidad . '">';
                echo "</div>";
            }
            else if($tipo_filiacion === 'interno'){
                echo '<div id="divi">';
                echo '<label for="uniInvPCP"> Unidad de Investigaci&oacute;n:<span class="must">*</span></label>';
                echo "<br>";
                echo '<select name="uniInvPCP" id="uniInvPCP">';
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
                echo "<br>";
                echo "Filiaci&oacute;n:<span class='must'>*</span>";
                echo "<br>";
                if($filiacion === 'docente'){
                    echo '<input id="rDocenteCP" name="rFiliacionIPCP" type="radio" value="docente" checked="checked">';
                    echo '<label for="rDocenteCP">Docente</label>';
                    echo "<br>";

                    echo '<input id="rEstudianteCP" name="rFiliacionIPCP" type="radio" value="estudiante">';
                    echo '<label for="rEstudianteCP">Estudiante</label>';
                    echo "<br>";
                    
                    echo '<input id="rAdminCICP" name="rFiliacionIPCP" type="radio" value="administrativo">';
                    echo '<label for="rAdminiCICP">Administrativo</label>';
                    echo "<br>";
                }
                else if($filiacion === 'estudiante'){
                    echo '<input id="rDocenteCP" name="rFiliacionIPCP" type="radio" value="docente">';
                    echo '<label for="rDocenteCP">Docente</label>';
                    echo "<br>";

                    echo '<input id="rEstudianteCP" name="rFiliacionIPCP" type="radio" value="estudiante" checked="checked">';
                    echo '<label for="rEstudianteCP">Estudiante</label>';
                    echo "<br>";
                    
                    echo '<input id="rAdminCICP" name="rFiliacionIPCP" type="radio" value="administrativo">';
                    echo '<label for="rAdminiCICP">Administrativo</label>';
                    echo "<br>";
                }
                else if($filiacion === 'administrativo'){
                    echo '<input id="rDocenteCP" name="rFiliacionIPCP" type="radio" value="docente">';
                    echo '<label for="rDocenteCP">Docente</label>';
                    echo "<br>";

                    echo '<input id="rEstudianteCP" name="rFiliacionIPCP" type="radio" value="estudiante">';
                    echo '<label for="rEstudianteCP">Estudiante</label>';
                    echo "<br>";
                    
                    echo '<input id="rAdminCICP" name="rFiliacionIPCP" type="radio" value="administrativo" checked="checked">';
                    echo '<label for="rAdminiCICP">Administrativo</label>';
                    echo "<br>";
                }
                echo "</div>";
            }
            ?>
        </div>
        </fieldset>

        <h3><i>Ahora, indica los detalles de los autores de colaboraci&oacute;n</i></h3>

        <fieldset>
        <h3>Autores secundarios <button class="button" onclick="addItemInv()"> +    </button></h3>
        <div id="InvS">
            <?php
                echo '<script> var i = ' . count($investigadores) . ';</script>';
                if(count($investigadores) !== 0){
                    for ($i=0; $i < count($investigadores); $i++) {
                        echo '<div id="dICP' . ($i) . '">
                                Nombre:<span class="must">*</span><input class="stextInput" name="nomInvSCP' . ($i) . '" id="nomInvSCP' . ($i) . '" value="' . $investigadores[$i]['nombre'] . '" type="text" />
                                <button class="button" id="bICP' .  ($i) . '" onclick="removeItemInv(' . ($i) . ')"> - </button><br>';
                        if($investigadores[$i]['tipo_filiacion'] == 'interno'){
                            echo '<input name="rPUniCP' . ($i) . '" id="rPUniCP' . ($i) . '" type="radio" value="interno" onclick="Select(' . ($i) . ')" checked>
                                    Pertenece a la Universidad Cat&oacute;lica Boliviana<br>
                                  <input name="rPUniCP' . ($i) . '" id="rOUniCP' . ($i) . '" type="radio" value="externo" onclick="noSelect(' . ($i) . ')" >
                                  Pertenece a otra Universidad<br>
                                  <div id="divi' . ($i) . '">
                                  Unidad de Investigaci&oacute;n:<span class="must">*</span><br>';

                                  echo '<select name="uniInvSCP' . ($i) .'" id="uniInvSCP' . ($i) .'">';
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
                            if($investigadores[$i]['filiacion'] == 'docente'){   
                                echo '<input name="rFiliacionISCP' . ($i) . '" id="rDocenteCP' . ($i) . '" type="radio" value="docente" checked>
                                Docente<br>
                                <input name="rFiliacionISCP' . ($i) . '" id="rEstudianteCP' . ($i) . '" type="radio" value="estudiante" >
                                Estudiante<br>
                                <input name="rFiliacionISCP' . ($i) . '" id="rAdminCP' . ($i) . '" type="radio" value="administrativo" > 
                                Administrativo<br>'; 
                                
                            }
                            else if($investigadores[$i]['filiacion'] == 'estudiante'){
                                echo '<input name="rFiliacionISCP' . ($i) . '" id="rDocenteCP' . ($i) . '" type="radio" value="docente" >
                                Docente<br>
                                <input name="rFiliacionISCP' . ($i) . '" id="rEstudianteCP' . ($i) . '" type="radio" value="estudiante" checked>
                                Estudiante<br>
                                <input name="rFiliacionISCP' . ($i) . '" id="rAdminCP' . ($i) . '" type="radio" value="administrativo" > 
                                Administrativo<br>';
                                
                            }
                            else{
                                echo '<input name="rFiliacionISCP' . ($i) . '" id="rDocenteCP' . ($i) . '" type="radio" value="docente" >
                                Docente<br>
                                <input name="rFiliacionISCP' . ($i) . '" id="rEstudianteCP' . ($i) . '" type="radio" value="estudiante" >
                                Estudiante<br>
                                <input name="rFiliacionISCP' . ($i) . '" id="rAdminCP' . ($i) . '" type="radio" value="administrativo" checked>
                                Administrativo<br>';
                            }
                            echo '</div>';
                        }
                        else{
                            echo '<input name="rPUniCP' . ($i) . '" id="rPUniCP' . ($i) . '" type="radio" value="interno" onclick="Select(' . ($i) . ')" >
                                    Pertenece a la Universidad Cat&oacute;lica Boliviana<br>
                                  <input name="rPUniCP' . ($i) . '" id="rOUniCP' . ($i) . '" type="radio" value="externo" onclick="noSelect(' . ($i) . ')" checked>
                                  Pertenece a otra Universidad<br>
                                  <div id="divi' . ($i) . '">
                                  Universidad:<span class="must">*</span><br>
                                  <input class="stextInput" name="uniISCP' . ($i) . '" id="uniISCP' . ($i) . '" value="' . ($investigadores[$i]['universidad']) . '" type="text" >';
                            echo '</div>';
                        }
                        echo '</div>';                    
                    }
                }
            ?>
        </div>
        </fieldset>

        <div align="center">
            <input class="button" syte="margin-right:20px;" type="submit" value="Guardar">
            <input class="button" type="submit" name="cancel" value="Cancelar" />
        </div> 
    </form>
    </div>
</body>
</html>

