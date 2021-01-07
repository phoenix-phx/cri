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

echo '<h2><b>CRONOGRAMA DE INVESTIGACIONES</b></h2>';
echo '<div role="container">' . "\n";

if($fechas_inv !== false){
    for ($i=0; $i < count($fechas_inv); $i++) { 
        echo '<p><b>INVESTIGACION</b></p>';
        echo '<div role="cabecera"> 
                <div class="aLeft" style="width:320px;">DESCRIPCION</div> 
                <div class="aLeft" style="width:250px;">FECHA DE FINALIZACION</div>
                </div>
            </div>';
        $idInv = htmlentities($fechas_inv[$i]['idInv']);
        $nombre = htmlentities($fechas_inv[$i]['nombre']);
        $codigo = htmlentities($fechas_inv[$i]['codigo']);
        $fecha_final = htmlentities($fechas_inv[$i]['fecha_fin']);
        
        echo '<div role="fila"> <span>Entrega final de la investigacion: </span> <span><b><i>' . $nombre . '</i></b></span></div>';
        echo '<div role="fila"><span>' . $fecha_final . ' </span></div>';

        $act = new Actividad();
        $activities = $act->loadActividad($pdo, $idInv);
        
        echo "<p><b>ACTIVIDADES ASOCIADAS</b></p>";
        if(count($activities) !== 0){
            echo '<div role="cabecera"> 
                    <div class="aLeft" style="width:320px;">NOMBRE ACTIVIDAD</div> 
                    <div class="aLeft" style="width:250px;">FECHA DE FINALIZACION</div>
                    </div>
                </div>';
            for ($j=0; $j < count($activities); $j++) {
                echo '<div id="actividad' . ($j+1) .'">';
                echo '<p> <span> Fecha limite de la actividad: </span><span><b><i>' . htmlentities($activities[$j]['nombre']) . '</i></b></span>';
                echo "<br>";
                echo '<span>' . htmlentities($activities[$j]['fecha_final']) . '</span> <p>';
                echo "</div>";
            }
        }
        else{
            echo "<p><span>No se han registrado actividades asociadas a esta investigacion</span><p>";
        }
        echo "<br> <br>";
    }
    
}
echo "<br> <br>";
?>