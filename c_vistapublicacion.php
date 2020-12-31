<?php 
session_start();
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

    // cargar autor principal
    $principal = $pub->loadAutorPrincipal($pdo, $_REQUEST['pub_id']);

    // cargar autores internos
    $internos = $pub->loadAutorInterno($pdo, $_REQUEST['pub_id']);

    // cargar autores externos
    $externos = $pub->loadAutorExterno($pdo, $_REQUEST['pub_id']);

    //datos generales
    echo '<div role="container">' . "\n";
    echo '<div role="fila"> <span>CODIGO: </span> <span>' . $codigo . ' </span></div>';
    echo '<div role="fila"> <span>TITULO: </span> <span>' . $titulo . ' </span></div>';
    echo '<div role="fila"> <span>RESUMEN: </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>TIPO PUBLICACION: : </span> <span>' . $tipo . ' </span></div>';

    //autores
    echo "<p>AUTORES</p>";
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
    echo "<p>ENTREGA FINAL</p>";
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

    // cargar autor principal
    $principal = $pub->loadAutorPrincipal($pdo, $_REQUEST['pub_id']);

    // cargar autores internos
    $internos = $pub->loadAutorInterno($pdo, $_REQUEST['pub_id']);

    // cargar autores externos
    $externos = $pub->loadAutorExterno($pdo, $_REQUEST['pub_id']);

    //datos generales
    echo '<div role="container">' . "\n";
    echo '<div role="fila"> <span>Codigo</span> <span>' . $codigo . ' </span></div>';
    echo '<div role="fila"> <span>Titulo</span> <span>' . $titulo . ' </span></div>';
    echo '<div role="fila"> <span>Resumen </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>Tipo de publicacion </span> <span>' . $tipo . ' </span></div>';

    //autores
    echo "<p>AUTORES</p>";
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
    echo "<p>ENTREGA FINAL</p>";
    echo '<div role="fila" id="archivo">';
    if($pub->getDocumento() !== null){
        echo htmlentities($pub->getDocumento());
    }
    else{
        echo "No se ha registrado la entrega de un documento final";
    }

    echo "</div>";
}
?>