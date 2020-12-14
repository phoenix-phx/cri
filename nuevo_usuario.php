<!DOCTYPE html>
<html>
    <head>
        <title>Crear Usuario</title>
        <?php require_once "c_crearusuario.php"?>
    </head> <!-- Agregar css-->
    <body>
        <!-- Agregar cabecera-->
        <h1>Registrar Usuario</h1>
        <?php
        if (isset($_SESSION['error'])) {
            echo ('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
        ?>
        <form action="c_crearusuario.php" method="post" >
            <label for="nombre">Nombre: </label>
            <input name="nombre" id="nombre" type="text"><br>

            <label for="correo">Correo:</label>
            <input name="correo" id="correo" type="text"><br>

            <label for="celular">Celular:</label>
            <input name="celular" id="celular" type="text"><br>

            <label for="telefono">Telefono:</label>
            <input name="telefono" id="telefono" type="text"><br>
            
            <h4>Filiaci&oacute;n</h4>
            <input type="radio" name="rbfiliacion" id="rbestudiante" value="estudiante">
            <label for="rbestudiante">Estudiante</label><br>
            <input type="radio" name="rbfiliacion" id="rbdocente" value="docente">
            <label for="rbdocente">Docente</label><br>
            <input type="radio" name="rbfiliacion" id="rbadmin" value="administrativo">
            <label for="rbadmin">Administrativo</label><br>
            <label for="tUnidadI">Unidad de Investigacion</label>
            <input type="text" name="tUnidadI" id="tUnidadI"><br>
            <h4>Permisos</h4>
            <input type="radio" name="rbpermisos" id="rbinvestigador" value="investigador">
            <label for="rbinvestigador">Investigador</label><br>
            <input type="radio" name="rbpermisos" id="rbadminp" value="administrativo">
            <label for="rbadminp">Administrativo</label><br>
            <input type="submit" value="Crear Usuario">
        </form>
        <!--Agregar footer-->
    </body>
</html>

