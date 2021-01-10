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
    let txtInp = document.createElement("input");
    txtInp.id = "uniInvPCP"; txtInp.name = "uniInvPCP"; txtInp.type = "text"; txtInp.className = "stextInput";
    divi.appendChild(txtInp);
    divi.appendChild(document.createElement("br"));
    divi.appendChild(document.createTextNode("Filiación"));
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
    divi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
    divi.appendChild(document.createElement("br"));
    let txtInp = document.createElement("input");
    txtInp.id = "uniIPCP"; txtInp.name = "uniIPCP"; txtInp.type = "text"; txtInp.className = "stextInput";
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
    inp.name = "nomInvSCP" + i; inp.id = "nomInvSCP" + i; inp.type = "text";  inp.className="stextInput";
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
    let txtInp = document.createElement("input");
    txtInp.id = "uniInvSCP" + index; txtInp.name = "uniInvSCP" + index; txtInp.type = "text" + index;  txtInp.className = "stextInput";
    divi.appendChild(txtInp);
    divi.appendChild(document.createElement("br"));
    divi.appendChild(document.createTextNode("Filiación"));
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
    txtInp.id = "uniISCP" + index; txtInp.name = "uniISCP" + index; txtInp.type = "text"; txtInp.className = "stextInput";
    divi.appendChild(txtInp);
}