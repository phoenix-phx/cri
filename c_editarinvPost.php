<?php 
session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";
require_once "Autor.php";
require_once "AutorInterno.php";
require_once "AutorExterno.php";
require_once "Financiador.php";
require_once "Actividad.php";
require_once "Historial.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['inv_id']) ){
    $_SESSION['error'] = 'No se encontro la investigacion';
    header('Location: listaInv_investigador.php');
    return;
}

if ( isset($_POST['cancel'] ) ) {
    header('Location: detalles_investigacion_inv.php?inv_id='.$_REQUEST['inv_id']);
    return;
}

// validacion de edicion
if(isset($_POST['invTituloCI']) && isset($_POST['invNomCortoCI']) && isset($_POST['resumenCI']) && isset($_POST['fechaFinCI']) && isset($_POST['uniInvCI']) && isset($_POST['linInvCI']) && isset($_POST['nomInvPCI']) ){

    if (strlen($_POST['invTituloCI']) < 1 || strlen($_POST['invNomCortoCI']) < 1  || strlen($_POST['resumenCI']) < 1 || strlen($_POST['uniInvCI']) < 1 || strlen($_POST['linInvCI']) < 1) {

        $_SESSION['error'] = 'Debe llenar todos los campos obligatorios de la investigacion';
        header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
        return;
    }
    if( strlen($_POST['nomInvPCI']) < 1 || !isset($_POST['univIP'])){
        $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
        header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
        return;
    }
    if( isset($_POST['univIP']) && $_POST['univIP'] === 'interno'){
        if (strlen($_POST['uniInvPCI']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
            return;
        }        
        if (!isset($_POST['rFiliacionIP'])){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
            return;

        }
    }
    if( isset($_POST['univIP']) && $_POST['univIP'] === 'externo'){
        if (strlen($_POST['uniIPCI']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
            return;
        }        
    }
    if( !isset($_POST['rExisteFI']) ) {
        $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
        header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
        return;
    }
    if(isset($_POST['rExisteFI']) && $_POST['rExisteFI'] === 'si'){
        if(!isset($_POST['rTipoFr']) || !isset($_POST['rTipoFI']) ){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
            return;
        }
        if(isset($_POST['rTipoFr']) && $_POST['rTipoFr'] === 'externo'){
            if(strlen($_POST['nombreFinanciador']) < 1){
                $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
                header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
                return;                
            }
        }
        if(isset($_POST['rTipoFI']) && $_POST['rTipoFI'] === 'monetario'){
            if(strlen($_POST['monto']) < 1){
                $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
                header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
                return;
            }
            if(!is_numeric($_POST['monto'])){
                $_SESSION['error'] = 'El monto debe ser numérico';
                header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
                return;
            }
        }
    }    

    
    function validateAutores(){
        for ($i=0; $i <= 100 ; $i++) {
            if( !isset($_POST['nomInvSCI'.$i]) ) continue;
            $nombre = $_POST['nomInvSCI'.$i];
            if( !isset($_POST['rPUniCI'.$i]) ){
                return "Debe completar los datos obligatorios de los investigadores de colaboracion";
            }
            $pertenencia = $_POST['rPUniCI'.$i];
            if(strlen($nombre) < 1){
                return "Debe completar los datos obligatorios de los investigadores de colaboracion";
            }
            if( isset($_POST['rPUniCI'.$i]) && $_POST['rPUniCI'.$i] === 'interno'){
                if (strlen($_POST['uniInvSCI'.$i]) < 1){
                    return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                }        
                else if (!isset($_POST['rFiliacionIS'.$i])){
                    return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                }
            }
            else if( isset($_POST['rPUniCI'.$i]) && $_POST['rPUniCI'.$i] === 'externo'){
                if (strlen($_POST['uniISCI'.$i]) < 1){
                    return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                }        
            }
        }
        return true;
    }
    
    function validar_fecha($fecha){
        $valores = explode('-', $fecha);
        if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){
            return true;
        }
        return 'Las fechas deben estar acorde al formato requerido (aaaa-mm-dd) o deben ser validas';
    }

    $failure = validateAutores();
    if ( is_string($failure)) {
        $_SESSION['error'] = $failure;
        header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
        return;
    }

    function validateActividades(){
        for ($i=0; $i <= 100 ; $i++) {
            if( !isset($_POST['nomActCI'.$i]) ) continue;
            if( !isset($_POST['FIActCI'.$i]) ) continue;
            if( !isset($_POST['FFActCI'.$i]) ) continue;
            $falla = validar_fecha($_POST['FIActCI'.$i]);
            if(is_string($falla)){
                $_SESSION['error'] = $falla;
                header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
                return;
            }
            $falla = validar_fecha($_POST['FFActCI'.$i]);
            if(is_string($falla)){
                $_SESSION['error'] = $falla;
                header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
                return;
            }
            $nombre = $_POST['nomActCI'.$i];
            $finicio = $_POST['FIActCI'.$i];
            $ffinal = $_POST['FFActCI'.$i];
            if(strlen($nombre) < 1 || strlen($finicio) < 1 || strlen($ffinal) < 1){
                return "Debe completar los datos obligatorios de las actividades";
            }
        }
        return true;
    }
    $failure = validateActividades();
    if ( is_string($failure)) {
        $_SESSION['error'] = $failure;
        header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
        return;
    }

    // registrar cambios
    $dia = getdate();
    $fecha = $dia['year'] . '-' . $dia['mon'] . '-' . $dia['mday'];

    //$inv = new Investigacion(); pero que troll
    $inv = new Investigacion();
    $state = $inv->loadDetalles($_SESSION['idUsuario'], $_REQUEST['inv_id'], 'investigador', $pdo);
    if($state === false){
        $_SESSION['error'] = 'Valores erroneos para inv_id';
        header('Location: listaInv_investigador.php');
        return;
    }
    
    $codigo = htmlentities($inv->getCodigo());
    $titulo = htmlentities($inv->getTitulo());
    $nombre_corto = htmlentities($inv->getNombreCorto());
    $resumen = htmlentities($inv->getResumen());
    $fecha_inicio = htmlentities($inv->getFechaInicio());
    $fecha_fin = htmlentities($inv->getFechaFinal());
    $unidad = htmlentities($inv->getUnidadInvestigacion());
    $linea = htmlentities($inv->getLineaInvestigacion());
    $inv_id = htmlentities($inv->getId());
    
    if($titulo !== $_POST['invTituloCI']){ 
        // exec('echo "Titulo: ' . $titulo .'" >> lol.txt', $output, $retval);        
        $det = 'Se registró el cambio del TITULO' . "\n\nAntes:\n" . $titulo . "\n\nAhora:\n" . $_POST['invTituloCI'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }

    if($nombre_corto !== $_POST['invNomCortoCI']){
        // exec('echo "Nombre corto: ' . $nombre_corto .'" >> lol.txt', $output, $retval);        
        $det = 'Se registró el cambio del NOMBRE CORTO' . "\n\nAntes:\n" . $nombre_corto . "\n\nAhora:\n" . $_POST['invNomCortoCI'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }

    if($resumen !== $_POST['resumenCI']){
        // exec('echo "Resumen: ' . $resumen .'" >> lol.txt', $output, $retval);        
        $det = 'Se registró el cambio del RESUMEN' . "\n\nAntes:\n" . $resumen . "\n\nAhora:\n" . $_POST['resumenCI'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }

    if($fecha_fin !== $_POST['fechaFinCI']){
        // exec('echo "Fecha fin: ' . $fecha_fin .'" >> lol.txt', $output, $retval);        
        $det = 'Se registró el cambio de la FECHA FINAL' . "\n\nAntes:\n" . $fecha_fin . "\n\nAhora:\n" . $_POST['fechaFinCI'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }

    if($unidad !== $_POST['uniInvCI']){
        // exec('echo "Unidad: ' . $unidad .'" >> lol.txt', $output, $retval);        
        $det = 'Se registró el cambio de la UNIDAD DE INVESTIGACION' . "\n\nAntes:\n" . $unidad . "\n\nAhora:\n" . $_POST['uniInvCI'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }
    
    if($linea !== $_POST['linInvCI']){
        // exec('echo "Linea: ' . $linea .'" >> lol.txt', $output, $retval);        
        $det = 'Se registró el cambio de la LINEA DE INVESTIGACION' . "\n\nAntes:\n" . $linea . "\n\nAhora:\n" . $_POST['linInvCI'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }

    // investigacion 
    $newInv = new Investigacion();

    $newInv->setTitulo($_POST['invTituloCI']);
    $newInv->setNombreCorto($_POST['invNomCortoCI']);
    $newInv->setResumen($_POST['resumenCI']);
    if(strlen($_POST['fechaFinCI']) > 1){
        $falla = validar_fecha($_POST['fechaFinCI']);
        if(is_string($falla)){
            $_SESSION['error'] = $falla;
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
            return;
        }
    }
    if(strlen($_POST['fechaInicioCI']) > 1){
        $falla = validar_fecha($_POST['fechaInicioCI']);
        if(is_string($falla)){
            $_SESSION['error'] = $falla;
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
            return;
        }
    }

    $newInv->setUnidadInvestigacion($_POST['uniInvCI']);
    $newInv->setLineaInvestigacion($_POST['linInvCI']);
    $newInv->actualizarDatos($_SESSION['idUsuario'], $_REQUEST['inv_id'], $pdo);

    // fecha inicio
    if(strlen($_POST['fechaInicioCI']) > 1){
        $newInv->setFechaInicio($_POST['fechaInicioCI']);
        $newInv->agregarFechaInicio($_SESSION['idUsuario'], $_REQUEST['inv_id'], $pdo);
    }
    else if(strlen($fecha_inicio) !== 0){
        $newInv->setFechaInicio(null);
        $newInv->agregarFechaInicio($_SESSION['idUsuario'], $_REQUEST['inv_id'], $pdo);
    }

    // fecha final
    if(strlen($_POST['fechaFinCI']) > 1){
        $newInv->setFechaFinal($_POST['fechaFinCI']);
        $newInv->agregarFechaFinal($_SESSION['idUsuario'], $_REQUEST['inv_id'], $pdo);
    }
    else if(strlen($fecha_fin) !== 0){
        $newInv->setFechaFinal(null);
        $newInv->agregarFechaFinal($_SESSION['idUsuario'], $_REQUEST['inv_id'], $pdo);
    }

    // autor principal
    $test = new Autor();
    $autory = $test->testAutorPrincipal($_REQUEST['inv_id'], $pdo, 'investigacion');

    if($autory['universidad'] === null){
        $auth = new AutorInterno();
        $auth->loadData($_REQUEST['inv_id'], $pdo, 'investigacion');
    }
    else if($autory['universidad'] !== null){
        $auth = new AutorExterno();
        $auth->loadData($_REQUEST['inv_id'], $pdo, 'investigacion');
    }
    if($_POST['univIP'] === 'interno'){
        $newAuth = new AutorInterno();

        $newAuth->setNombre($_POST['nomInvPCI']);
        $newAuth->setTipoFiliacion($_POST['univIP']);
        $newAuth->setUnidadInvestigacion($_POST['uniInvPCI']);
        $newAuth->setFiliacion($_POST['rFiliacionIP']);
        $newAuth->setRol("principal");
        if(!($auth->compare($newAuth))){
            $det = 'Se registró el cambio del Autor Principal';
            $hist = new Historial();
            $hist->setFechaCambio($fecha);
            $hist->setDetalle($det);
            $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
        }
        $newAuth->actualizarAutor($_POST['pautor_id'], $pdo);
    }
    else if($_POST['univIP'] === 'externo'){
        $newAuth = new AutorExterno();

        $newAuth->setNombre($_POST['nomInvPCI']);
        $newAuth->setTipoFiliacion($_POST['univIP']);
        $newAuth->setUniversidad($_POST['uniIPCI']);
        $newAuth->setRol("principal");
        if(!($auth->compare($newAuth))){
            $det = 'Se registró el cambio del Autor Principal';
            $hist = new Historial();
            $hist->setFechaCambio($fecha);
            $hist->setDetalle($det);
            $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
        }

        $newAuth->actualizarAutor($_POST['pautor_id'], $pdo);
    }       

    // autores de colaboracion
    $auths = new Autor();
    $investigadores = $auths->loadAutores($pdo, $_REQUEST['inv_id'], 'investigacion');
    for($i = 0; $i < count($investigadores); $i++){
        if($investigadores[$i]['tipo_filiacion'] == 'interno'){
            $aux = new AutorInterno();
            $newAuth->setNombre($investigadores[$i]['nombre']);
            $newAuth->setTipoFiliacion($investigadores[$i]['tipo_filiacion']);
            $newAuth->setUnidadInvestigacion($investigadores[$i]['unidad_investigacion']);
            $newAuth->setFiliacion($investigadores[$i]['filiacion']);
            $newAuth->setRol("colaboracion");
            $investigadores[$i] = $aux;
        }
        else {
            $aux = new AutorExterno();
            $newAuth->setNombre($investigadores[$i]['nombre']);
            $newAuth->setTipoFiliacion($investigadores[$i]['tipo_filiacion']);
            $newAuth->setUniversidad($investigadores[$i]['unidad_investigacion']);
            $newAuth->setRol("colaboracion");
            $investigadores[$i] = $aux;
        }
        
    }
    $auths->eliminarAutor($_REQUEST['inv_id'], 'investigacion', $pdo);
    $inv_nuevos = array();

    for ($i=0; $i <= 100 ; $i++) {
        if( !isset($_POST['nomInvSCI'.$i]) ) continue;
        $nombre = $_POST['nomInvSCI'.$i];
        $pertenencia = $_POST['rPUniCI'.$i];
        if($pertenencia === 'interno'){
            $unidad =  $_POST['uniInvSCI'.$i]; 
            $filiacion =  $_POST['rFiliacionIS'.$i]; 

            $auth = new AutorInterno();

            $auth->setNombre($nombre);
            $auth->setTipoFiliacion($pertenencia);
            $auth->setRol('colaboracion');
            $auth->setUnidadInvestigacion($unidad);
            $auth->setFiliacion($filiacion);
            array_push($inv_nuevos, $auth);
            //$auth->crearAutor($_REQUEST['inv_id'], 'investigacion', $pdo);
        }
        else if($pertenencia === 'externo'){
            $univ =  $_POST['uniISCI'.$i]; 

            $auth = new AutorExterno();

            $auth->setNombre($nombre);
            $auth->setTipoFiliacion($pertenencia);
            $auth->setRol('colaboracion');
            $auth->setUniversidad($univ);
            array_push($inv_nuevos, $auth);
            // $auth->crearAutor($_REQUEST['inv_id'], 'investigacion', $pdo);
        }
    }
    

    //ver si hay cambios en autores secundarios
    if(count($investigadores) !== count($inv_nuevos)){
        // exec('echo "Fecha fin: ' . $fecha_fin .'" >> lol.txt', $output, $retval);        
        $det = "Se registró el cambio de los Autores Secundarios";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }
    else{
        for ($i=0; $i < count($investigadores); $i++) {
            // exec('echo "'.$i.'" >> lol.txt',$output,$retval);
            // exec('echo "'.$inv_nuevos[$i]->to_string().'" >> lol.txt',$output,$retval);
            // exec('echo "'. $investigadores[$i]->to_string().'" >> lol.txt',$output,$retval);
            
            if( $investigadores[$i] instanceof AutorInterno && $inv_nuevos[$i] instanceof AutorInterno){
                if($investigadores[$i]->compare($inv_nuevos[$i]) === false){
                    $det = 'Se registró el cambio de los Autores Secundarios';
                    $hist = new Historial();
                    $hist->setFechaCambio($fecha);
                    $hist->setDetalle($det);
                    $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
                    break;
                }
            }
            else if($investigadores[$i] instanceof AutorExterno && $inv_nuevos[$i] instanceof AutorExterno){
                if(!$investigadores[$i]->compare($inv_nuevos[$i]) === false){
                    $det = 'Se registró el cambio de los Autores Secundarios';
                    $hist = new Historial();
                    $hist->setFechaCambio($fecha);
                    $hist->setDetalle($det);
                    $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
                    break;
                }
            }
            else{
                $det = 'Se registró el cambio de los Autores Secundarios';
                $hist = new Historial();
                $hist->setFechaCambio($fecha);
                $hist->setDetalle($det);
                $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
                break;
            }
            
        }
        
    }
    for($i = 0; $i < count($inv_nuevos); $i++){
        $inv_nuevos[$i]->crearAutor($_REQUEST['inv_id'], 'investigacion', $pdo);
    }

    // financiamiento
    $finA = new Financiador();
    $estado = $finA->loadData($pdo, $_REQUEST['inv_id']);
    if($estado === false){
        $finA->setTipoFinanciamiento("");
        $finA->setTipoFinanciador("");
        $finA->setNombreFinanciador("");
        $finA->setNombreFinanciador("");
        $finA->setMonto("");
        $finA->setObservaciones("");
    }

    $finn = new Financiador();
    $flag = $finn->exists($pdo, $_REQUEST['inv_id']); 
    $fin = new Financiador();
    if($_POST['rExisteFI'] === 'si'){
        
        $fin->setTipoFinanciamiento($_POST['rTipoFI']);
        $fin->setTipoFinanciador($_POST['rTipoFr']);
        if($_POST['rTipoFr'] === 'interno'){
            $fin->setNombreFinanciador('Universidad Catolica Boliviana');           
        }
        else if($_POST['rTipoFr'] === 'externo'){
            $fin->setNombreFinanciador($_POST['nombreFinanciador']);
        }
        if($flag === true) $fin->actualizar($pdo, $_POST['financiador_id']);
        else $fin->registrar($pdo, $inv_id);

        if($_POST['rTipoFI'] === 'monetario'){
            $fin->setMonto($_POST['monto']);
            $fin->registrarMonto($pdo, $_REQUEST['inv_id']);      
        }

        if(strlen($_POST['obsTipoFOCI']) > 1){
            $fin->setObservaciones($_POST['obsTipoFOCI']);
            $fin->registrarObservaciones($pdo, $_REQUEST['inv_id']);
        }
    }
    else if($_POST['rExisteFI'] === 'no'){
        if($flag !== false){
            $fin->setTipoFinanciamiento("");
            $fin->setTipoFinanciador("");
            $fin->setNombreFinanciador("");
            $fin->setNombreFinanciador("");
            $fin->actualizar($pdo, $_POST['financiador_id']);

            $fin->setMonto("");
            $fin->registrarMonto($pdo, $_REQUEST['inv_id']);
            $fin->setObservaciones("");
            $fin->registrarObservaciones($pdo, $_REQUEST['inv_id']);
            
            $fin->eliminar($pdo, $financiador_id, $_REQUEST['inv_id']);
        }
        else{
            $fin->setTipoFinanciamiento("");
            $fin->setTipoFinanciador("");
            $fin->setNombreFinanciador("");
            $fin->setNombreFinanciador("");
            $fin->setMonto("");
            $fin->setObservaciones("");
            $fin->eliminar($pdo, $financiador_id, $_REQUEST['inv_id']);
        }
    }
    if($fin->compare($finA) === false){
        $det = 'Se registró el cambio del Financiamiento';
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);    
    }
    
    // actividades
    $act = new Actividad();
    $actividadesA = $act->loadActividad($pdo, $_REQUEST['inv_id']);
    for($i = 0; $i < count($actividadesA); $i++){
        $aux = new Actividad();
        $aux->setNombre($actividadesA[$i]['nombre']);
        $aux->setFechaInicio($actividadesA[$i]['fecha_inicio']);
        $aux->setFechaFinal($actividadesA[$i]['fecha_final']);
        $actividadesA[$i] = $aux;
    }
    $acty = new Actividad();
    $acty->eliminar($pdo, $_REQUEST['inv_id']);
    $act_nuevos = array();
    for ($i=0; $i <= 100 ; $i++) {
        if( !isset($_POST['nomActCI'.$i]) ) continue;
        if( !isset($_POST['FIActCI'.$i]) ) continue;
        if( !isset($_POST['FFActCI'.$i]) ) continue;
        $act = new Actividad();
        $nombre = $_POST['nomActCI'.$i];
        $finicio = $_POST['FIActCI'.$i];
        $ffinal = $_POST['FFActCI'.$i];
        $act->setNombre($nombre);
        $act->setFechaInicio($finicio);
        $act->setFechaFinal($ffinal);
        //$act->registrar($pdo, $_REQUEST['inv_id']);
        array_push($act_nuevos,$act);
    }
    
    if(count($actividadesA) !== count($act_nuevos)){
        $det = 'Se registró el cambio de las Actividades';
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);    
    }
    else{
        for($i = 0; $i < count($actividadesA); $i++){
            if(($actividadesA[$i])->compare($act_nuevos[$i]) === false){
                $det = 'Se registró el cambio de las Actividades';
                $hist = new Historial();
                $hist->setFechaCambio($fecha);
                $hist->setDetalle($det);
                $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);    
                break;
            }
        }
    }
    for($i = 0; $i < count($act_nuevos); $i++){
        $act_nuevos[$i]->registrar($pdo, $_REQUEST['inv_id']);
    }


    $_SESSION["success"] = 'cambios guardados correctamente';
    header('Location: detalles_investigacion_inv.php?inv_id='.$_REQUEST['inv_id']);
    return;
}
?>