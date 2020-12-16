<!DOCTYPE html>
<html>
<head>
    <title>Nueva Publicacion</title>
    <?= require_once "c_crearpub.php"?>
    <script>
        function SelectInvP(){
            var radio = document.getElementById("principal");
            if(radio.getElementsByTagName("input").length !== 8){
                var txtInp = document.createElement("input");
                txtInp.id = "NPerteneceEsp"; txtInp.type = "text"; txtInp.name = "NPerteneceEsp";
                radio.insertBefore(txtInp,document.getElementById("rOUniCP").nextSibling.nextSibling);
            }
        }
        function noSelectInvP(){
            var radio = document.getElementById("principal");
            radio.removeChild(document.getElementById("NPerteneceEsp"));
            
        }
        var i = 0;
        function addItemInvS(){
            event.preventDefault();
            var dlist = document.getElementById("InvS");
            //dlist.appendChild(document.createTextNode("hola"));
            var ndivi = document.createElement("div");
            ndivi.setAttribute('id',"dI" + i);
            //Radio button pertenece
            var inp = ndivi.appendChild(document.createElement("input"));
            const lol = "" + i;
            inp.name = "rPUniCP" + i; inp.id = "rPUniCP" + i; inp.type = "radio"; inp.value = "interno";
            inp.onclick = function() {noSelect(lol)};
            ndivi.appendChild(document.createTextNode("Pertenece a la Universidad Catolica Boliviana"));
            ndivi.appendChild(document.createElement("br"));
            ///////////////////////
            //Radio button no pertenece
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "rPUniCP" + i; inp.id = "rOUniCP" + i; inp.type = "radio"; inp.value = "externo";
            inp.onclick = function() {Select(lol)};
            ndivi.appendChild(document.createTextNode("Pertenece a otra Universidad"));
            ndivi.appendChild(document.createElement("br"));
            //////////////////////////
            //Nombre
            ndivi.appendChild(document.createTextNode("Nombre"));
            inp = ndivi.appendChild(document.createElement("input"));
            inp.name = "nomInvSCP" + i; inp.id = "nomInvSCP" + i; inp.type = "text";
            inp = ndivi.appendChild(document.createElement("button"));
            inp.innerHTML = "-";
            inp.id = 'bI' + i;
            
            inp.onclick = function() { removeItemInvS(lol) };
            /////////////////////////
            dlist.appendChild(ndivi);
            i++;
        }
        function removeItemInvS(index){
            // console.log("index "+index);
            var dlist = document.getElementById("InvS");
            var item = document.getElementById("dI" + index);
            var divs = dlist.getElementsByTagName("div").length;
            let cont = 0;
            for(let j = 0; j < divs; j++){
                if(index != j){
                    const lul = "" + cont;
                    //Radio button pertenece
                    var inp = document.getElementById("rPUniCP" + j);
                    inp.name = "rPUniCP" + cont;
                    inp.id = "rPUniCP" + cont;
                    inp.onclick = function() {noSelect(lul)};
                    //////////////
                    //Radio button no pertenece
                    inp = document.getElementById("rOUniCP" + j);
                    inp.name = "rOUniCP" + cont;
                    inp.id = "rOUniCP" + cont;
                    inp.onclick = function() { Select(lul) };
                    if(document.getElementById("NPerteneceEsp" + j) !== null){
                        //console.log("NPerteneceEsp" + j);
                        var txtOtro = document.getElementById("NPerteneceEsp" + j);
                        txtOtro.id = "NPerteneceEsp" + cont;
                        txtOtro.name = "NPerteneceEsp" + cont;
                    }
                    /////////////
                    inp = document.getElementById("nomInvSCP" + j);
                    inp.name = "nomInvSCP" + cont;
                    inp.id = "nomInvSCP" + cont;
                    //boton -
                    inp = document.getElementById("bI" + j);
                    inp.id = "bI" + cont;
                    inp.onclick = function() { removeItemInvS(lul) };
                    ///
                    ///Cambio de nombre al div
                    inp = document.getElementById("dI" + j);
                    inp.id = "dI" + cont;
                    cont++;
                }
            }
            dlist.removeChild(item);
            i--;
        }
        function Select(index){
            var dlist = document.getElementById("InvS");
            var radio = document.getElementById("dI" + index);
            if(radio.getElementsByTagName("input").length !== 4){
                var txtInp = document.createElement("input");
                txtInp.id = "NPerteneceEsp" + index; txtInp.name = "NPerteneceEsp" + index; txtInp.type = "text"; 
                radio.insertBefore(txtInp,document.getElementById("rOUniCP" + index).nextSibling.nextSibling);
            }
        }
        function noSelect(index){
            var radio = document.getElementById("dI" + index);
            if(radio.getElementsByTagName("input").length == 4){
                radio.removeChild(document.getElementById("NPerteneceEsp" + index));
            }
        }
    </script>
</head>
<body>
    <form action="c_crearpub.php" method="post">
        <h1>Crear Nueva publicacion</h1>   
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
        Titulo: <input name="tituloCP" id="tituloCP" type="text"><br>
        Resumen:<br><textarea name="resumenCP" id="resumenCP" rows="4" cols="100"></textarea><br>
        Investigacion: <input name="invCP" id="invCP" type="text"><br>
        Tipo publicacion: <select name="tipoCP" id="tipoCP">
            <option value="Articulo">Articulo</option>
            <option value="Acta">Acta</option>
            <option value="Libro">Libro</option>
            <option value="Capitulo de libro">Capitulo de libro</option>
            <option value="Patente">Patente</option>
            <option value="Otro">Otro</option>

            
            <!-- Aniadir tipos -->
        </select>
        <h3><i>A continuacion, indica los detalles del autor principal</i></h3>
        <fieldset>
        <div id="principal">
            <input name="rPUniCP" id="rPUniCP" type="radio" onclick="noSelectInvP()" value="interno"> Pertenece a la Universidad<br>
            <input name="rPUniCP" id="rOUniCP" type="radio" onclick="SelectInvP()" value="externo"> Pertenece a otra Universidad<br>
            Nombre: <input name="nomInvPCP" id="nomInvPCP" type="text"><br>
            Unidad de investigacion: <input name="uniInvPCP" id="uniInvPCP" type="text"><br>
            Filiacion: <br>
            <input name="rFiliCP" id="rDocenteCP" type="radio"> Docente<br>
            <input name="rFiliCP" id="rEstudianteCP" type="radio"> Estudiante<br>
            <input name="rFiliCP" id="rAdminCP" type="radio"> Administrativo<br>
        </div>
        </fieldset>

        <h3><i>Ahora, indica los detalles de los autores de colaboracion</i></h3>

        <fieldset>
        <h3>Autores secundarios <button onclick="addItemInvS()">+</button></h3>
        <div id="InvS">

        </div>
        </fieldset>

        <input type="submit" value="Crear"> 
    </form>





</body>
</html>

