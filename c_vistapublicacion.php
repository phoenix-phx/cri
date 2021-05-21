<?php 
//session_start();
require_once "c_pdo.php";
require_once "Publicacion.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['pub_id'])) {
    if($_SESSION['permisos'] === 'investigador'){
        $_SESSION['error'] = "Codigo de publicacion faltante";
        header('Location: listaPub_investigador.php');
        return;
    }
    else if($_SESSION['permisos'] === 'administrativo'){
        $_SESSION['error'] = "Codigo de publicacion faltante";
        header('Location: listaPub_admin.php');
        return;
    }
}

if($_SESSION['permisos'] === 'investigador'){
    $pub = new Publicacion();
    $estado = $pub->loadDetalles($_SESSION['idUsuario'], $_REQUEST['pub_id'], $_SESSION['permisos'], $pdo);
    if($estado === false){
        $_SESSION['error'] = 'No se pudo cargar la publicacion';
        header('Location: listaPub_investigador.php');
        return;
    }

    // cargar detalles generales
    $codigo = htmlentities($pub->getCodigo());
    $titulo = htmlentities($pub->getTitulo());
    $resumen = htmlentities($pub->getResumen());
    $tipo = htmlentities($pub->getTipo());
    $ui = htmlentities($pub->getUnidadInvestigacion());
    $li = htmlentities($pub->getLineaInvestigacion());
    $apa = htmlentities($pub->getApa());
    $est = htmlentities($pub->getEstado());
    $investigacion = htmlentities($pub->getIdInv());
    $flag = false;
    if(strlen($investigacion) !== 0){
        $nombreInv = $pub->getNombreInv();
        $flag = true;
    }

    // cargar autor principal
    $principal = $pub->loadAutorPrincipal($pdo, $_REQUEST['pub_id']);

    // cargar autores internos
    $internos = $pub->loadAutorInterno($pdo, $_REQUEST['pub_id']);

    // cargar autores externos
    $externos = $pub->loadAutorExterno($pdo, $_REQUEST['pub_id']);

    //datos generales
    echo "<p><b>DATOS GENERALES</b></p>";
    echo '<div role="container">' . "\n";
    echo '<div role="fila"> <span>C&Oacute;DIGO: </span> <span>' . $codigo . ' </span></div>';
    echo '<div role="fila"> <span>TITULO: </span> <span>' . $titulo . ' </span></div>';
    echo '<div role="fila"> <span>RESUMEN: </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>LINEA DE INVESTIGACI&Oacute;N: </span> <span>' . $li . '</span></div>';
    echo '<div role="fila"> <span>UNIDAD DE INVESTIGACI&Oacute;N: </span> <span>' . $ui . ' </span></div>';    
    echo '<div role="fila"> <span>TIPO PUBLICACI&Oacute;N: </span> <span>' . $tipo . ' </span></div>';
    echo '<div role="fila"> <span>CITATI&Oacute;N: </span> <span>' . $apa . ' </span></div>';
    if($flag === true){
        echo '<div role="fila"> <span>INVESTIGACI&Oacute;N ASOCIADA: </span> <span>' . $nombreInv . ' </span></div>';
    }
    else{
        echo '<div role="fila"> <span>INVESTIGACI&Oacute;N ASOCIADA: </span> <span><i>' . 'No existe investigaci&oacute;n asociada' . '</i></span></div>';
    }

    //autores
    echo "<br>";
    echo "<span><b>AUTORES</b></span>";
    echo '<span> <a href="ver_autor_inv.php?type=pub&pub_id='. $_REQUEST['pub_id'] . '">Ver detalles</a></span>';
    echo '<div role="fila" id="autores">';
    echo '<ul>';
    if($principal !== false){
        echo '<li>' . htmlentities($principal['nombre']) . ' </li>';

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

    echo "<p><b>ENTREGA FINAL</b></p>";
    echo '<div role="fila" id="archivo">';
    $estado = $pub->existsDoc($_REQUEST['pub_id'], $pdo);
    if($estado === false){
        echo '<span>No se ha registrado la entrega del documento final </span>';
    }
    else{
        $doc = $pub->loadDoc($_REQUEST['pub_id'], $pdo);
        echo '<a target="_blank" href="view.php?pub_id='.$_REQUEST['pub_id'].'">'.$doc['nombre'].'</a>';

        echo "<p><b>REVISIÓN</b></p>";
        echo '<div role="fila" id="feedback">';
        if(strlen($doc['feedback']) === 0){
            echo '<span>No se ha registrado la retroalimentaci&oacute;n del documento </span>';
        }
        else{
            echo '<span>'.$doc['feedback'].'</span>';
        }
    }
    
    echo "</div>";
}
else if($_SESSION['permisos'] === 'administrativo'){
    $pub = new Publicacion();
    $estado = $pub->loadDetalles($_SESSION['idUsuario'], $_REQUEST['pub_id'], $_SESSION['permisos'], $pdo);
    if($estado === false){
        $_SESSION['error'] = 'No se pudo cargar la publicaci&oacute;n';
        header('Location: listaPub_admin.php');
        return;
    }

    // cargar detalles generales
    $codigo = htmlentities($pub->getCodigo());
    $titulo = htmlentities($pub->getTitulo());
    $resumen = htmlentities($pub->getResumen());
    $ui = htmlentities($pub->getUnidadInvestigacion());
    $li = htmlentities($pub->getLineaInvestigacion());
    $apa = htmlentities($pub->getApa());
    $est = htmlentities($pub->getEstado());
    $tipo = htmlentities($pub->getTipo());
    $investigacion = htmlentities($pub->getIdInv());
    $flag = false;
    if(strlen($investigacion) !== 0){
        $nombreInv = $pub->getNombreInv();
        $flag = true;
    }

    // cargar autor principal
    $principal = $pub->loadAutorPrincipal($pdo, $_REQUEST['pub_id']);

    // cargar autores internos
    $internos = $pub->loadAutorInterno($pdo, $_REQUEST['pub_id']);

    // cargar autores externos
    $externos = $pub->loadAutorExterno($pdo, $_REQUEST['pub_id']);

    // documento
    $estado = $pub->existsDoc($_REQUEST['pub_id'], $pdo);
    
    /*
    //datos generales
    echo "<p><b>DATOS GENERALES</b></p>";
    echo '<div role="container">' . "\n";
    echo '<div role="fila"> <span>C&Oacute;DIGO: </span> <span>' . $codigo . ' </span></div>';
    echo '<div role="fila"> <span>TITULO: </span> <span>' . $titulo . ' </span></div>';
    echo '<div role="fila"> <span>RESUMEN: </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>UNIDAD DE INVESTIGACI&Oacute;N: </span> <span>' . $ui . ' </span></div>';
    echo '<div role="fila"> <span>TIPO PUBLICACI&Oacute;N: </span> <span>' . $tipo . ' </span></div>';
    if($flag){
        echo '<div role="fila"> <span>INVESTIGACI&Oacute;N ASOCIADA: </span> <span>' . $nombreInv . ' </span></div>';
    }
    else{
        echo '<div role="fila"> <span>INVESTIGACI&Oacute;N ASOCIADA: </span> <span><i>' . 'No existe investigaci&oacute;n asociada' . '</i></span></div>';
    }
    //autores
    echo "<br>";
    echo "<span><b>AUTORES</b></span>";
    echo '<span> <a href="ver_autor_admin.php?type=pub&pub_id='. $_REQUEST['pub_id'] . '">Ver detalles</a></span>';
    echo '<div role="fila" id="autores">';
    echo '<ul>';
    if($principal !== false){
        echo '<li>' . htmlentities($principal['nombre']) . ' </li>';
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

    // archivo final
    echo "<p><b>ENTREGA FINAL</b></p>";
    echo '<div role="fila" id="archivo" style="padding-left:10px;">';
    $estado = $pub->existsDoc($_REQUEST['pub_id'], $pdo);
    if($estado === false){
        echo '<span>No se ha registrado la entrega del documento final </span>';
    }
    else{
        $doc = $pub->loadDoc($_REQUEST['pub_id'], $pdo);
        echo '<a target="_blank" href="view.php?pub_id='.$_REQUEST['pub_id'].'">'.$doc['nombre'].'</a>';
    }

    echo "</div>";
    */
}
?>