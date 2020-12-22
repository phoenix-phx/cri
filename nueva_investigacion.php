<!DOCTYPE html>
<html>
<head>
    <title>Nueva Investigacion</title>
    <?php require_once "c_crearinv.php"?>
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
            var dlist = document.getElementById("InvS");
            var ndivi = document.createElement("div");
            ndivi.setAttribute('id',"dICI" + i);
            //Nombre
            ndivi.appendChild(document.createTextNode("Nombre"));
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "nomInvSCI" + i; inp.id = "nomInvSCI" + i; inp.type = "text";  
            inp = ndivi.appendChild(document.createElement("button"));
            inp.innerHTML = "-";
            inp.id = 'bICI' + i;
            const lol = "" + i;
            inp.onclick = function() { removeItemInv(lol) };
            ndivi.appendChild(document.createElement("br"));
            //////////////////////
            //Radio button pertenece
            var inp = ndivi.appendChild(document.createElement("input"));
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
            var dlist = document.getElementById("InvS");
            var item = document.getElementById("dICI" + index);
            var divs = dlist.getElementsByTagName("div");
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
                        var txtOtro = document.getElementById("uniISCI" + j);
                        txtOtro.id = "uniISCI" + cont;
                        txtOtro.name = "uniISCI" + cont;
                    }
                    else if(document.getElementById("uniInvSCI" + j) !== null){
                        var txtOtro = document.getElementById("uniInvSCI" + j);
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
            var dlist = document.getElementById("InvS");
            var radio = document.getElementById("dICI" + index);
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
            var radio = document.getElementById("dICI" + index);
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
            inp = ndivi.appendChild(document.createElement("input"));
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
    </script>
    <style type="text/css">
        .must{
            color: red;
        }
    </style>
</head>
<body>
    <h1>Crear nueva investigacion</h1>
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
        <label for="tituloCI">Titulo<span class="must">*</span>: </label>
        <input name="invTituloCI" id="tituloCI" type="text"><br>
        
        <label for="nombreCortoCI">Nombre corto<span class="must">*</span>:</label>
        <input name="invNomCortoCI" id="nombreCortoCI" type="text"><br>
        
        <label for="resumenCI">Resumen<span class="must">*</span>:</label><br>
        <textarea name="resumenCI" id="resumenCI" rows="4" cols="100"></textarea><br>
        
        <label for="fechaFinCI">Fecha de finalizacion<span class="must">*</span>:</label>
        <input name="fechaFinCI" id="fechaFinCI" type="date"><br>
        
        <label for="uniInvCI">Unidad de Investigacion<span class="must">*</span>:</label>
        <input name="uniInvCI" id="uniInvCI" type="text"><br>

        <h3><i>A continuacion, indica los detalles del investigador principal:</i></h3>
        <!--Agregar div-->
        <fieldset>
        <h3>Investigador principal</h3>
        <div id="InvP">
            <label for="nomInvPCI">Nombre<span class="must">*</span>:</label>
            <input name="nomInvPCI" id="nomInvPCI" type="text"><br>
            
            <input name="univIP" id="rPUniCI" type="radio" onclick="perteneceInvP()" value="interno">
            <label for="rPUniCI">Pertenece a la Universidad Catolica Boliviana</label><br>
            
            <input name="univIP" id="rOUniCI" type="radio" onclick="noPerteneceInvP()" value="externo">
            <label for="rOUniCI">Pertenece a otra Universidad</label><br>
            
        </div>
        </fieldset>

        <h3><i>Ahora, indica los detalles de los investigadores de colaboracion (si existen):</i></h3>
        <fieldset>   
        <h3>Investigadores de colaboracion <button onclick="addItemInv()" >+</button> </h3>
        <div id="InvS">
        </div>
        </fieldset>
     
        <h3><i>A continuacion, ingresa los detalles del financiamiento:</i></h3>
        <fieldset>
        <h3>Financiamiento</h3>
        <h4>Existe</h4>
        <input name="rExisteFI" id="rSiExisteFCI" type="radio" value="si">
        <label for="rSiExisteFCI">Si</label><br>
        
        <input name="rExisteFI" id="rNoExisteFCI" type="radio" value="no">
        <label for="rNoExisteFCI">No</label><br>
        
        <h4>Tipo financiador</h4>
        <input name="rTipoFr" id="rTipoFIntCI" type="radio" value="interno">
        <label for="rTipoFIntCI">Interno</label><br>
        
        <input name="rTipoFr" id="rTipoFExtCI" type="radio" value="externo">
        <label for="rTipoFExtCI">Externo</label><br>
        
        <label for="nomFCI">Nombre financiador:</label>
        <input name="nomFCI" id="nomFCI" type="text"><br>
        
        <h4>Tipo financiamiento</h4>
        <input name="rTipoFI" id="rTipoMCI" type="radio" value="monetario">
        <label for="rTipoMCI">Monetario</label><br>
        
        <input name="rTipoFI" id="rTipoOCI" type="radio" value="otro">
        <label for="rTipoOCI">Otro</label><br>
        
        <label for="obsTipoFOCI">Observaciones</label>
        <textarea name="obsTipoFOCI" id="obsTipoFOCI" rows="4" cols="100"></textarea><br>
        </fieldset>
        
        <!--Agregar actividades-->
        <h3><i>Finalmente, indica las actividades planificadas para la investigacion:</i></h3>
        <fieldset>
        <h3>Actividades <button onclick="addItemAct()">+</button></h3>
        <div id="Act">
        </div>
        </fieldset>
        <input type="submit" value="Crear"> 
    </form>
</body>
</html>