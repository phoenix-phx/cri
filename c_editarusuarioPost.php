<?php 
session_start();
require_once "c_pdo.php";
require_once "Usuario.php";


if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
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

if($_SESSION['permisos'] === 'investigador'){
	// validacion de edicion
    if(isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['celular']) && isset($_POST['telefono'])){
    	if (strlen($_POST['nombre']) < 1 || strlen($_POST['correo']) < 1) {
    		$_SESSION['error'] = 'Debe llenar los campos obligatorios';
    		header("Location: editar_usuario.php?user_id=".$_REQUEST['user_id']);
    		return;
    	}
        if(strlen($_POST['celular']) > 0){   
            if (!is_numeric($_POST['celular'])) {
                $_SESSION['error'] = 'El celular debe ser numerico';
                header("Location: editar_usuario.php?user_id=".$_REQUEST['user_id']);
                return;
            }
        }
        if(strlen($_POST['telefono']) > 0){
            if(!is_numeric($_POST['telefono'])){
                $_SESSION['error'] = 'El telefono deben ser numerico';
                header("Location: editar_usuario.php?user_id=".$_REQUEST['user_id']);
                return;
            }
        }
    	if(strlen($_POST['correo']) > 0 && ! filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)){
    		$_SESSION["error"] = "El correo electronico debe contener @";
            header("Location: editar_usuario.php?user_id=".$_REQUEST['user_id']);
            return;
        }
        else{
            try{
                $pdo->beginTransaction();
                $us = new Usuario();
                $us->setId($_REQUEST['user_id']);
            	$us->setNombre($_POST['nombre']);
            	$us->setCorreo($_POST['correo']);

            	$us->actualizarDatos($pdo);

             	if(strlen($_POST['celular']) > 0){
             		$us->setCelular($_POST['celular']);
             		$us->agregarCelular($pdo);
        	    }
        	    if(strlen($_POST['telefono']) > 0){
        	    	$us->setTelefono($_POST['telefono']);
             		$us->agregarTelefono($pdo);
        	    }
        	    
                $pdo->commit();
                $_SESSION["success"] = 'Los cambios se han guardado correctamente y serán visibles desde la siguiente sesión';
                header('Location: home_investigador.php');
                return;
            }catch(Exception $e){
                $pdo->rollback();
                $error = "Ocurrio un error inesperado, intentalo nuevamente";
                $_SESSION['error'] = $error;
                header("Location: editar_usuario.php?user_id=".$_REQUEST['user_id']);
                return;
            }
        }
    }
}
else if($_SESSION['permisos'] === 'administrativo'){
	// validacion de edicion
    if(isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['celular']) && isset($_POST['telefono'])){
        if (strlen($_POST['nombre']) < 1 || strlen($_POST['correo']) < 1 || strlen($_POST['tUnidadI']) < 1) {
            $_SESSION['error'] = 'Debe llenar los campos obligatorios';
            header("Location: admin_editar_usuario.php?user_id=".$_REQUEST['user_id']);
            return;
        }
        if(strlen($_POST['celular']) > 0){   
            if (!is_numeric($_POST['celular'])) {
                $_SESSION['error'] = 'El celular debe ser numerico';
                header("Location: admin_editar_usuario.php?user_id=".$_REQUEST['user_id']);
                return;
            }
        }
        if(strlen($_POST['telefono']) > 0){
            if(!is_numeric($_POST['telefono'])){
                $_SESSION['error'] = 'El telefono deben ser numerico';
                header("Location: admin_editar_usuario.php?user_id=".$_REQUEST['user_id']);
                return;
            }
        }
        if( !isset($_POST['rbfiliacion']) || !isset($_POST['rbpermisos'])){
            $_SESSION['error'] = 'La filiacion y los permisos deben ser registrados';
            header("Location: admin_editar_usuario.php?user_id=".$_REQUEST['user_id']);
            return;
        }
        if(strlen($_POST['correo']) > 0 && ! filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)){
            $_SESSION["error"] = "El correo electronico debe contener @";
            header("Location: admin_editar_usuario.php?user_id=".$_REQUEST['user_id']);
            return;
        }
        else{
            try{
                $pdo->beginTransaction();
                $us = new Usuario();
                $us->setId($_REQUEST['user_id']);
                $us->setNombre($_POST['nombre']);
                $us->setCorreo($_POST['correo']);
                $us->setFiliacion($_POST['rbfiliacion']);
                $us->setUnidadInvestigacion($_POST['tUnidadI']);
                $us->setRol($_POST['rbpermisos']);

                $us->actualizarDatosAdmin($pdo);

                if(strlen($_POST['celular']) > 0){
                    $us->setCelular($_POST['celular']);
                    $us->agregarCelular($pdo);
                }
                if(strlen($_POST['telefono']) > 0){
                    $us->setTelefono($_POST['telefono']);
                    $us->agregarTelefono($pdo);
                }
                
                $pdo->commit();
                $_SESSION["success"] = 'cambios guardados correctamente';
                header('Location: home_administrativo.php');
                return;            
            }catch(Exception $e){
                $pdo->rollback();
                $error = "Ocurrio un error inesperado, intentalo nuevamente";
                $_SESSION['error'] = $error;
                header("Location: admin_editar_usuario.php?user_id=".$_REQUEST['user_id']);
                return;
            }
        }
    }
}

?>