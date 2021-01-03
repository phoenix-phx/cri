<?php 
session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if(isset($_POST['txtFiltroBI']) && isset($_POST['filtroBI']) ){
    $inv = new Investigacion();
    if($_POST['filtroBI'] === 'Ninguno'){
        $row = $inv->busqueda('Ninguno', '', $pdo);
    }
    else if ($_POST['filtroBI'] === 'Unidad de Investigacion') {
        if(strlen($_POST['txtFiltroBI']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_investigacion.php");
            return;
        }
        else{
            $data = array(':ui' => '%'.strtolower($_POST['txtFiltroBI']).'%');
            $row = $inv->busqueda('Unidad de Investigacion', $data, $pdo);
        }
    }
    else if ($_POST['filtroBI'] === 'Nombre Investigacion') {
        if(strlen($_POST['txtFiltroBI']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_investigacion.php");
            return;
        }
        else{
            $data = array(':no' => '%'.strtolower($_POST['txtFiltroBI']).'%', ':nc' => '%'.strtolower($_POST['txtFiltroBI']).'%');
            $row = $inv->busqueda('Nombre Investigacion', $data, $pdo);
        }
    }
    else if ($_POST['filtroBI'] === 'Codigo Investigacion') {
        if(strlen($_POST['txtFiltroBI']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_investigacion.php");
            return;
        }
        else{
            $data = array(':cd' => '%'.strtolower($_POST['txtFiltroBI']).'%');
            $row = $inv->busqueda('Codigo Investigacion', $data, $pdo);
        }
    }
    else if ($_POST['filtroBI'] === 'Nombre Investigador') {
        if(strlen($_POST['txtFiltroBI']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_investigacion.php");
            return;
        }
        else{
            $data = array(':no' => '%'.strtolower($_POST['txtFiltroBI']).'%');
            $row = $inv->busqueda('Nombre Investigador', $data, $pdo);
        }
    } 

    $_SESSION["success"] = 'busqueda exitosa';
    $_SESSION['resultados'] = $row;
    header('Location: buscar_investigacion.php');
    return;
}
?>