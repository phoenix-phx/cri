<?php 
session_start();
require_once "c_pdo.php";
require_once "Publicacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if(isset($_POST['txtFiltroBP']) && isset($_POST['filtroBP']) ){
    $pub = new Publicacion();
    if($_POST['filtroBP'] === 'Ninguno'){
        $row = $pub->busqueda('Ninguno', '', $pdo);
    }
    else if ($_POST['filtroBP'] === 'Unidad de Investigacion') {
        if(strlen($_POST['txtFiltroBP']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_publicacion.php");
            return;
        }
        else{
            $data = array(':ui' => '%'.strtolower($_POST['txtFiltroBP']).'%');
            $row = $pub->busqueda('Unidad de Investigacion', $data, $pdo);
        }
    }
    else if ($_POST['filtroBP'] === 'Nombre') {
        if(strlen($_POST['txtFiltroBP']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_publicacion.php");
            return;
        }
        else{
            $data = array(':no' => '%'.strtolower($_POST['txtFiltroBP']).'%');
            $row = $pub->busqueda('Nombre', $data, $pdo);
        }
    }
    else if ($_POST['filtroBP'] === 'Codigo') {
        if(strlen($_POST['txtFiltroBP']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_publicacion.php");
            return;
        }
        else{
            $data = array(':cd' => '%'.strtolower($_POST['txtFiltroBP']).'%');
            $row = $pub->busqueda('Codigo', $data, $pdo);            
        }
    }
    else if ($_POST['filtroBP'] === 'Tipo') {
        if(strlen($_POST['txtFiltroBP']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_publicacion.php");
            return;
        }
        else{
            $data = array(':ti' => '%'.strtolower($_POST['txtFiltroBP']).'%');
            $row = $pub->busqueda('Tipo', $data, $pdo);
        }
    }
    
    $_SESSION['resultados'] = $row;
    $_SESSION['success'] = 'busqueda exitosa!';
    header('Location: buscar_publicacion.php');
    return;
} 
?>