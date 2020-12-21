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
if($row !== false){
    do{
        echo '<div role="table">' . "\n";
        echo '<div role="cabecera"> <span>Nombre Corto</span> </div>';
        echo '<div role="cabecera"> <span>Codigo</span> </div>';
        echo '<div role="cabecera"> <span>Resumen</span> </div>';
        
        echo '<div role="fila">';
        echo '<div role="celda"> <span>' . htmlentities($row['nombre_corto']) . '</span> </div>';
        echo '<div role="celda"> <span>' . htmlentities($row['codigo']) . '</span> </div>';
        echo '<div role="celda"> <span>' . htmlentities($row['resumen']) . '</span> </div>';
        echo '<a href="detalles_investigacion_inv.php?inv_id='.$row['idInv'].'">&gt&gt</a>'; echo "</td>";
        echo "</div>\n";
        echo "</div>";
    }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
}
else if($row === false){
    echo "<span> No tiene investigaciones registradas </span>";
}


echo "<br /><img src=''>
<h1>Publicaciones</h1> <a href='listaPub_investigador.php'>ver todo</a> <br/>";

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
    do{
        echo '<div role="table">' . "\n";
        echo '<div role="cabecera"> <span>Titulo</span> </div>';
        echo '<div role="cabecera"> <span>Codigo</span> </div>';
        echo '<div role="cabecera"> <span>Resumen</span> </div>';
        
        echo '<div role="fila">';
        echo '<div role="celda"> <span>' . htmlentities($row['titulo']) . '</span> </div>';
        echo '<div role="celda"> <span>' . htmlentities($row['codigo']) . '</span> </div>';
        echo '<div role="celda"> <span>' . htmlentities($row['resumen']) . '</span> </div>';
        echo '<a href="detalles_publicacion_inv.php?pub_id='.$row['idPub'].'">&gt&gt</a>'; echo "</td>";
        echo "</div>\n";
        echo "</div>";
    }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
}
else if($row === false){
    echo "<span> No tiene publicaciones registradas </span>";
}
echo "<br />";

?>