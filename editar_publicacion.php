<!DOCTYPE html>
<html>
<head>
    <title>Editar Publicacion</title>
    <?php require_once "c_editarpub.php"?>
    
    <script src="script/s_editar_publicacion.js"></script>
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
                Unidad de Investigacion UCB
            </a>
            <a class="aRight textIblue">
                <?php 
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <div style="padding-left:5%; padding-right:5%;">
    <form action="c_editarpub.php?pub_id=<?php echo($_REQUEST['pub_id']) ?>" method="post">
        <h1>Editar publicacion</h1>   
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
        <h3><i>Llena todos los campos para registrar la publicacion</i></h3>
        Codigo: <?php echo $codigo; ?> <br>

        <label for="tituloCP">Titulo:</label>
        <input class="textInput" name="tituloCP" id="tituloCP" type="text" value="<?php echo($titulo) ?>"><br>

        <label for="resumenCP">Resumen:</label><br>
        <textarea class="textInput" name="resumenCP" id="resumenCP" rows="4" cols="100"><?php echo $resumen ?></textarea><br>

        <label for="invCP">Investigacion asociada:</label><br> 
        <input class="textInput" name="invCP" id="invCP" type="text" <?php if($investigacion !== null) {echo 'value="'.$nombreInv.'"';}?>><br>
        <?php // TODO: procesar select si existe ?>

        <label for="tipoCP">Tipo publicacion:</label>
        <select name="tipoCP" id="tipoCP">
            <option value="Ninguno">Ninguno</option>
            <option value="Articulo" <?php if($tipo === 'Articulo') echo 'selected="selected"'; ?>>Articulo</option>
            <option value="Acta" <?php if($tipo === 'Acta') echo 'selected="selected"'; ?>>Acta</option>
            <option value="Libro" <?php if($tipo === 'Libro') echo 'selected="selected"'; ?>>Libro</option>
            <option value="Capitulo de libro" <?php if($tipo === 'Capitulo de libro') echo 'selected="selected"'; ?>>Capitulo de libro</option>
            <option value="Patente" <?php if($tipo === 'Patente') echo 'selected="selected"'; ?>>Patente</option>
            <option value="Otro" <?php if($tipo === 'Otro') echo 'selected="selected"'; ?>>Otro</option>
        </select>
        <h3><i>A continuacion, indica los detalles del autor principal</i></h3>
        <fieldset>
        <legend>AUTOR PRINCIPAL</legend>
        <div id="InvP">
            <input type="hidden" name="pautor_id" value="<?php echo($pautor_id) ?>">

            <label for="nomInvPCP">Nombre:</label><br>
            <input class="textInput" name="nomInvPCP" id="nomInvPCP" type="text" value="<?php echo($pnombre) ?>"><br>

            <input name="rPUniCP" id="rPUniCP" type="radio" onclick="perteneceInvP()" value="interno" <?php if($tipo_filiacion === 'interno') echo 'checked="checked"'; ?>> 
            <label for="rPUniCP"> Pertenece a la Universidad</label><br>
            <input name="rPUniCP" id="rOUniCP" type="radio" onclick="noPerteneceInvP()" value="externo" <?php if($tipo_filiacion === 'externo') echo 'checked="checked"'; ?>>
            <label for="rOUniCP">Pertenece a otra Universidad</label><br>
            <?php 
            if($tipo_filiacion === 'externo'){
                echo '<div id="divi">';
                echo '<label for="uniIPCP"> Universidad </label>';
                echo "<br>";
                echo '<input class="stextInput" id="uniIPCP" name="uniIPCP" type="text" value="'. $universidad . '">';
                echo "</div>";
            }
            else if($tipo_filiacion === 'interno'){
                echo '<div id="divi">';
                echo '<label for="uniInvPCP"> Unidad de Investigacion </label>';
                echo "<br>";
                echo '<input class="stextInput" id="uniInvPCP" name="uniInvPCP" type="text" value="'. $unidad_investigacion . '">';
                echo "<br>";
                echo "Filiacion";
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

        <h3><i>Ahora, indica los detalles de los autores de colaboracion</i></h3>

        <fieldset>
        <h3>Autores secundarios <button class="button" onclick="addItemInv()"> +    </button></h3>
        <div id="InvS">
            <?php
                echo '<script> var i = ' . count($investigadores) . ';</script>';
                if(count($investigadores) !== 0){
                    for ($i=0; $i < count($investigadores); $i++) {
                        echo '<div id="dICP' . ($i) . '">
                                Nombre <input class="stextInput" name="nomInvSCP' . ($i) . '" id="nomInvSCP' . ($i) . '" value="' . $investigadores[$i]['nombre'] . '" type="text" />
                                <button class="button" id="bICP' .  ($i) . '" onclick="removeItemInv(' . ($i) . ')"> - </button><br>';
                        if($investigadores[$i]['tipo_filiacion'] == 'interno'){
                            echo '<input name="rPUniCP' . ($i) . '" id="rPUniCP' . ($i) . '" type="radio" value="interno" onclick="Select(' . ($i) . ')" checked>
                                    Pertenece a la Universidad Catolica Boliviana<br>
                                  <input name="rPUniCP' . ($i) . '" id="rOUniCP' . ($i) . '" type="radio" value="externo" onclick="noSelect(' . ($i) . ')" >
                                  Pertenece a otra Universidad<br>
                                  <div id="divi' . ($i) . '">
                                  Unidad de Investigacion<br>
                                  <input class="stextInput" name="uniInvSCP' . ($i) . '" id="uniInvSCP' . ($i) . '" value="' . $investigadores[$i]['unidad_investigacion'] . '" type="text" /> <br>';
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
                                    Pertenece a la Universidad Catolica Boliviana<br>
                                  <input name="rPUniCP' . ($i) . '" id="rOUniCP' . ($i) . '" type="radio" value="externo" onclick="noSelect(' . ($i) . ')" checked>
                                  Pertenece a otra Universidad<br>
                                  <div id="divi' . ($i) . '">
                                  Universidad<br>
                                  <input class="stextInput" name="uniISCP' . ($i) . '" id="uniISCP' . ($i) . '" value="' . ($investigadores[$i]['universidad']) . '" type="text" >';
                            echo '</div>';
                        }
                        echo '</div>';                    
                    }
                }
            ?>
        </div>
        </fieldset>

        <div align="center"><input class="button"type="submit" value="Guardar"></div> 
    </form>
    </div>
</body>
</html>

