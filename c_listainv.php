<?php 
//session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if($_SESSION['permisos'] === 'investigador'){
    echo "<div style='padding-left:5%;'><h2> En Curso </h2></div>";
    $inv = new Investigacion();
    $estado = $inv->listaInv($_SESSION['idUsuario'], 'en curso', $pdo);
    if($estado === false){
        echo "<div style='padding-left:5%;'>No tiene investigaciones en curso actualmente </div>";
    }
    echo "<br />";

    echo "<div style='padding-left:5%;'><h2> Cerrado </h2></div>";
    $estado = $inv->listaInv($_SESSION['idUsuario'], 'cerrado', $pdo);
    if($estado === false){
        echo "<div style='padding-left:5%;'>No tiene investigaciones cerradas actualmente </div>";
    }
    echo "<br />";
}
else if($_SESSION['permisos'] === 'administrativo'){
    $inv = new Investigacion();
    $estado = $inv->listaAdmin($pdo);
    if($estado === false){
        echo "<div style='padding-left:5%;'>No existen investigaciones registradas </div>";
    }
    echo "<br />";   
}
?>