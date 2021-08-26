<?php
session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";
require_once "AutorExterno.php";
require_once "AutorInterno.php";
require_once "Financiador.php";
require_once "Actividad.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if ( isset($_POST['cancel'] ) ) {
    header("Location: listaInv_investigador.php");
    return;
}

if(isset($_POST['invTituloCI']) && isset($_POST['invNomCortoCI']) && isset($_POST['resumenCI']) && isset($_POST['fechaFinCI']) && isset($_POST['uniInvCI']) && isset($_POST['linInvCI']) && isset($_POST['nomInvPCI']) ){

    if (strlen($_POST['invTituloCI']) < 1 || strlen($_POST['invNomCortoCI']) < 1  || strlen($_POST['resumenCI']) < 1 || strlen($_POST['uniInvCI']) < 1 || strlen($_POST['linInvCI']) < 1) {

        $_SESSION['error'] = 'Debe llenar todos los campos obligatorios de la investigacion';
        header("Location: nueva_investigacion.php");
        return;
    }
    if( strlen($_POST['nomInvPCI']) < 1 || !isset($_POST['univIP'])){
        $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
        header("Location: nueva_investigacion.php");
        return;
    }
    if( isset($_POST['univIP']) && $_POST['univIP'] === 'interno'){
        if (strlen($_POST['uniInvPCI']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: nueva_investigacion.php");
            return;
        }        
        if (!isset($_POST['rFiliacionIP'])){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: nueva_investigacion.php");
            return;

        }
    }
    if( isset($_POST['univIP']) && $_POST['univIP'] === 'externo'){
        if (strlen($_POST['uniIPCI']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: nueva_investigacion.php");
            return;
        }        
    }
    if( !isset($_POST['rExisteFI']) ) {
        $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
        header("Location: nueva_investigacion.php");
        return;
    }
    if(isset($_POST['rExisteFI']) && $_POST['rExisteFI'] === 'si'){
        if(!isset($_POST['rTipoFr']) || !isset($_POST['rTipoFI']) ){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
            header("Location: nueva_investigacion.php");
            return;
        }
        if(isset($_POST['rTipoFr']) && $_POST['rTipoFr'] === 'externo'){
            if(strlen($_POST['nombreFinanciador']) < 1){
                $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
                header("Location: nueva_investigacion.php");
                return;                
            }
        }
        if(isset($_POST['rTipoFI']) && $_POST['rTipoFI'] === 'monetario'){
            if(strlen($_POST['monto']) < 1){
                $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
                header("Location: nueva_investigacion.php");
                return;
            }
            if(!is_numeric($_POST['monto'])){
                $_SESSION['error'] = 'El monto debe ser numérico';
                header("Location: nueva_investigacion.php");
                return;
            }
        }
    }
    
    function validar_fecha($fecha){
        $valores = explode('-', $fecha);
        if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){
            return true;
        }
        return 'Las fechas deben estar acorde al formato requerido (aaaa-mm-dd) o deben ser validas';
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
    $failure = validateAutores();
    if ( is_string($failure)) {
        $_SESSION['error'] = $failure;
        header("Location: nueva_investigacion.php");
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
                header("Location: nueva_investigacion.php");
                return;
            }
            $falla = validar_fecha($_POST['FFActCI'.$i]);
            if(is_string($falla)){
                $_SESSION['error'] = $falla;
                header("Location: nueva_investigacion.php");
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
        header("Location: nueva_investigacion.php");
        return;
    }

    // investigacion 
    try{
        $pdo->beginTransaction();
        $inv = new Investigacion();
        
        $inv->setTitulo($_POST['invTituloCI']);
        $inv->setNombreCorto($_POST['invNomCortoCI']);
        $inv->setResumen($_POST['resumenCI']);
        if(strlen($_POST['fechaFinCI']) > 1){
            $falla = validar_fecha($_POST['fechaFinCI']);
            if(is_string($falla)){
                $_SESSION['error'] = $falla;
                header("Location: nueva_investigacion.php");
                return;
            }
        }
        
        $inv->setUnidadInvestigacion($_POST['uniInvCI']);
        $inv->setLineaInvestigacion($_POST['linInvCI']);
        //$inv->setEstado("en curso");
        
        //estado
        if($_POST['estInv'] === 'curso'){
            $inv->setEstado("en curso");
            $inv->agregarEstado($_SESSION['idUsuario'], $inv_id, $pdo);
        }else if($_POST['estInv'] === 'terminado'){
            $inv->setEstado("cerrado");
            $inv->agregarEstado($_SESSION['idUsuario'], $inv_id, $pdo);
        }

        $inv->crear($_SESSION['idUsuario'], $pdo);
        $inv_id = $inv->getId();

        $dia = getdate();
        $finicio = $dia['year'] . '-' . $dia['mon'] . '-' . $dia['mday'];
        $nombre = explode(' ', $_POST['invNomCortoCI']);
        $codigo = $finicio . '_';
        for ($i=0; $i < count($nombre); $i++) { 
            $codigo = $codigo . strtolower($nombre[$i]);
        }
        
        //$inv->setFechaInicio($finicio);
        $inv->setCodigo($codigo);

        $inv->completarDetalles($_SESSION['idUsuario'], $pdo);
        
        // fecha inicio
        if(strlen($_POST['fechaIniCI']) > 1){
            $inv->setFechaInicio($_POST['fechaIniCI']);
            $inv->agregarFechaInicio($_SESSION['idUsuario'], $inv_id, $pdo);
        }
        
        // fecha final
        if(strlen($_POST['fechaFinCI']) > 1){
            $inv->setFechaFinal($_POST['fechaFinCI']);
            $inv->agregarFechaFinal($_SESSION['idUsuario'], $inv_id, $pdo);
        }

        // autor principal
        if($_POST['univIP'] === 'interno'){
            $auth = new AutorInterno();

            $auth->setNombre($_POST['nomInvPCI']);
            $auth->setTipoFiliacion($_POST['univIP']);
            $auth->setRol('principal');
            $auth->setUnidadInvestigacion($_POST['uniInvPCI']);
            $auth->setFiliacion($_POST['rFiliacionIP']);
            
            $auth->crearAutor($inv_id, 'investigacion', $pdo);
        }
        else if($_POST['univIP'] === 'externo'){
            $auth = new AutorExterno();

            $auth->setNombre($_POST['nomInvPCI']);
            $auth->setTipoFiliacion($_POST['univIP']);
            $auth->setRol('principal');
            $auth->setUniversidad($_POST['uniIPCI']);

            $auth->crearAutor($inv_id, 'investigacion', $pdo);
        }      

        // autores de colaboracion
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
                
                $auth->crearAutor($inv_id, 'investigacion', $pdo);
            }
            else if($pertenencia === 'externo'){
                $univ =  $_POST['uniISCI'.$i]; 

                $auth = new AutorExterno();

                $auth->setNombre($nombre);
                $auth->setTipoFiliacion($pertenencia);
                $auth->setRol('colaboracion');
                $auth->setUniversidad($univ);
                
                $auth->crearAutor($inv_id, 'investigacion', $pdo);
            }
        }
        
        // financiamiento
        if($_POST['rExisteFI'] === 'si'){
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
        else{
            $fin = new Financiador();
            $fin->setTipoFinanciamiento("");
            $fin->setTipoFinanciador("");
            $fin->setNombreFinanciador("");
            $fin->registrar($pdo, $inv_id);
        }

        // actividades
        for ($i=0; $i <= 100 ; $i++) {
            if( !isset($_POST['nomActCI'.$i]) ) continue;
            if( !isset($_POST['FIActCI'.$i]) ) continue;
            if( !isset($_POST['FFActCI'.$i]) ) continue;
            $act = new Actividad();
            $nombre = $_POST['nomActCI'.$i];
            $finicio = $_POST['FIActCI'.$i];
            $falla = validar_fecha($_POST['fechaFinCI']);
        
            $ffinal = $_POST['FFActCI'.$i];
            $act->setNombre($nombre);
            $act->setFechaInicio($finicio);
            $act->setFechaFinal($ffinal);
            $act->registrar($pdo, $inv_id);
        }
        
        $pdo->commit();
        $_SESSION["success"] = 'investigacion creada exitosamente';
        header('Location: detalles_investigacion_inv.php?inv_id='.$inv_id);
        return;
    }catch(Exception $e){
        $pdo->rollback();
        $error = "Ocurrio un error inesperado, intentalo nuevamente";
        $_SESSION['error'] = $error;
        header('Location: nueva_investigacion.php');
        return;
    }        
}
?>
