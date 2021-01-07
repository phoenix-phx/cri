<?php 
session_start();
require_once "c_pdo.php";
require_once "Autor.php";
require_once "AutorInterno.php";
require_once "AutorExterno.php";

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

if($_REQUEST['type'] === 'inv'){
    echo "<p><b>DETALLES DE FINANCIAMIENTO:</b><p>";
    $test = new Autor();
    $tipo = $test->testAutorPrincipal($_REQUEST['inv_id'], $pdo, 'investigacion');
    
    echo '<div role="container">' . "\n";
    if($tipo !== false){
        if($tipo['universidad'] === null){
            $auth = new AutorInterno();
            $auth->loadData($_REQUEST['inv_id'], $pdo, 'investigacion');
            $pautor_id = htmlentities($auth->getId());
            $pnombre = htmlentities($auth->getNombre());
            $tipo_filiacion = htmlentities($auth->getTipoFiliacion());
            $rol = htmlentities($auth->getRol());
            $unidad_investigacion = htmlentities($auth->getUnidadInvestigacion());
            $filiacion = htmlentities($auth->getFiliacion());

            echo '<div role="fila"> <span>TIPO DE AUTOR: </span> <span><b><i>' . $rol . '</i></b></span></div>';
            echo '<div role="fila"> <span>NOMBRE: </span> <span>' . $pnombre . ' </span></div>';
            echo '<div role="fila"> <span>TIPO DE FILIACION: </span> <span>' . $tipo_filiacion . ' </span></div>';
            echo '<div role="fila"> <span>UNIDAD DE INVESTIGACION: </span> <span>' . $unidad_investigacion . ' </span></div>';
            echo '<div role="fila"> <span>FILIACION: </span> <span>' . $filiacion . ' </span></div>';
        }
        else if($tipo['universidad'] !== null){
            $auth = new AutorExterno();
            $auth->loadData($_REQUEST['inv_id'], $pdo, 'investigacion');
            $pautor_id = htmlentities($auth->getId());
            $pnombre = htmlentities($auth->getNombre());
            $tipo_filiacion = htmlentities($auth->getTipoFiliacion());
            $rol = htmlentities($auth->getRol());
            $universidad = htmlentities($auth->getUniversidad());

            echo '<div role="fila"> <span>TIPO DE AUTOR: </span> <span><b><i>' . $rol . '</i></b></span></div>';
            echo '<div role="fila"> <span>NOMBRE: </span> <span>' . $pnombre . ' </span></div>';
            echo '<div role="fila"> <span>TIPO DE FILIACION: </span> <span>' . $tipo_filiacion . ' </span></div>';
            echo '<div role="fila"> <span>UNIVERSIDAD: </span> <span>' . $universidad . ' </span></div>';
        }
    }
    echo "<br> <br>";

    // autores de colaboracion
    $auths = new Autor();
    $investigadores = $auths->loadAutores($pdo, $_REQUEST['inv_id'], 'investigacion');

    if(count($investigadores) !== 0){
        for ($i=0; $i < count($investigadores); $i++) {
            if($investigadores[$i]['universidad'] === null){
                $pautor_id = htmlentities($investigadores[$i]['idAutor']);
                $pnombre = htmlentities($investigadores[$i]['nombre']);
                $tipo_filiacion = htmlentities($investigadores[$i]['tipo_filiacion']);
                $rol = htmlentities($investigadores[$i]['rol']);
                $unidad_investigacion = htmlentities($investigadores[$i]['unidad_investigacion']);
                $filiacion = htmlentities($investigadores[$i]['filiacion']);

                echo '<div role="fila"> <span>TIPO DE AUTOR: </span> <span><b><i>' . $rol . '</i></b></span></div>';
                echo '<div role="fila"> <span>NOMBRE: </span> <span>' . $pnombre . ' </span></div>';
                echo '<div role="fila"> <span>TIPO DE FILIACION: </span> <span>' . $tipo_filiacion . ' </span></div>';
                echo '<div role="fila"> <span>UNIDAD DE INVESTIGACION: </span> <span>' . $unidad_investigacion . ' </span></div>';
                echo '<div role="fila"> <span>FILIACION: </span> <span>' . $filiacion . ' </span></div>';
            }
            else if($investigadores[$i]['universidad'] !== null){
                $pautor_id = htmlentities($investigadores[$i]['idAutor']);
                $pnombre = htmlentities($investigadores[$i]['nombre']);
                $tipo_filiacion = htmlentities($investigadores[$i]['tipo_filiacion']);
                $rol = htmlentities($investigadores[$i]['rol']);
                $universidad = htmlentities($investigadores[$i]['universidad']);

                echo '<div role="fila"> <span>TIPO DE AUTOR: </span> <span><b><i>' . $rol . '</i></b></span></div>';
                echo '<div role="fila"> <span>NOMBRE: </span> <span>' . $pnombre . ' </span></div>';
                echo '<div role="fila"> <span>TIPO DE FILIACION: </span> <span>' . $tipo_filiacion . ' </span></div>';
                echo '<div role="fila"> <span>UNIVERSIDAD: </span> <span>' . $universidad . ' </span></div>';
            }
            echo "<br><br>";
        }
    }
    echo '</div>';
}   
else if($_REQUEST['type'] === 'pub'){
    echo "<p><b>AUTORES:</b><p>";
    $test = new Autor();
    $tipo = $test->testAutorPrincipal($_REQUEST['pub_id'], $pdo, 'publicacion');
    
    echo '<div role="container">' . "\n";
    if($tipo !== false){
        if($tipo['universidad'] === null){
            $auth = new AutorInterno();
            $auth->loadData($_REQUEST['pub_id'], $pdo, 'publicacion');
            $pautor_id = htmlentities($auth->getId());
            $pnombre = htmlentities($auth->getNombre());
            $tipo_filiacion = htmlentities($auth->getTipoFiliacion());
            $rol = htmlentities($auth->getRol());
            $unidad_investigacion = htmlentities($auth->getUnidadInvestigacion());
            $filiacion = htmlentities($auth->getFiliacion());

            echo '<div role="fila"> <span>TIPO DE AUTOR: </span> <span><b><i>' . $rol . '</i></b></span></div>';
            echo '<div role="fila"> <span>NOMBRE: </span> <span>' . $pnombre . ' </span></div>';
            echo '<div role="fila"> <span>TIPO DE FILIACION: </span> <span>' . $tipo_filiacion . ' </span></div>';
            echo '<div role="fila"> <span>UNIDAD DE INVESTIGACION: </span> <span>' . $unidad_investigacion . ' </span></div>';
            echo '<div role="fila"> <span>FILIACION: </span> <span>' . $filiacion . ' </span></div>';
        }
        else if($tipo['universidad'] !== null){
            $auth = new AutorExterno();
            $auth->loadData($_REQUEST['pub_id'], $pdo, 'publicacion');
            $pautor_id = htmlentities($auth->getId());
            $pnombre = htmlentities($auth->getNombre());
            $tipo_filiacion = htmlentities($auth->getTipoFiliacion());
            $rol = htmlentities($auth->getRol());
            $universidad = htmlentities($auth->getUniversidad());

            echo '<div role="fila"> <span>TIPO DE AUTOR: </span> <span><b><i>' . $rol . '</i></b></span></div>';
            echo '<div role="fila"> <span>NOMBRE: </span> <span>' . $pnombre . ' </span></div>';
            echo '<div role="fila"> <span>TIPO DE FILIACION: </span> <span>' . $tipo_filiacion . ' </span></div>';
            echo '<div role="fila"> <span>UNIVERSIDAD: </span> <span>' . $universidad . ' </span></div>';
        }
    }
    echo "<br> <br>";

    // autores de colaboracion
    $auths = new Autor();
    $investigadores = $auths->loadAutores($pdo, $_REQUEST['pub_id'], 'publicacion');

    if(count($investigadores) !== 0){
        for ($i=0; $i < count($investigadores); $i++) {
            if($investigadores[$i]['universidad'] === null){
                $pautor_id = htmlentities($investigadores[$i]['idAutor']);
                $pnombre = htmlentities($investigadores[$i]['nombre']);
                $tipo_filiacion = htmlentities($investigadores[$i]['tipo_filiacion']);
                $rol = htmlentities($investigadores[$i]['rol']);
                $unidad_investigacion = htmlentities($investigadores[$i]['unidad_investigacion']);
                $filiacion = htmlentities($investigadores[$i]['filiacion']);

                echo '<div role="fila"> <span>TIPO DE AUTOR: </span> <span><b><i>' . $rol . '</i></b></span></div>';
                echo '<div role="fila"> <span>NOMBRE: </span> <span>' . $pnombre . ' </span></div>';
                echo '<div role="fila"> <span>TIPO DE FILIACION: </span> <span>' . $tipo_filiacion . ' </span></div>';
                echo '<div role="fila"> <span>UNIDAD DE INVESTIGACION: </span> <span>' . $unidad_investigacion . ' </span></div>';
                echo '<div role="fila"> <span>FILIACION: </span> <span>' . $filiacion . ' </span></div>';
            }
            else if($investigadores[$i]['universidad'] !== null){
                $pautor_id = htmlentities($investigadores[$i]['idAutor']);
                $pnombre = htmlentities($investigadores[$i]['nombre']);
                $tipo_filiacion = htmlentities($investigadores[$i]['tipo_filiacion']);
                $rol = htmlentities($investigadores[$i]['rol']);
                $universidad = htmlentities($investigadores[$i]['universidad']);

                echo '<div role="fila"> <span>TIPO DE AUTOR: </span> <span><b><i>' . $rol . '</i></b></span></div>';
                echo '<div role="fila"> <span>NOMBRE: </span> <span>' . $pnombre . ' </span></div>';
                echo '<div role="fila"> <span>TIPO DE FILIACION: </span> <span>' . $tipo_filiacion . ' </span></div>';
                echo '<div role="fila"> <span>UNIVERSIDAD: </span> <span>' . $universidad . ' </span></div>';
            }
            echo "<br><br>";
        }
    }
    echo '</div>';
}
?>