<?php
session_start();
require_once "c_pdo.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['pub_id']) ){
    $_SESSION['error'] = 'No se encontro la publicacion';
    header('Location: listaPub_investigador.php');
    return;
}

$stmt = $pdo->prepare('SELECT * FROM publicacion
                       WHERE idPub = :pub
                       AND idUsuario = :id');
$stmt->execute(array(
    ':pub' => $_REQUEST['pub_id'],
    ':id' => $_SESSION['idUsuario']
));
$inv = $stmt->fetch(PDO::FETCH_ASSOC);
if($inv === false){
    $_SESSION['error'] = 'No se pudo cargar la publicacion';
    header('Location: listaPub_investigador.php');
    return;    
}

// validacion de edicion
if(isset($_POST['tituloCP']) && isset($_POST['resumenCP']) && isset($_POST['tipoCP']) && isset($_POST['nomInvPCP'])){

    if (strlen($_POST['tituloCP']) < 1 || strlen($_POST['resumenCP']) < 1  || strlen($_POST['tipoCP']) < 1 ) {
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
        header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
        return;
    }
    // TODO: trabajar la busqueda de investigacion asociada
    if($_POST['tipoCP'] === 'Ninguno'){
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
        header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
        return;        
    }
    if( !isset($_POST['rPUniCP']) || strlen($_POST['nomInvPCP']) < 1 ){
        $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
        header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
        return;
    }    
    if( isset($_POST['rPUniCP']) && $_POST['rPUniCP'] === 'interno'){
        if (strlen($_POST['uniInvPCP']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
            return;
        }        
        else if (!isset($_POST['rFiliacionIPCP'])){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
            return;
        }
    }
    if( isset($_POST['rPUniCP']) && $_POST['rPUniCP'] === 'externo'){
        if (strlen($_POST['uniIPCP']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
            return;
        }        
    }
    
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
            header("Location: editar_publicacion.php?pub_id=".$_REQUEST['pub_id']);
            return;
        }

        // publicacion
        $sql = 'UPDATE publicacion
                SET titulo = :no, resumen = :res, tipo = :ti
                WHERE idPub = :pub
                AND idUsuario = :us';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':no' => $_POST['tituloCP'],
            ':res' => $_POST['resumenCP'],
            ':ti' => $_POST['tipoCP'],
            ':pub' => $_REQUEST['pub_id'],
            ':us' => $_SESSION['idUsuario']
        ));
        
        // autor principal
        if($_POST['rPUniCP'] === 'interno'){
            $sql = 'UPDATE autor
                    SET nombre = :no, tipo_filiacion = :tf, unidad_investigacion = :ui, filiacion = :fl
                    WHERE idAutor = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':no' => $_POST['nomInvPCP'],
                ':tf' => $_POST['rPUniCP'],
                ':ui' => $_POST['uniInvPCP'],
                ':fl' => $_POST['rFiliacionIPCP'],
                ':id' => $_POST['pautor_id']
            ));
        }
        else if($_POST['rPUniCP'] === 'externo'){
            $sql = 'UPDATE autor
                    SET nombre = :no, tipo_filiacion = tf, universidad = :uni
                    WHERE idAutor = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':no' => $_POST['nomInvPCP'],
                ':tf' => $_POST['rPUniCP'],
                ':uni' => $_POST['uniIPCP'],
                ':id' => $_POST['pautor_id']
            ));
        }

        // autores de colaboracion
        $sql = "DELETE a, ci
                FROM autor a, colaborador_pub ci
                WHERE a.idAutor IN (
                    select a.idAutor
                    from publicacion i
                    where i.idPub = ci.idPub
                    and ci.idAutor = a.idAutor
                    and a.rol = 'colaboracion'
                    and i.idPub = :pub
                )";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':pub' => $_REQUEST['pub_id']
        ));

        for ($i=0; $i <= 100 ; $i++) {
            if( !isset($_POST['nomInvSCP'.$i]) ) continue;
            $nombre = $_POST['nomInvSCP'.$i];
            $pertenencia = $_POST['rPUniCP'.$i];
            if($pertenencia === 'interno'){
                $unidad = $_POST['uniInvSCP'.$i];
                $filiacion = $_POST['rFiliacionISCP'.$i];

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
                $univ = $_POST['uniISCP'.$i];
                
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
        
        $_SESSION["success"] = 'cambios guardados correctamente';
        header('Location: detalles_publicacion_inv.php?pub_id='.$_REQUEST['pub_id']);
        return;   
}


// cargar datos
$stmt = $pdo->prepare('SELECT * FROM publicacion
                       WHERE idPub = :pub');
$stmt->execute(array(
    ':pub' => $_REQUEST['pub_id']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row === false){
    $_SESSION['error'] = 'Valores erroneos para pub_id';
    header('Location: listaPub_investigador.php');
    return;
}

$codigo = htmlentities($row['codigo']);
$titulo = htmlentities($row['titulo']);
$resumen = htmlentities($row['resumen']);
$investigacion = htmlentities($row['idInv']);// TODO: select investigador si existe
$tipo = htmlentities($row['tipo']);
$doc = htmlentities($row['documento_final']); // TODO: arreglar
$pub_id = htmlentities($row['idPub']);

// autor principal
$stmt = $pdo->prepare("SELECT a.idAutor, a.nombre, a.tipo_filiacion, a.rol, a.unidad_investigacion, a.filiacion, a.universidad
                       FROM autor a, colaborador_pub ci, publicacion i
                       WHERE i.idPub = ci.idPub
                       AND ci.idAutor = a.idAutor
                       AND a.rol = 'principal'
                       AND i.idPub = :pub");
$stmt->execute(array(
    ':pub' => $_REQUEST['pub_id']
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
            FROM autor a, colaborador_pub ci, publicacion i
            WHERE i.idPub = ci.idPub
            AND ci.idAutor = a.idAutor
            AND a.rol = 'colaboracion'
            AND i.idPub = :pub";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':pub' => $_REQUEST['pub_id']
    ));
    $investigadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $investigadores;
}
$investigadores = loadAutores($pdo, $_REQUEST['pub_id']);
?>