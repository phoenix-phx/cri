<?php 
//session_start();
require_once "c_pdo.php";
require_once "Historial.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['inv_id']) ){
    $_SESSION['error'] = 'No se encontro la investigaci&oacute;n';
    header('Location: detalles_investigacion_admin.php?inv_id='.$_REQUEST['inv_id']);
    return;
}

$hist = new Historial();
$hist->loadHistorial($_REQUEST['inv_id'], 'investigacion', $pdo);
?>