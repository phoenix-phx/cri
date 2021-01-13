<?php 
//session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";
require_once "Actividad.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos']) || $_SESSION['permisos'] !== 'investigador'){
    die('No ha iniciado sesion');
}

$inv = new Investigacion();
$fechas_inv = $inv->fechas($_SESSION['idUsuario'], $pdo);

echo '<div style="padding-left:5%;"><h2><b>CRONOGRAMA DE INVESTIGACIONES</b></h2></div>';
echo '<div style="padding-left:5%;padding-right:5%;">';

if($fechas_inv !== false){
    for ($i=0; $i < count($fechas_inv); $i++) { 
        echo '<div class="container" style="padding-left:3%;">';
        echo '<p><b>INVESTIGACI&Oacute;N</b></p>';
        echo '<div class="aLeft" style="width:320px;">DESCRIPCI&Oacute;N</div>';
        $idInv = htmlentities($fechas_inv[$i]['idInv']);
        $nombre = htmlentities($fechas_inv[$i]['nombre']);
        $codigo = htmlentities($fechas_inv[$i]['codigo']);
        $fecha_final = htmlentities($fechas_inv[$i]['fecha_fin']);
        
        echo '<div role="fila"> <span>Entrega final de la investigaci&oacute;n: </span> <span><b><i>' . $nombre . '</i></b></span></div>';
        echo '<div class="aLeft" style="width:320px;">FECHA DE FINALIZACI&Oacute;N</div>';
        echo '<div role="fila"><span>' . $fecha_final . ' </span></div>';

        $act = new Actividad();
        $activities = $act->loadActividad($pdo, $idInv);
        
        echo "<p><b>ACTIVIDADES ASOCIADAS</b></p>";
        if(count($activities) !== 0){
            for ($j=0; $j < count($activities); $j++) {
                echo '<div class="aLeft" style="width:320px;">NOMBRE ACTIVIDAD</div>';
                echo '<div id="actividad' . ($j+1) .'">';
                echo '<span> Fecha limite de la actividad: </span><span><b><i>' . htmlentities($activities[$j]['nombre']) . '</i></b></span><br>';
                echo '<div class="aLeft" style="width:320px;">DESCRIPCI&Oacute;N</div>';
                echo '<span>' . htmlentities($activities[$j]['fecha_final']) . '</span> ';
                echo "</div><br>";
            }
        }
        else{
            echo "<p><span>No se han registrado actividades asociadas a esta investigaci&oacute;n</span><p>";
        }
        echo '</div>';
        echo "<br> <br>";
    }
    
}
echo '</div>';
echo "<br> <br>";
?>