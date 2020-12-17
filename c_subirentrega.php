<?php 
session_start();
require_once "c_pdo.php";

/*
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}
*/
if( !isset($_REQUEST['pub_id'])) {
    $_SESSION['error'] = "Codigo de publicacion faltante";
    header('Location: listaPub_investigador.php');
    return;
}

$sql = "UPDATE investigacion
        SET  estado = :st
        WHERE idUsuario = :id
        AND idInv = :inv";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
    ':st' => "cerrado",
    ':id' => $_SESSION['idUsuario'],
    ':inv' => $_REQUEST['inv_id']
));

if(isset($_POST['archivoEntregaF']) && isset($_POST['descripcionEnvio'])){
    if(strlen($_POST['descripcionEnvio']) < 1 ){
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
        header("Location: listaPub_investigador.php");
        return;
    }
    else if( !isset($_POST['archivoEntregaF'])){
        $_SESSION['error'] = 'Debe completar los campos obligatorios';
        header("Location: listaPub_investigador.php");
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
        header('Location: detalles_publicacion_pub.php?pub_id='.$_REQUEST['pub_id']);
        return;
    }
}
?>