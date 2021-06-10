<?php
//session_start();
require_once "c_pdo.php";
require_once "Usuario.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    echo "Estoy aqui";
    die('No ha iniciado sesion');
}

if( isset($_SESSION['idUsuario']) && $_SESSION['permisos'] === 'investigador' && $_SESSION['idUsuario'] !== $_REQUEST['user_id']){
    die('No tiene permisos para editar la informacion de un usuario distinto al suyo');
}

if( !isset($_REQUEST['user_id'])){
    $_SESSION['error'] = 'user_id faltante';
    if($_SESSION['permisos'] === 'investigador'){
        header("Location: home_investigador.php");
        return;
    }
    else if($_SESSION['permisos'] === 'administrativo'){
        header("Location: home_administrativo.php");
        return;
    }
}

if ( isset($_POST['cancel'] ) ) {
    if($_SESSION['permisos'] === 'investigador'){
        header("Location: home_investigador.php");
        return;
    }
    else if($_SESSION['permisos'] === 'administrativo'){
        header("Location: home_administrativo.php");
        return;
    }
}

// cargar datos
if($_SESSION['permisos'] === 'investigador'){
    $us = new Usuario();
    $state = $us->loadDetalles($_REQUEST['user_id'], $pdo);
    if($state === false){
        $_SESSION['error'] = 'Valores erroneos para user_id';
        header('Location: home_investigador.php');
        return;
    }

    $nombre = htmlentities($us->getNombre());
    $correo = htmlentities($us->getCorreo());
    $celular = htmlentities($us->getCelular());
    $telefono = htmlentities($us->getTelefono());
    $filiacion = htmlentities($us->getFiliacion());
    $unidad_investigacion = htmlentities($us->getUnidadInvestigacion());
    $rol = htmlentities($us->getRol());
    $user_id = htmlentities($us->getId());

    $user = htmlentities($us->getUser());
    $pass = htmlentities($us->getPass());

    // existencia de CV
    $state = $us->existsCV($_REQUEST['user_id'], $pdo);
}
else if($_SESSION['permisos'] === 'administrativo'){
    $us = new Usuario();
    $state = $us->loadDetalles($_REQUEST['user_id'], $pdo);
    if($state === false){
        $_SESSION['error'] = 'Valores erroneos para user_id';
        header('Location: home_administrativo.php');
        return;
    }

    $nombre = htmlentities($us->getNombre());
    $correo = htmlentities($us->getCorreo());
    $celular = htmlentities($us->getCelular());
    $telefono = htmlentities($us->getTelefono());
    $filiacion = htmlentities($us->getFiliacion());
    $unidad_investigacion = htmlentities($us->getUnidadInvestigacion());
    $rol = htmlentities($us->getRol());
    $user_id = htmlentities($us->getId());

    $user = htmlentities($us->getUser());
    $pass = htmlentities($us->getPass());

    // existencia de CV
    $state = $us->existsCV($_REQUEST['user_id'], $pdo);
    /*
    if($state === false){
        $user->uploadCV($_REQUEST['user_id'], $name, $type, $data, $pdo);
    }
    else if($state === true){
        $user->updateCV($_REQUEST['user_id'], $name, $type, $data, $pdo);
    }*/
}
?>