<?php 
session_start();
require_once "c_pdo.php";
require_once "Investigacion.php";

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
        $inv = new Investigacion();

        $kvp = array();
        $select = 'SELECT i.codigo, i.nombre_corto, i.unidad_investigacion, i.idInv'."\n";
        $from = 'FROM investigacion i'."\n";
        $where = 'WHERE ';
        $isWhere = false;
        if($unidad_investigacion){
            if($isWhere){
                $where = $where . 'AND i.unidad_investigacion LIKE :ui'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.unidad_investigacion LIKE :ui'."\n";
                $isWhere = true;
            }
            $kvp[':ui'] = '%'.$_POST['uniInvRI'].'%';
        }
        if($estado){
            if($isWhere){
                $where = $where . 'AND i.estado LIKE :st'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.estado LIKE :st'."\n";
                $isWhere = true;
            }
            $kvp[':st'] = '%'.$_POST['estadoRI'].'%';
        }
        if($financiamiento){
            $from = $from . ', financiador f'."\n";
            if($isWhere){
                $where = $where . 'AND i.idInv = f.idInv AND f.tipo_financiador LIKE :tf'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.idInv = f.idInv AND f.tipo_financiador LIKE :tf'."\n";
                $isWhere = true;
            }
            $kvp[':tf'] = '%'.$_POST['financiamientoRI'].'%';
        }
        if($creacion){
            if($isWhere){
                $where = $where . 'AND year(i.fecha_inicio) LIKE :anio'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'year(i.fecha_inicio) LIKE :anio'."\n";
                $isWhere = true;
            }
            $kvp[':anio'] = '%'.$_POST['anioCreacionRI'].'%';
        }
        if($investigador){
            $from = $from . ', autor a, colaborador_inv ci'."\n";
            if($isWhere){
                $where = $where . 'AND i.idInv = ci.idInv AND ci.idAutor = a.idAutor AND a.nombre LIKE :nm'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.idInv = ci.idInv AND ci.idAutor = a.idAutor AND a.nombre LIKE :nm'."\n";
                $isWhere = true;
            }
            $kvp[':nm'] = '%'.$_POST['nomInvRI'].'%';
        }
        $row = $inv->reporte($select.$from.$where, $kvp, '',$pdo);
        
        $c = 'SELECT count(*) AS conteo'. "\n";
        $n = $inv->counting($c.$from.$where, $kvp, '',$pdo);
    }
    else{
        $inv = new Investigacion();
        $c = 'SELECT count(*) AS conteo
              FROM investigacion';
        $n = $inv->counting($c, '', 'Ninguno', $pdo);

        $sql = 'SELECT codigo, nombre_corto, unidad_investigacion, idInv 
                FROM investigacion';    
        $row = $inv->reporte($sql, '', 'Ninguno', $pdo);
    }

    $_SESSION['resultados'] = $row;
    $_SESSION['numeros'] = $n;
    header('Location: reporte_investigacion.php');
    return;
}
?>