<?php 
session_start();
require_once "c_pdo.php";


if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['pub_id'])) {
    $_SESSION['error'] = "Codigo de publicacion faltante";
    header('Location: listaPub_investigador.php');
    return;
}

$sql = 'SELECT * 
    	FROM publicacion
		WHERE idUsuario = :id
        AND idPub = :pub'; 
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
   ':id' => $_SESSION['idUsuario'],
   ':pub' => $_REQUEST['pub_id']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row === false){
    $_SESSION['error'] = 'No se pudo cargar la publicacion';
    header('Location: listaPub_investigador.php');
    return;
}

$codigo = htmlentities($row['codigo']);
$titulo = htmlentities($row['titulo']);
$resumen = htmlentities($row['resumen']);
$tipo = htmlentities($row['tipo']);

function loadAutorPrincipal($pdo, $pub_id){
    $sql = "SELECT autor.nombre 
            FROM autor, colaborador_pub cp, publicacion p
            WHERE p.idPub = :pub
            AND p.idPub = cp.idPub
            AND autor.idAutor = cp.idAutor
            AND autor.rol = 'principal'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':pub' => $pub_id
    ));
    $principal = $stmt->fetch(PDO::FETCH_ASSOC);
    return $principal;
}
$principal = loadAutorPrincipal($pdo, $_REQUEST['pub_id']);

function loadAutorInterno($pdo, $pub_id){
    $sql = "SELECT autor.nombre 
            FROM autor, colaborador_pub cp, publicacion p
            WHERE p.idPub = :pub
            AND p.idPub = cp.idPub
            AND autor.idAutor = cp.idAutor
            AND autor.rol = 'colaboracion'
            AND autor.tipo_filiacion = 'interno'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':pub' => $pub_id
    ));
    $internos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $internos;
}
$internos = loadAutorInterno($pdo, $_REQUEST['pub_id']);

function loadAutorExterno($pdo, $pub_id){
    $sql = "SELECT autor.nombre 
            FROM autor, colaborador_pub cp, publicacion p
            WHERE p.idPub = :pub
            AND p.idPub = cp.idPub
            AND autor.idAutor = cp.idAutor
            AND autor.rol = 'colaboracion'
            AND autor.tipo_filiacion = 'externo'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':pub' => $pub_id
    ));
    $externos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $externos;
}
$externos = loadAutorExterno($pdo, $_REQUEST['pub_id']);

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
if($row['documento_final'] !== false){
    echo htmlentities($row['documento_final']);
}
echo "</div>";

?>