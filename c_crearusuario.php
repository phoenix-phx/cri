<?php
session_start();
require_once "c_pdo.php";
require_once "Usuario.php";
require_once "Notificacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos']) || $_SESSION['permisos'] !== 'administrativo'){
    die('No ha iniciado sesion');
}

if ( isset($_POST['cancel'] ) ) {
    header("Location: home_administrativo.php");
    return;
}

if(isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['celular']) && isset($_POST['telefono']) && isset($_POST['tUnidadI'])){
	if (strlen($_POST['nombre']) < 1 || strlen($_POST['tUnidadI']) < 1 || strlen($_POST['correo']) < 1) {
		$_SESSION['error'] = 'Debe llenar los campos obligatorios';
		header("Location: nuevo_usuario.php");
		return;
	}
    if(strlen($_POST['celular']) > 0 || strlen($_POST['telefono']) > 0){   
        if (!is_numeric($_POST['celular']) || !is_numeric($_POST['telefono'])) {
            $_SESSION['error'] = 'El celular o telefono deben ser datos numericos';
            header("Location: nuevo_usuario.php");
            return;
        }
    }
	else if( !isset($_POST['rbfiliacion']) || !isset($_POST['rbpermisos'])){
		$_SESSION['error'] = 'La filiacion y los permisos deben ser registrados';
		header("Location: nuevo_usuario.php");
		return;
	}
	else if(strlen($_POST['correo']) > 0 && ! filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)){
		$_SESSION["error"] = "El correo electronico debe contener @";
        header('Location: nuevo_usuario.php');
        return;
    }
    else{
        $us = new Usuario();
        
        $mails[] = $_POST['correo'];
        $admins = $us->searchAdminEmails($pdo);
        if(count($admins) !== 0){
            for ($i=0; $i < count($admins); $i++) { 
                $mails[] = $admins[$i]['correo'];
            }    
        }

    	$us->setNombre($_POST['nombre']);
    	$us->setFiliacion($_POST['rbfiliacion']);
    	$us->setUnidadInvestigacion($_POST['tUnidadI']);
    	$us->setRol($_POST['rbpermisos']);
    	$us->setCorreo($_POST['correo']);

    	$us->crear($pdo);
        $profile_id = $pdo->lastInsertId();

     	if(strlen($_POST['celular']) > 0){
     		$us->setCelular($_POST['celular']);
     		$us->agregarCelular($pdo);
	    }
	    if(strlen($_POST['telefono']) > 0){
	    	$us->setTelefono($_POST['telefono']);
     		$us->agregarTelefono($pdo);
	    }

	    // user y pass
	    $us->asignarDatosLogin($pdo);
	    
        // notificar
        $notify = new Notificacion();
        $notify->nuevoUsuario($mails, $us->getUser());

	    $_SESSION["success"] = 'usuario creado correctamente';
        header('Location: home_administrativo.php');
        return;
    }
}
?>