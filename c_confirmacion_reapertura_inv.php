<?php 
session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";
require_once "Notificacion.php";
require_once "Usuario.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['inv_id'])) {
    $_SESSION['error'] = "Codigo de investigacion faltante";
    header('Location: listaInv_admin.php');
    return;
}

try{
    $pdo->beginTransaction();
    $inv = new Investigacion();
    $inv->loadDetalles($_SESSION['idUsuario'], $_REQUEST['inv_id'], 'administrativo', $pdo);
    $inv->setEstado('en curso');
    $inv->cerrarInv($inv->getIdUsuario(), $_REQUEST['inv_id'], $pdo);

    $us = new Usuario();
    $us->loadDetalles($inv->getIdUsuario(), $pdo);

    $notify = new Notificacion();
    $notify->reaperturaInv($us->getCorreo(), $inv->getTitulo());

    $pdo->commit();
    $_SESSION['success'] = 'se hizo la reapertura de la investigación correctamente';
    header('Location: detalles_investigacion_admin.php?inv_id='.$_REQUEST['inv_id']);
    return;
}catch(Exception $e){
    $pdo->rollback();
    $error = "Ocurrio un error inesperado, intentalo nuevamente";
    $_SESSION['error'] = $error;
    header('Location: listaInv_admin.php');
    return;
}
?>