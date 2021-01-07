<?php 
session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";
require_once "Actividad.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos']) || $_SESSION['permisos'] !== 'investigador'){
    die('No ha iniciado sesion');
}

$inv = new Investigacion();
$fechas_inv = $inv->fechas($_SESSION['idUsuario'], $pdo);

echo '<p><b>CRONOGRAMA DE INVESTIGACIONES</b></p>'
echo '<div role="container">' . "\n";
if($fechas_inv !== false){
    echo '<div role="cabecera"> 
            <div class="aLeft" style="width:320px;">DESCRIPCION</div> 
            <div class="aLeft" style="width:250px;">FECHA DE FINALIZACION</div>
            </div><br><br>
        </div>';

    for ($i=0; $i < count($fechas_inv); $i++) { 
        $idInv = htmlentities($fechas_inv[$i]['idInv']);
        $nombre_corto = htmlentities($fechas_inv[$i]['nombre_corto']);
        $codigo = htmlentities($fechas_inv[$i]['codigo']);
        $fecha_final = htmlentities($fechas_inv[$i]['fecha_fin']);
        
        echo '<div role="fila"> <span>Entrega final de la investigacion: </span> <span><b><i>' . $nombre_corto . '</i></b></span></div>';
        echo '<div role="fila">' . $fecha_final . ' </span></div>';
    }
    
}
echo "<br> <br>";
?>