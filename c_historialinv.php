<?php 
session_start();
require_once "c_pdo.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['inv_id']) ){
    $_SESSION['error'] = 'No es encontro la investigacion';
    header('Location: detalles_investigacion_admin.php?inv_id='.$_REQUEST['inv_id']);
    return;
}

    $sql = 'SELECT fecha_cambio, detalle 
            FROM historial_inv
            WHERE idInv = :inv
            ORDER BY fecha_cambio ASC';
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
    else{
        echo "Esta investigacion no tiene cambios registrados";
    }
    echo "<br />";   
    echo "<br />";
?>