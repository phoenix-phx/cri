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
    divi.appendChild(document.createTextNode("Unidad de Investigación"));
    divi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
    divi.appendChild(document.createElement("br"));
    let txtInp = document.createElement("input");
    txtInp.id = "uniInvPCI"; txtInp.name = "uniInvPCI"; txtInp.type = "text"; txtInp.className="stextInput";
    divi.appendChild(txtInp);
    divi.appendChild(document.createElement("br"));
    divi.appendChild(document.createTextNode("Filiación"));
    aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
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
    divi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
    divi.appendChild(document.createElement("br"));
    let txtInp = document.createElement("input");
    txtInp.id = "uniIPCI"; txtInp.name = "uniIPCI"; txtInp.type = "text"; txtInp.className="stextInput";
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
    ndivi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    ndivi.appendChild(aux);
    let inp = ndivi.appendChild(document.createElement("input"));
    inp.name = "nomInvSCI" + i; inp.id = "nomInvSCI" + i; inp.type = "text"; inp.className="stextInput"; 
    inp = ndivi.appendChild(document.createElement("button"));
    inp.innerHTML = " - "; inp.id = 'bICI' + i; inp.className="button";
    const lol = "" + i;
    inp.onclick = function() { removeItemInv(lol) };
    ndivi.appendChild(document.createElement("br"));
    //////////////////////
    //Radio button pertenece
    inp = ndivi.appendChild(document.createElement("input"));
    inp.name = "rPUniCI" + i; inp.id = "rPUniCI" + i; inp.type = "radio"; inp.value = "interno";
    inp.onclick = function() {Select(lol)};
    ndivi.appendChild(document.createTextNode("Pertenece a la Universidad Católica Boliviana"));
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
    divi.appendChild(document.createTextNode("Unidad de Investigación"));
    divi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
    divi.appendChild(document.createElement("br"));
    let txtInp = document.createElement("input");
    txtInp.id = "uniInvSCI" + index; txtInp.name = "uniInvSCI" + index; txtInp.type = "text" + index;
    txtInp.className = "stextInput";
    divi.appendChild(txtInp);
    divi.appendChild(document.createElement("br"));
    divi.appendChild(document.createTextNode("Filiación"));
    aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
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
    divi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    divi.appendChild(aux);
    divi.appendChild(document.createElement("br"));
    let txtInp = document.createElement("input");
    txtInp.id = "uniISCI" + index; txtInp.name = "uniISCI" + index; txtInp.type = "text"; txtInp.className = "stextInput";
    divi.appendChild(txtInp);
}


var actividad = 0;
function addItemAct(){
    event.preventDefault();
    let dlist = document.getElementById("Act");
    let ndivi = document.createElement("div");
    ndivi.setAttribute('id',"dA" + actividad);
    ndivi.appendChild(document.createTextNode("Nombre"));
    ndivi.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    ndivi.appendChild(aux);
    let inp = ndivi.appendChild(document.createElement("input"));
    inp.name = "nomActCI" + actividad; inp.id = "nomActCI" + actividad; inp.type = "text"; inp.className = "stextInput";
    inp = ndivi.appendChild(document.createElement("button"));
    inp.innerHTML = " - ";
    inp.id = 'bA' + actividad; inp.className="button";
    const lul = "" + actividad;
    inp.onclick = function() {removeItemAct(lul)};
    ndivi.appendChild(document.createElement("br"));
    ndivi.appendChild(document.createTextNode("Fecha inicio"));
    ndivi.appendChild(document.createTextNode(":"));
    aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    ndivi.appendChild(aux);
    inp = ndivi.appendChild(document.createElement("input"));
    inp.name = "FIActCI" + actividad; inp.id = "FIActCI" + actividad; inp.type = "date"; inp.className = "xstextInput";
    ndivi.appendChild(document.createElement("br"));
    ndivi.appendChild(document.createTextNode("Fecha final"));
    ndivi.appendChild(document.createTextNode(":"));
    aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    ndivi.appendChild(aux);
    inp = ndivi.appendChild(document.createElement("input"));
    inp.name = "FFActCI" + actividad; inp.id = "FFActCI" + actividad; inp.type = "date"; inp.className = "xstextInput";
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
    inp.name = "obsTipoFOCI"; inp.id = "obsTipoFOCI"; inp.rows = "4"; inp.cols = "100"; inp.className = "stextInput";
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
    d.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    d.appendChild(aux);
    let inp = document.createElement("input");
    inp.name = "nombreFinanciador"; inp.id = "nombreFinanciador"; inp.type = "text"; inp.className = "stextInput";
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
    fin.parentNode.insertBefore(d, fin.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling);
    
    d.appendChild(document.createTextNode("Monto"));
    d.appendChild(document.createTextNode(":"));
    let aux = document.createElement("span");
    aux.innerHTML = "*"; aux.className="must";
    d.appendChild(aux);
    let inp = document.createElement("input");
    inp.name = "monto"; inp.id = "monto"; inp.type = "text"; inp.className = "xstextInput";
    d.appendChild(inp);
    d.appendChild(document.createTextNode("Bs."));
    d.appendChild(document.createElement("br"));
}
function tipoOtro(){
    let fin = document.getElementById("financiamiento");
    let d = document.getElementById("existe");
    let inp = document.getElementById("montFin");
    if(inp !== null) d.removeChild(inp);
}