<?php 
session_start();
require_once "c_pdo.php";
require_once "Notificacion.php";
require_once "Usuario.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['user_id'])) {
    die('Codigo de usuario faltante');
}

if ( isset($_POST['cancel'] ) ) {
    if($_SESSION['permisos'] === 'investigador')
        header('Location: editar_usuario.php?user_id='.$_REQUEST['user_id']);
    else
        header('Location: admin_editar_usuario.php?user_id='.$_REQUEST['user_id']);        
    return;
}

if(isset($_POST['subido'])){
    if(isset($_FILES['archivoEntregaF']) && $_FILES['archivoEntregaF']['error'] !== 0){
        $_SESSION['error'] = 'Debe llenar el campo del archivo';
        header("Location: subir_CV.php?user_id=".$_REQUEST['user_id']);
        return;        
    }
    else {
        try{
            $pdo->beginTransaction();
            $user = new Usuario();
            
            $name = $_FILES['archivoEntregaF']['name'];
            $type = $_FILES['archivoEntregaF']['type'];
            $data = file_get_contents($_FILES['archivoEntregaF']['tmp_name']);
            $size = $_FILES['archivoEntregaF']['size'];
            
            $state = $user->existsCV($_REQUEST['user_id'], $pdo);
            if($state === false){
                $user->uploadCV($_REQUEST['user_id'], $name, $type, $data, $pdo);
            }
            else if($state === true){
                $user->updateCV($_REQUEST['user_id'], $name, $type, $data, $pdo);
            }
            $user->loadDetalles($_SESSION['idUsuario'], $pdo);
            /*
            $admins = $us->searchAdminEmails($pdo);
            if(count($admins) !== 0){
                for ($i=0; $i < count($admins); $i++) { 
                    $mails[] = $admins[$i]['correo'];
                }    
            }

            $notify = new Notificacion();
            $notify->documentoFinalPub($mails, $pub->getTitulo(), $us->getNombre());
            */

            $pdo->commit();
            $_SESSION["success"] = 'CV subido correctamente!';
            header('Location: editar_usuario.php?user_id='.$_REQUEST['user_id']);
            return;
        }catch(Exception $e){
            $pdo->rollback();
            $error = "Ocurrio un error inesperado, intentalo nuevamente";
            $_SESSION['error'] = $error;
            header("Location: subir_CV.php?user_id=".$_REQUEST['user_id']);
            return;
        }    
    }
}
?>