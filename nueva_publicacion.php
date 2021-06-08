<?php 
session_start();
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos']) || $_SESSION['permisos'] != 'investigador'){
    die('No ha iniciado sesion');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nueva Publicaci&oacute;n</title>
    <?php //require_once "c_crearpub.php"?>
    <script src="script/s_nueva_publicacion.js"></script>
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
        <form action="c_crearpub.php" method="post">
            <h1>Crear Nueva publicaci&oacute;n</h1>   
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
            <h3><i>Para registrar la publicaci&oacute;n debe ingresar todos los datos obligatorios (<span class="must">*</span>)</i></h3>
            <label for="tituloCP"> Titulo:<span class="must">*</span> </label><br>
            <input class="textInput" name="tituloCP" id="tituloCP" type="text"><br>
            <label for="resumenCP">Resumen:<span class="must">*</span></label><br>
            <textarea class="textInput" name="resumenCP" id="resumenCP" rows="4" cols="100"></textarea><br><br>
            
            <!-- Estado -->
            
            <label>Estado:<span class="must">*</span></label><br>
            <input name="estPub" id="cursoPub" type="radio" value="curso">
            <label for="cursoPub">En Curso</label><br>
            <input name="estPub" id="termPub" type="radio" value="terminado">
            <label for="termPub">Terminada</label><br>
            
            <!-- Linea de Inv -->

            <label for="linInvCP">Linea de Investigaci&oacute;n:<span class="must">*</span></label>
            <select name="linInvCP" id="tLineaI">
                <option value="">Ninguno</option>
                <option value="Familia y Comunidad">Familia y Comunidad</option>
                <option value="Etica y moral">&Eacute;tica y moral</option>
                <option value="Desarrollo humano integral: Derechos humanos, salud y educacion">Desarrollo humano integral: Derechos humanos, salud y educación</option>
                <option value="Ciencia, tecnologia e innovacion">Ciencia, tecnología e innovación</option>
                <option value="Crecimiento equitativo, desarrollo inclusivo, emprendimiento y productividad">Crecimiento equitativo, desarrollo inclusivo, emprendimiento y productividad</option>
                <option value="Medio ambiente, recursos naturales y energias">Medio ambiente, recursos naturales y energías</option>
                <option value="Culturas y patrimonio">Culturas y patrimonio</option>
                <option value="Institucionalidad, relaciones internacionales y soberania">Institucionalidad, relaciones internacionales y soberanía<option>
            </select>
            <br><br>
        
            
            <label for="uInvestigacion">Unidad de Investigaci&oacute;n:<span class="must">*</span></label>
            <select name="uInvestigacion" id="uInvestigacion">
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
            
            <label for="apaCP">Citacion APA:<!--<span class="must">*</span>--></label><br>
            <textarea class="textInput" name="apaCP" id="apaCP" rows="4" cols="100"></textarea><br>
            

            <label for="invCP">Investigaci&oacute;n asociada (C&oacute;digo):</label>
            <input class="textInput" name="invCP" id="invCP" type="text"><br>
            <label for="tipoCP">Tipo publicaci&oacute;n:<span class="must">*</span></label>
            <select name="tipoCP" id="tipoCP">
                <option value="">Ninguno</option>
                <option value="Articulo">Articulo</option>
                <option value="Acta">Acta</option>
                <option value="Libro">Libro</option>
                <option value="Capitulo de libro">Capitulo de libro</option>
                <option value="Patente">Patente</option>
                <option value="Otro">Otro</option>
            </select>
            <h3><i>A continuaci&oacute;n, indica los detalles del autor principal</i></h3>
            <fieldset>
            <legend>AUTOR PRINCIPAL<span class="must">*</span></legend>
                <div id="InvP">
                    <label for="nomInvPCP">Nombre:<span class="must">*</span></label> 
                    <input class="textInput" name="nomInvPCP" id="nomInvPCP" type="text"><br>
                    <input name="rPUniCP" id="rPUniCP" type="radio" onclick="perteneceInvP()" value="interno"> 
                    <label for="rPUniCP">Pertenece a la Universidad Cat&oacute;lica Boliviana</label><br>
                    <input name="rPUniCP" id="rOUniCP" type="radio" onclick="noPerteneceInvP()" value="externo">
                    <label for="rOUniCP"> Pertenece a otra Universidad</label><br>
                </div>
            </fieldset>

            <h3><i>Ahora, indica los detalles de los autores de colaboraci&oacute;n</i></h3>

            <fieldset>
            <h3>Autores secundarios <button class="button" onclick="addItemInv()"> + </button></h3>
            <div id="InvS">

            </div>
            </fieldset>

            <div align="center">
                <input class="button" style="margin-right:20px;" type="submit" value="Crear">
                <input class="button" type="submit" name="cancel" value="Cancelar" />
            </div>
        </form>
    </div>




</body>
</html>

