<?php 
session_start();
require_once "c_pdo.php";
require_once "Financiador.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['inv_id'])) {
    if($_SESSION['permisos'] === 'investigador'){
        $_SESSION['error'] = "Especificacion de tipo faltante";
        header('Location: home_investigador.php');
        return;
    }
    else if($_SESSION['permisos'] === 'administrativo'){
        $_SESSION['error'] = "Especificacion de tipo faltante";
        header('Location: home_administrativo.php');
        return;        
    }
}

echo "<p><b>DETALLES DE FINANCIAMIENTO:</b><p>";
$test = new Financiador();
$tipo = $test->loadDetalles($_REQUEST['inv_id'], $pdo, 'investigacion');

echo '<div role="container">' . "\n";
if($tipo !== false){
    $fin_id = htmlentities($test->getId());
    $tipo_financiador = htmlentities($test->getTipoFinanciador());
    $nombre_financiador = htmlentities($test->getNombreFinanciador());
    $tipo_financiamiento = htmlentities($test->getTipoFinanciamiento());
    $monto = htmlentities($test->getMonto());
    $observaciones = htmlentities($test->getObservaciones());

    echo '<div role="fila"> <span>TIPO DE FINANCIADOR: </span> <span><b><i>' . $tipo_financiador . '</i></b></span></div>';
    echo '<div role="fila"> <span>NOMBRE DE FINANCIADOR: </span> <span>' . $nombre_financiador . ' </span></div>';
    echo '<div role="fila"> <span>TIPO DE FINANCIAMIENTO: </span> <span>' . $tipo_financiamiento . ' </span></div>';
    if($tipo_financiamiento == 'monetario'){
        echo '<div role="fila"> <span>MONTO: </span> <span>' . $monto . ' </span></div>';
    }
    if(strlen($observaciones) !== 0 ){
        echo '<div role="fila"> <span>OBSERVACIONES: </span> <span>' . $observaciones . ' </span></div>';
    }
}
echo "<br> <br>";
echo '</div>';
?>