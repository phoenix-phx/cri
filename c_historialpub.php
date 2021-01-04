<?php 
//session_start();
require_once "c_pdo.php";
require_once "Historial.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

$hist = new Historial();
$hist->loadHistorial($_REQUEST['pub_id'], 'publicacion', $pdo);
?>