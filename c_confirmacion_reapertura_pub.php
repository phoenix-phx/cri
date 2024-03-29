<?php 
session_start();
require_once "c_pdo.php";
require_once "Publicacion.php";
require_once "Notificacion.php";
require_once "Usuario.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['pub_id'])) {
    $_SESSION['error'] = "Codigo de publicacion faltante";
    header('Location: listaPub_admin.php');
    return;
}

try{
    $pdo->beginTransaction();
    $pub = new Publicacion();
    $pub->loadDetalles($_SESSION['idUsuario'], $_REQUEST['pub_id'], 'administrativo', $pdo);
    $pub->setEstado('en curso');
    $pub->cerrarPub($pub->getIdUsuario(), $_REQUEST['pub_id'], $pdo);

    $us = new Usuario();
    $us->loadDetalles($pub->getIdUsuario(), $pdo);

    $notify = new Notificacion();
    $notify->reaperturaPub($us->getCorreo(), $pub->getTitulo());

    $pdo->commit();
    $_SESSION['success'] = 'se hizo la reapertura de la publicación correctamente';
    header('Location: detalles_publicacion_admin.php?pub_id='.$_REQUEST['pub_id']);
    return;
}catch(Exception $e){
    $pdo->rollback();
    $error = "Ocurrio un error inesperado, intentalo nuevamente";
    $_SESSION['error'] = $error;
    header('Location: listaPub_admin.php');
    return;
}
?>