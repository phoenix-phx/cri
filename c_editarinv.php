<?php
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
$linea = htmlentities($inv->getLineaInvestigacion());
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

if($estado === false || $fin->getNombreFinanciador() === ""){
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
?>