<?php 
session_start();
require_once "c_pdo.php";
require_once "Publicacion.php";
require_once "Investigacion.php";
require_once "Autor.php";
require_once "AutorExterno.php";
require_once "AutorInterno.php";
require_once "Historial.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['pub_id']) ){
    $_SESSION['error'] = 'No se encontro la publicacion';
    header('Location: listaPub_investigador.php');
    return;
}

if ( isset($_POST['cancel'] ) ) {
    header('Location: detalles_publicacion_inv.php?pub_id='.$_REQUEST['pub_id']);
    return;
}

// validacion de edicion
if(isset($_POST['tituloCP']) && isset($_POST['resumenCP']) && isset($_POST['tipoCP']) && isset($_POST['nomInvPCP']) && isset($_POST['uInvestigacion']) && isset($_POST['linInv'])){

    if (strlen($_POST['tituloCP']) < 1 || strlen($_POST['resumenCP']) < 1  || strlen($_POST['tipoCP']) < 1 || strlen($_POST['uInvestigacion']) < 1 || strlen($_POST['linInv']) < 1) {
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
        header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
        return;
    }
    if($_POST['tipoCP'] === 'Ninguno'){
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
        header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
        return;        
    }
    if( !isset($_POST['rPUniCP']) || strlen($_POST['nomInvPCP']) < 1 ){
        $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
        header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
        return;
    }    
    if( isset($_POST['rPUniCP']) && $_POST['rPUniCP'] === 'interno'){
        if (strlen($_POST['uniInvPCP']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
            return;
        }        
        else if (!isset($_POST['rFiliacionIPCP'])){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
            return;
        }
    }
    if( isset($_POST['rPUniCP']) && $_POST['rPUniCP'] === 'externo'){
        if (strlen($_POST['uniIPCP']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
            return;
        }        
    }
    
    function validateAutores(){
        for ($i=0; $i <= 100 ; $i++) {
            if( !isset($_POST['nomInvSCP'.$i]) ) continue;
            $nombre = $_POST['nomInvSCP'.$i];
            if( !isset($_POST['rPUniCP'.$i]) ){
                return "Debe completar los datos obligatorios de los investigadores de colaboracion";
            }
            $pertenencia = $_POST['rPUniCP'.$i];
            if(strlen($nombre) < 1){
                return "Debe completar los datos obligatorios de los investigadores de colaboracion";
            }
            if( isset($_POST['rPUniCP'.$i]) && $_POST['rPUniCP'.$i] === 'interno'){
                if (strlen($_POST['uniInvSCP'.$i]) < 1){
                    return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                }        
                else if (!isset($_POST['rFiliacionISCP'.$i])){
                    return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                }
            }
            else if( isset($_POST['rPUniCP'.$i]) && $_POST['rPUniCP'.$i] === 'externo'){
                if (strlen($_POST['uniISCP'.$i]) < 1){
                    return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                }        
            }
        }
        return true;
    }
    $failure = validateAutores();
    if ( is_string($failure)) {
        $_SESSION['error'] = $failure;
        header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
        return;
    }

    $idInv = '';
    if(strlen($_POST['invCP']) > 1){
        $inv = new Investigacion();
        $idInv = $inv->searchID($_POST['invCP'], $pdo);
        if($idInv === false){
            $_SESSION['error'] = 'Codigo de investigacion asociada invalido';
            header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
            return;            
        }
    }

    try{
        $pdo->beginTransaction();
        // registrar cambios
        $dia = getdate();
        $fecha = $dia['year'] . '-' . $dia['mon'] . '-' . $dia['mday'];
        
        $pub = new Publicacion(); 
        $state = $pub->loadDetalles($_SESSION['idUsuario'], $_REQUEST['pub_id'], 'investigador', $pdo);
        if($state === false){
            $_SESSION['error'] = 'Valores erroneos para pub_id';
            header('Location: listaPub_investigador.php');
            return;
        }
        
        $codigo = htmlentities($pub->getCodigo());
        $titulo = htmlentities($pub->getTitulo());
        $resumen = htmlentities($pub->getResumen());
        $tipo = htmlentities($pub->getTipo());
        $apa = htmlentities($pub->getApa());
        $unidad = htmlentities($pub->getUnidadInvestigacion());
        $linea = htmlentities($pub->getLineaInvestigacion());
        $estado = htmlentities($pub->getEstado());
        $pub_id = htmlentities($pub->getId());
        

        // publicacion
        $newPub = new Publicacion();

        $newPub->setTitulo($_POST['tituloCP']); 
        $newPub->setResumen($_POST['resumenCP']); 
        $newPub->setTipo($_POST['tipoCP']); 
        $newPub->setApa($_POST['apaCP']);
        $newPub->setUnidadInvestigacion($_POST['uInvestigacion']); 
        $newPub->setLineaInvestigacion($_POST['linInv']);
        $newPub->actualizarDatos($_SESSION['idUsuario'], $_REQUEST['pub_id'], $pdo);

        if(strlen($_POST['invCP']) > 1){
            $newPub->asociarInvestigacion($_SESSION['idUsuario'], $idInv, $pdo);
        }
        else if(strlen($_POST['invCP']) < 1 && strlen($investigacion) !== 0){
            $newPub->desasociarInvestigacion($_SESSION['idUsuario'], $pdo);
        }

        // autor principal
        $test = new Autor();
        $autory = $test->testAutorPrincipal($_REQUEST['pub_id'], $pdo, 'publicacion');

        if($autory['universidad'] === null){
            $auth = new AutorInterno();
            $auth->loadData($_REQUEST['pub_id'], $pdo, 'publicacion');
        }
        else if($autory['universidad'] !== null){
            $auth = new AutorExterno();
            $auth->loadData($_REQUEST['pub_id'], $pdo, 'publicacion');
        }
        if($_POST['rPUniCP'] === 'interno'){
            $newAuth = new AutorInterno();

            $newAuth->setNombre($_POST['nomInvPCP']);//posible error
            $newAuth->setTipoFiliacion($_POST['rPUniCP']);
            $newAuth->setUnidadInvestigacion($_POST['uniInvPCP']);//posible error
            $newAuth->setFiliacion($_POST['rFiliacionIPCP']);
            $newAuth->setRol("principal");
            if(!($auth->compare($newAuth))){
                $det = 'Se registró el cambio del Autor Principal';
                $hist = new Historial();
                $hist->setFechaCambio($fecha);
                $hist->setDetalle($det);
                $hist->registrarCambio($_REQUEST['pub_id'], 'publicacion', $pdo);
            }
            $newAuth->actualizarAutor($_POST['pautor_id'], $pdo);//psobile error
        }
        else if($_POST['rPUniCP'] === 'externo'){
            $newAuth = new AutorExterno();

            $newAuth->setNombre($_POST['nomInvPCP']);//posible error
            $newAuth->setTipoFiliacion($_POST['rPUniCP']);
            $newAuth->setUniversidad($_POST['uniIPCP']);
            $newAuth->setRol("principal");
            if(!($auth->compare($newAuth))){
                $det = 'Se registró el cambio del Autor Principal';
                $hist = new Historial();
                $hist->setFechaCambio($fecha);
                $hist->setDetalle($det);
                $hist->registrarCambio($_REQUEST['pub_id'], 'publicacion', $pdo);
            }

            $newAuth->actualizarAutor($_POST['pautor_id'], $pdo);
        } 
     
        // autores de colaboracion
        $auths = new Autor();
        $investigadores = $auths->loadAutores($pdo, $_REQUEST['pub_id'], 'publicacion');
        for($i = 0; $i < count($investigadores); $i++){
            if($investigadores[$i]['tipo_filiacion'] == 'interno'){
                $newAuth = new AutorInterno();
                $newAuth->setNombre($investigadores[$i]['nombre']);
                $newAuth->setTipoFiliacion($investigadores[$i]['tipo_filiacion']);
                $newAuth->setUnidadInvestigacion($investigadores[$i]['unidad_investigacion']);
                $newAuth->setFiliacion($investigadores[$i]['filiacion']);
                $newAuth->setRol("colaboracion");
                $investigadores[$i] = $newAuth;
            }
            else {
                $newAuth = new AutorExterno();
                $newAuth->setNombre($investigadores[$i]['nombre']);
                $newAuth->setTipoFiliacion($investigadores[$i]['tipo_filiacion']);
                $newAuth->setUniversidad($investigadores[$i]['unidad_investigacion']);
                $newAuth->setRol("colaboracion");
                $investigadores[$i] = $newAuth;
            }
            
        }
        
        $auths->eliminarAutor($_REQUEST['pub_id'], 'publicacion', $pdo);
        $inv_nuevos = array();

        for ($i=0; $i <= 100 ; $i++) {
            if( !isset($_POST['nomInvSCP'.$i]) ) continue;
            $nombre = $_POST['nomInvSCP'.$i];
            $pertenencia = $_POST['rPUniCP'.$i];
            if($pertenencia === 'interno'){
                $unidad = $_POST['uniInvSCP'.$i];
                $filiacion = $_POST['rFiliacionISCP'.$i];

                $auth = new AutorInterno();

                $auth->setNombre($nombre);
                $auth->setTipoFiliacion($pertenencia);
                $auth->setRol('colaboracion');
                $auth->setUnidadInvestigacion($unidad);
                $auth->setFiliacion($filiacion);
                //$auth->crearAutor($_REQUEST['pub_id'], 'publicacion', $pdo);
                array_push($inv_nuevos, $auth);
            }
            else if($pertenencia === 'externo'){
                $univ = $_POST['uniISCP'.$i];
                
                $auth = new AutorExterno();

                $auth->setNombre($nombre);
                $auth->setTipoFiliacion($pertenencia);
                $auth->setRol('colaboracion');
                $auth->setUniversidad($univ);
                //$auth->crearAutor($_REQUEST['pub_id'], 'publicacion', $pdo);
                array_push($inv_nuevos, $auth);
            }
        }
        
        //ver si hay cambios en autores secundarios
        if(count($investigadores) !== count($inv_nuevos)){
            // exec('echo "Fecha fin: ' . $fecha_fin .'" >> lol.txt', $output, $retval);        
            $det = "Se registró el cambio de la Autores Secundarios";
            $hist = new Historial();
            $hist->setFechaCambio($fecha);
            $hist->setDetalle($det);
            $hist->registrarCambio($_REQUEST['pub_id'], 'publicacion', $pdo);
        }
        else{
            for ($i=0; $i < count($investigadores); $i++) {
                if($investigadores[$i] instanceof AutorInterno && $inv_nuevos[$i] instanceof AutorInterno){
                    if($investigadores[$i]->compare($inv_nuevos[$i]) === false){
                        $det = 'Se registró el cambio de los Autores Secundarios';
                        $hist = new Historial();
                        $hist->setFechaCambio($fecha);
                        $hist->setDetalle($det);
                        $hist->registrarCambio($_REQUEST['pub_id'], 'publicacion', $pdo);
                        break;
                    }
                }
                else if($investigadores[$i] instanceof AutorExterno && $inv_nuevos[$i] instanceof AutorExterno){
                    if(!$investigadores[$i]->compare($inv_nuevos[$i]) === false){
                        $det = 'Se registró el cambio de los Autores Secundarios';
                        $hist = new Historial();
                        $hist->setFechaCambio($fecha);
                        $hist->setDetalle($det);
                        $hist->registrarCambio($_REQUEST['pub_id'], 'publicacion', $pdo);
                        break;
                    }
                }
                else{
                    $det = 'Se registró el cambio de los Autores Secundarios';
                    $hist = new Historial();
                    $hist->setFechaCambio($fecha);
                    $hist->setDetalle($det);
                    $hist->registrarCambio($_REQUEST['pub_id'], 'publicacion', $pdo);
                    break;
                }
                $inv_nuevos[$i]->crearAutor($_REQUEST['pub_id'], 'publicacion', $pdo);
            }
            
        }
        
        for($i = 0; $i < count($inv_nuevos); $i++){
            $inv_nuevos[$i]->crearAutor($_REQUEST['pub_id'], 'publicacion', $pdo);
        }
        
        $pdo->commit();
        $_SESSION["success"] = 'cambios guardados correctamente';
        header('Location: detalles_publicacion_inv.php?pub_id='.$_REQUEST['pub_id']);
        return;   
    }catch(Exception $e){
        $pdo->rollback();
        $error = "Ocurrio un error inesperado, intentalo nuevamente";
        $_SESSION['error'] = $error;
        header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
        return;
    }
}
?>
