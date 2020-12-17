<?php
session_start();
require_once "c_pdo.php";
/*
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}
*/
if(isset($_POST['tituloCP']) && isset($_POST['resumenCP']) && isset($_POST['invCP']) && isset($_POST['tipoCP']) && isset($_POST['nomInvPCP'])){

	if (strlen($_POST['tituloCP']) < 1 || strlen($_POST['resumenCP']) < 1  || strlen($_POST['invCP']) < 1 || strlen($_POST['tipoCP']) < 1 || strlen($_POST['nomInvPCP']) < 1 ) {
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
		header("Location: nueva_publicacion.php");
		return;
	}
	else if( !isset($_POST['rPUniCP']) ){
		$_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
		header("Location: nueva_publicacion.php");
		return;
	}
    else if( isset($_POST['rPUniCP']) && $_POST['rPUniCP'] === 'interno'){
        if (strlen($_POST['uniInvPCP']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: nueva_investigacion.php");
            return;
        }        
        else if (!isset($_POST['rFiliacionIPCP'])){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: nueva_investigacion.php");
            return;

        }
    }
    else if( isset($_POST['rPUniCP']) && $_POST['rPUniCP'] === 'externo'){
        if (strlen($_POST['uniIPCP']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: nueva_investigacion.php");
            return;
        }        
    }
	else{
		function validateAutores(){
            for ($i=0; $i <= 100 ; $i++) {
                if( !isset($_POST['nomInvSCP'.$i]) ) continue;
                $nombre = $_POST['nomInvSCP'.$i];
                if( !isset($_POST['rPUniCP'.$i]) ){
                	return "Debe completar los datos obligatorios de los investigadores de colaboracion";
                }
                $pertenencia = $_POST['rPUniCP'.$i];
                if(strlen($nombre) < 1){
                    return "Debe completar los datos obligatorios de los investigadores de colaboracion";
                }
                if( isset($_POST['rPUniCP'.$i]) && $_POST['rPUniCP'.$i] === 'interno'){
                    if (strlen($_POST['uniInvSCP'.$i]) < 1){
                        return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                    }        
                    else if (!isset($_POST['rFiliacionISCP'.$i])){
                        return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                    }
                }
                else if( isset($_POST['rPUniCP'.$i]) && $_POST['rPUniCP'.$i] === 'externo'){
                    if (strlen($_POST['uniISCP'.$i]) < 1){
                        return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                    }        
                }
            }
            return true;
        }
        $failure = validateAutores();
        if ( is_string($failure)) {
            $_SESSION['error'] = $failure;
            header("Location: nueva_publicacion.php");
            return;
        }

        $sql = "INSERT INTO publicacion (idUsuario, titulo, resumen, tipo)
                VALUES (:us, :no, :res, :ti)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':us' => $_SESSION['idUsuario'],
            ':no' => $_POST['tituloCP'],
            ':res' => $_POST['resumenCP'],
            ':ti' => $_POST['tipoCP']
        ));
        
        $pub_id = $pdo->lastInsertId();

     	$dia = getdate();
   		$finicio = $dia['year'] . '-' . $dia['mon'] . '-' . $dia['mday'];
   		$nombre = explode(' ', $_POST['tituloCP']);
	    $codigo = $finicio;
	    for ($i=0; $i < count($nombre); $i++) { 
	   		$codigo = $codigo . strtolower($nombre[$i]);
	    }
   		
     	$sql = "UPDATE publicacion
	            SET  codigo = :cd,
	            WHERE idUsuario = :id
	            AND idPub = :pub";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':cd' => $codigo,
	        ':id' => $_SESSION['idUsuario'],
	       	':pub' => $pub_id 
	    ));
	    
	    // autor principal
        if($_POST['rPUniCP'] === 'interno'){
            $sql = "INSERT INTO autor (nombre, tipo_filiacion, rol, unidad_investigacion, filiacion)
                    VALUES (:no, :tf, :rol, :ui, :fl)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':no' => $_POST['nomInvPCP'],
                ':tf' => $_POST['rPUniCP'],
                ':rol' => "principal",
                ':ui' => $_POST['uniInvSCP'],
                ':fl' => $_POST['rFiliacionISCP']
            ));
    		$autor_id = $pdo->lastInsertId();
    		$sql = "INSERT INTO colaborador_pub (idPub, idAutor)
                    VALUES (:pub, :auth)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':pub' => $pub_id,
                ':auth' => $autor_id
            ));
		}
        else if($_POST['rPUniCP'] === 'externo'){
            $sql = "INSERT INTO autor (nombre, tipo_filiacion, rol, universidad)
                    VALUES (:no, :tf, :rol, :uni)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':no' => $_POST['nomInvPCP'],
                ':tf' => $_POST['rPUniCP'],
                ':rol' => "principal",
                ':uni' => $_POST['uniISCP']
            ));
            $autor_id = $pdo->lastInsertId();
            $sql = "INSERT INTO colaborador_pub (idPub, idAutor)
                    VALUES (:pub, :auth)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':pub' => $pub_id,
                ':auth' => $autor_id
            ));
        }

        // autores de colaboracion
        for ($i=0; $i <= 100 ; $i++) {
            if( !isset($_POST['nomInvSCP'.$i]) ) continue;
            $nombre = $_POST['nomInvSCP'.$i];
            $pertenencia = $_POST['rPUniCP'.$i];
            if($pertenencia === 'interno'){
                $unidad = $_POST['uniInvSCP'];
                $filiacion = $_POST['rFiliacionISCP'];

                $sql = 'INSERT INTO autor (nombre, tipo_filiacion, rol, unidad_investigacion, filiacion)
                        VALUES (:no, :tf, :rol, :ui, :fl)';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':no' => $nombre,
                    ':tf' => $pertenencia,
                    ':rol' => "colaboracion",
                    ':ui' => $unidad,
                    ':fl' => $filiacion
                ));
                $autor_id = $pdo->lastInsertId();
    			$sql = "INSERT INTO colaborador_pub (idPub, idAutor)
    	                VALUES (:pub, :auth)";
    	        $stmt = $pdo->prepare($sql);
    	        $stmt->execute(array(
    	            ':pub' => $pub_id,
    	            ':auth' => $autor_id
    	        ));	
            }
            else if($pertenencia === 'externo'){
                $univ = $_POST['uniISCP'];
                
                $sql = 'INSERT INTO autor (nombre, tipo_filiacion, rol, universidad)
                        VALUES (:no, :tf, :rol, :uni)';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':no' => $nombre,
                    ':tf' => $pertenencia,
                    ':rol' => "colaboracion",
                    ':uni' => $univ
                ));
                $autor_id = $pdo->lastInsertId();
                $sql = "INSERT INTO colaborador_pub (idPub, idAutor)
                        VALUES (:pub, :auth)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':pub' => $pub_id,
                    ':auth' => $autor_id
                )); 
            }
        }
        
        $_SESSION["success"] = 'usuario creado!';
        header('Location: nueva_publicacion.php');
        return;
    }
}
?>