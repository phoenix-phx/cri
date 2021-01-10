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

$stmt = $pdo->prepare('SELECT * FROM publicacion
                       WHERE idPub = :pub
                       AND idUsuario = :id');
$stmt->execute(array(
    ':pub' => $_REQUEST['pub_id'],
    ':id' => $_SESSION['idUsuario']
));
$inv = $stmt->fetch(PDO::FETCH_ASSOC);
if($inv === false){
    $_SESSION['error'] = 'No se pudo cargar la publicacion';
    header('Location: listaPub_investigador.php');
    return;    
}

// cargar datos
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
$investigacion = htmlentities($pub->getIdInv());
$ui = htmlentities($pub->getUnidadInvestigacion());
$est = htmlentities($pub->getEstado());
if($investigacion !== null){
    $nombreInv = $pub->getCodigoInv();
}
$tipo = htmlentities($pub->getTipo());
$pub_id = htmlentities($pub->getId());

// autor principal
$test = new Autor();
$autory = $test->testAutorPrincipal($_REQUEST['pub_id'], $pdo, 'publicacion');
if($autory['universidad'] === null){
    $auth = new AutorInterno();
    $auth->loadData($_REQUEST['pub_id'], $pdo, 'publicacion');

    $pautor_id = htmlentities($auth->getId());
    $pnombre = htmlentities($auth->getNombre());
    $tipo_filiacion = htmlentities($auth->getTipoFiliacion());
    $rol = htmlentities($auth->getRol());
    $unidad_investigacion = htmlentities($auth->getUnidadInvestigacion());
    $filiacion = htmlentities($auth->getFiliacion());
}
else if($autory['universidad'] !== null){
    $auth = new AutorExterno();
    $auth->loadData($_REQUEST['pub_id'], $pdo, 'publicacion');
    
    $pautor_id = htmlentities($auth->getId());
    $pnombre = htmlentities($auth->getNombre());
    $tipo_filiacion = htmlentities($auth->getTipoFiliacion());
    $rol = htmlentities($auth->getRol());
    $universidad = htmlentities($auth->getUniversidad());
}

// autores de colaboracion
$auths = new Autor();
$investigadores = $auths->loadAutores($pdo, $_REQUEST['pub_id'], 'publicacion');

// validacion de edicion
if(isset($_POST['tituloCP']) && isset($_POST['resumenCP']) && isset($_POST['tipoCP']) && isset($_POST['nomInvPCP']) && isset($_POST['uInvestigacion'])){

    if (strlen($_POST['tituloCP']) < 1 || strlen($_POST['resumenCP']) < 1  || strlen($_POST['tipoCP']) < 1 || strlen($_POST['uInvestigacion']) < 1) {
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

    // registrar cambios
    $dia = getdate();
    $fecha = $dia['year'] . '-' . $dia['mon'] . '-' . $dia['mday'];
    
    if($pub->getTitulo() !== $_POST['tituloCP']){
        $det = 'Se registró el cambio del TITULO' . "\n\nAntes:\n" . $pub->getTitulo() . "\n\nAhora:\n" . $_POST['tituloCP'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['pub_id'], 'publicacion', $pdo);
    }

    if($pub->getResumen() !== $_POST['resumenCP']){
        $det = 'Se registró el cambio del RESUMEN' . "\n\nAntes:\n" . $pub->getResumen() . "\n\nAhora:\n" . $_POST['resumenCP'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['pub_id'], 'publicacion', $pdo);
    }

    if($pub->getTipo() !== $_POST['tipoCP']){
        $det = 'Se registró el cambio del TIPO' . "\n\nAntes:\n" . $pub->getTipo() . "\n\nAhora:\n" . $_POST['tipoCP'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['pub_id'], 'publicacion', $pdo);
    }

    if($pub->getUnidadInvestigacion() !== $_POST['uInvestigacion']){
        $det = 'Se registró el cambio de la UNIDAD DE INVESTIGACION' . "\n\nAntes:\n" . $pub->getUnidadInvestigacion() . "\n\nAhora:\n" . $_POST['uInvestigacion'] . "\n";
        $hist = new Historial();
        $hist->setFechaCambio($fecha);
        $hist->setDetalle($det);
        $hist->registrarCambio($_REQUEST['pub_id'], 'publicacion', $pdo);
    }

    // publicacion
    $newPub = new Publicacion();

    $newPub->setTitulo($_POST['tituloCP']); 
    $newPub->setResumen($_POST['resumenCP']); 
    $newPub->setTipo($_POST['tipoCP']); 
    $newPub->setUnidadInvestigacion($_POST['uInvestigacion']); 
    
    $newPub->actualizarDatos($_SESSION['idUsuario'], $_REQUEST['pub_id'], $pdo);

    if(strlen($_POST['invCP']) > 1){
        $newPub->asociarInvestigacion($_SESSION['idUsuario'], $idInv, $pdo);
    }
    //else: set null 

    // autor principal
    if($_POST['rPUniCP'] === 'interno'){
        $newAuth = new AutorInterno();

        $newAuth->setNombre($_POST['nomInvPCP']);
        $newAuth->setTipoFiliacion($_POST['rPUniCP']);
        $newAuth->setUnidadInvestigacion($_POST['uniInvPCP']);
        $newAuth->setFiliacion($_POST['rFiliacionIPCP']);

        $newAuth->actualizarAutor($_POST['pautor_id'], $pdo);
    }
    else if($_POST['rPUniCP'] === 'externo'){
        $newAuth = new AutorExterno();

        $newAuth->setNombre($_POST['nomInvPCP']);
        $newAuth->setTipoFiliacion($_POST['rPUniCP']);
        $newAuth->setUniversidad($_POST['uniIPCP']);

        $newAuth->actualizarAutor($_POST['pautor_id'], $pdo);
    }
 
    // autores de colaboracion
    $auths = new Autor();
    $auths->eliminarAutor($_REQUEST['pub_id'], 'publicacion', $pdo);

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
            
            $auth->crearAutor($_REQUEST['pub_id'], 'publicacion', $pdo);
        }
        else if($pertenencia === 'externo'){
            $univ = $_POST['uniISCP'.$i];
            
            $auth = new AutorExterno();

            $auth->setNombre($nombre);
            $auth->setTipoFiliacion($pertenencia);
            $auth->setRol('colaboracion');
            $auth->setUniversidad($univ);
            
            $auth->crearAutor($_REQUEST['pub_id'], 'publicacion', $pdo);
        }
    }
    
    $_SESSION["success"] = 'cambios guardados correctamente';
    header('Location: detalles_publicacion_inv.php?pub_id='.$_REQUEST['pub_id']);
    return;   
}
?>