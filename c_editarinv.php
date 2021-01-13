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

$stmt = $pdo->prepare('SELECT * FROM investigacion
                       WHERE idInv = :inv
                       AND idUsuario = :id');
$stmt->execute(array(
    ':inv' => $_REQUEST['inv_id'],
    ':id' => $_SESSION['idUsuario']
));
$test = $stmt->fetch(PDO::FETCH_ASSOC);
if($test === false){
    $_SESSION['error'] = 'No se pudo cargar la investigacion';
    header('Location: listaInv_investigador.php');
    return;    
}

// cargar datos
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
$inv_id = htmlentities($inv->getId());

// autor principal
$test = new Autor();
$autory = $test->testAutorPrincipal($_REQUEST['inv_id'], $pdo, 'investigacion');

if($autory['universidad'] === null){
    $auth = new AutorInterno();
    $auth->loadData($_REQUEST['inv_id'], $pdo, 'investigacion');

    $pautor_id = htmlentities($auth->getId());
    $pnombre = htmlentities($auth->getNombre());
    $tipo_filiacion = htmlentities($auth->getTipoFiliacion());
    $rol = htmlentities($auth->getRol());
    $unidad_investigacion = htmlentities($auth->getUnidadInvestigacion());
    $filiacion = htmlentities($auth->getFiliacion());
}
else if($autory['universidad'] !== null){
    $auth = new AutorExterno();
    $auth->loadData($_REQUEST['inv_id'], $pdo, 'investigacion');
    
    $pautor_id = htmlentities($auth->getId());
    $pnombre = htmlentities($auth->getNombre());
    $tipo_filiacion = htmlentities($auth->getTipoFiliacion());
    $rol = htmlentities($auth->getRol());
    $universidad = htmlentities($auth->getUniversidad());
}

// autores de colaboracion
$auths = new Autor();
$investigadores = $auths->loadAutores($pdo, $_REQUEST['inv_id'], 'investigacion');

// financiamiento
$fin = new Financiador();
$estado = $fin->loadData($pdo, $_REQUEST['inv_id']);

if($estado === false){
    $nombre_financiador = 'No Existe';
}
else{
    $financiador_id = htmlentities($fin->getId());
    $tipo_financiador = htmlentities($fin->getTipoFinanciador());
    $nombre_financiador = htmlentities($fin->getNombreFinanciador());
    $tipo_financiamiento = htmlentities($fin->getTipoFinanciamiento());
    if($tipo_financiamiento === 'monetario'){
        $monto = htmlentities($fin->getMonto());
    }
    if($fin->getObservaciones() !== null){
        $observaciones = htmlentities($fin->getObservaciones());
    }
}

// actividades
$act = new Actividad();
$actividades = $act->loadActividad($pdo, $_REQUEST['inv_id']);

// validacion de edicion
if(isset($_POST['invTituloCI']) && isset($_POST['invNomCortoCI']) && isset($_POST['resumenCI']) && isset($_POST['fechaFinCI']) && isset($_POST['uniInvCI']) && isset($_POST['nomInvPCI']) ){

    if (strlen($_POST['invTituloCI']) < 1 || strlen($_POST['invNomCortoCI']) < 1  || strlen($_POST['resumenCI']) < 1 || strlen($_POST['fechaFinCI']) < 1 || strlen($_POST['uniInvCI']) < 1 ) {

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

    // investigacion 
    $newInv = new Investigacion();

    $newInv->setTitulo($_POST['invTituloCI']);
    $newInv->setNombreCorto($_POST['invNomCortoCI']);
    $newInv->setResumen($_POST['resumenCI']);
    $falla = validar_fecha($_POST['fechaFinCI']);
    if(is_string($falla)){
        $_SESSION['error'] = $falla;
        header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
        return;
    }
    $newInv->setFechaFinal($_POST['fechaFinCI']);
    $newInv->setUnidadInvestigacion($_POST['uniInvCI']);
    
    $newInv->actualizarDatos($_SESSION['idUsuario'], $_REQUEST['inv_id'], $pdo);

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
            $fin->registrar($pdo, $inv_id);

            if($_POST['rTipoFI'] === 'monetario'){
                $fin->setMonto($_POST['monto']);
                $fin->registrarMonto($pdo, $inv_id);            
            }

            if(strlen($_POST['obsTipoFOCI']) > 1){
                $fin->setObservaciones($_POST['obsTipoFOCI']);
                $fin->registrarObservaciones($pdo, $inv_id);
            }
        }
        else if($flag !== false){
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
    }
    else if($_POST['rExisteFI'] === 'no'){
        if($flag !== false){
            $fin = new Financiador();
            $fin->eliminar($pdo, $financiador_id, $_REQUEST['inv_id']);
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
        $act->registrar($pdo, $inv_id);
    }
    
    $_SESSION["success"] = 'cambios guardados correctamente';
    header('Location: detalles_investigacion_inv.php?inv_id='.$_REQUEST['inv_id']);
    return;
}
?>