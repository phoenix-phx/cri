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

    $inv = new Investigacion();
    
    if($inv->getTitulo() !== $_POST['invTituloCI']){
        $det = 'Se registró el cambio del TITULO' . "\n\nAntes:\n" . $inv->getTitulo() . "\n\nAhora:\n" . $_POST['invTituloCI'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }

    if($inv->getNombreCorto() !== $_POST['invNomCortoCI']){
        $det = 'Se registró el cambio del NOMBRE CORTO' . "\n\nAntes:\n" . $inv->getNombreCorto() . "\n\nAhora:\n" . $_POST['invNomCortoCI'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }

    if($inv->getResumen() !== $_POST['resumenCI']){
        $det = 'Se registró el cambio del RESUMEN' . "\n\nAntes:\n" . $inv->getResumen() . "\n\nAhora:\n" . $_POST['resumenCI'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }

    if($inv->getFechaFinal() !== $_POST['fechaFinCI']){
        $det = 'Se registró el cambio de la FECHA FINAL' . "\n\nAntes:\n" . $inv->getFechaFinal() . "\n\nAhora:\n" . $_POST['fechaFinCI'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }

    if($inv->getUnidadInvestigacion() !== $_POST['uniInvCI']){
        $det = 'Se registró el cambio de la UNIDAD DE INVESTIGACION' . "\n\nAntes:\n" . $inv->getUnidadInvestigacion() . "\n\nAhora:\n" . $_POST['uniInvCI'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['inv_id'], 'investigacion', $pdo);
    }
    
    if($inv->getLineaInvestigacion() !== $_POST['linInvCI']){
        $det = 'Se registró el cambio de la LINEA DE INVESTIGACION' . "\n\nAntes:\n" . $inv->getLineaInvestigacion() . "\n\nAhora:\n" . $_POST['linInvCI'] . "\n";
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
    if($_POST['univIP'] === 'interno'){
        $newAuth = new AutorInterno();

        $newAuth->setNombre($_POST['nomInvPCI']);
        $newAuth->setTipoFiliacion($_POST['univIP']);
        $newAuth->setUnidadInvestigacion($_POST['uniInvPCI']);
        $newAuth->setFiliacion($_POST['rFiliacionIP']);

        $newAuth->actualizarAutor($_POST['pautor_id'], $pdo);
    }
    else if($_POST['univIP'] === 'externo'){
        $newAuth = new AutorExterno();

        $newAuth->setNombre($_POST['nomInvPCI']);
        $newAuth->setTipoFiliacion($_POST['univIP']);
        $newAuth->setUniversidad($_POST['uniIPCI']);

        $newAuth->actualizarAutor($_POST['pautor_id'], $pdo);
    }       

    // autores de colaboracion
    $auths = new Autor();
    $auths->eliminarAutor($_REQUEST['inv_id'], 'investigacion', $pdo);
    
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
            
            $auth->crearAutor($_REQUEST['inv_id'], 'investigacion', $pdo);
        }
        else if($pertenencia === 'externo'){
            $univ =  $_POST['uniISCI'.$i]; 

            $auth = new AutorExterno();

            $auth->setNombre($nombre);
            $auth->setTipoFiliacion($pertenencia);
            $auth->setRol('colaboracion');
            $auth->setUniversidad($univ);
            
            $auth->crearAutor($_REQUEST['inv_id'], 'investigacion', $pdo);
        }
    }
    
    // financiamiento
    $finn = new Financiador();
    $flag = $finn->exists($pdo, $_REQUEST['inv_id']); 

    if($_POST['rExisteFI'] === 'si'){
        /*
        if($flag === false){
            $fin = new Financiador();
            $fin->setTipoFinanciamiento($_POST['rTipoFI']);
            $fin->setTipoFinanciador($_POST['rTipoFr']);
            if($_POST['rTipoFr'] === 'interno'){
                $fin->setNombreFinanciador('Universidad Catolica Boliviana');           
            }
            else if($_POST['rTipoFr'] === 'externo'){
                $fin->setNombreFinanciador($_POST['nombreFinanciador']);
            }
            $fin->registrar($pdo, $_REQUEST['inv_id']);

            if($_POST['rTipoFI'] === 'monetario'){
                $fin->setMonto($_POST['monto']);
                $fin->registrarMonto($pdo, $inv_id);            
            }

            if(strlen($_POST['obsTipoFOCI']) > 1){
                $fin->setObservaciones($_POST['obsTipoFOCI']);
                $fin->registrarObservaciones($pdo, $inv_id);
            }
        }
        */
            $fin = new Financiador();
            $fin->setTipoFinanciamiento($_POST['rTipoFI']);
            $fin->setTipoFinanciador($_POST['rTipoFr']);
            if($_POST['rTipoFr'] === 'interno'){
                $fin->setNombreFinanciador('Universidad Catolica Boliviana');           
            }
            else if($_POST['rTipoFr'] === 'externo'){
                $fin->setNombreFinanciador($_POST['nombreFinanciador']);
            }
            $fin->actualizar($pdo, $_POST['financiador_id']);

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
            $fin = new Financiador();
            $fin->setTipoFinanciamiento("");
            $fin->setTipoFinanciador("");
            $fin->setNombreFinanciador("");
            $fin->setNombreFinanciador("");
            $fin->actualizar($pdo, $_POST['financiador_id']);

            $fin->setMonto("");
            $fin->registrarMonto($pdo, $_REQUEST['inv_id']);
            $fin->setObservaciones("");
            $fin->registrarObservaciones($pdo, $_REQUEST['inv_id']);
            
            //$fin->eliminar($pdo, $financiador_id, $_REQUEST['inv_id']);
        }
    }
    
    // actividades
    $acty = new Actividad();
    $acty->eliminar($pdo, $_REQUEST['inv_id']);

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
        $act->registrar($pdo, $_REQUEST['inv_id']);
    }
    
    $_SESSION["success"] = 'cambios guardados correctamente';
    header('Location: detalles_investigacion_inv.php?inv_id='.$_REQUEST['inv_id']);
    return;
}
?>