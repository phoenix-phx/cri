<?php 
session_start();
require_once "c_pdo.php";

/*
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}
*/
if( !isset($_REQUEST['inv_id'])) {
    $_SESSION['error'] = "Codigo de investigacion faltante";
    header('Location: listaInv_investigador.php');
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
header('Location: investigacion_cerrada.php');
return;
?>