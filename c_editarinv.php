<?php
session_start();
require_once "c_pdo.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['inv_id']) ){
    $_SESSION['error'] = 'No se encontro la investigacion';
    header('Location: listaInv_investigador');
    return;
}

$stmt = $pdo->prepare('SELECT * FROM investigacion
                       WHERE idInv = :inv
                       AND idUsuario = :id');
$stmt->execute(array(
    ':inv' => $_REQUEST['inv_id'],
    ':id' => $_SESSION['idUsuario']
));
$inv = $stmt->fetch(PDO::FETCH_ASSOC);
if($inv === false){
    $_SESSION['error'] = 'No se pudo cargar la investigacion';
    header('Location: listaInv_investigador');
    return;    
}

// validacion de edicion
if(isset($_POST['invTituloCI']) && isset($_POST['invNomCortoCI']) && isset($_POST['resumenCI']) && isset($_POST['fechaFinCI']) && isset($_POST['uniInvCI']) && isset($_POST['nomInvPCI']) ){

	if (strlen($_POST['invTituloCI']) < 1 || strlen($_POST['invNomCortoCI']) < 1  || strlen($_POST['resumenCI']) < 1 || strlen($_POST['fechaFinCI']) < 1 || strlen($_POST['uniInvCI']) < 1 ) {

		$_SESSION['error'] = 'Debe llenar todos los campos obligatorios de la investigacion';
		header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
		return;
	}
	if( strlen($_POST['nomInvPCI']) < 1 || !isset($_POST['univIP'])){
		$_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
		header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
		return;
	}
    if( isset($_POST['univIP']) && $_POST['univIP'] === 'interno'){
        if (strlen($_POST['uniInvPCI']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
            return;
        }        
        if (!isset($_POST['rFiliacionIP'])){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
            return;

        }
    }
    if( isset($_POST['univIP']) && $_POST['univIP'] === 'externo'){
        if (strlen($_POST['uniIPCI']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
            return;
        }        
    }
	if( !isset($_POST['rExisteFI']) ) {
        $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
		header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
		return;
	}
    if(isset($_POST['rExisteFI']) && $_POST['rExisteFI'] === 'si'){
        if(!isset($_POST['rTipoFr']) || !isset($_POST['rTipoFI']) ){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
            return;
        }
        if(isset($_POST['rTipoFr']) && $_POST['rTipoFr'] === 'externo'){
            if(strlen($_POST['nombreFinanciador']) < 1){
                $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
                header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
                return;                
            }
        }
        if(isset($_POST['rTipoFI']) && $_POST['rTipoFI'] === 'monetario'){
            if(strlen($_POST['monto']) < 1){
                $_SESSION['error'] = 'Debe completar los datos obligatorios del financiamiento';
                header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
                return;
            }
        }
    }
	
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
                if( isset($_POST['rPUniCI'.$i]) && $_POST['rPUniCI'.$i] === 'interno'){
                    if (strlen($_POST['uniInvSCI'.$i]) < 1){
                        return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                    }        
                    else if (!isset($_POST['rFiliacionIS'.$i])){
                        return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                    }
                }
                else if( isset($_POST['rPUniCI'.$i]) && $_POST['rPUniCI'.$i] === 'externo'){
                    if (strlen($_POST['uniISCI'.$i]) < 1){
                        return 'Debe completar los datos obligatorios de los investigadores  de colaboracion';
                    }        
                }
            }
            return true;
        }
        $failure = validateAutores();
        if ( is_string($failure)) {
            $_SESSION['error'] = $failure;
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
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
            header("Location: editar_investigacion.php?inv_id=".$_REQUEST['inv_id']);
            return;
        }

        // investigacion 
    	$sql = 'UPDATE investigacion
                SET nombre = :no, nombre_corto = :nc, resumen = :res, fecha_fin = :ff, unidad_investigacion = :ui
                WHERE idInv = :inv
                AND idUsuario = :us';                
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        	':no' => $_POST['invTituloCI'],
            ':nc' => $_POST['invNomCortoCI'],
            ':res' => $_POST['resumenCI'],
            ':ff' => $_POST['fechaFinCI'],
            ':ui' => $_POST['uniInvCI'],
            ':inv' => $_REQUEST['inv_id'],
            ':us' => $_SESSION['idUsuario']
        ));
        
	    // autor principal
        if($_POST['univIP'] === 'interno'){
    	    $sql = 'UPDATE autor
                    SET nombre = :no, tipo_filiacion = :tf, unidad_investigacion = :ui, filiacion = :fl
                    WHERE idAutor = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':no' => $_POST['nomInvPCI'],
                ':tf' => $_POST['univIP'],
                ':ui' => $_POST['uniInvPCI'],
                ':fl' => $_POST['rFiliacionIP'],
                ':id' => $_POST['pautor_id']
            ));
    		$autor_id = $pdo->lastInsertId();
        }
        else if($_POST['univIP'] === 'externo'){
            $sql = 'UPDATE autor
                    SET nombre = :no, tipo_filiacion = :tf, universidad = :uni
                    WHERE idAutor = :id';                    
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':no' => $_POST['nomInvPCI'],
                ':tf' => $_POST['univIP'],
                ':uni' => $_POST['uniIPCI'],
                ':id' => $_POST['pautor_id']
            ));
            $autor_id = $pdo->lastInsertId();
        }		

        // autores de colaboracion
        $sql = "DELETE a, ci
                FROM autor a, colaborador_inv ci
                WHERE a.idAutor IN (
                    select a.idAutor
                    from investigacion i
                    where i.idInv = ci.idInv
                    and ci.idAutor = a.idAutor
                    and a.rol = 'colaboracion'
                    and i.idInv = :inv
                )";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $_REQUEST['inv_id']
        ));

        for ($i=0; $i <= 100 ; $i++) {
            if( !isset($_POST['nomInvSCI'.$i]) ) continue;
            $nombre = $_POST['nomInvSCI'.$i];
            $pertenencia = $_POST['rPUniCI'.$i];
            if($pertenencia === 'interno'){
                $unidad =  $_POST['uniInvSCI'.$i]; 
                $filiacion =  $_POST['rFiliacionIS'.$i]; 

                $sql = "INSERT INTO autor (nombre, tipo_filiacion, rol, unidad_investigacion, filiacion)
                        VALUES (:no, :tf, :rol, :ui, :fl)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':no' => $nombre,
                    ':tf' => $pertenencia,
                    ':rol' => "colaboracion",
                    ':ui' => $unidad,
                    ':fl' => $filiacion
                ));
                $autor_id = $pdo->lastInsertId();
                $sql = "INSERT INTO colaborador_inv (idInv, idAutor)
                        VALUES (:inv, :auth)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':inv' => $_REQUEST['inv_id'],
                    ':auth' => $autor_id
                ));
            }
            else if($pertenencia === 'externo'){
                $univ =  $_POST['uniISCI'.$i]; 

                $sql = "INSERT INTO autor (nombre, tipo_filiacion, rol, universidad)
                        VALUES (:no, :tf, :rol, :uni)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':no' => $nombre,
                    ':tf' => $pertenencia,
                    ':rol' => "colaboracion",
                    ':uni' => $univ
                ));
                $autor_id = $pdo->lastInsertId();
                $sql = "INSERT INTO colaborador_inv (idInv, idAutor)
                        VALUES (:inv, :auth)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':inv' => $_REQUEST['inv_id'],
                    ':auth' => $autor_id
                ));
            }
        }
        
        // financiamiento
        $sql = 'SELECT * 
                FROM financiador
                WHERE idInv = :inv';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $_REQUEST['inv_id']
        ));
        $exists = $stmt->fetch(PDO::FETCH_ASSOC); 

        if($_POST['rExisteFI'] === 'si'){
            if($exists === false){
    	        $sql = "INSERT INTO financiador (idInv, tipo_financiamiento)
    	                VALUES (:inv, :tfm)";
    	        $stmt = $pdo->prepare($sql);
    	        $stmt->execute(array(
    	            ':inv' => $_REQUEST['inv_id'],
    	            ':tfm' => $_POST['rTipoFI']
    	        ));
                $financiador = $pdo->lastInsertId();

                if($_POST['rTipoFr'] === 'interno'){
                    $sql = "UPDATE financiador
                            SET  tipo_financiador = :tfr, nombre_financiador = :nfr
                            WHERE idFinanciador = :id
                            AND idInv = :inv";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':tfr' => $_POST['rTipoFr'],
                        ':nfr' => 'Universidad Catolica Boliviana',
                        ':id' => $financiador,
                        ':inv' => $_REQUEST['inv_id'] 
                    ));            
                }
                else if($_POST['rTipoFr'] === 'externo'){
                    $sql = "UPDATE financiador
                            SET  tipo_financiador = :tfr, nombre_financiador = :nfr
                            WHERE idFinanciador = :id
                            AND idInv = :inv";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':tfr' => $_POST['rTipoFr'],
                        ':nfr' => $_POST['nombreFinanciador'],
                        ':id' => $financiador,
                        ':inv' => $_REQUEST['inv_id'] 
                    ));            
                }

                if($_POST['rTipoFI'] === 'monetario'){
                    $sql = "UPDATE financiador
                            SET  monto = :mn
                            WHERE idFinanciador = :id
                            AND idInv = :inv";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':mn' => $_POST['monto'],
                        ':id' => $financiador,
                        ':inv' => $_REQUEST['inv_id'] 
                    ));            
                }

                if(strlen($_POST['obsTipoFOCI']) > 1){
                    $sql = 'UPDATE financiador
                            SET  observaciones = :obs
                            WHERE idFinanciador = :id
                            AND idInv = :inv';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':obs' => $_POST['obsTipoFOCI'],
                        ':id' => $financiador,
                        ':inv' => $_REQUEST['inv_id'] 
                    ));            
                }
            }
            else if($exists !== false){
                $sql = "UPDATE financiador 
                        SET tipo_financiamiento = :tfm
                        WHERE idInv = :inv
                        AND idFinanciador = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':tfm' => $_POST['rTipoFI'],
                    ':inv' => $_REQUEST['inv_id'],
                    ':id' => $_POST['financiador_id']
                ));
                $financiador = $_POST['financiador_id'];

                if($_POST['rTipoFr'] === 'interno'){
                    $sql = "UPDATE financiador
                            SET  tipo_financiador = :tfr, nombre_financiador = :nfr
                            WHERE idFinanciador = :id
                            AND idInv = :inv";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':tfr' => $_POST['rTipoFr'],
                        ':nfr' => 'Universidad Catolica Boliviana',
                        ':id' => $financiador,
                        ':inv' => $_REQUEST['inv_id'] 
                    ));            
                }
                else if($_POST['rTipoFr'] === 'externo'){
                    $sql = "UPDATE financiador
                            SET  tipo_financiador = :tfr, nombre_financiador = :nfr
                            WHERE idFinanciador = :id
                            AND idInv = :inv";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':tfr' => $_POST['rTipoFr'],
                        ':nfr' => $_POST['nombreFinanciador'],
                        ':id' => $financiador,
                        ':inv' => $_REQUEST['inv_id'] 
                    ));            
                }

                if($_POST['rTipoFI'] === 'monetario'){
                    $sql = "UPDATE financiador
                            SET  monto = :mn
                            WHERE idFinanciador = :id
                            AND idInv = :inv";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':mn' => $_POST['monto'],
                        ':id' => $financiador,
                        ':inv' => $_REQUEST['inv_id'] 
                    ));            
                }

                if(strlen($_POST['obsTipoFOCI']) > 1){
                    $sql = 'UPDATE financiador
                            SET  observaciones = :obs
                            WHERE idFinanciador = :id
                            AND idInv = :inv';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':obs' => $_POST['obsTipoFOCI'],
                        ':id' => $financiador,
                        ':inv' => $_REQUEST['inv_id'] 
                    ));            
                }   
            }
	    }
        else if($_POST['rExisteFI'] === 'no'){
            if($exists !== false){
                $sql = 'DELETE FROM financiador
                        WHERE idFinanciador = :id
                        AND idInv = :inv';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':id' => $exists['idFinanciador'],
                    ':inv' => $_REQUEST['inv_id'] 
                ));
            }
        }
        
        // actividades
        $sql = 'DELETE FROM actividad
                WHERE idInv = :inv';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $_REQUEST['inv_id'] 
        ));

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
                ':inv' => $_REQUEST['inv_id'],
                ':no' => $nombre,
               	':fi' => $finicio,
                ':ff' => $ffinal
            ));
        }
        
        $_SESSION["success"] = 'cambios guardados correctamente';
        header('Location: detalles_investigacion_inv.php?inv_id='.$_REQUEST['inv_id']);
        return;
    
}

// cargar datos
$stmt = $pdo->prepare('SELECT * FROM investigacion
                       WHERE idInv = :inv');
$stmt->execute(array(
    ':inv' => $_REQUEST['inv_id']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row === false){
    $_SESSION['error'] = 'Valores erroneos para inv_id';
    header('Location: listaInv_investigador');
    return;
}

$codigo = htmlentities($row['codigo']);
$titulo = htmlentities($row['nombre']);
$nombre_corto = htmlentities($row['nombre_corto']);
$resumen = htmlentities($row['resumen']);
$fecha_inicio = htmlentities($row['fecha_inicio']);
$fecha_fin = htmlentities($row['fecha_fin']);
$unidad = htmlentities($row['unidad_investigacion']);
$inv_id = htmlentities($row['idInv']);

// autor principal
$stmt = $pdo->prepare("SELECT a.idAutor, a.nombre, a.tipo_filiacion, a.rol, a.unidad_investigacion, a.filiacion, a.universidad
                       FROM autor a, colaborador_inv ci, investigacion i
                       WHERE i.idInv = ci.idInv
                       AND ci.idAutor = a.idAutor
                       AND a.rol = 'principal'
                       AND i.idInv = :inv");
$stmt->execute(array(
    ':inv' => $_REQUEST['inv_id']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$pautor_id = htmlentities($row['idAutor']);
$pnombre = htmlentities($row['nombre']);
$tipo_filiacion = htmlentities($row['tipo_filiacion']);
$rol = htmlentities($row['rol']);
if($row['universidad'] === null){
    $unidad_investigacion = htmlentities($row['unidad_investigacion']);
    $filiacion = htmlentities($row['filiacion']);
}
else if($row['universidad'] !== null){
    $universidad = htmlentities($row['universidad']);
}

// autores de colaboracion
function loadAutores($pdo, $inv_id){
    $sql = "SELECT a.idAutor, a.nombre, a.tipo_filiacion, a.rol, a.unidad_investigacion, a.filiacion, a.universidad
            FROM autor a, colaborador_inv ci, investigacion i
            WHERE i.idInv = ci.idInv
            AND ci.idAutor = a.idAutor
            AND a.rol = 'colaboracion'
            AND i.idInv = :inv";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':inv' => $_REQUEST['inv_id']
    ));
    $investigadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $investigadores;
}
$investigadores = loadAutores($pdo, $_REQUEST['inv_id']);

// financiamiento
$stmt = $pdo->prepare("SELECT a.idFinanciador, a.tipo_financiador, a.nombre_financiador, a.tipo_financiamiento, a.monto, a.observaciones
                       FROM financiador a, investigacion i
                       WHERE i.idInv = a.idInv
                       AND i.idInv = :inv");
$stmt->execute(array(
    ':inv' => $_REQUEST['inv_id']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row === false){
    $nombre_financiador = 'No Existe';
}
else{
    $financiador_id = htmlentities($row['idFinanciador']);
    $tipo_financiador = htmlentities($row['tipo_financiador']);
    $nombre_financiador = htmlentities($row['nombre_financiador']);
    $tipo_financiamiento = htmlentities($row['tipo_financiamiento']);
    if($tipo_financiamiento === 'monetario'){
        $monto = htmlentities($row['monto']);
    }
    if($row['observaciones'] !== null){
        $observaciones = htmlentities($row['observaciones']);
    }
}

// autores de colaboracion
function loadActividades($pdo, $inv_id){
    $sql = "SELECT a.idActividad, a.nombre, a.fecha_inicio, a.fecha_final
            FROM actividad a, investigacion i
            WHERE i.idInv = a.idInv
            AND i.idInv = :inv";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':inv' => $_REQUEST['inv_id']
    ));
    $actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $actividades;
}
$actividades = loadActividades($pdo, $_REQUEST['inv_id']);
?>