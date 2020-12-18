<?php
session_start();
require_once "c_pdo.php";
/*
Session:
['rol']

Post:
['user']
['pass']
*/

$salt = '*cRriII20#_';
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
		$try = hash('sha256', $salt.$_POST['pass']);
		$stmt = $pdo->prepare('SELECT idUsuario, rol
							   FROM usuario
							   WHERE user = :us
							   AND pass = :pw
							   AND rol = :perm');
		$stmt->execute(array(
			':us' => $_POST['user'],
			':pw' => $try,
			':perm' => $modo
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row !== false){
			$_SESSION['permisos'] = $row['rol'];
			$_SESSION['idUsuario'] = $row['idUsuario'];
			if($row['rol'] === 'investigador'){
				header("Location: home_investigador.php");
				return;
			}
			else if($row['rol'] === 'administrativo'){
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