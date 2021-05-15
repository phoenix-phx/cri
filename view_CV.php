<?php  
session_start();
require_once "c_pdo.php";
require_once "Usuario.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['user_id'])) {
    /*
    if($_SESSION['permisos'] === 'investigador'){
        $_SESSION['error'] = "Codigo de usuario faltante";
        header('Location: listaPub_investigador.php');
        return;
    }
    else if($_SESSION['permisos'] === 'administrativo'){
        $_SESSION['error'] = "Codigo de publicacion faltante";
        header('Location: listaPub_admin.php');
        return;
    }
    */
    die();
}

$user = new Usuario();
$doc = $user->loadCV($_REQUEST['user_id'], $pdo);

header('Content-type:'.$doc['tipo']);
echo $doc['doc'];
?>