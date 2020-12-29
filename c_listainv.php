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
    echo '<div style="padding-left:5%;padding-right:5%;">' . "\n";
            echo '<div role="cabecera" align="center"> 
                <div class="aLeft" style="width:320px;">CODIGO</div> 
                <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
                <div class="aLeft" style="width:250px;">FECHA FINALIZACION</div>
                </div><br><br>
            </div>';
            

    if($row !== false){
        echo '<div style="padding-left:4%;padding-right:4%;">';
        do{ 
            echo '<div role="fila" class="container" 
            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
                <div class="aLeft" style="width:320px;">' . htmlentities($row['codigo']) . '</div> 
                <div class="aLeft" style="width:500px;">' . htmlentities($row['nombre_corto']) . '</div> 
                <div class="aLeft" style="width:250px;">' . htmlentities($row['fecha_fin']) . '</div>
                <a class="link" href="detalles_investigacion_inv.php?inv_id='.$row['idInv'].'">&gt&gt</a>
                </div>';
            echo "<br> <br>";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
        echo '</div>';
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
    echo '<div style="padding-left:5%;padding-right:5%;">' . "\n";
    echo '<div role="cabecera" align="center"> 
        <div class="aLeft" style="width:320px;">CODIGO</div> 
        <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
        <div class="aLeft" style="width:250px;">UNIDAD DE INVESTIGACION</div>
        </div><br><br>
    </div>';
    
    if($row !== false){
        echo '<div style="padding-left:4%;padding-right:4%;">';
        do{
            echo '<div role="fila" class="container" 
            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
                <div class="aLeft" style="width:320px;">' . htmlentities($row['codigo']) . '</div> 
                <div class="aLeft" style="width:500px;">' . htmlentities($row['nombre_corto']) . '</div> 
                <div class="aLeft" style="width:250px;">' . htmlentities($row['unidad_investigacion']) . '</div>
                <a class="link" href="detalles_investigacion_admin.php?inv_id='.$row['idInv'].'">&gt&gt</a>
                </div>';
                echo "<br> <br>";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
    }
    else if($row === false){
        echo "<span> No tiene investigaciones registradas </span>";
    }
    echo "<br />";   
}
?>