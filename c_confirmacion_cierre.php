<?php 
session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['inv_id'])) {
    $_SESSION['error'] = "Codigo de investigacion faltante";
    header('Location: listaInv_investigador.php');
    return;
}

$inv = new Investigacion();
$inv->setEstado('cerrado');
$inv->cerrarInv($_SESSION['idUsuario'], $_REQUEST['inv_id'], $pdo);
header('Location: investigacion_cerrada.php');
return;
?>