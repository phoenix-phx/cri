<!DOCTYPE html>
<html>
<head>
    <title>Nueva Investigaci&oacute;n</title>
    <?php require_once "c_crearinv.php"?>
    <script src="script/s_nueva_investigacion.js"></script>
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
        <h1>Crear nueva investigaci&oacute;n</h1>
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
        <h3><i>Para registrar la investigaci&oacute;n debe ingresar todos los datos obligatorios (<span class="must">*</span>)</i></h3>
        <form action="c_crearinv.php" method="post">
            <label for="tituloCI">Titulo:<span class="must">*</span> </label><br>
            <input class="textInput" name="invTituloCI" id="tituloCI" type="text"><br>
            
            <label for="nombreCortoCI">Nombre Corto:<span class="must">*</span></label><br>
            <input class="textInput" name="invNomCortoCI" id="nombreCortoCI" type="text"><br>
            
            <label for="resumenCI">Resumen:<span class="must">*</span></label><br>
            <textarea class="textInput" name="resumenCI" id="resumenCI" rows="4" cols="100"></textarea><br>
            
            <label for="fechaFinCI">Fecha de finalizaci&oacute;n (aaaa-mm-dd):<span class="must">*</span></label><br>
            <input class="xstextInput" name="fechaFinCI" id="fechaFinCI" type="date"><br>
            
            <label for="uniInvCI">Unidad de Investigaci&oacute;n:<span class="must">*</span></label><br>
            <input class="textInput" name="uniInvCI" id="uniInvCI" type="text"><br>

            <h3><i>A continuaci&oacute;n, indica los detalles del investigador principal:</i></h3>
            <!--Agregar div-->
            <fieldset>
            <legend>INVESTIGADOR PRINCIPAL<span class="must">*</span></legend>
            <div id="InvP">
                <label for="nomInvPCI">Nombre<span class="must">*</span>:</label>
                <input class="textInput" name="nomInvPCI" id="nomInvPCI" type="text"><br>
                
                <input name="univIP" id="rPUniCI" type="radio" onclick="perteneceInvP()" value="interno">
                <label for="rPUniCI">Pertenece a la Universidad Cat&oacute;lica Boliviana</label><br>
                
                <input name="univIP" id="rOUniCI" type="radio" onclick="noPerteneceInvP()" value="externo">
                <label for="rOUniCI">Pertenece a otra Universidad</label><br>
                
            </div>
            </fieldset>

            <h3><i>Ahora, indica los detalles de los investigadores de colaboraci&oacute;n (si existen):</i></h3>
            <fieldset>   
            <h3>Investigadores de colaboraci&oacute;n <button onclick="addItemInv()" class="button"> + </button> </h3>
            <div id="InvS">
            </div>
            </fieldset>
        
            <h3><i>A continuaci&oacute;n, ingresa los detalles del financiamiento:</i></h3>
            <fieldset id="financiamiento">
                <legend>FINANCIAMIENTO<span class="must">*</span></legend>
                <h3>Existe:<span class="must">*</span></h3>
                <input name="rExisteFI" id="rSiExisteFCI" type="radio" value="si" onclick="existFinan()">
                <label for="rSiExisteFCI">Si</label><br>
                
                <input name="rExisteFI" id="rNoExisteFCI" type="radio" value="no" onclick="noexistFinan()">
                <label for="rNoExisteFCI">No</label><br>
            </fieldset>
            
            <!--Agregar actividades-->
            <h3><i>Finalmente, indica las actividades planificadas para la investigaci&oacute;n:</i></h3>
            <fieldset>
            <h3>Actividades <button onclick="addItemAct()" class="button"> + </button></h3>
            <div id="Act">
            </div>
            </fieldset>
            <div align="center">
                <input class="button" style="margin-right:20px;" type="submit" value="Crear">
                <input class="button" type="submit" name="cancel" value="Cancelar" />
            <div> 
        </form>
    <div>
</body>
</html>