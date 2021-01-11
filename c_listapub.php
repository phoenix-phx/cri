<?php 
//session_start();
require_once "c_pdo.php";
require_once "Publicacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if($_SESSION['permisos'] === 'investigador'){
    echo "<div style='padding-left:5%;'><h2> En Curso </h2></div>";
    $pub = new Publicacion();
    $estado = $pub->listaInv($_SESSION['idUsuario'], 'en curso', $pdo);
    if($estado === false){
        echo "<div style='padding-left:5%;'>No existen publicaciones registradas </div>";
    }
    echo "<br />";

    echo "<div style='padding-left:5%;'><h2> Cerrado </h2></div>";
    $estado = $pub->listaInv($_SESSION['idUsuario'], 'cerrado',$pdo);
    if($estado === false){
        echo "<div style='padding-left:5%;'>No existen publicaciones registradas </div>";
    }
    echo "<br />";
}
else if($_SESSION['permisos'] === 'administrativo'){
    $pub = new Publicacion();
    $estado = $pub->listaAdmin($pdo);
    if($estado === false){
        echo "<div style='padding-left:5%;'>No existen publicaciones registradas </div>";
    }
    echo "<br />";   
}
?>