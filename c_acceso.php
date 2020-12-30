<?php
session_start();
require_once "Usuario.php";
require_once "c_pdo.php";

$modo = $_REQUEST['modo'];
if(isset($_POST['user']) && isset($_POST['pass'])){
	unset($_SESSION['permisos']);
	if(strlen($_POST['user']) < 1 || strlen($_POST['pass']) < 1){
		$_SESSION['error'] = 'Se requiere usuario y contraseña';
		if($modo === 'investigador'){
			header("Location: login_investigador.php?modo=".$modo);
			return;
		}
		else if($modo === 'administrativo'){
			header("Location: login_administrativo.php?modo=".$modo);
			return;
		}
		return;
	}
	else {
		$us = new Usuario();
		$state = $us->login($_POST['user'], $_POST['pass'], $modo, $pdo);
		if($state === true){
			$_SESSION['permisos'] = $us->getRol();
			$_SESSION['idUsuario'] = $us->getId();
			if($us->getRol() === 'investigador'){
				header("Location: home_investigador.php");
				return;
			}
			else if($us->getRol() === 'administrativo'){
				header("Location: home_administrativo.php");
				return;
			}
		}
		else{
			$_SESSION['error'] = 'Usuario o contraseña incorrectos';
			if($modo === 'investigador'){
				header("Location: login_investigador.php?modo=".$modo);
				return;
			}
			else if($modo === 'administrativo'){
				header("Location: login_administrativo.php?modo=".$modo);
				return;
			}
		}
	}
}
?>