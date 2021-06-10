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

if ( isset($_POST['cancel'] ) ) {
    header('Location: detalles_publicacion_admin.php?pub_id='.$_REQUEST['pub_id']);
    return;
}

// manejar respuesta
if(isset($_POST['obsRevEF'])){
    if(strlen($_POST['obsRevEF']) < 1 ){
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
        header("Location: revision_entrega_final.php?pub_id=".$_REQUEST['pub_id']);
        return;
    }
    else {
        $pub = new Publicacion();

        $pub->sendFeedback($_REQUEST['pub_id'], $_POST['obsRevEF'], $pdo);

        $pub->loadDetalles($_SESSION['idUsuario'], $_REQUEST['pub_id'], 'administrativo', $pdo);

        $us = new Usuario();
        $us->loadDetalles($pub->getIdUsuario(), $pdo);
        
        $notify = new Notificacion();
        $notify->revisionCompleta($us->getCorreo(), $pub->getTitulo());

        $_SESSION["success"] = 'retroalimentacion enviada';
        header('Location: detalles_publicacion_admin.php?pub_id='.$_REQUEST['pub_id']);
        return;
    }
}
?>