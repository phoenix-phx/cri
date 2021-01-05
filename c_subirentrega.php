<?php 
session_start();
require_once "c_pdo.php";
require_once "Publicacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['pub_id'])) {
    $_SESSION['error'] = "Codigo de publicacion faltante";
    header('Location: listaPub_investigador.php');
    return;
}

if ( isset($_POST['cancel'] ) ) {
    header('Location: detalles_publicacion_inv.php?pub_id='.$_REQUEST['pub_id']);
    return;
}

if(isset($_POST['descripcionEnvio'])){
    if(strlen($_POST['descripcionEnvio']) < 1 ){
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
        header("Location: subir_entrega_final.php?pub_id=".$_REQUEST['pub_id']);
        return;
    }
    if(isset($_FILES['archivoEntregaF']) && $_FILES['archivoEntregaF']['error'] !== 0){
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
        header("Location: subir_entrega_final.php?pub_id=".$_REQUEST['pub_id']);
        return;        
    }
    else {
        $pub = new Publicacion();

        $name = $_FILES['archivoEntregaF']['name'];
        $type = $_FILES['archivoEntregaF']['type'];
        $data = file_get_contents($_FILES['archivoEntregaF']['tmp_name']);
        $size = $_FILES['archivoEntregaF']['size'];
        
        $pub->subirEntrega($_SESSION['idUsuario'], $_REQUEST['pub_id'], $data, $pdo);
        $_SESSION["success"] = 'documento subido correctamente!';
        header('Location: detalles_publicacion_inv.php?pub_id='.$_REQUEST['pub_id']);
        return;
    }
}
?>