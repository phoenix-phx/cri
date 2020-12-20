<?php 
session_start();
require_once "c_pdo.php";


if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if($_SESSION['permisos'] === 'investigador'){
    $sql = 'SELECT codigo, nombre_corto, fecha_fin, idInv 
        	FROM investigacion
    		WHERE idUsuario = :id
            AND estado = :st';  // que pasara con las investigaciones terminadas??
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
       ':id' => $_SESSION['idUsuario'],
       ':st' => 'en curso'
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
            echo '<a href="detalles_investigacion_inv.php?inv_id='.$row['idInv'].'">&gt&gt</a>'; echo "</td>";
            echo "</div>\n";

            echo "</div>";
            echo "<br /> <br />";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
    }
    else if($row === false){
        echo "<span> No tiene investigaciones registradas </span>";
    }
    echo "<br />";
}
else if($_SESSION['permisos'] === 'administrativo'){
    $sql = 'SELECT codigo, nombre_corto, unidad_investigacion, idInv 
            FROM investigacion';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row !== false){
        do{
            echo '<div role="table">' . "\n";
            echo '<div role="cabecera"> <span>Codigo</span> </div>';
            echo '<div role="cabecera"> <span>Nombre Corto</span> </div>';
            echo '<div role="cabecera"> <span>Unidad de Investigacion</span> </div>';
            
            echo '<div role="fila">';
            echo '<div role="celda"> <span>' . htmlentities($row['codigo']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($row['nombre_corto']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($row['unidad_investigacion']) . '</span> </div>';
            echo '<a href="detalles_investigacion_admin.php?inv_id='.$row['idInv'].'">&gt&gt</a>'; echo "</td>";
            echo "</div>\n";

            echo "</div>";
            echo "<br /> <br />";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
    }
    else if($row === false){
        echo "<span> No tiene investigaciones registradas </span>";
    }
    echo "<br />";   
}
?>