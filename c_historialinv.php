<?php 
session_start();
require_once "c_pdo.php";

/*
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}
*/
    $sql = 'SELECT fecha_cambio, detalle 
            FROM historial_inv
            WHERE idInv = :inv';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':inv' => $_REQUEST['inv_id']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row !== false){
        echo '<table border="1" >' . "\n";
        echo "<tr> <th> Fecha de Suceso </th> <th>Suceso </th>";
        do{
            echo "<tr>";
            echo "<td>"; echo (htmlentities($row['fecha_cambio'])); echo "</td>";
            echo "<td>"; echo (htmlentities($row['detalle'])); echo "</td>";
            echo "</tr>\n";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
        echo "</table>";
    }
    echo "<br />";   
    echo "<br />";
?>