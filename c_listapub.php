<?php 
//session_start();
require_once "c_pdo.php";
require_once "Publicacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if($_SESSION['permisos'] === 'investigador'){
    $pub = new Publicacion();
    $estado = $pub->listaInv($_SESSION['idUsuario'], $pdo);
    if($estado === false){
        echo "<span> No tiene publicaciones registradas </span>";
    }
    echo "<br />";
}
else if($_SESSION['permisos'] === 'administrativo'){
    $pub = new Publicacion();
    $estado = $pub->listaAdmin($pdo);
    if($estado === false){
        echo "<span> No existen publicaciones registradas </span>";
    }
    echo "<br />";   
}
?>