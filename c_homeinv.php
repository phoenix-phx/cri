<?php 
session_start();
require_once "c_pdo.php";


if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos']) || $_SESSION['permisos'] != 'investigador'){
    die('No ha iniciado sesion');
}

// investigaciones
$sql = 'SELECT codigo, nombre_corto, resumen, idInv 
    	FROM investigacion
		WHERE idUsuario = :id
        LIMIT 3'; 
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
   ':id' => $_SESSION['idUsuario']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo '<div style="padding-left:240px;">' . "\n";
    echo '<div style="width:90%;">' . "\n";
        echo '<div style="padding-top: 15px; padding-bottom: 15px; height:50px;">' . "\n";
            echo '<h1 class="aLeft">Investigaciones Recientes</h1>' . "\n";
            echo '<div class="aRight" style="padding-top:25px;padding-bottom:25px;">' . "\n";
                echo '<a style="color: blue;" href="listaInv_investigador.php">ver todo</a>' . "\n";
            echo '</div>' . "\n";
        echo '</div>' . "\n";
    echo '</div>' . "\n";
    if($row !== false){
        echo '<div class="aLeft" style="width:82%;padding-left:40px">';
        do{
            echo '<div class="aLeft container" style="width:26%;height:200px; padding:10px;margin:18px;">' . "\n";
                echo 'TITULO: ' . htmlentities($row['nombre_corto']) . "<br><br>"."\n";
                echo htmlentities($row['codigo']) . "<br><br>"."\n";
                echo htmlentities($row['resumen']) . "<br><br>"."\n";
            echo '</div>' . "\n";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
        echo '</div>';
    }
    else if($row === false){
        echo "<div>No tiene investigaciones registradas</div>";
    }
echo '</div>';
echo '<div style="padding-left:240px;">' . "\n";
    echo '<div style="width:90%;">' . "\n";
        echo '<div style="padding-top: 15px; padding-bottom: 15px; height:50px;">' . "\n";
            echo '<h1 class="aLeft">Publicaciones Recientes</h1>' . "\n";
            echo '<div class="aRight" style="padding-top:25px;padding-bottom:25px;">' . "\n";
                echo '<a style="color: blue;" href="listaPub_investigador.php">ver todo</a>' . "\n";
            echo '</div>' . "\n";
        echo '</div>' . "\n";
    echo '</div>' . "\n";
// publicaciones
    $sql = 'SELECT codigo, titulo, resumen, idPub 
            FROM publicacion
            WHERE idUsuario = :id
            LIMIT 3'; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
    ':id' => $_SESSION['idUsuario']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row !== false){
        echo '<div class="aLeft" style="width:82%;padding-left:40px">';
        do{
            echo '<div class="aLeft container" style="width:26%;height:200px; padding:10px;margin:18px;">' . "\n";
                echo 'TITULO: ' . htmlentities($row['titulo']) . '<br>' . "\n";
                echo htmlentities($row['codigo']) . "<br><br>"."\n";
                echo htmlentities($row['resumen']) . "<br><br>"."\n";
            echo '</div>' . "\n";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
        echo '</div>';
    }
    else if($row === false){
        echo "<div>No tiene publicaciones registradas</div>";
    }
    echo "<br />";
echo "</div>";
?>
