<!DOCTYPE html>
<html>
<head>
    <title>Editar Publicacion</title>
    <?php require_once "c_editarpub.php"?>
    <script>
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
            txtInp.id = "uniInvPCP"; txtInp.name = "uniInvPCP"; txtInp.type = "text"; 
            divi.appendChild(txtInp);
            divi.appendChild(document.createElement("br"));
            divi.appendChild(document.createTextNode("Filiacion"));
            divi.appendChild(document.createElement("br"));
            let rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionIPCP"; rbutton.id="rDocenteCP"; rbutton.type="radio"; rbutton.value="docente";
            divi.appendChild(document.createTextNode("Docente"));
            divi.appendChild(document.createElement("br"));
            rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionIPCP"; rbutton.id="rEstudianteCP"; rbutton.type="radio"; rbutton.value="estudiante";
            divi.appendChild(document.createTextNode("Estudiante"));
            divi.appendChild(document.createElement("br"));
            rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionIPCP"; rbutton.id="rAdminCICP"; rbutton.type="radio"; rbutton.value="administrativo";
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
            txtInp.id = "uniIPCP"; txtInp.name = "uniIPCP"; txtInp.type = "text"; 
            divi.appendChild(txtInp);
        }
        var i = 0;
        
        function addItemInv(){
            event.preventDefault();
            var dlist = document.getElementById("InvS");
            var ndivi = document.createElement("div");
            ndivi.setAttribute('id',"dICP" + i);
            //Nombre
            ndivi.appendChild(document.createTextNode("Nombre"));
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "nomInvSCP" + i; inp.id = "nomInvSCP" + i; inp.type = "text";  
            inp = ndivi.appendChild(document.createElement("button"));
            inp.innerHTML = "-";
            inp.id = 'bICP' + i;
            const lol = "" + i;
            inp.onclick = function() { removeItemInv(lol) };
            ndivi.appendChild(document.createElement("br"));
            //////////////////////
            //Radio button pertenece
            var inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "rPUniCP" + i; inp.id = "rPUniCP" + i; inp.type = "radio"; inp.value = "interno";
            inp.onclick = function() {Select(lol)};
            ndivi.appendChild(document.createTextNode("Pertenece a la Universidad Catolica Boliviana"));
            ndivi.appendChild(document.createElement("br"));
            ///////////////////////
            //Radio button no pertenece
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "rPUniCP" + i; inp.id = "rOUniCP" + i; inp.type = "radio"; inp.value = "externo"
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
            var dlist = document.getElementById("InvS");
            var item = document.getElementById("dICP" + index);
            var divs = dlist.getElementsByTagName("div");
            let cont = 0, jj = 0;
            
            for(let j = 0; j < divs.length; j++){
                //console.log(divs[j].id);
                if(divs[j].id == "dICP" + jj){
                    
                    jj++;
                } 
            }
            //console.log("jj" + jj);
            for(let j = 0; j < jj; j++){
                if(index != j){
                    const lul = "" + cont;
                    let inp = document.getElementById("nomInvSCP" + j);
                    inp.name = "nomInvSCP" + cont;
                    inp.id = "nomInvSCP" + cont;
                    //boton -
                    inp = document.getElementById("bICP" + j);
                    inp.id = "bICP" + cont;
                    inp.onclick = function() { removeItemInv(lul) };
                    ///
                    
                    //Radio button pertenece
                    inp = document.getElementById("rPUniCP" + j);
                    inp.name = "rPUniCP" + cont;
                    inp.id = "rPUniCP" + cont;
                    inp.onclick = function() {Select(lul)};
                    //////////////
                    //Radio button no pertenece
                    inp = document.getElementById("rOUniCP" + j);
                    inp.name = "rPUniCP" + cont;
                    inp.id = "rOUniCP" + cont;
                    inp.onclick = function() { noSelect(lul) };
                    
                    /////////////
                    ///Cambio de nombre UniInv / Uni
                    if(document.getElementById("uniISCP" + j) !== null){
                        var txtOtro = document.getElementById("uniISCP" + j);
                        txtOtro.id = "uniISCP" + cont;
                        txtOtro.name = "uniISCP" + cont;
                    }
                    else if(document.getElementById("uniInvSCP" + j) !== null){
                        var txtOtro = document.getElementById("uniInvSCP" + j);
                        txtOtro.id = "uniInvSCP" + cont;
                        txtOtro.name = "uniInvSCP" + cont;
                        let rbutton = document.getElementById("rDocenteCP" + j);
                        rbutton.name="rFiliacionISCP" + cont; rbutton.id="rDocenteCP" + cont;
                        rbutton = document.getElementById("rEstudianteCP" + j);
                        rbutton.name="rFiliacionISCP" + cont; rbutton.id="rEstudianteCP" + cont;
                        rbutton = document.getElementById("rAdminCP" + j);
                        rbutton.name="rFiliacionISCP" + cont; rbutton.id="rAdminCP" + cont;
                    }
                    ////////////
                    ///Cambio de nombre al div
                    inp = document.getElementById("divi" + j);
                    if(inp !== null) inp.id = "divi" + cont;
                    inp = document.getElementById("dICP" + j);
                    inp.id = "dICP" + cont;
                    cont++;
                    
                }   
            }
            dlist.removeChild(item);
            i--;
        }
        function Select(index){
            var dlist = document.getElementById("InvS");
            var radio = document.getElementById("dICP" + index);
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
            txtInp.id = "uniInvSCP" + index; txtInp.name = "uniInvSCP" + index; txtInp.type = "text" + index; 
            divi.appendChild(txtInp);
            divi.appendChild(document.createElement("br"));
            divi.appendChild(document.createTextNode("Filiacion"));
            divi.appendChild(document.createElement("br"));
            let rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionISCP" + index; rbutton.id="rDocenteCP" + index; rbutton.type="radio"; rbutton.value="docente";
            divi.appendChild(document.createTextNode("Docente"));
            divi.appendChild(document.createElement("br"));
            rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionISCP" + index; rbutton.id="rEstudianteCP" + index; rbutton.type="radio"; rbutton.value="estudiante";
            divi.appendChild(document.createTextNode("Estudiante"));
            divi.appendChild(document.createElement("br"));
            rbutton = document.createElement("input");
            divi.appendChild(rbutton);
            rbutton.name="rFiliacionISCP" + index; rbutton.id="rAdminCP" + index; rbutton.type="radio"; rbutton.value="administrativo";
            divi.appendChild(document.createTextNode("Administrativo"));
            divi.appendChild(document.createElement("br"));
        }
        function noSelect(index){
            var radio = document.getElementById("dICP" + index);
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
            txtInp.id = "uniISCP" + index; txtInp.name = "uniISCP" + index; txtInp.type = "text"; 
            divi.appendChild(txtInp);
        }
    </script>
</head>
<body>
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

        Titulo: <input name="tituloCP" id="tituloCP" type="text" value="<?php echo($titulo) ?>"><br>

        Resumen:<br><textarea name="resumenCP" id="resumenCP" rows="4" cols="100"><?php echo $resumen ?></textarea><br>

        Investigacion: <input name="invCP" id="invCP" type="text"><br>
        <?php // TODO: procesar select si existe ?>

        Tipo publicacion: 
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
        <div id="InvP">
            <input type="hidden" name="pautor_id" value="<?php echo($pautor_id) ?>">

            Nombre: <input name="nomInvPCP" id="nomInvPCP" type="text" value="<?php echo($pnombre) ?>"><br>

            <input name="rPUniCP" id="rPUniCP" type="radio" onclick="perteneceInvP()" value="interno" <?php if($tipo_filiacion === 'interno') echo 'checked="checked"'; ?>> Pertenece a la Universidad<br>
            <input name="rPUniCP" id="rOUniCP" type="radio" onclick="noPerteneceInvP()" value="externo" <?php if($tipo_filiacion === 'externo') echo 'checked="checked"'; ?>> Pertenece a otra Universidad<br>
            <?php 
            if($tipo_filiacion === 'externo'){
                echo '<div id="divi">';
                echo "Universidad";
                echo "<br>";
                echo '<input id="uniIPCP" name="uniIPCP" type="text" value="'. $universidad . '">';
                echo "</div>";
            }
            else if($tipo_filiacion === 'interno'){
                echo '<div id="divi">';
                echo "Unidad de Investigacion";
                echo "<br>";
                echo '<input id="uniInvPCP" name="uniInvPCP" type="text" value="'. $unidad_investigacion . '">';
                echo "<br>";
                echo "Filiacion";
                echo "<br>";
                if($filiacion === 'docente'){
                    echo '<input id="rDocenteCP" name="rFiliacionIPCP" type="radio" value="docente" checked="checked">';
                    echo "Docente";
                    echo "<br>";

                    echo '<input id="rEstudianteCP" name="rFiliacionIPCP" type="radio" value="estudiante">';
                    echo "Estudiante";
                    echo "<br>";
                    
                    echo '<input id="rAdminCICP" name="rFiliacionIPCP" type="radio" value="administrativo">';
                    echo "Administrativo";
                    echo "<br>";
                }
                else if($filiacion === 'estudiante'){
                    echo '<input id="rDocenteCP" name="rFiliacionIPCP" type="radio" value="docente">';
                    echo "Docente";
                    echo "<br>";

                    echo '<input id="rEstudianteCP" name="rFiliacionIPCP" type="radio" value="estudiante" checked="checked">';
                    echo "Estudiante";
                    echo "<br>";
                    
                    echo '<input id="rAdminCICP" name="rFiliacionIPCP" type="radio" value="administrativo">';
                    echo "Administrativo";
                    echo "<br>";
                }
                else if($filiacion === 'administrativo'){
                    echo '<input id="rDocenteCP" name="rFiliacionIPCP" type="radio" value="docente">';
                    echo "Docente";
                    echo "<br>";

                    echo '<input id="rEstudianteCP" name="rFiliacionIPCP" type="radio" value="estudiante">';
                    echo "Estudiante";
                    echo "<br>";
                    
                    echo '<input id="rAdminCICP" name="rFiliacionIPCP" type="radio" value="administrativo" checked="checked">';
                    echo "Administrativo";
                    echo "<br>";
                }
                echo "</div>";
            }
            ?>
        </div>
        </fieldset>

        <h3><i>Ahora, indica los detalles de los autores de colaboracion</i></h3>

        <fieldset>
        <h3>Autores secundarios <button onclick="addItemInv()">+</button></h3>
        <div id="InvS">

        </div>
        </fieldset>

        <input type="submit" value="Guardar"> 
    </form>
</body>
</html>

