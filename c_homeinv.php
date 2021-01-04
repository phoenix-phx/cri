<?php 
//session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";
require_once "Publicacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos']) || $_SESSION['permisos'] != 'investigador'){
    die('No ha iniciado sesion');
}

// investigaciones
echo '<div style="padding-left:240px;">' . "\n";
    echo '<div style="width:90%;">' . "\n";
        echo '<div style="padding-top: 15px; padding-bottom: 15px; height:50px;">' . "\n";
            echo '<h1 class="aLeft">Investigaciones Recientes</h1>' . "\n";
            echo '<div class="aRight" style="padding-top:25px;padding-bottom:25px;">' . "\n";
                echo '<a style="color: blue;" href="listaInv_investigador.php">ver todo</a>' . "\n";
            echo '</div>' . "\n";
        echo '</div>' . "\n";
    echo '</div>' . "\n";

$inv = new Investigacion();
$state = $inv->initInv($_SESSION['idUsuario'], $pdo);
if($state === false){
    echo "<div align='center'>No tiene investigaciones registradas</div>";
}

// publicaciones
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

$pub = new Publicacion();
$state = $pub->initPub($_SESSION['idUsuario'], $pdo);
if($state === false){
    echo "<div align='center'>No tiene publicaciones registradas</div>";
}
echo "<br />";
echo "</div>";
?>
