<!DOCTYPE html>
<html>
<head>
    <title>Editar Investigacion</title>
    <?php require_once "c_editarinv.php"?>
    <script>
        ///////Investigador principal
        function perteneceInvP(){
            let radio = document.getElementById("InvP");
            let divi;
            if(radio.getElementsByTagName("div").length !== 0){
                divi = document.getElementById("divi");
                divi.parentNode.removeChild(divi);   
            }
            divi = radio.appendChild(document.createElement("div"));
            divi.id = "divi";
            divi.appendChild(document.createTextNode("Unidad de Investigacion"));
            divi.appendChild(document.createElement("br"));
            let txtInp = document.createElement("input");
            txtInp.id = "uniInvPCI"; txtInp.name = "uniInvPCI"; txtInp.type = "text"; 
            divi.appendChild(txtInp);
            divi.appendChild(document.createElement("br"));
            divi.appendChild(document.createTextNode("Filiacion"));
            divi.appendChild(document.createElement("br"));
            let rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionIP"; rbutton.id="rDocenteCI"; rbutton.type="radio"; rbutton.value="docente";
            divi.appendChild(document.createTextNode("Docente"));
            divi.appendChild(document.createElement("br"));
            rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionIP"; rbutton.id="rEstudianteCI"; rbutton.type="radio"; rbutton.value="estudiante";
            divi.appendChild(document.createTextNode("Estudiante"));
            divi.appendChild(document.createElement("br"));
            rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionIP"; rbutton.id="rAdminCI"; rbutton.type="radio"; rbutton.value="administrativo";
            divi.appendChild(document.createTextNode("Administrativo"));
            divi.appendChild(document.createElement("br"));
        }
        function noPerteneceInvP(){
            let radio = document.getElementById("InvP");
            let divi;
            if(radio.getElementsByTagName("div").length !== 0){
                divi = document.getElementById("divi");
                divi.parentNode.removeChild(divi);
            }
            divi = radio.appendChild(document.createElement("div"));
            divi.id = "divi";
            divi.appendChild(document.createTextNode("Universidad"));
            divi.appendChild(document.createElement("br"));
            let txtInp = document.createElement("input");
            txtInp.id = "uniIPCI"; txtInp.name = "uniIPCI"; txtInp.type = "text"; 
            divi.appendChild(txtInp);
        }
        //////


        var i = 0;
        
        function addItemInv(){
            event.preventDefault();
            let dlist = document.getElementById("InvS");
            let ndivi = document.createElement("div");
            ndivi.setAttribute('id',"dICI" + i);
            //Nombre
            ndivi.appendChild(document.createTextNode("Nombre"));
            let inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "nomInvSCI" + i; inp.id = "nomInvSCI" + i; inp.type = "text";  
            inp = ndivi.appendChild(document.createElement("button"));
            inp.innerHTML = "-";
            inp.id = 'bICI' + i;
            const lol = "" + i;
            inp.onclick = function() { removeItemInv(lol) };
            ndivi.appendChild(document.createElement("br"));
            //////////////////////
            //Radio button pertenece
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "rPUniCI" + i; inp.id = "rPUniCI" + i; inp.type = "radio"; inp.value = "interno";
            inp.onclick = function() {Select(lol)};
            ndivi.appendChild(document.createTextNode("Pertenece a la Universidad Catolica Boliviana"));
            ndivi.appendChild(document.createElement("br"));
            ///////////////////////
            //Radio button no pertenece
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "rPUniCI" + i; inp.id = "rOUniCI" + i; inp.type = "radio"; inp.value = "externo"
            inp.onclick = function() {noSelect(lol)};
            ndivi.appendChild(document.createTextNode("Pertenece a otra Universidad"));
            ndivi.appendChild(document.createElement("br"));
            /////////////////////////
            
            dlist.appendChild(ndivi);
            // console.log("prev add" + i);
            i++;
            // console.log("now add" + i);
        }
        function removeItemInv(index){
            console.log("index "+index);
            let dlist = document.getElementById("InvS");
            let item = document.getElementById("dICI" + index);
            let divs = dlist.getElementsByTagName("div");
            let cont = 0, jj = 0;
            
            for(let j = 0; j < divs.length; j++){
                //console.log(divs[j].id);
                if(divs[j].id == "dICI" + jj){
                    
                    jj++;
                } 
            }
            //console.log("jj" + jj);
            for(let j = 0; j < jj; j++){
                if(index != j){
                    const lul = "" + cont;
                    let inp = document.getElementById("nomInvSCI" + j);
                    inp.name = "nomInvSCI" + cont;
                    inp.id = "nomInvSCI" + cont;
                    //boton -
                    inp = document.getElementById("bICI" + j);
                    inp.id = "bICI" + cont;
                    inp.onclick = function() { removeItemInv(lul) };
                    ///
                    
                    //Radio button pertenece
                    inp = document.getElementById("rPUniCI" + j);
                    inp.name = "rPUniCI" + cont;
                    inp.id = "rPUniCI" + cont;
                    inp.onclick = function() {Select(lul)};
                    //////////////
                    //Radio button no pertenece
                    inp = document.getElementById("rOUniCI" + j);
                    inp.name = "rPUniCI" + cont;
                    inp.id = "rOUniCI" + cont;
                    inp.onclick = function() { noSelect(lul) };
                    
                    /////////////
                    ///Cambio de nombre UniInv / Uni
                    if(document.getElementById("uniISCI" + j) !== null){
                        let txtOtro = document.getElementById("uniISCI" + j);
                        txtOtro.id = "uniISCI" + cont;
                        txtOtro.name = "uniISCI" + cont;
                    }
                    else if(document.getElementById("uniInvSCI" + j) !== null){
                        let txtOtro = document.getElementById("uniInvSCI" + j);
                        txtOtro.id = "uniInvSCI" + cont;
                        txtOtro.name = "uniInvSCI" + cont;
                        let rbutton = document.getElementById("rDocenteCI" + j);
                        rbutton.name="rFiliacionIS" + cont; rbutton.id="rDocenteCI" + cont;
                        rbutton = document.getElementById("rEstudianteCI" + j);
                        rbutton.name="rFiliacionIS" + cont; rbutton.id="rEstudianteCI" + cont;
                        rbutton = document.getElementById("rAdminCI" + j);
                        rbutton.name="rFiliacionIS" + cont; rbutton.id="rAdminCI" + cont;
                    }
                    ////////////
                    ///Cambio de nombre al div
                    inp = document.getElementById("divi" + j);
                    if(inp !== null) inp.id = "divi" + cont;
                    inp = document.getElementById("dICI" + j);
                    inp.id = "dICI" + cont;
                    cont++;
                    
                }   
            }
            dlist.removeChild(item);
            i--;
        }
        function Select(index){
            let dlist = document.getElementById("InvS");
            let radio = document.getElementById("dICI" + index);
            let divi;
            if(radio.getElementsByTagName("div").length !== 0){
                divi = document.getElementById("divi" + index);
                divi.parentNode.removeChild(divi);   
            }
            divi = radio.appendChild(document.createElement("div"));
            divi.id = "divi" + index;
            divi.appendChild(document.createTextNode("Unidad de Investigacion"));
            divi.appendChild(document.createElement("br"));
            let txtInp = document.createElement("input");
            txtInp.id = "uniInvSCI" + index; txtInp.name = "uniInvSCI" + index; txtInp.type = "text" + index; 
            divi.appendChild(txtInp);
            divi.appendChild(document.createElement("br"));
            divi.appendChild(document.createTextNode("Filiacion"));
            divi.appendChild(document.createElement("br"));
            let rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionIS" + index; rbutton.id="rDocenteCI" + index; rbutton.type="radio"; rbutton.value="docente";
            divi.appendChild(document.createTextNode("Docente"));
            divi.appendChild(document.createElement("br"));
            rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionIS" + index; rbutton.id="rEstudianteCI" + index; rbutton.type="radio"; rbutton.value="estudiante";
            divi.appendChild(document.createTextNode("Estudiante"));
            divi.appendChild(document.createElement("br"));
            rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionIS" + index; rbutton.id="rAdminCI" + index; rbutton.type="radio"; rbutton.value="administrativo";
            divi.appendChild(document.createTextNode("Administrativo"));
            divi.appendChild(document.createElement("br"));
        }
        function noSelect(index){
            let radio = document.getElementById("dICI" + index);
            let divi;
            if(radio.getElementsByTagName("div").length !== 0){
                divi = document.getElementById("divi" + index);
                divi.parentNode.removeChild(divi);
            }
            divi = radio.appendChild(document.createElement("div"));
            divi.id = "divi" + index;
            divi.appendChild(document.createTextNode("Universidad"));
            divi.appendChild(document.createElement("br"));
            let txtInp = document.createElement("input");
            txtInp.id = "uniISCI" + index; txtInp.name = "uniISCI" + index; txtInp.type = "text"; 
            divi.appendChild(txtInp);
        }


        var actividad = 0;
        function addItemAct(){
            event.preventDefault();
            let dlist = document.getElementById("Act");
            let ndivi = document.createElement("div");
            ndivi.setAttribute('id',"dA" + actividad);
            ndivi.appendChild(document.createTextNode("Nombre"));
            let inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "nomActCI" + actividad; inp.id = "nomActCI" + actividad; inp.type = "text";
            inp = ndivi.appendChild(document.createElement("button"));
            inp.innerHTML = "-";
            inp.id = 'bA' + actividad;
            const lul = "" + actividad;
            inp.onclick = function() {removeItemAct(lul)};
            ndivi.appendChild(document.createElement("br"));
            ndivi.appendChild(document.createTextNode("Fecha inicio"));
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "FIActCI" + actividad; inp.id = "FIActCI" + actividad; inp.type = "date";
            ndivi.appendChild(document.createElement("br"));
            ndivi.appendChild(document.createTextNode("Fecha final"));
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "FFActCI" + actividad; inp.id = "FFActCI" + actividad; inp.type = "date";
            dlist.appendChild(ndivi);
            actividad++;
        }
        function removeItemAct(index){
            // console.log("index "+index);
            let dlist = document.getElementById("Act");
            let item = document.getElementById("dA" + index);
            let divs = dlist.getElementsByTagName("div").length;
            let cont = 0;
            for(let j = 0; j < divs; j++){
                if(index != j){
                    const lul = "" + cont;
                    
                    /////////////
                    let inp = document.getElementById("nomActCI" + j);
                    inp.name = "nomActCI" + cont;
                    inp.id = "nomActCI" + cont;
                    inp = document.getElementById("FIActCI" + j);
                    inp.name = "FIActCI" + cont;
                    inp.id = "FIActCI" + cont;
                    inp = document.getElementById("FFActCI" + j);
                    inp.name = "FFActCI" + cont;
                    inp.id = "FFActCI" + cont;
                    //boton -
                    inp = document.getElementById("bA" + j);
                    inp.id = "bA" + cont;
                    inp.onclick = function() { removeItemAct(lul) };
                    ///
                    ///Cambio de nombre al div
                    inp = document.getElementById("dA" + j);
                    inp.id = "dA" + cont;
                    cont++;
                }
            }
            dlist.removeChild(item);
            // console.log("prev del" + i);
            actividad--;
            // console.log("now del" + i);

        }
        function existFinan(){
            let fin = document.getElementById("financiamiento");
            let d = fin.appendChild(document.createElement("div")); d.id = "existe";
            d.appendChild(document.createTextNode("Tipo financiador"));
            d.appendChild(document.createElement("br"));
            let inp = d.appendChild(document.createElement("input"));
            inp.name = "rTipoFr"; inp.id = "rTipoFIntCI"; inp.value = "interno"; inp.type="radio";
            inp.onclick = function() {tipoInter()};
            d.appendChild(document.createTextNode("Interno"));
            d.appendChild(document.createElement("br"));
            inp = d.appendChild(document.createElement("input"));
            inp.name = "rTipoFr"; inp.id = "rTipoFEntCI"; inp.type="radio"; inp.value = "externo";
            inp.onclick = function() {tipoExtern()};
            d.appendChild(document.createTextNode("Externo"));
            d.appendChild(document.createElement("br"));
            d.appendChild(document.createTextNode("Tipo Financiamiento"));
            d.appendChild(document.createElement("br"));
            inp = d.appendChild(document.createElement("input"));
            inp.name = "rTipoFI"; inp.id = "rTipoMCI"; inp.type="radio"; inp.value = "monetario";
            inp.onclick = function() {tipoMont()};
            d.appendChild(document.createTextNode("Monetario"));
            d.appendChild(document.createElement("br"));
            inp = d.appendChild(document.createElement("input"));
            inp.name = "rTipoFI"; inp.id = "rTipoOCI"; inp.type="radio"; inp.value = "otro";
            inp.onclick = function() {tipoOtro()};
            d.appendChild(document.createTextNode("Otro"));
            d.appendChild(document.createElement("br"));
            d.appendChild(document.createTextNode("Observaciones"));
            d.appendChild(document.createElement("br"));
            inp = d.appendChild(document.createElement("textarea"));
            inp.name = "obsTipoFOCI"; inp.id = "obsTipoFOCI"; inp.rows = "4"; inp.cols = "100";
            d.appendChild(document.createElement("br"));
        }
        function noexistFinan(){
            let fin = document.getElementById("financiamiento");
            let d = document.getElementById("existe");
            if(d === null) return;
            else fin.removeChild(d);
        }    
        function tipoExtern(){
            let fin = document.getElementById("rTipoFEntCI");
            let d = document.createElement("div");
            d.id = "nomFin";
            fin.parentNode.insertBefore(d, fin.nextSibling.nextSibling);
            d.appendChild(document.createElement("br"));
            d.appendChild(document.createTextNode("Nombre Financiador"));
            let inp = document.createElement("input");
            inp.name = "nombreFinanciador"; inp.id = "nombreFinanciador"; inp.type = "text";
            d.appendChild(inp);
        }
        function tipoInter(){
            let fin = document.getElementById("financiamiento");
            let d = document.getElementById("existe");
            let inp = document.getElementById("nomFin");
            if(inp !== null) d.removeChild(inp);
        } 

        function tipoMont(){
            let fin = document.getElementById("rTipoMCI");
            let d = document.createElement("div");
            d.id = "montFin";
            fin.parentNode.insertBefore(d, fin.nextSibling.nextSibling);
            d.appendChild(document.createElement("br"));
            d.appendChild(document.createTextNode("Monto"));
            let inp = document.createElement("input");
            inp.name = "monto"; inp.id = "monto"; inp.type = "text";
            d.appendChild(inp);
        }
        function tipoOtro(){
            let fin = document.getElementById("financiamiento");
            let d = document.getElementById("existe");
            let inp = document.getElementById("montFin");
            if(inp !== null) d.removeChild(inp);
        }
    </script>
    <style type="text/css">
        .must{
            color: red;
        }
    </style>
</head>
<body>
    <h1>Editar investigacion</h1>
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
    <h3><i>Llena todos los campos para registrar la investigacion</i></h3>
    <form action="c_crearinv.php" method="post">
        
        <label>Codigo</label><span> <?php echo $codigo; ?></span> <br>

        <label for="tituloCI">Titulo<span class="must">*</span>: </label>
        <input name="invTituloCI" id="tituloCI" type="text" value="<?php echo($titulo) ?>"><br>
        
        <label for="nombreCortoCI">Nombre corto<span class="must">*</span>:</label>
        <input name="invNomCortoCI" id="nombreCortoCI" type="text" value="<?php echo($nombre_corto) ?>"><br>
        
        <label for="resumenCI">Resumen<span class="must">*</span>:</label><br>
        <textarea name="resumenCI" id="resumenCI" rows="4" cols="100"><?php echo($resumen) ?></textarea><br>
        
        <label>Fecha de Inicio</label><span> <?php echo $fecha_inicio; ?></span> <br>
        
        <label for="fechaFinCI">Fecha de finalizacion<span class="must">*</span>:</label>
        <input name="fechaFinCI" id="fechaFinCI" type="date" value="<?php echo($fecha_fin) ?>"><br>
        
        <label for="uniInvCI">Unidad de Investigacion<span class="must">*</span>:</label>
        <input name="uniInvCI" id="uniInvCI" type="text" value="<?php echo($unidad) ?>"><br>

        <input type="hidden" name="inv_id" value="<?php echo $inv_id ?>">
        
        <h3><i>A continuacion, indica los detalles del investigador principal:</i></h3>
        <!--Agregar div-->
        <fieldset>
        <h3>Investigador principal</h3>
        <div id="InvP">
            <label for="nomInvPCI">Nombre<span class="must">*</span>:</label>
            <input name="nomInvPCI" id="nomInvPCI" type="text" value="<?php echo($pnombre) ?>"><br>
            
            <input name="univIP" id="rPUniCI" type="radio" onclick="perteneceInvP()" value="interno" <?php if($tipo_filiacion === 'interno'){
                echo 'checked="checked"';
            } ?> > 
            <label for="rPUniCI">Pertenece a la Universidad Catolica Boliviana</label><br>
            
            <input name="univIP" id="rOUniCI" type="radio" onclick="noPerteneceInvP()" value="externo" <?php if($tipo_filiacion === 'externo'){
                echo 'checked="checked"';
            } ?> >

            <label for="rOUniCI">Pertenece a otra Universidad</label><br>
            
            <?php 
            if($tipo_filiacion === 'externo'){
                echo '<div id="divi">';
                echo "Universidad";
                echo "<br>";
                echo '<input id="uniIPCI" name="uniIPCI" type="text" value="'. $universidad . '">';
                echo "</div>";
            }
            else if($tipo_filiacion === 'interno'){
                echo '<div id="divi">';
                echo "Unidad de Investigacion";
                echo "<br>";
                echo '<input id="uniInvPCI" name="uniInvPCI" type="text" value="'. $unidad_investigacion . '">';
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

        <h3><i>Ahora, indica los detalles de los investigadores de colaboracion (si existen):</i></h3>
        <?php
            echo '<fieldset>
                    <h3>
                    Investigadores de colaboracion 
                    <button onclick="addItemInv()">+</button>
                    </h3>';
            if(count($investigadores) !== 0){
                echo '<div id="InvS">';
                for ($i=0; $i < count($investigadores); $i++) {
                    echo '<div id="dICI' . ($i) . '">
                            Nombre <input name="nomInvSCI' . ($i) . '" id="nomInvSCI' . ($i) . '" value="' . $investigadores[$i]['nombre'] . '" type="text" />
                            <button id="bICI' .  ($i) . '" onclick="removeItemInv(' . ($i) . ')">-</button><br>';
                    if($investigadores[$i]['tipo_filiacion'] == 'interno'){
                        echo '<input name="rPUniCI' . ($i) . '" id="rPUniCI' . ($i) . '" type="radio" value="interno" onclick="Select(' . ($i) . ')" checked>
                                Pertenece a la Universidad Catolica Boliviana<br>
                              <input name="rPUniCI' . ($i) . '" id="rOUniCI' . ($i) . '" type="radio" value="externo" onclick="noSelect(' . ($i) . ')" >
                              Pertenece a otra Universidad<br>
                              <div id="divi' . ($i) . '">
                              Unidad de Investigacion<br>
                              <input name="uniInvSCI' . ($i) . '" id="uniInvSCI' . ($i) . '" value="' . $investigadores[$i]['unidad_investigacion'] . '" type="text" /> <br>';
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
                                Pertenece a la Universidad Catolica Boliviana<br>
                              <input name="rPUniCI' . ($i) . '" id="rOUniCI' . ($i) . '" type="radio" value="externo" onclick="noSelect(' . ($i) . ')" checked>
                              Pertenece a otra Universidad<br>
                              <div id="divi' . ($i) . '">
                              Universidad<br>
                              <input name="uniISCI' . ($i) . '" id="uniISCI' . ($i) . '" value="' . ($investigadores[$i]['universidad']) . '" type="text" >';
                        echo '</div>';
                    }
                    echo '</div> <br/>';                    
                }
                echo '</div>';
            }
        echo '</fieldset>';
    ?>
        <h3><i>A continuacion, ingresa los detalles del financiamiento:</i></h3>
        <fieldset id="financiamiento">
            <h3>Financiamiento</h3>
            <h4>Existe</h4>
            <input name="rExisteFI" id="rSiExisteFCI" type="radio" value="si" onclick="existFinan()">
            <label for="rSiExisteFCI">Si</label><br>
            
            <input name="rExisteFI" id="rNoExisteFCI" type="radio" value="no" onclick="noexistFinan()">
            <label for="rNoExisteFCI">No</label><br>
        </fieldset>
        
        <!--Agregar actividades-->
        <h3><i>Finalmente, indica las actividades planificadas para la investigacion:</i></h3>
        <?php
        echo '<fieldset>
        <h3>
        "Actividades "
        <button onclick="addItemAct()">+</button>
        </h3>';
        if(count($actividades) !== 0){
            echo '<div id="Act">';
            for ($i=0; $i < count($actividades); $i++) {
                echo '<div id="dA' . ($i) . '">
                    Nombre
                    <input name="nomActCI' . ($i) . '" id="nomActCI' . ($i) . '" type="text" value="' . $actividades[$i]['nombre'] . '">
                    <button id="bA' . ($i) . '" onclick="removeItemAct('. ($i) .')">-</button><br>
                    Fecha inicio
                    <input name="FIActCI' . ($i) . '" id="FIActCI' . ($i) . '" type="date" value="' . $actividades[$i]['fecha_inicio'] . '"><br>
                    Fecha final 
                    <input name="FFActCI' . ($i) . '" id="FFActCI' . ($i) . '" type="date" value="' . $actividades[$i]['fecha_final'] . '"><br>
                    </div>';
            }
            echo '</div>';
        }
        echo '</fieldset>';
    ?>
        <input type="submit" value="Crear"> 
    </form>
</body>
</html>