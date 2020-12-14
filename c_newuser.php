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

if(isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['celular']) && isset($_POST['telefono'])){

	if ( strlen($_POST['nombre']) < 1 || strlen($_POST['correo']) < 1 ) {
        $failure = "User name and password are required";
        $_SESSION["error"] = $failure;
        header('Location: nuevo_usuario.php');
        return;
    }
   	/*
	else {
		$try = hash('sha256', $salt.$_POST['pass']);
		$stmt = $pdo->prepare('SELECT idUsuario, rol
							   FROM usuario
							   WHERE user = :us
							   AND pass = :pw
							   AND rol = :perm');
		$stmt->execute(array(
			':us' => $_POST['user'],
			':pw' => $_POST['pass'],
			':perm' => $_SESSION['rol']
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row !== false){
			$_SESSION['permisos'] = $row['rol'];
			unset($_SESSION['rol']);
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
			if($_SESSION['rol'] === 'investigador'){
				header("Location: login_investigador.php");
				return;
			}
			else if($_SESSION['rol'] === 'administrativo'){
				header("Location: login_administrativo.php");
				return;
			}
		}
	}*/
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Control Acceso</title>
</head>
<body>
	<h1>Compilado Exitosamente</h1>
</body>
</html>