<?php 
session_start();
require_once "c_pdo.php";


if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['pub_id'])) {
    $_SESSION['error'] = "Codigo de publicacion faltante";
    header('Location: listaPub_investigador.php');
    return;
}

if(isset($_POST['archivoEntregaF']) && isset($_POST['descripcionEnvio'])){
    if(strlen($_POST['descripcionEnvio']) < 1 || strlen($_POST['archivoEntregaF']) < 1 ){
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
        header("Location: subir_entrega_final.php?pub_id=".$_REQUEST['pub_id']);
        return;
    }
    else {
        $sql = "UPDATE publicacion
                SET  documento_final = :df
                WHERE idUsuario = :id
                AND idPub = :pub";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':df' => $_POST['archivoEntregaF'],
            ':id' => $_SESSION['idUsuario'],
            ':pub' => $_REQUEST['pub_id']
        ));
        $_SESSION["success"] = 'documento subido correctamente!';
        header('Location: detalles_publicacion_inv.php?pub_id='.$_REQUEST['pub_id']);
        return;
    }
}
?>