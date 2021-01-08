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
        <h3><i>Llena todos los campos para registrar la investigaci&oacute;n</i></h3>
        <form action="c_editarinv.php?inv_id=<?php echo($_REQUEST['inv_id']) ?>" method="post">
            
            <label>C&oacute;digo</label><span> <?php echo $codigo; ?></span> <br>

            <label for="tituloCI">Titulo<span class="must">*</span>: </label>
            <input class="textInput" name="invTituloCI" id="tituloCI" type="text" value="<?php echo($titulo) ?>"><br>
            
            <label for="nombreCortoCI">Nombre corto<span class="must">*</span>:</label>
            <input class="textInput" name="invNomCortoCI" id="nombreCortoCI" type="text" value="<?php echo($nombre_corto) ?>"><br>
            
            <label for="resumenCI">Resumen<span class="must">*</span>:</label><br>
            <textarea class="textInput" name="resumenCI" id="resumenCI" rows="4" cols="100"><?php echo($resumen) ?></textarea><br>
            
            <label>Fecha de Inicio</label><span> <?php echo $fecha_inicio; ?></span> <br>
            
            <label for="fechaFinCI">Fecha de finalizaci&oacute;n<span class="must">*</span>:</label>
            <input class="xstextInput" name="fechaFinCI" id="fechaFinCI" type="date" value="<?php echo($fecha_fin) ?>"><br>
            
            <label for="uniInvCI">Unidad de Investigaci&oacute;n<span class="must">*</span>:</label>
            <input class="textInput" name="uniInvCI" id="uniInvCI" type="text" value="<?php echo($unidad) ?>"><br>

            <input type="hidden" name="inv_id" value="<?php echo $inv_id ?>">
            
            <h3><i>A continuaci&oacute;n, indica los detalles del investigador principal:</i></h3>
            <fieldset>
                <legend>INVESTIGADOR PRINCIPAL</legend>
                <div id="InvP">
                    <label for="nomInvPCI">Nombre<span class="must">*</span>:</label>
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
                        echo "Universidad";
                        echo "<br>";
                        echo '<input class="stextInput" id="uniIPCI" name="uniIPCI" type="text" value="'. $universidad . '">';
                        echo "</div>";
                    }
                    else if($tipo_filiacion === 'interno'){
                        echo '<div id="divi">';
                        echo "Unidad de Investigaci&oacute;n";
                        echo "<br>";
                        echo '<input class="stextInput" id="uniInvPCI" name="uniInvPCI" type="text" value="'. $unidad_investigacion . '">';
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
                                Nombre <input class="stextInput" name="nomInvSCI' . ($i) . '" id="nomInvSCI' . ($i) . '" value="' . $investigadores[$i]['nombre'] . '" type="text" />
                                <button id="bICI' .  ($i) . '" class="button" onclick="removeItemInv(' . ($i) . ')"> - </button><br>';
                        if($investigadores[$i]['tipo_filiacion'] == 'interno'){
                            echo '<input name="rPUniCI' . ($i) . '" id="rPUniCI' . ($i) . '" type="radio" value="interno" onclick="Select(' . ($i) . ')" checked>
                                    Pertenece a la Universidad Cat&oacute;lica Boliviana<br>
                                <input name="rPUniCI' . ($i) . '" id="rOUniCI' . ($i) . '" type="radio" value="externo" onclick="noSelect(' . ($i) . ')" >
                                Pertenece a otra Universidad<br>
                                <div id="divi' . ($i) . '">
                                Unidad de Investigaci&oacute;n<br>
                                <input class="stextInput" name="uniInvSCI' . ($i) . '" id="uniInvSCI' . ($i) . '" value="' . $investigadores[$i]['unidad_investigacion'] . '" type="text" /> <br>
                                Filiaci&oacute;n<br>';

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
                                Universidad<br>
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
                <h3>Financiamiento</h3>
                <h4>Existe</h4>
                <input name="rExisteFI" id="rSiExisteFCI" type="radio" value="si" onclick="existFinan()" <?php if($nombre_financiador !== 'No Existe'){
                    echo 'checked="checked"';
                } ?>>
                <label for="rSiExisteFCI">Si</label><br>
                
                <input name="rExisteFI" id="rNoExisteFCI" type="radio" value="no" onclick="noexistFinan()" <?php if($nombre_financiador === 'No Existe'){
                    echo 'checked="checked"';
                } ?>>
                <label for="rNoExisteFCI">No</label><br>
                <?php 
                if($nombre_financiador !== 'No Existe'){
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
                        echo 'Nombre Financiador';
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
                        echo '<div id="montFin">';
                        echo 'Monto';
                        echo '<input class="xstextInput" id="monto" name="monto" type="text" value="' . $monto . '">';
                        echo "</div>";
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