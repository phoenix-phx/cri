<?php
session_start();
require_once "c_pdo.php";
require_once "Usuario.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( isset($_SESSION['idUsuario']) && $_SESSION['idUsuario'] !== $_REQUEST['user_id']){
    die('No tiene permisos para cambiar la contraseña de un usuario distinto al suyo');
}

if( !isset($_REQUEST['user_id'])){
    $_SESSION['error'] = 'user_id faltante';
    header("Location: home_investigador.php");
    return;
}

if ( isset($_POST['cancel'] ) ) {
    if($_SESSION['permisos'] === 'investigador'){
        header("Location: editar_usuario.php?user_id=".$_REQUEST['user_id']);
        return;
    }
    else if($_SESSION['permisos'] === 'administrativo'){
        header("Location: admin_editar_usuario.php?user_id=".$_REQUEST['user_id']);
        return;
    }
}

// validacion de edicion
if(isset($_POST['pass']) && isset($_POST['npass'])){
	if (strlen($_POST['pass']) < 1 || strlen($_POST['npass']) < 1 || strlen($_POST['confir']) < 1) {
		$_SESSION['error'] = 'Debe llenar los campos obligatorios';
		header("Location: change_pass.php?user_id=".$_REQUEST['user_id']);
		return;
	}
    if ($_POST['npass'] !== $_POST['confir']) {
        $_SESSION['error'] = 'La confirmacion es diferente a la nueva contraseña, intentelo de nuevo';
        header("Location: change_pass.php?user_id=".$_REQUEST['user_id']);
        return;
    }
	else{
        try{
        	$us = new Usuario();
        	$res = $us->authenticatePass($_SESSION['idUsuario'], $_POST['pass'], $_SESSION['permisos'], $pdo);
            if($res === false){
                $_SESSION['error'] = 'La contraseña actual es incorrecta';
                header("Location: change_pass.php?user_id=".$_REQUEST['user_id']);
                return;                
            }
            else{
                if($res !== $_REQUEST['user_id']){
                    $_SESSION['error'] = 'Ha ocurrido un error, contactese con soporte';
                    header("Location: change_pass.php?user_id=".$_REQUEST['user_id']);
                    return;                                    
                }
            }
            $us->changePass($_SESSION['idUsuario'], $_POST['npass'], $pdo);
            if($_SESSION['permisos'] === 'investigador'){
                $_SESSION['success'] = 'Contraseña actualizada correctamente';
                header("Location: editar_usuario.php?user_id=".$_REQUEST['user_id']);
                return;
            }
            else if($_SESSION['permisos'] === 'administrativo'){
                $_SESSION['success'] = 'Contraseña actualizada correctamente';
                header("Location: admin_editar_usuario.php?user_id=".$_REQUEST['user_id']);
                return;
            }
        }catch(Exception $e){
            $pdo->rollback();
            $error = "Ocurrio un error inesperado, intentalo nuevamente";
            $_SESSION['error'] = $error;
            header("Location: change_pass.php?user_id=".$_REQUEST['user_id']);
            return;
        }
    }
}
?>