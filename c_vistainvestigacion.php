<?php 
//session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['inv_id'])) {
    if($_SESSION['permisos'] === 'investigador'){
        $_SESSION['error'] = "Codigo de investigacion faltante";
        header('Location: listaInv_investigador.php');
        return;
    }
    else if($_SESSION['permisos'] === 'administrativo'){
        $_SESSION['error'] = "Codigo de investigacion faltante";
        header('Location: listaInv_admin.php');
        return;        
    }
}

if($_SESSION['permisos'] === 'investigador'){
    $inv = new Investigacion();

    // cargar detalles generales
    $estado = $inv->loadDetalles($_SESSION['idUsuario'], $_REQUEST['inv_id'], $_SESSION['permisos'], $pdo);
    if($estado === false){
        $_SESSION['error'] = 'No se pudo cargar la investigacion';
        header('Location: listaInv_investigador.php');
        return;
    }
    $codigo = htmlentities($inv->getCodigo());
    $titulo = htmlentities($inv->getTitulo());
    $nc = htmlentities($inv->getNombreCorto());
    $ui = htmlentities($inv->getUnidadInvestigacion());
    $resumen = htmlentities($inv->getResumen());
    $finicio = htmlentities($inv->getFechaInicio());
    $ffinal = htmlentities($inv->getFechaFinal());

    // cargar autor principal
    $principal = $inv->loadAutorPrincipal($pdo, $_REQUEST['inv_id']);

    // cargar autores internos
    $internos = $inv->loadAutorInterno($pdo, $_REQUEST['inv_id']);

    // cargar autores externos
    $externos = $inv->loadAutorExterno($pdo, $_REQUEST['inv_id']);

    // cargar financiamiento
    $financiador = $inv->loadFinanciamiento($pdo, $_REQUEST['inv_id']);

    // cargar actividades
    $actividades = $inv->loadActividad($pdo, $_REQUEST['inv_id']);

    //MOSTRAR
    //datos generales
    echo "<p><b>DATOS GENERALES:</b><p>";
    echo '<div role="container">' . "\n";
    echo '<div role="fila"> <span>CODIGO: </span> <span>' . $codigo . ' </span></div>';
    echo '<div role="fila"> <span>TITULO: </span> <span>' . $titulo . ' </span></div>';
    echo '<div role="fila"> <span>NOMBRE CORTO: </span> <span>' . $nc . ' </span></div>';
    echo '<div role="fila"> <span>UNIDAD DE INVESTIGACION: </span> <span>' . $ui . ' </span></div>';
    echo '<div role="fila"> <span>RESUMEN: </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>FECHA INICIO: </span> <span>' . $finicio . ' </span></div>';
    echo '<div role="fila"> <span>FECHA FINAL: </span> <span>' . $ffinal . ' </span></div>';

    //autores
    echo "<br>";
    echo '<div role="fila" id="autores">';
    echo "<span><b>INVESTIGADORES:</b><span>";
    echo '<span> <a href="autores.php?type=inv&inv_id='. $_REQUEST['inv_id'] . '">Ver detalles</a></span>';
    echo '<ul>';
    if($principal !== false){
        echo '<li>' . htmlentities($principal['nombre']) . '</li>';
    }
    if(count($internos) !== 0){
        for ($i=0; $i < count($internos); $i++) {
            echo '<li>' . htmlentities($internos[$i]['nombre']) . '</li>'; 
        }
    }
    if(count($externos) !== 0){
        for ($i=0; $i < count($externos); $i++) {
            echo '<li>' . htmlentities($externos[$i]['nombre']) . '</li>'; 
        }
    }
    echo '</ul>';
    echo '</div>';

    //financiamiento
    echo "<p><b>FINANCIAMIENTO</b></p>";
    echo '<div role="fila" style="padding-left:10px;">';
    if($financiador !== false){
        echo '<span>' . htmlentities($financiador['nombre_financiador']) . ' </span> ';
        echo '<span> <a href="financiamiento.php?fin_id='. $financiador['idFinanciador'] . '">Ver detalles</a></span>';
    }
    else{
        echo '<span>No existe financiamiento</span>';   
    }
    echo "</div>";

    //actividades
    echo "<p><b>ACTIVIDADES</b></p>";
    echo '<div role="fila" id="actividades" style="padding-left:10px;">';
    if(count($actividades) !== 0){
        for ($i=0; $i < count($actividades); $i++) {
            echo '<div id="actividad' . ($i+1) .'">';
            echo '<p> <span> NOMBRE:  </span> <span>' . htmlentities($actividades[$i]['nombre']) . '</span>';
            echo "<br>";
            echo '<span> FECHA INICIO: </span> <span>' . htmlentities($actividades[$i]['fecha_inicio']) . '</span>';
            echo "<br>";
            echo '<span> FECHA FINALIZACION: </span> <span>' . htmlentities($actividades[$i]['fecha_final']) . '</span> <p>';
            echo "</div>";
        }
    }
    else{
        echo "<span>No se han registrado actividades</span>";
    }
    echo '</div>';

    //publicaciones
    echo '<br><p><b> PUBLICACIONES </b></p>';
    $estado = $inv->loadPubAsociadas($_SESSION['idUsuario'], $_SESSION['permisos'], $pdo);
    if($estado === false){
        echo '<span>No existen publicaciones asociadas registradas </span>';
    }
    
}
else if($_SESSION['permisos'] === 'administrativo'){
    $inv = new Investigacion();
    $estado = $inv->loadDetalles($_SESSION['idUsuario'], $_REQUEST['inv_id'], $_SESSION['permisos'], $pdo);
    if($estado === false){
        $_SESSION['error'] = 'No se pudo cargar la investigacion';
        header('Location: listaInv_admin.php');
        return;
    }

    $codigo = htmlentities($inv->getCodigo());
    $titulo = htmlentities($inv->getTitulo());
    $nc = htmlentities($inv->getNombreCorto());
    $ui = htmlentities($inv->getUnidadInvestigacion());
    $resumen = htmlentities($inv->getResumen());
    $finicio = htmlentities($inv->getFechaInicio());
    $ffinal = htmlentities($inv->getFechaFinal());

    // cargar autor principal
    $principal = $inv->loadAutorPrincipal($pdo, $_REQUEST['inv_id']);

    // cargar autores internos
    $internos = $inv->loadAutorInterno($pdo, $_REQUEST['inv_id']);

    // cargar autores externos
    $externos = $inv->loadAutorExterno($pdo, $_REQUEST['inv_id']);

    // cargar financiamiento
    $financiador = $inv->loadFinanciamiento($pdo, $_REQUEST['inv_id']);

    // cargar actividades
    $actividades = $inv->loadActividad($pdo, $_REQUEST['inv_id']);

    //datos generales
    echo "<p><b>DATOS GENERALES</b></p>";
    echo '<div role="container">' . "\n";
    echo '<div role="fila"> <span>CODIGO: </span> <span>' . $codigo . ' </span></div>';
    echo '<div role="fila"> <span>TITULO: </span> <span>' . $titulo . ' </span></div>';
    echo '<div role="fila"> <span>NOMBRE CORTO: </span> <span>' . $nc . ' </span></div>';
    echo '<div role="fila"> <span>UNIDAD DE INVESTIGACION: </span> <span>' . $ui . ' </span></div>';
    echo '<div role="fila"> <span>RESUMEN: </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>FECHA INICIO: </span> <span>' . $finicio . ' </span></div>';
    echo '<div role="fila"> <span>FECHA FINAL: </span> <span>' . $ffinal . ' </span></div>';    

    //autores
    echo "<br>";
    echo "<span><b>INVESTIGADORES</b></span>";
    echo '<span> <a href="autores_inv.php?inv_id='. $_REQUEST['inv_id'] . '">Ver detalles</a></span>';
    echo '<div role="fila" id="autores">';
    echo '<ul>';
    if($principal !== false){
        echo '<li>' . htmlentities($principal['nombre']) . '</li>'; 
    }
    if(count($internos) !== 0){
        for ($i=0; $i < count($internos); $i++) {
            echo '<li>' . htmlentities($internos[$i]['nombre']) . '</li>'; 
        }
    }
    if(count($externos) !== 0){
        for ($i=0; $i < count($externos); $i++) {
            echo '<li>' . htmlentities($externos[$i]['nombre']) . '</li>'; 
        }
    }
    echo '</ul>';
    echo '</div>';

    //financiamiento
    echo "<p><b>FINANCIAMIENTO</b></p>";
    echo '<div role="fila" style="padding-left:10px;">';
    if($financiador !== false){
        echo '<span>' . htmlentities($financiador['nombre_financiador']) . ' </span> <span> <a href="financiamiento.php?fin_id="' . $financiador['idFinanciador'] . '">Ver detalles</a></span>';
    }
    else{
        echo '<span>No existe financiamiento</span>';   
    }
    echo "</div>";

    //actividades
    echo "<p><b>ACTIVIDADES</b></p>";
    echo '<div role="fila" id="actividades" style="padding-left:10px;">';
    if(count($actividades) !== 0){
        for ($i=0; $i < count($actividades); $i++) {
            echo '<div id="actividad' . ($i+1) .'">';
            echo '<p> <span>NOMBRE:</span> <span>' . htmlentities($actividades[$i]['nombre']) . '</span>';
            echo "<br>";
            echo '<span>FECHA INICIO: </span> <span>' . htmlentities($actividades[$i]['fecha_inicio']) . '</span>';
            echo "<br>";
            echo '<span>FECHA FINALIZACION: </span> <span>' . htmlentities($actividades[$i]['fecha_final']) . '</span> <p>';
            echo "</div>";
        }
    }
    else{
        echo "<span>No se han registrado actividades</span>";
    }
    echo '</div>';

    //publicaciones
    echo '<br><p><b> PUBLICACIONES </b></p>';
    $estado = $inv->loadPubAsociadas($_SESSION['idUsuario'], $_SESSION['permisos'], $pdo);
    if($estado === false){
        echo 'No existen publicaciones asociadas registradas ';
    }
    echo '</div>';
}
?>