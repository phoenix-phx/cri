<?php 
session_start();
require_once "c_pdo.php";
require_once "Usuario.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if(isset($_POST['txtFiltroBP']) && isset($_POST['filtroBP']) ){
    $us = new Usuario();
    if($_POST['filtroBP'] === 'Ninguno'){
        $row = $us->busqueda('Ninguno', '', $pdo);
    }
    else if ($_POST['filtroBP'] === 'Nombre') {
        if(strlen($_POST['txtFiltroBP']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_usuario.php");
            return;
        }
        else{
            $data = array(':no' => '%'.strtolower($_POST['txtFiltroBP']).'%');
            $row = $us->busqueda('Nombre', $data, $pdo);
        }
    }
    
    $_SESSION['resultados'] = $row;
    $_SESSION['success'] = 'busqueda exitosa!';
    header('Location: buscar_usuario.php');
    return;
} 
?>