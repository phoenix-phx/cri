<?php
session_start();
require_once "c_pdo.php";
require_once "Publicacion.php";
require_once "Investigacion.php";
require_once "AutorExterno.php";
require_once "AutorInterno.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if ( isset($_POST['cancel'] ) ) {
    header("Location: listaPub_investigador.php");
    return;
}

if(isset($_POST['tituloCP']) && isset($_POST['resumenCP']) && isset($_POST['tipoCP']) && isset($_POST['nomInvPCP']) && isset($_POST['uInvestigacion']) && isset($_POST['linInvCP'])){

    if (strlen($_POST['tituloCP']) < 1 || strlen($_POST['resumenCP']) < 1  || strlen($_POST['tipoCP']) < 1 || strlen($_POST['uInvestigacion']) < 1 || strlen($_POST['linInvCP']) < 1) {
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
        header("Location: nueva_publicacion.php");
        return;
    }

    if($_POST['tipoCP'] === 'Ninguno'){
        $_SESSION['error'] = 'Debe llenar los campos obligatorios';
        header("Location: nueva_publicacion.php");
        return;        
    }
    if( !isset($_POST['rPUniCP']) || strlen($_POST['nomInvPCP']) < 1 ){
        $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
        header("Location: nueva_publicacion.php");
        return;
    }    
    if( isset($_POST['rPUniCP']) && $_POST['rPUniCP'] === 'interno'){
        if (strlen($_POST['uniInvPCP']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: nueva_publicacion.php");
            return;
        }        
        else if (!isset($_POST['rFiliacionIPCP'])){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: nueva_publicacion.php");
            return;
        }
    }
    if( isset($_POST['rPUniCP']) && $_POST['rPUniCP'] === 'externo'){
        if (strlen($_POST['uniIPCP']) < 1){
            $_SESSION['error'] = 'Debe completar los datos obligatorios del investigador principal';
            header("Location: nueva_publicacion.php");
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
        header("Location: nueva_publicacion.php");
        return;
    }

    $idInv = '';
    if(strlen($_POST['invCP']) > 1){
        $inv = new Investigacion();
        $idInv = $inv->searchID($_POST['invCP'], $pdo);
        if($idInv === false){
            $_SESSION['error'] = 'Codigo de investigacion asociada invalido';
            header("Location: nueva_publicacion.php");
            return;            
        }
    }

    try{
        // publicacion
        $pdo->beginTransaction();
        $pub = new Publicacion();

        $pub->setTitulo($_POST['tituloCP']);
        $pub->setResumen($_POST['resumenCP']);
        $pub->setTipo($_POST['tipoCP']);
        $pub->setApa($_POST['apaCP']);
        $pub->setUnidadInvestigacion($_POST['uInvestigacion']);
        $pub->setLineaInvestigacion($_POST['linInvCP']);
        //$pub->setEstado('en curso');

        //estado
        if($_POST['estPub'] === 'curso'){
            $pub->setEstado("en curso");
            $pub->cerrarPub($_SESSION['idUsuario'], $inv_id, $pdo);
        }else if($_POST['estPub'] === 'terminado'){
            $pub->setEstado("cerrado");
            $pub->cerrarPub($_SESSION['idUsuario'], $inv_id, $pdo);
        }
        
        $pub->crear($_SESSION['idUsuario'], $pdo);
        $pub_id = $pub->getId();

        $dia = getdate();
        $finicio = $dia['year'] . '-' . $dia['mon'] . '-' . $dia['mday'];
        $nombre = explode(' ', $_POST['tituloCP']);
        $codigo = $finicio . '_';
        for ($i=0; $i < count($nombre); $i++) { 
            $codigo = $codigo . strtolower($nombre[$i]);
        }
        
        $pub->setCodigo($codigo);
        
        $pub->completarDetalles($_SESSION['idUsuario'], $pdo);

        if(strlen($_POST['invCP']) > 1){
            $pub->asociarInvestigacion($_SESSION['idUsuario'], $idInv, $pdo);
        }

        // autor principal
        if($_POST['rPUniCP'] === 'interno'){
            $auth = new AutorInterno();

            $auth->setNombre($_POST['nomInvPCP']);
            $auth->setTipoFiliacion($_POST['rPUniCP']);
            $auth->setRol('principal');
            $auth->setUnidadInvestigacion($_POST['uniInvPCP']);
            $auth->setFiliacion($_POST['rFiliacionIPCP']);
            
            $auth->crearAutor($pub_id, 'publicacion', $pdo);
        }
        else if($_POST['rPUniCP'] === 'externo'){
            $auth = new AutorExterno();

            $auth->setNombre($_POST['nomInvPCP']);
            $auth->setTipoFiliacion($_POST['rPUniCP']);
            $auth->setRol('principal');
            $auth->setUniversidad($_POST['uniIPCP']);

            $auth->crearAutor($pub_id, 'publicacion', $pdo);
        }

        // autores de colaboracion
        for ($i=0; $i <= 100 ; $i++) {
            if( !isset($_POST['nomInvSCP'.$i]) ) continue;
            $nombre = $_POST['nomInvSCP'.$i];
            $pertenencia = $_POST['rPUniCP'.$i];
            if($pertenencia === 'interno'){
                $unidad = $_POST['uniInvSCP'.$i];
                $filiacion = $_POST['rFiliacionISCP'.$i];

                $auth = new AutorInterno();

                $auth->setNombre($nombre);
                $auth->setTipoFiliacion($pertenencia);
                $auth->setRol('colaboracion');
                $auth->setUnidadInvestigacion($unidad);
                $auth->setFiliacion($filiacion);
                
                $auth->crearAutor($pub_id, 'publicacion', $pdo);
            }
            else if($pertenencia === 'externo'){
                $univ = $_POST['uniISCP'.$i];
                
                $auth = new AutorExterno();

                $auth->setNombre($nombre);
                $auth->setTipoFiliacion($pertenencia);
                $auth->setRol('colaboracion');
                $auth->setUniversidad($univ);
                
                $auth->crearAutor($pub_id, 'publicacion', $pdo);
            }
        }
        
        $pdo->commit();
        $_SESSION["success"] = 'publicacion creada exitosamente';
        header('Location: detalles_publicacion_inv.php?pub_id='.$pub_id);
        return;
    }catch(Exception $e){
        $pdo->rollback();
        $error = "Ocurrio un error inesperado, intentalo nuevamente";
        $_SESSION['error'] = $error;
        header('Location: nueva_publicacion.php');
        return;
    }
}
?>
