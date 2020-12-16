<?php
session_start();
require_once "c_pdo.php";
/*
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}
*/
if(isset($_POST['invTituloCI']) && isset($_POST['invNomCortoCI']) && isset($_POST['resumenCI']) && isset($_POST['fechaFinCI']) && isset($_POST['uniInvCI']) && isset($_POST['nomInvPCI']) && isset($_POST['nomFCI'])){

	if (strlen($_POST['invTituloCI']) < 1 || strlen($_POST['invNomCortoCI']) < 1  || strlen($_POST['resumenCI']) < 1 || strlen($_POST['fechaFinCI']) < 1 || strlen($_POST['uniInvCI']) < 1 || strlen($_POST['nomInvPCI']) < 1 || strlen($_POST['nomFCI']) < 1) {

		$_SESSION['error'] = 'Debe llenar los campos obligatorios';
		header("Location: nueva_investigacion.php");
		return;
	}
	else if( !isset($_POST['univIP']) || !isset($_POST['rFiliacionIP'])){
		$_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
		header("Location: nueva_investigacion.php");
		return;
	}
	else if( !isset($_POST['rExisteFI']) || !isset($_POST['rTipoFr'])|| !isset($_POST['rTipoFI'])) {
		$_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
		header("Location: nueva_investigacion.php");
		return;
	}
	else{
		function validateAutores(){
            for ($i=0; $i <= 100 ; $i++) {
                if( !isset($_POST['nomInvSCI'.$i]) ) continue;
                $nombre = $_POST['nomInvSCI'.$i];
                if( !isset($_POST['rPUniCI'.$i]) ){
                	return "Debe completar los datos obligatorios de los investigadores de colaboracion";
                }
                $pertenencia = $_POST['rPUniCI'.$i];
                if(strlen($nombre) < 1){
                    return "Debe completar los datos obligatorios de los investigadores de colaboracion";
                }
            }
            return true;
        }
        $failure = validateAutores();
        if ( is_string($failure)) {
            $_SESSION['error'] = $failure;
            header("Location: nueva_investigacion.php");
            return;
        }

        function validateActividades(){
            for ($i=0; $i <= 100 ; $i++) {
                if( !isset($_POST['nomActCI'.$i]) ) continue;
                if( !isset($_POST['FIActCI'.$i]) ) continue;
                if( !isset($_POST['FFActCI'.$i]) ) continue;
                $nombre = $_POST['nomActCI'.$i];
                $finicio = $_POST['FIActCI'.$i];
				$ffinal = $_POST['FFActCI'.$i];
                if(strlen($nombre) < 1 || strlen($finicio) < 1 || strlen($ffinal) < 1){
                    return "Debe completar los datos obligatorios de las actividades";
                }
            }
            return true;
        }
        $failure = validateActividades();
        if ( is_string($failure)) {
            $_SESSION['error'] = $failure;
            header("Location: nueva_investigacion.php");
            return;
        }

    	$sql = "INSERT INTO investigacion (idUsuario, nombre, nombre_corto, resumen, fecha_fin, unidad_investigacion, estado)
                VALUES (:us, :no, :nc, :res, :ff, :ui, :st)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        	':us' => $_SESSION['idUsuario'],
            ':no' => $_POST['invTituloCI'],
            ':nc' => $_POST['invNomCortoCI'],
            ':res' => $_POST['resumenCI'],
            ':ff' => $_POST['fechaFinCI'],
            ':ui' => $_POST['uniInvCI'],
            ':st' => "en curso"
        ));
        
        $inv_id = $pdo->lastInsertId();

     	$dia = getdate();
   		$finicio = $dia['year'] . '-' . $dia['mon'] . '-' . $dia['mday'];
   		$nombre = explode(' ', $_POST['invNomCortoCI']);
	    $codigo = $finicio;
	    for ($i=0; $i < count($nombre); $i++) { 
	   		$codigo = $codigo . strtolower($nombre[$i]);
	    }
   		
     	$sql = "UPDATE investigacion
	            SET  codigo = :cd, fecha_inicio = :fi
	            WHERE idUsuario = :id
	            AND idInv = :inv";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':cd' => $codigo,
	        ':fi' => $finicio,
	        ':id' => $_SESSION['idUsuario'],
	       	':inv' => $inv_id 
	    ));
	    
	    // autor principal
	    $sql = "INSERT INTO autor (nombre, tipo_filiacion, rol)
                VALUES (:no, :tf, :rol)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':no' => $_POST['nomInvPCI'],
            ':tf' => $_POST['univIP'],
            ':rol' => "principal"
        ));
		$autor_id = $pdo->lastInsertId();
		$sql = "INSERT INTO colaborador_inv (idInv, idAutor)
                VALUES (:inv, :auth)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id,
            ':auth' => $autor_id
        ));
		
        // autores de colaboracion
        for ($i=0; $i <= 100 ; $i++) {
            if( !isset($_POST['nomInvSCI'.$i]) ) continue;
            $nombre = $_POST['nomInvSCI'.$i];
            $pertenencia = $_POST['rPUniCI'.$i];
            $sql = 'INSERT INTO autor (nombre, tipo_filiacion, rol)
                    VALUES (:no, :tf, :rol)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':no' => $nombre,
                ':tf' => $pertenencia,
                ':rol' => "colaboracion",
            ));
            $autor_id = $pdo->lastInsertId();
			$sql = "INSERT INTO colaborador_inv (idInv, idAutor)
	                VALUES (:inv, :auth)";
	        $stmt = $pdo->prepare($sql);
	        $stmt->execute(array(
	            ':inv' => $inv_id,
	            ':auth' => $autor_id
	        ));	
        }
        
        // financiamiento
        if($_POST['rExisteFI'] === 'si'){
	        $sql = "INSERT INTO financiador (idInv, tipo_financiador, nombre_financiador, tipo_financiamiento)
	                VALUES (:inv, :tfr, :nfr, :tfm)";
	        $stmt = $pdo->prepare($sql);
	        $stmt->execute(array(
	            ':inv' => $inv_id,
	            ':tfr' => $_POST['rTipoFr'],
	            ':nfr' => $_POST['nomFCI'],
	            ':tfm' => $_POST['rTipoFI']
	        ));
	    }

        // actividades
        for ($i=0; $i <= 100 ; $i++) {
            if( !isset($_POST['nomActCI'.$i]) ) continue;
            if( !isset($_POST['FIActCI'.$i]) ) continue;
            if( !isset($_POST['FFActCI'.$i]) ) continue;
            $nombre = $_POST['nomActCI'.$i];
            $finicio = $_POST['FIActCI'.$i];
			$ffinal = $_POST['FFActCI'.$i];
            $sql = 'INSERT INTO actividad (idInv, nombre, fecha_inicio, fecha_final)
                    VALUES (:inv, :no, :fi, :ff)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':inv' => $inv_id,
                ':no' => $nombre,
               	':fi' => $finicio,
                ':ff' => $ffinal,
            ));
        }
        
        $_SESSION["success"] = 'usuario creado!';
        header('Location: nueva_investigacion.php');
        return;
    }
}
?>