<?php
session_start();
/*
Get:
['rol']
*/
if(isset($_GET['rol'])){
	if($_GET['rol'] === 'investigador'){
		$_SESSION['rol'] = $_GET['rol'];
		header("Location: login_investigador.php");
		return;
	}
	else if($_GET['rol'] === 'administrativo'){
		$_SESSION['rol'] = $_GET['rol'];
		header("Location: login_administrativo.php");
		return;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Control Seleccion</title>
</head>
<body>
	<h1>Compilado Exitosamente</h1>
</body>
</html>