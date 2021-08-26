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
    header('Location: listaInv_investigador.php');
    return;
}

try{
    $inv = new Investigacion();
    $inv->loadDetalles($_SESSION['idUsuario'], $_REQUEST['inv_id'], 'investigador', $pdo);
    $inv->setEstado('cerrado');
    $inv->cerrarInv($_SESSION['idUsuario'], $_REQUEST['inv_id'], $pdo);

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
    $notify->cierreInv($mails, $inv->getTitulo(), $us->getNombre());
    $pdo->commit();
    header('Location: investigacion_cerrada.php');
    return;
}
catch(Exception $e){
    $pdo->rollback();
    $error = "Ocurrio un error inesperado, intentalo nuevamente";
    $_SESSION['error'] = $error;
    header('Location: listaInv_investigador.php');
    return;
}
?>