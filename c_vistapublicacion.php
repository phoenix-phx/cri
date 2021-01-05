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
    echo '<div role="fila"> <span>CODIGO: </span> <span>' . $codigo . ' </span></div>';
    echo '<div role="fila"> <span>TITULO: </span> <span>' . $titulo . ' </span></div>';
    echo '<div role="fila"> <span>RESUMEN: </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>TIPO PUBLICACION: </span> <span>' . $tipo . ' </span></div>';
    if($flag === true){
        echo '<div role="fila"> <span>INVESTIGACION ASOCIADA: </span> <span>' . $nombreInv . ' </span></div>';
    }
    else{
        echo '<div role="fila"> <span>INVESTIGACION ASOCIADA: </span> <span><i>' . 'no existe investigacion asociada' . '</i></span></div>';
    }

    //autores
    echo "<br>";
    echo "<span><b>AUTORES</b></span>";
    echo '<span> <a href="autores.php?pub_id='. $_REQUEST['pub_id'] . '">Ver detalles</a></span>';
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
    // TODO: arreglar la carga y visualizacion del BLOB
    echo "<p><b>ENTREGA FINAL</b></p>";
    echo '<div role="fila" id="archivo">';
    if($pub->getDocumento() !== null){
        echo htmlentities($pub->getDocumento());
    }
    else{
        echo '<span>No se ha registrado la entrega del documento final </span>';
    }
    echo "</div>";
}
else if($_SESSION['permisos'] === 'administrativo'){
    $pub = new Publicacion();
    $estado = $pub->loadDetalles($_SESSION['idUsuario'], $_REQUEST['pub_id'], $_SESSION['permisos'], $pdo);
    if($estado === false){
        $_SESSION['error'] = 'No se pudo cargar la publicacion';
        header('Location: listaPub_admin.php');
        return;
    }

    // cargar detalles generales
    $codigo = htmlentities($pub->getCodigo());
    $titulo = htmlentities($pub->getTitulo());
    $resumen = htmlentities($pub->getResumen());
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

    //datos generales
    echo "<p><b>DATOS GENERALES</b></p>";
    echo '<div role="container">' . "\n";
    echo '<div role="fila"> <span>CODIGO: </span> <span>' . $codigo . ' </span></div>';
    echo '<div role="fila"> <span>TITULO: </span> <span>' . $titulo . ' </span></div>';
    echo '<div role="fila"> <span>RESUMEN: </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>TIPO PUBLICACION: </span> <span>' . $tipo . ' </span></div>';
    if($flag){
        echo '<div role="fila"> <span>INVESTIGACION ASOCIADA: </span> <span>' . $nombreInv . ' </span></div>';
    }
    else{
        echo '<div role="fila"> <span>INVESTIGACION ASOCIADA: </span> <span><i>' . 'no existe investigacion asociada' . '</i></span></div>';
    }
    //autores
    echo "<br>";
    echo "<span><b>AUTORES</b></span>";
    echo '<span> <a href="autores.php?pub_id='. $_REQUEST['pub_id'] . '">Ver detalles</a></span>';
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
    // TODO: arreglar la carga y visualizacion del BLOB
    echo "<p><b>ENTREGA FINAL</b></p>";
    echo '<div role="fila" id="archivo" style="padding-left:10px;">';
    if($pub->getDocumento() !== null){
        echo htmlentities($pub->getDocumento());
    }
    else{
        echo "No se ha registrado la entrega de un documento final";
    }

    echo "</div>";
}
?>