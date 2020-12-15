<!DOCTYPE html>
<html>
<head>
    <title>Nueva Investigacion</title>
    <?php require_once "c_crearinv.php"?>
    <script>
       var i = 0;
        
        function addItemInv(){
            event.preventDefault();
            var dlist = document.getElementById("InvS");
            var ndivi = document.createElement("div");
            ndivi.setAttribute('id',"dI" + i);
            //Radio button pertenece
            var inp = ndivi.appendChild(document.createElement("input"));
            const lol = "" + i;
            inp.name = "rPUniCI" + i; inp.id = "rPUniCI" + i; inp.type = "radio"; inp.value = "interno"
            inp.onclick = function() {noSelect(lol)};
            ndivi.appendChild(document.createTextNode("Pertenece a la Universidad Catolica Boliviana"));
            ndivi.appendChild(document.createElement("br"));
            ///////////////////////
            //Radio button no pertenece
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "rPUniCI" + i; inp.id = "rOUniCI" + i; inp.type = "radio"; inp.value = "externo"
            inp.onclick = function() {Select(lol)};
            ndivi.appendChild(document.createTextNode("Pertenece a otra Universidad"));
            ndivi.appendChild(document.createElement("br"));
            //////////////////////////
            //Nombre
            ndivi.appendChild(document.createTextNode("Nombre"));
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "nomInvSCI" + i; inp.id = "nomInvSCI" + i; inp.type = "text";
            inp = ndivi.appendChild(document.createElement("button"));
            inp.innerHTML = "-";
            inp.id = 'bI' + i;
            
            inp.onclick = function() { removeItemInv(lol) };
            /////////////////////////
            ndivi.appendChild(document.createElement("br"));
            ndivi.appendChild(document.createTextNode("Unidad de investigacion"));
            ndivi.appendChild(document.createElement("br"));
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "uniInvSCI" + i; inp.id = "uniInvSCI" + i; inp.type = "text";
            dlist.appendChild(ndivi);
            // console.log("prev add" + i);
            i++;
            // console.log("now add" + i);
        }
        function removeItemInv(index){
            // console.log("index "+index);
            var dlist = document.getElementById("InvS");
            var item = document.getElementById("dI" + index);
            var divs = dlist.getElementsByTagName("div").length;
            let cont = 0;
            for(let j = 0; j < divs; j++){
                if(index != j){
                    const lul = "" + cont;
                    //Radio button pertenece
                    var inp = document.getElementById("rPUniCI" + j);
                    inp.name = "rPUniCI" + cont;
                    inp.id = "rPUniCI" + cont;
                    inp.onclick = function() {noSelect(lul)};
                    //////////////
                    //Radio button no pertenece
                    inp = document.getElementById("rOUniCI" + j);
                    inp.name = "rOUniCI" + cont;
                    inp.id = "rOUniCI" + cont;
                    inp.onclick = function() { Select(lul) };
                    if(document.getElementById("NPerteneceEsp" + j) !== null){
                        console.log("NPerteneceEsp" + j);
                        var txtOtro = document.getElementById("NPerteneceEsp" + j);
                        txtOtro.id = "NPerteneceEsp" + cont;
                        txtOtro.name = "NPerteneceEsp" + cont;
                    }
                    /////////////
                    inp = document.getElementById("nomInvSCI" + j);
                    inp.name = "nomInvSCI" + cont;
                    inp.id = "nomInvSCI" + cont;
                    inp = document.getElementById("uniInvSCI" + j);
                    inp.name = "uniInvSCI" + cont;
                    inp.id = "uniInvSCI" + cont;
                    //boton -
                    inp = document.getElementById("bI" + j);
                    inp.id = "bI" + cont;
                    console.log("removeItem(" + lul +")");
                    inp.onclick = function() { removeItemInv(lul) };
                    ///
                    ///Cambio de nombre al div
                    inp = document.getElementById("dI" + j);
                    inp.id = "dI" + cont;
                    cont++;
                }
            }
            dlist.removeChild(item);
            // console.log("prev del" + i);
            i--;
            // console.log("now del" + i);

        }
        function Select(index){
            var dlist = document.getElementById("InvS");
            var radio = document.getElementById("dI" + index);
            if(radio.getElementsByTagName("input").length !== 5){
                var txtInp = document.createElement("input");
                txtInp.id = "NPerteneceEsp" + index; txtInp.name = "NPerteneceEsp" + index; txtInp.type = "text"; 
                radio.insertBefore(txtInp,document.getElementById("rOUniCI" + index).nextSibling.nextSibling);
            }
        }
        function noSelect(index){
            var radio = document.getElementById("dI" + index);
            if(radio.getElementsByTagName("input").length ===5){
                radio.removeChild(document.getElementById("NPerteneceEsp" + index));
            }
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
        <label for="tituloCI">Titulo: </label>
        <input name="invTituloCI" id="tituloCI" type="text"><br>
        
        <label for="nombreCortoCI">Nombre corto:</label>
        <input name="invNomCortoCI" id="nombreCortoCI" type="text"><br>
        
        <label for="resumenCI">Resumen:</label><br>
        <textarea name="resumenCI" id="resumenCI" rows="4" cols="100"></textarea><br>
        
        <label for="fechaFinCI">Fecha de finalizacion</label>
        <input name="fechaFinCI" id="fechaFinCI" type="date"><br>
        
        <label for="uniInvCI">Unidad de investigacion</label>
        <input name="uniInvCI" id="uniInvCI" type="text"><br>

        <h3><i>A continuacion, indica los detalles del investigador principal:</i></h3>
        <!--Agregar div-->
        <fieldset>
        <h3>Investigador principal</h3>
        <input name="univIP" id="rPUniCI" type="radio" value="interno">
        <label for="rPUniCI">Pertenece a la Universidad Catolica Boliviana</label><br>
        
        <input name="univIP" id="rOUniCI" type="radio" value="externo">
        <label for="rOUniCI">Pertenece a otra Universidad</label><br>
        
        <label for="nomInvPCI">Nombre</label>
        <input name="nomInvPCI" id="nomInvPCI" type="text"><br>
        
        <label for="uniInvPCI">Unidad de investigacion</label>
        <input name="uniInvPCI" id="uniInvPCI" type="text"><br>
        

        <h3>Filiacion</h3>
        <input name="rFiliacionIP" id="rDocenteCI" type="radio" value="docente">
        <label for="rDocenteCI">Docente</label><br>
        
        <input name="rFiliacionIP" id="rEstudianteCI" type="radio" value="estudiante">
        <label for="rEstudianteCI">Estudiante</label><br>
        
        <input name="rFiliacionIP" id="rAdminCI" type="radio" value="administrativo">
        <label for="rAdminCI">Administrativo</label><br><br>
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