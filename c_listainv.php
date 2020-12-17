<?php 
session_start();
require_once "c_pdo.php";

/*
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}
*/
$sql = 'SELECT codigo, nombre_corto, fecha_fin, idInv 
    	FROM investigacion
		WHERE idUsuario = :id'; 
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
   ':id' => $_SESSION['idUsuario']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row !== false){
    do{
        echo '<div role="table">' . "\n";
        echo '<div role="cabecera"> <span>Codigo</span> </div>';
        echo '<div role="cabecera"> <span>Nombre Corto</span> </div>';
        echo '<div role="cabecera"> <span>Fecha Finalizacion</span> </div>';
        
        echo '<div role="fila">';
        echo '<div role="celda"> <span>' . htmlentities($row['codigo']) . '</span> </div>';
        echo '<div role="celda"> <span>' . htmlentities($row['nombre_corto']) . '</span> </div>';
        echo '<div role="celda"> <span>' . htmlentities($row['fecha_fin']) . '</span> </div>';
        echo '<a href="ver_investigacion.php?inv_id='.$row['idInv'].'">&gt&gt</a>'; echo "</td>";
        echo "</div>\n";

        echo "</div>";
    }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
}
echo "<br />";
?>