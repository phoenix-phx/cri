<?php 
session_start();
require_once "c_pdo.php";

/*
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}
*/
if( !isset($_REQUEST['inv_id'])) {
    $_SESSION['error'] = "Codigo de investigacion faltante";
    header('Location: lista_investigacion.php');
    return;
}

$sql = 'SELECT * 
    	FROM investigacion
		WHERE idUsuario = :id
        AND idInv = :inv'; 
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
   ':id' => $_SESSION['idUsuario'],
   ':inv' => $_REQUEST['inv_id'],
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row === false){
    $_SESSION['error'] = 'No se pudo cargar la investigacion';
    header('Location: lista_investigacion.php');
    return;
}


    echo '<div role="table">' . "\n";
    echo '<div role="cabecera"> <span>Codigo</span> </div>';
    echo '<div role="cabecera"> <span>Titulo</span> </div>';
    echo '<div role="cabecera"> <span>Tipo</span> </div>';
if($row !== false){
    do{
        echo '<div role="fila">';
        echo '<div role="celda"> <span>' . htmlentities($row['codigo']) . '</span> </div>';
        echo '<div role="celda"> <span>' . htmlentities($row['titulo']) . '</span> </div>';
        echo '<div role="celda"> <span>' . htmlentities($row['tipo']) . '</span> </div>';
        echo '<a href="ver_publicacion.php?pub_id='.$row['idPub'].'">&gt&gt</a>'; echo "</td>";
        echo "</div>\n";
    }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
    echo "</div>";
}
echo "<br />";
?>