<?php
session_start();
require_once "c_pdo.php";

/*die*/

if(isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['celular']) && isset($_POST['telefono'])){
	if (strlen($_POST['nombre']) < 1 ) {
		$_SESSION['error'] = 'Debe llenar los campos obligatorios';
		header("Location: login_administrativo.php");
		return;
	}
}
?>