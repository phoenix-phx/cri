<?php 
session_start();
require_once "c_pdo.php";

/*
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}
*/
if(isset($_POST['txtFiltroBP']) && isset($_POST['filtroBP']) ){
    if($_POST['filtroBP'] === 'Ninguno'){
        $sql = 'SELECT codigo, titulo, tipo, idPub 
                FROM publicacion';    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    
    }
    else if ($_POST['filtroBP'] === 'Unidad de Investigacion') {
        if(strlen($_POST['txtFiltroBP']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_publicacion.php");
            return;
        }
        else{
                $sql = 'SELECT codigo, titulo, tipo, idPub 
                        FROM publicacion
                        WHERE unidad_investigacion = :ui';    
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':ui' => strtolower($_POST['txtFiltroBP'])
                ));
        }
    }
    else if ($_POST['filtroBP'] === 'Nombre') {
        if(strlen($_POST['txtFiltroBP']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_publicacion.php");
            return;
        }
        else{
                $sql = 'SELECT codigo, titulo, tipo, idPub 
                        FROM publicacion
                        WHERE titulo = :no';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':no' => strtolower($_POST['txtFiltroBP'])
                ));
        }
    }
    else if ($_POST['filtroBP'] === 'Codigo') {
        if(strlen($_POST['txtFiltroBP']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_publicacion.php");
            return;
        }
        else{
                $sql = 'SELECT codigo, titulo, tipo, idPub 
                        FROM publicacion
                        WHERE codigo = :cd';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':cd' => $_POST['txtFiltroBP']
                ));
        }
    }
    else if ($_POST['filtroBP'] === 'Tipo') {
        if(strlen($_POST['txtFiltroBP']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_publicacion.php");
            return;
        }
        else{
                $sql = 'SELECT codigo, titulo, tipo, idPub 
                        FROM publicacion
                        WHERE tipo = :ti';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':ti' => strtolower($_POST['txtFiltroBP'])
                ));
        }
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row !== false){
        do{
            echo '<div role="table">' . "\n";
            echo '<div role="cabecera"> <span>Codigo</span> </div>';
            echo '<div role="cabecera"> <span>Titulo</span> </div>';
            echo '<div role="cabecera"> <span>Tipo</span> </div>';
            
            echo '<div role="fila">';
            echo '<div role="celda"> <span>' . htmlentities($row['codigo']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($row['titulo']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($row['tipo']) . '</span> </div>';
            echo '<a href="detalles_publicacion_inv.php?pub_id='.$row['idPub'].'">&gt&gt</a>'; echo "</td>";
            echo "</div>\n";
         
            echo "</div>";
            echo "<br /> <br />";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
    }
    echo "<br />";   
?>