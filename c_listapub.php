<?php 
session_start();
require_once "c_pdo.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if($_SESSION['permisos'] === 'investigador'){
    $sql = 'SELECT codigo, titulo, tipo, idPub 
        	FROM publicacion
    		WHERE idUsuario = :id'; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
       ':id' => $_SESSION['idUsuario']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<div style="padding-left:5%;padding-right:5%;">' . "\n";
            echo '<div role="cabecera" align="center"> 
                <div class="aLeft" style="width:320px;">CODIGO</div> 
                <div class="aLeft" style="width:500px;">TITULO</div> 
                <div class="aLeft" style="width:250px;">TIPO</div>
                </div><br><br>
            </div>';
            
    if($row !== false){
        echo '<div style="padding-left:4%;padding-right:4%;">';
        do{
            echo '<div role="fila" class="container" 
            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
            <div class="aLeft" style="width:320px;">' . htmlentities($row['codigo']) . '</div> 
            <div class="aLeft" style="width:500px;">' . htmlentities($row['titulo']) . '</div> 
            <div class="aLeft" style="width:250px;">' . htmlentities($row['tipo']) . '</div>
            <a class="link" href="detalles_publicacion_inv.php?pub_id='.$row['idPub'].'">&gt&gt</a>';
            echo "</div>";
            echo "<br /> <br />";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
        echo '</div>';
    }
    else if($row === false){
        echo "<span> No tiene publicaciones registradas </span>";
    }
    echo "<br />";
}
else if($_SESSION['permisos'] === 'administrativo'){
    $sql = 'SELECT codigo, titulo, tipo, idPub 
            FROM publicacion';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<div style="padding-left:5%;padding-right:5%;">' . "\n";
            echo '<div role="cabecera" align="center"> 
                <div class="aLeft" style="width:320px;">CODIGO</div> 
                <div class="aLeft" style="width:500px;">TITULO</div> 
                <div class="aLeft" style="width:250px;">TIPO</div>
                </div><br><br>
            </div>';
    if($row !== false){
        echo '<div style="padding-left:4%;padding-right:4%;">';
        do{
            echo '<div role="fila" class="container" 
            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
            <div class="aLeft" style="width:320px;">' . htmlentities($row['codigo']) . '</div> 
            <div class="aLeft" style="width:500px;">' . htmlentities($row['titulo']) . '</div> 
            <div class="aLeft" style="width:250px;">' . htmlentities($row['tipo']) . '</div>
            <a class="link" href="detalles_publicacion_inv.php?pub_id='.$row['idPub'].'">&gt&gt</a>';
            echo "</div>";
            echo "<br /> <br />";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
        echo '</div>';
    }
    echo "<br />";   
}
?>