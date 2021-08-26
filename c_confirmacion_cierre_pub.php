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
    header('Location: listaPub_investigador.php');
    return;
}

try{
    $pub = new Publicacion();
    $pub->loadDetalles($_SESSION['idUsuario'], $_REQUEST['pub_id'], 'investigador', $pdo);
    $pub->setEstado('cerrado');
    $pub->cerrarPub($_SESSION['idUsuario'], $_REQUEST['pub_id'], $pdo);

    $us = new Usuario();
    $us->loadDetalles($_SESSION['idUsuario'], $pdo);

    $admins = $us->searchAdminEmails($pdo);
    if(count($admins) !== 0){
        for ($i=0; $i < count($admins); $i++) { 
            $mails[] = $admins[$i]['correo'];
        }    
    }

    $pdo->beginTransaction();
    $notify = new Notificacion();
    $notify->cierrePub($mails, $pub->getTitulo(), $us->getNombre());
    $pdo->commit();
    header('Location: publicacion_cerrada.php');
}catch(Exception $e){
    $pdo->rollback();
    $error = "Ocurrio un error inesperado, intentalo nuevamente";
    $_SESSION['error'] = $error;
    header('Location: listaPub_investigador.php');
    return;
}
return;
?>