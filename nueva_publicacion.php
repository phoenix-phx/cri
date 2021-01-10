<!DOCTYPE html>
<html>
<head>
    <title>Nueva Publicaci&oacute;n</title>
    <?php require_once "c_crearpub.php"?>
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
            <textarea class="textInput" name="resumenCP" id="resumenCP" rows="4" cols="100"></textarea><br>

            <label for="uInvestigacion">Unidad de Investigaci&oacute;n:<span class="must">*</span></label>
            <input class="textInput" name="uInvestigacion" id="uInvestigacion" type="text"><br>
            
            <label for="invCP">Investigaci&oacute;n asociada (C&oacute;digo):</label>
            <input class="textInput" name="invCP" id="invCP" type="text"><br>
            <label for="tipoCP">Tipo publicaci&oacute;n:<span class="must">*</span></label>
            <select name="tipoCP" id="tipoCP">
                <option value="Ninguno">Ninguno</option>
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

