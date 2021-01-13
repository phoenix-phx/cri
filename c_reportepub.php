<?php 
session_start();
require_once "c_pdo.php";
require_once "Publicacion.php";

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
        $pub = new Publicacion();

        $kvp = array();
        $select = 'SELECT substring(i.codigo,1,25) as codigo, substring(i.titulo,1,25) as titulo, i.tipo, i.idPub'."\n";
        $from = 'FROM publicacion i'."\n";
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
            $kvp[':ui'] = '%'.$_POST['uniInvRP'].'%';
        }
        if($estado){
            if($isWhere){
                $where = $where . 'AND i.estado LIKE :st'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.estado LIKE :st'."\n";
                $isWhere = true;
            }
            $kvp[':st'] = '%'.$_POST['estadoRP'].'%';
        }
        if($tipo){
            if($isWhere){
                $where = $where . 'AND i.tipo LIKE :tp'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.tipo LIKE :tp'."\n";
                $isWhere = true;
            }
            $kvp[':tp'] = '%'.$_POST['tipoCP'].'%';
        }
        if($investigador){
            $from = $from . ', autor a, colaborador_pub ci'."\n";
            if($isWhere){
                $where = $where . 'AND i.idPub = ci.idPub AND ci.idAutor = a.idAutor AND a.nombre LIKE :nm'."\n";
            }
            else if(!$isWhere){
                $where = $where . 'i.idPub = ci.idPub AND ci.idAutor = a.idAutor AND a.nombre LIKE :nm'."\n";
                $isWhere = true;
            }
            $kvp[':nm'] = '%'.$_POST['nomInvRP'].'%';
        }
        $row = $pub->reporte($select.$from.$where, $kvp, '',$pdo);
        
        $c = 'SELECT count(*) AS conteo'. "\n";
        $n = $pub->counting($c.$from.$where, $kvp, '',$pdo);
    }
    else{
        $pub = new Publicacion();
        $c = 'SELECT count(*) AS conteo
              FROM publicacion';
        $n = $pub->counting($c, '', 'Ninguno', $pdo);

        $sql = 'SELECT substring(codigo,1,25) as codigo, substring(titulo,1,25) as titulo, tipo, idPub 
                FROM publicacion';
        $row = $pub->reporte($sql, '', 'Ninguno', $pdo);
    }

    $_SESSION['resultados'] = $row;
    $_SESSION['numeros'] = $n;
    header('Location: reporte_publicacion.php');
    return;
} 
?>