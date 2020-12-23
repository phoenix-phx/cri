<?php 
session_start();
require_once "c_pdo.php";

if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if(isset($_POST['uniInvRP']) && isset($_POST['nomInvRP']) ){
    $query = 'SELECT i.count(*), codigo, nombre_corto, unidad_investigacion, idInv
              FROM investigacion i';

    $unidad_investigacion = ($_POST['uniInvRP'] === 'Todos') ? false : true;
    $investigador = ($_POST['nomInvRP'] === 'Todos') ? false : true;
    $estado = ($_POST['estadoRP'] === 'Todos') ? false : true;
    $tipo = ($_POST['tipoCP'] === 'Todos') ? false : true;
    
    if($unidad_investigacion || $investigador || $estado || $tipo){
        $kvp = array();
        $select = 'SELECT i.codigo, i.titulo, i.tipo, i.idPub'."\n";
        $from = 'FROM publicacion i'."\n";
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
            $kvp[':ui'] = $_POST['uniInvRP'];
        }
        if($estado){
            if($isWhere){
                $where = $where . 'AND i.estado = :st'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.estado = :st'."\n";
                $isWhere = true;
            }
            $kvp[':st'] = $_POST['estadoRP'];
        }
        if($tipo){
            if($isWhere){
                $where = $where . 'AND i.tipo = :tp'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.tipo = :tp'."\n";
                $isWhere = true;
            }
            $kvp[':tp'] = $_POST['tipoCP'];
        }
        if($investigador){
            $from = $from . ', autor a, colaborador_pub ci'."\n";
            if($isWhere){
                $where = $where . 'AND i.idPub = ci.idPub AND ci.idAutor = a.idAutor AND a.nombre = :nm'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.idPub = ci.idPub AND ci.idAutor = a.idAutor AND a.nombre = :nm'."\n";
                $isWhere = true;
            }
            $kvp[':nm'] = $_POST['nomInvRP'];
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
                     FROM publicacion';
        $number = $pdo->prepare($counting);
        $number->execute();

        $sql = 'SELECT codigo, titulo, tipo, idPub 
                FROM publicacion';    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();    
    }
    $n = $number->fetch(PDO::FETCH_ASSOC);
    echo "<h2> Resultados </h2>";
    echo "<span> Total de publicaciones registradas: </span>";
    echo $n['conteo'];
    echo "<br> <br> <br>";
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row !== false){
        echo '<div role="table">' . "\n";
        echo '<div role="cabecera"> <span>Codigo</span> </div>';
        echo '<div role="cabecera"> <span>Nombre Corto</span> </div>';
        echo '<div role="cabecera"> <span>Unidad de Investigacion</span> </div>';
            
        do{
               
            echo '<div role="fila">';
            echo '<div role="celda"> <span>' . htmlentities($row['codigo']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($row['titulo']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($row['tipo']) . '</span> </div>';
            echo '<a href="detalles_publicacion_admin.php?pub_id='.$row['idPub'].'">&gt&gt</a>'; echo "</td>";
            echo "</div>\n";

            echo "</div>";
            echo "<br /> <br />";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
    }
    echo "<br />";  
} 
?>