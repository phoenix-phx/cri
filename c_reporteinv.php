<?php 
session_start();
require_once "c_pdo.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if(isset($_POST['uniInvRI']) && isset($_POST['nomInvRI']) && isset($_POST['anioCreacionRI'])){
    $unidad_investigacion = ($_POST['uniInvRI'] === 'Todos') ? false : true;
    $investigador = ($_POST['nomInvRI'] === 'Todos') ? false : true;
    $estado = ($_POST['estadoRI'] === 'Todos') ? false : true;
    $financiamiento = ($_POST['financiamientoRI'] === 'Todos') ? false : true;
    $creacion = ($_POST['anioCreacionRI'] === 'Todos') ? false : true;
    
    if($unidad_investigacion || $investigador || $estado || $financiamiento || $creacion){
        $kvp = array();
        $select = 'SELECT i.codigo, i.nombre_corto, i.unidad_investigacion, i.idInv'."\n";
        $from = 'FROM investigacion i'."\n";
        $where = 'WHERE ';
        $isWhere = false;
        if($unidad_investigacion){
            if($isWhere){
                $where = $where . 'AND i.unidad_investigacion = :ui'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.unidad_investigacion = :ui'."\n";
                $isWhere = true;
            }
            $kvp[':ui'] = $_POST['uniInvRI'];
        }
        if($estado){
            if($isWhere){
                $where = $where . 'AND i.estado = :st'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.estado = :st'."\n";
                $isWhere = true;
            }
            $kvp[':st'] = $_POST['estadoRI'];
        }
        if($financiamiento){
            $from = $from . ', financiador f'."\n";
            if($isWhere){
                $where = $where . 'AND i.idInv = f.idInv AND f.tipo_financiador = :tf'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.idInv = f.idInv AND f.tipo_financiador = :tf'."\n";
                $isWhere = true;
            }
            $kvp[':tf'] = $_POST['financiamientoRI'];
        }
        if($creacion){
            if($isWhere){
                $where = $where . 'AND year(i.fecha_inicio) = :anio'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'year(i.fecha_inicio) = :anio'."\n";
                $isWhere = true;
            }
            $kvp[':anio'] = $_POST['anioCreacionRI'];
        }
        if($investigador){
            $from = $from . ', autor a, colaborador_inv ci'."\n";
            if($isWhere){
                $where = $where . 'AND i.idInv = ci.idInv AND ci.idAutor = a.idAutor AND a.nombre = :nm'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.idInv = ci.idInv AND ci.idAutor = a.idAutor AND a.nombre = :nm'."\n";
                $isWhere = true;
            }
            $kvp[':nm'] = $_POST['nomInvRI'];
        }
        $sql = $select . $from . $where;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($kvp);
        
        $counting = 'SELECT count(*) AS conteo'. "\n";
        $counting = $counting . $from . $where;
        $number = $pdo->prepare($counting);
        $number->execute($kvp);
    }
    else{
        $counting = 'SELECT count(*) AS conteo
                     FROM investigacion';
        $number = $pdo->prepare($counting);
        $number->execute();

        $sql = 'SELECT codigo, nombre_corto, unidad_investigacion, idInv 
                FROM investigacion';    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();    
    }
    $n = $number->fetch(PDO::FETCH_ASSOC);
    echo "<h2> Resultados </h2>";
    echo "<span> Total de investigaciones registradas: </span>";
    echo $n['conteo'];
    echo "<br/> <br/> <br/>";
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row !== false){
        echo '<div role="table">' . "\n";
        echo '<div role="cabecera"> <span>Codigo</span> </div>';
        echo '<div role="cabecera"> <span>Nombre Corto</span> </div>';
        echo '<div role="cabecera"> <span>Unidad de Investigacion</span> </div>';
        do{
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
    echo "<br />";   
}
?>