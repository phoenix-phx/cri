<?php 
//session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if($_SESSION['permisos'] === 'investigador'){
    $inv = new Investigacion();
    $estado = $inv->listaInv($_SESSION['idUsuario'], 'en curso', $pdo);
    if($estado === false){
        echo "<span> No tiene investigaciones registradas </span>";
    }
    echo "<br />";
}
else if($_SESSION['permisos'] === 'administrativo'){
    $inv = new Investigacion();
    $estado = $inv->listaAdmin($pdo);
    if($estado === false){
        echo "<span> No tiene investigaciones registradas </span>";
    }
    echo "<br />";   
}
?>