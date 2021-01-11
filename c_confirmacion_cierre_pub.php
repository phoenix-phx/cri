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

$pub = new Publicacion();
$pub->loadDetalles($_SESSION['idUsuario'], $_REQUEST['pub_id'], 'investigador', $pdo);
$pub->setEstado('cerrado');
$pub->cerrarInv($_SESSION['idUsuario'], $_REQUEST['inv_id'], $pdo);

$us = new Usuario();
$us->loadDetalles($_SESSION['idUsuario'], $pdo);

$admins = $us->searchAdminEmails($pdo);
if(count($admins) !== 0){
    for ($i=0; $i < count($admins); $i++) { 
        $mails[] = $admins[$i]['correo'];
    }    
}

$notify = new Notificacion();
$notify->cierrePub($mails, $pub->getTitulo(), $us->getNombre());

header('Location: investigacion_cerrada.php');
return;
?>