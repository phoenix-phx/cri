function perteneceInvP(){
    let radio = document.getElementById("InvP");
    let divi;
    if(radio.getElementsByTagName("div").length !== 0){
        divi = document.getElementById("divi");
        divi.parentNode.removeChild(divi);   
    }
    divi = radio.appendChild(document.createElement("div"));
    divi.id = "divi";
    divi.appendChild(document.createTextNode("Unidad de Investigación"));
    divi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
    divi.appendChild(document.createElement("br"));
    let txtInp = document.createElement("select");
    txtInp.id = "uniInvPCP"; txtInp.name = "uniInvPCP";
    txtInp.innerHTML = '<option value="">Ninguno</option>' + 
    '<option value="Instituto de Investigaciones Socio Economicas">Instituto de Investigaciones Socio Economicas</option>' + 
    '<option value="Instituto de Investigaciones en Ciencias del Comportamiento">Instituto de Investigaciones en Ciencias del Comportamiento</option>' +
    '<option value="Instituto de Estudios en Etica Profesional">Instituto de Estudios en Etica Profesional</option>' +
    '<option value="Instituto para la Democracia">Instituto para la Democracia</option>' + 
    '<option value="Servicio en Capacitacion en Raio y Television">Servicio en Capacitacion en Raio y Television</option>' + 
    '<option value="Intituto de Investigaciones Aplicadas">Intituto de Investigaciones Aplicadas</option>' + 
    '<option value="Instituto de Investigaciones sobre Asentamientos Humanos">Instituto de Investigaciones sobre Asentamientos Humanos</option>' + 
    '<option value="Centro de Investigacion en Agua, Energia y Sotenibilidad">Centro de Investigacion en Agua, Energia y Sotenibilidad</option>' + 
    '<option value="Centro de Investigacion en Turismo">Centro de Investigacion en Turismo</option>' + 
    '<option value="Centro de Investigacion en Diseno">Centro de Investigacion en Diseno</option>' + 
    '<option value="Centro de Investigacion en Cadena de Suministros">Centro de Investigacion en Cadena de Suministros</option>' +
    '<option value="Centro de Investigacion Desarrollo e Innovacion en Mecatronica">Centro de Investigacion Desarrollo e Innovacion en Mecatronica</option>' +
    '<option value="Centro de Investigacion Boliviano de Estudios Sociales">Centro de Investigacion Boliviano de Estudios Sociales</option>' +
    '<option value="Unidades de Investigacion Experimental">Unidades de Investigacion Experimental</option>' +
    '<option value="Centro de Investigacion en Ingenieria Comercial">Centro de Investigacion en Ingenieria Comercial</option>' +
    '<option value="Centro de investigacion e Innovacion del Departamento de Administracion de Empresas">Centro de investigacion e Innovacion del Departamento de Administracion de Empresas</option>' +
    '<option value="Grupo de Investigacion BIOMA">Grupo de Investigacion BIOMA</option>' +
    '<option value="Grupo de Investigacion Base/Aplicada Ingenieria Civil">Grupo de Investigacion Base/Aplicada Ingenieria Civil</option>' +
    '<option value="Grupo de Investigacion Telecomunicaciones">Grupo de Investigacion Telecomunicaciones</option>' +
    '<option value="Sociedad Cientifica Estudiantil de Administracion de Empresas">Sociedad Cientifica Estudiantil de Administracion de Empresas</option>' +
    '<option value="Sociedad Cientifica Estudiantil de Derecho">Sociedad Cientifica Estudiantil de Derecho</option>' + 
    '<option value="Sociedad Cientifica Estudiantil de Ing. Ambiental">Sociendad Cientifica Esutdiantil de Ing. Ambiental</option>' +
    '<option value="Sociedad Cientifica Estudiantil de Ingenieria Comercial">Sociedad Cientifica Estudiantil de Ingenieria Comercial</option>' +
    '<option value="Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas">Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas</option>' +
    '<option value="Sociedad Cientifica de Comunicacion Social">Sociedad Cientifica de Comunicacion Social</option>' +
    '<option value="Sociedad Cientifica de Psicologia">Sociedad Cientifica de Psicologia</option>' +
    '<option value="Sociedad Cientifica Estudiantil de Economia">Sociedad Cientifica Estudiantil de Economia</option>' +
    '<option value="Sociedad Cientifica de la Carrera de Arquitectura">Sociedad Cientifica de la Carrera de Arquitectura</option>' + 
    '<option value="Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA">Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA</option>' + 
    '<option value="Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO">Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO</option>' +
    '<option value="Sociedad Cientifica Estudiantil de Administracion Turistica">Sociedad Cientifica Estudiantil de Administracion Turistica</option>' + 
    '<option value="Sociedad Cientifica de Investigacion de Ingenieria Civil">Sociedad Cientifica de Investigacion de Ingenieria Civil</option>' +
    '<option value="Sociedad Cientifica Estudinatil de Ingenieria Industrial">Sociedad Cientifica Estudinatil de Ingenieria Industrial</option>' +
    '<option value="Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'">Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'</option>' +
    '<option value="Sociedad Cientifica de Ingenieria Mecatronica">Sociedad Cientifica de Ingenieria Mecatronica</option>' +
    '<option value="Sociedad Cientifica de Ingenieria Mecatronica">Sociedad Cientifica de Ingenieria Mecatronica</option>' +
    '<option value="Sociedad Cientifica de Contaduria Publica">Sociedad Cientifica de Contaduria Publica</option>' +
    '<option value="Sociedad Cientifica de Ingenieria de Telecomunicaciones">Sociedad Cientifica de Ingenieria de Telecomunicaciones</option>' +
    '<option value="Sociedad Cientifica de Ciencias Politicas">Sociedad Cientifica de Ciencias Politicas</option>' +
    '<option value="Sociedad Cientifica de Ingenieria Biomedica">Sociedad Cientifica de Ingenieria Biomedica</option>';
    divi.appendChild(txtInp);
    divi.appendChild(document.createElement("br"));
    divi.appendChild(document.createTextNode("Filiación"));
    aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
    divi.appendChild(document.createElement("br"));
    let rbutton = document.createElement("input");
    divi.appendChild(rbutton);
    // cambiar por labels
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
    divi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
    divi.appendChild(document.createElement("br"));
    let txtInp = document.createElement("input");
    txtInp.id = "uniIPCP"; txtInp.name = "uniIPCP"; txtInp.type = "text"; txtInp.className="stextInput";
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
    ndivi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    ndivi.appendChild(aux);
    inp = ndivi.appendChild(document.createElement("input"));
    inp.name = "nomInvSCP" + i; inp.id = "nomInvSCP" + i; inp.type = "text"; inp.className="stextInput";
    inp = ndivi.appendChild(document.createElement("button"));
    inp.innerHTML = " - ";
    inp.id = 'bICP' + i; inp.className="button";
    const lol = "" + i;
    inp.onclick = function() { removeItemInv(lol) };
    ndivi.appendChild(document.createElement("br"));
    //////////////////////
    //Radio button pertenece
    var inp = ndivi.appendChild(document.createElement("input"));
    inp.name = "rPUniCP" + i; inp.id = "rPUniCP" + i; inp.type = "radio"; inp.value = "interno";
    inp.onclick = function() {Select(lol)};
    ndivi.appendChild(document.createTextNode("Pertenece a la Universidad Católica Boliviana"));
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
    divi.appendChild(document.createTextNode("Unidad de Investigación"));
    divi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
    divi.appendChild(document.createElement("br"));
    let txtInp = document.createElement("select");
    txtInp.id = "uniInvSCP" + index; txtInp.name = "uniInvSCP" + index;
    txtInp.innerHTML = '<option value="">Ninguno</option>' + 
    '<option value="Instituto de Investigaciones Socio Economicas">Instituto de Investigaciones Socio Economicas</option>' + 
    '<option value="Instituto de Investigaciones en Ciencias del Comportamiento">Instituto de Investigaciones en Ciencias del Comportamiento</option>' +
    '<option value="Instituto de Estudios en Etica Profesional">Instituto de Estudios en Etica Profesional</option>' +
    '<option value="Instituto para la Democracia">Instituto para la Democracia</option>' + 
    '<option value="Servicio en Capacitacion en Raio y Television">Servicio en Capacitacion en Raio y Television</option>' + 
    '<option value="Intituto de Investigaciones Aplicadas">Intituto de Investigaciones Aplicadas</option>' + 
    '<option value="Instituto de Investigaciones sobre Asentamientos Humanos">Instituto de Investigaciones sobre Asentamientos Humanos</option>' + 
    '<option value="Centro de Investigacion en Agua, Energia y Sotenibilidad">Centro de Investigacion en Agua, Energia y Sotenibilidad</option>' + 
    '<option value="Centro de Investigacion en Turismo">Centro de Investigacion en Turismo</option>' + 
    '<option value="Centro de Investigacion en Diseno">Centro de Investigacion en Diseno</option>' + 
    '<option value="Centro de Investigacion en Cadena de Suministros">Centro de Investigacion en Cadena de Suministros</option>' +
    '<option value="Centro de Investigacion Desarrollo e Innovacion en Mecatronica">Centro de Investigacion Desarrollo e Innovacion en Mecatronica</option>' +
    '<option value="Centro de Investigacion Boliviano de Estudios Sociales">Centro de Investigacion Boliviano de Estudios Sociales</option>' +
    '<option value="Unidades de Investigacion Experimental">Unidades de Investigacion Experimental</option>' +
    '<option value="Centro de Investigacion en Ingenieria Comercial">Centro de Investigacion en Ingenieria Comercial</option>' +
    '<option value="Centro de investigacion e Innovacion del Departamento de Administracion de Empresas">Centro de investigacion e Innovacion del Departamento de Administracion de Empresas</option>' +
    '<option value="Grupo de Investigacion BIOMA">Grupo de Investigacion BIOMA</option>' +
    '<option value="Grupo de Investigacion Base/Aplicada Ingenieria Civil">Grupo de Investigacion Base/Aplicada Ingenieria Civil</option>' +
    '<option value="Grupo de Investigacion Telecomunicaciones">Grupo de Investigacion Telecomunicaciones</option>' +
    '<option value="Sociedad Cientifica Estudiantil de Administracion de Empresas">Sociedad Cientifica Estudiantil de Administracion de Empresas</option>' +
    '<option value="Sociedad Cientifica Estudiantil de Derecho">Sociedad Cientifica Estudiantil de Derecho</option>' + 
    '<option value="Sociedad Cientifica Estudiantil de Ing. Ambiental">Sociendad Cientifica Esutdiantil de Ing. Ambiental</option>' +
    '<option value="Sociedad Cientifica Estudiantil de Ingenieria Comercial">Sociedad Cientifica Estudiantil de Ingenieria Comercial</option>' +
    '<option value="Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas">Sociedad Cientifica Estudiantil NOrbert Wiener de Ingenieria de Sistemas</option>' +
    '<option value="Sociedad Cientifica de Comunicacion Social">Sociedad Cientifica de Comunicacion Social</option>' +
    '<option value="Sociedad Cientifica de Psicologia">Sociedad Cientifica de Psicologia</option>' +
    '<option value="Sociedad Cientifica Estudiantil de Economia">Sociedad Cientifica Estudiantil de Economia</option>' +
    '<option value="Sociedad Cientifica de la Carrera de Arquitectura">Sociedad Cientifica de la Carrera de Arquitectura</option>' + 
    '<option value="Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA">Sociedad Cientifica Estudiantil de investigacion INPSICOPEDIA</option>' + 
    '<option value="Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO">Sociedad Cientifica Estudiantil de Diseño Grafico DESIGNO</option>' +
    '<option value="Sociedad Cientifica Estudiantil de Administracion Turistica">Sociedad Cientifica Estudiantil de Administracion Turistica</option>' + 
    '<option value="Sociedad Cientifica de Investigacion de Ingenieria Civil">Sociedad Cientifica de Investigacion de Ingenieria Civil</option>' +
    '<option value="Sociedad Cientifica Estudinatil de Ingenieria Industrial">Sociedad Cientifica Estudinatil de Ingenieria Industrial</option>' +
    '<option value="Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'">Sociedad Cientifica de ingenieria Quimica \'Jovenes para la Ciencia\'</option>' +
    '<option value="Sociedad Cientifica de Ingenieria Mecatronica">Sociedad Cientifica de Ingenieria Mecatronica</option>' +
    '<option value="Sociedad Cientifica de Ingenieria Mecatronica">Sociedad Cientifica de Ingenieria Mecatronica</option>' +
    '<option value="Sociedad Cientifica de Contaduria Publica">Sociedad Cientifica de Contaduria Publica</option>' +
    '<option value="Sociedad Cientifica de Ingenieria de Telecomunicaciones">Sociedad Cientifica de Ingenieria de Telecomunicaciones</option>' +
    '<option value="Sociedad Cientifica de Ciencias Politicas">Sociedad Cientifica de Ciencias Politicas</option>' +
    '<option value="Sociedad Cientifica de Ingenieria Biomedica">Sociedad Cientifica de Ingenieria Biomedica</option>';
    divi.appendChild(txtInp);
    divi.appendChild(document.createElement("br"));
    divi.appendChild(document.createTextNode("Filiación"));
    aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
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
    divi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
    divi.appendChild(document.createElement("br"));
    let txtInp = document.createElement("input");
    txtInp.id = "uniISCP" + index; txtInp.name = "uniISCP" + index; txtInp.type = "text"; txtInp.className="stextInput";
    divi.appendChild(txtInp);
}