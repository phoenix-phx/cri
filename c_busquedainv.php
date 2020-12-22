<?php 
session_start();
require_once "c_pdo.php";


if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if(isset($_POST['txtFiltroBI']) && isset($_POST['filtroBI']) ){
    if($_POST['filtroBI'] === 'Ninguno'){
        $sql = 'SELECT codigo, nombre_corto, unidad_investigacion, idInv 
                FROM investigacion';    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
    else if ($_POST['filtroBI'] === 'Unidad de Investigacion') {
        if(strlen($_POST['txtFiltroBI']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_investigacion.php");
            return;
        }
        else{
                $sql = 'SELECT codigo, nombre_corto,    unidad_investigacion, idInv 
                        FROM investigacion
                        WHERE unidad_investigacion = :ui';    
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':ui' => strtolower($_POST['txtFiltroBI'])
                ));
        }
    }
    else if ($_POST['filtroBI'] === 'Nombre Investigacion') {
        if(strlen($_POST['txtFiltroBI']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_investigacion.php");
            return;
        }
        else{
                $sql = 'SELECT codigo, nombre_corto,    unidad_investigacion, idInv 
                        FROM investigacion
                        WHERE nombre = :no
                        OR nombre_corto = :nc';    
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':no' => strtolower($_POST['txtFiltroBI']),
                    ':nc' => strtolower($_POST['txtFiltroBI'])
                ));
        }
    }
    else if ($_POST['filtroBI'] === 'Codigo Investigacion') {
        if(strlen($_POST['txtFiltroBI']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_investigacion.php");
            return;
        }
        else{
                $sql = 'SELECT codigo, nombre_corto,    unidad_investigacion, idInv 
                        FROM investigacion
                        WHERE codigo = :cd';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':cd' => $_POST['txtFiltroBI']
                ));
        }
    }
    else if ($_POST['filtroBI'] === 'Nombre Investigador') {
        if(strlen($_POST['txtFiltroBI']) < 1 ){
            $_SESSION['error'] = 'Debe llenar un criterio de busqueda para el filtro';
            header("Location: buscar_investigacion.php");
            return;
        }
        else{
            $sql = 'SELECT i.codigo, i.nombre_corto, i.unidad_investigacion, i.idInv
                    FROM investigacion i, colaborador_inv ci, autor a
                    WHERE a.idAutor = ci.idAutor
                    AND ci.idInv = i.idInv
                    AND a.nombre = :no';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':no' => $_POST['txtFiltroBI']
            ));
        }
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row !== false){
        do{
            echo '<div role="table">' . "\n";
            echo '<div role="cabecera"> <span>Codigo</span> </div>';
            echo '<div role="cabecera"> <span>Nombre Corto</span> </div>';
            echo '<div role="cabecera"> <span>Unidad de Investigacion</span> </div>';
                
            echo '<div role="fila">';
            echo '<div role="celda"> <span>' . htmlentities($row['codigo']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($row['nombre_corto']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($row['unidad_investigacion']) . '</span> </div>';
            echo '<a href="detalles_investigacion_admin.php?inv_id='.$row['idInv'].'">&gt&gt</a>'; echo "</td>";
            echo "</div>\n";

            echo "</div>";
            echo "<br /> <br />";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
    }
    else if ($row === false) {
        echo "No se encontraron resultados a su busqueda";
    }
    echo "<br />";   
}
?>