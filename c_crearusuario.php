<?php
session_start();
require_once "c_pdo.php";

/*die*/

if(isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['celular']) && isset($_POST['telefono']) && isset($_POST['tUnidadI'])){
	echo "hasta aqui ha entrao cabro";
    if (strlen($_POST['nombre']) < 1 || strlen($_POST['tUnidadI']) < 1) {
		$_SESSION['error'] = 'Debe llenar los campos obligatorios';
		header("Location: nuevo_usuario.php");
		return;
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
    	echo "no hay observacionesa";
    	$sql = "INSERT INTO usuario (nombre, filiacion, unidad_investigacion, rol)
                VALUES (:na, :fi, :ui, :pm)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':na' => $_POST['nombre'],
            ':fi' => $_POST['rbfiliacion'],
            ':ui' => $_POST['tUnidadI'],
            ':pm' => $_POST['rbpermisos'],
        ));
        
        $profile_id = $pdo->lastInsertId();
     	if(strlen($_POST['correo']) > 0){
	        $sql = "UPDATE usuario
	                SET  correo = :em
	                WHERE idUsuario = :id";
	        $stmt = $pdo->prepare($sql);
	        $stmt->execute(array(
	            ':em' => $_POST['correo'],
	            ':id' => $profile_id
	        ));
	    }  
	    if(strlen($_POST['celular']) > 0){
	        $sql = "UPDATE usuario
	                SET  celular = :ce
	                WHERE idUsuario = :id";
	        $stmt = $pdo->prepare($sql);
	        $stmt->execute(array(
	            ':ce' => $_POST['celular'],
	            ':id' => $profile_id
	        ));
	    }
	    if(strlen($_POST['telefono']) > 0){
	        $sql = "UPDATE usuario
	                SET  telefono = :tf
	                WHERE idUsuario = :id";
	        $stmt = $pdo->prepare($sql);
	        $stmt->execute(array(
	            ':tf' => $_POST['telefono'],
	            ':id' => $profile_id
	        ));
	    }

	    // user y pass
	    $nombre = explode(' ', $_POST['nombre']);
	    $user = '';
	    for ($i=0; $i < count($nombre); $i++) { 
	    	if ($i%2!=0) {
	    		$user = $user . strtoupper($nombre[$i]);
	    	}
	    	else{
	    		$user = $user . strtolower($nombre[$i]);
	    	}
	    }
	    $dia = getdate();
   		$user = $user . $dia['mday'] . $dia['month'] . $dia['year'] . '-' . $dia['hours'] . ':' . $dia['minutes'];
   		$salt = '*cRriII20#_';
   		$cs = hash('sha256', $salt.$user);
		$sql = "UPDATE usuario
	            SET  user = :us, pass = :pw
	            WHERE idUsuario = :id";

	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':us' => $user,
	        ':pw' => $cs,
	        ':id' => $profile_id
	    ));
	    $_SESSION["success"] = 'usuario creado!';
        header('Location: nuevo_usuario.php');
        return;
    }
}
?>