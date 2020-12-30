<?php 
session_start();
require_once "c_pdo.php";


if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( !isset($_REQUEST['inv_id'])) {
    if($_SESSION['permisos'] === 'investigador'){
        $_SESSION['error'] = "Codigo de investigacion faltante";
        header('Location: listaInv_investigador.php');
        return;
    }
    else if($_SESSION['permisos'] === 'administrativo'){
        $_SESSION['error'] = "Codigo de investigacion faltante";
        header('Location: listaInv_admin.php');
        return;        
    }
}

if($_SESSION['permisos'] === 'investigador'){
    $sql = 'SELECT * 
        	FROM investigacion
    		WHERE idUsuario = :id
            AND idInv = :inv'; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
       ':id' => $_SESSION['idUsuario'],
       ':inv' => $_REQUEST['inv_id']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row === false){
        $_SESSION['error'] = 'No se pudo cargar la investigacion';
        header('Location: listaInv_investigador.php');
        return;
    }

    $codigo = htmlentities($row['codigo']);
    $titulo = htmlentities($row['nombre']);
    $nc = htmlentities($row['nombre_corto']);
    $ui = htmlentities($row['unidad_investigacion']);
    $resumen = htmlentities($row['resumen']);
    $finicio = htmlentities($row['fecha_inicio']);
    $ffinal = htmlentities($row['fecha_fin']);

    function loadAutorPrincipal($pdo, $inv_id){
        $sql = "SELECT autor.nombre 
                FROM autor, colaborador_inv ci, investigacion i
                WHERE i.idInv = :inv
                AND i.idInv = ci.idInv
                AND autor.idAutor = ci.idAutor
                AND autor.rol = 'principal'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id
        ));
        $principal = $stmt->fetch(PDO::FETCH_ASSOC);
        return $principal;
    }
    $principal = loadAutorPrincipal($pdo, $_REQUEST['inv_id']);

    function loadAutorInterno($pdo, $inv_id){
        $sql = "SELECT autor.nombre 
                FROM autor, colaborador_inv ci, investigacion i
                WHERE i.idInv = :inv
                AND i.idInv = ci.idInv
                AND autor.idAutor = ci.idAutor
                AND autor.rol = 'colaboracion'
                AND autor.tipo_filiacion = 'interno'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id
        ));
        $internos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $internos;
    }
    $internos = loadAutorInterno($pdo, $_REQUEST['inv_id']);

    function loadAutorExterno($pdo, $inv_id){
        $sql = "SELECT autor.nombre 
                FROM autor, colaborador_inv ci, investigacion i
                WHERE i.idInv = :inv
                AND i.idInv = ci.idInv
                AND autor.idAutor = ci.idAutor
                AND autor.rol = 'colaboracion'
                AND autor.tipo_filiacion = 'externo'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id
        ));
        $externos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $externos;
    }
    $externos = loadAutorExterno($pdo, $_REQUEST['inv_id']);

    function loadFinanciamiento($pdo, $inv_id){
        $sql = "SELECT f.nombre_financiador, f.idFinanciador
                FROM financiador f, investigacion i
                WHERE i.idInv = :inv
                AND i.idInv = f.idInv";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id
        ));
        $financiador = $stmt->fetch(PDO::FETCH_ASSOC);
        return $financiador;
    }
    $financiador = loadFinanciamiento($pdo, $_REQUEST['inv_id']);

    function loadActividad($pdo, $inv_id){
        $sql = "SELECT a.nombre, a.fecha_inicio, a.fecha_final 
                FROM actividad a, investigacion i
                WHERE i.idInv = :inv
                AND i.idInv = a.idInv";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id
        ));
        $actividades= $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $actividades;
    }
    $actividades = loadActividad($pdo, $_REQUEST['inv_id']);

    //datos generales
    echo '<div role="container">' . "\n";
    echo '<div role="fila"> <span>CODIGO: </span> <span>' . $codigo . ' </span></div>';
    echo '<div role="fila"> <span>TITULO: </span> <span>' . $titulo . ' </span></div>';
    echo '<div role="fila"> <span>NOMBRE CORTO: </span> <span>' . $nc . ' </span></div>';
    echo '<div role="fila"> <span>UNIDAD DE INVESTIGACION: </span> <span>' . $ui . ' </span></div>';
    echo '<div role="fila"> <span>RESUMEN: </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>FECHA INICIO: </span> <span>' . $finicio . ' </span></div>';
    echo '<div role="fila"> <span>FECHA FINAL: </span> <span>' . $ffinal . ' </span></div>';

    //autores
    echo '<div role="fila" id="autores">';
    if(count($principal) !== 0){
        echo '<span>INVESTIGADOR PRINCIPAL: ' . htmlentities($principal['nombre']) . '</span><br>';
        //echo '<li>' . htmlentities($principal['nombre']) . '</li>'; 
    }
        echo 'INVESTIGADOR / ES DE COLABORACION';
    echo '<ul>';
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

    //financiamiento
    echo "<p>FINANCIAMIENTO</p>";
    echo '<div role="fila">';
    if($financiador !== false){
        echo '<span>' . htmlentities($financiador['nombre_financiador']) . ' </span> <span> <a href="financiamiento.php?fin_id="' . $financiador['idFinanciador'] . '">Ver detalles</a></span>';
    }
    else{
        echo '<span>No existe financiamiento</span>';   
    }
    echo "</div>";

    //actividades
    echo "<p>ACTIVIDADES</p>";
    echo '<div role="fila" id="actividades"';
    if(count($actividades) !== 0){
        for ($i=0; $i < count($actividades); $i++) {
            echo '<div id="actividad' . ($i+1) .'">';
            echo '<p> <span> NOMBRE:  </span> <span>' . htmlentities($actividades[$i]['nombre']) . '</span>';
            echo "<br>";
            echo '<span> FECHA INICIO: </span> <span>' . htmlentities($actividades[$i]['fecha_inicio']) . '</span>';
            echo "<br>";
            echo '<span> FECHA FINALIZACION: </span> <span>' . htmlentities($actividades[$i]['fecha_final']) . '</span> <p>';
            echo "</div>";
        }
    }
    else{
        echo "<span>No se han registrado actividades</span>";
    }
    echo '<h3> Publicaciones </h3>';
    echo '</div></div>';

    //publicaciones
    $sql = 'SELECT codigo, titulo, tipo, idPub 
            FROM publicacion
            WHERE idUsuario = :id
            AND idInv = :inv'; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
       ':id' => $_SESSION['idUsuario'],
       ':inv' => $_REQUEST['inv_id'],
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo'<div style="padding-left:5%;padding-right:5%;">' . "\n";
            echo '<div role="cabecera" align="center"> 
                <div class="aLeft" style="width:320px;">CODIGO</div> 
                <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
                <div class="aLeft" style="width:250px;">FECHA FINALIZACION</div>
                </div><br><br>
            </div>';
    if($row !== false){
        echo '<div style="padding-left:4%;padding-right:4%;">';
        do{
            echo '<div role="fila" class="container" 
            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
            <div class="aLeft" style="width:320px;">' . htmlentities($row['codigo']) . '</div> 
            <div class="aLeft" style="width:500px;">' . htmlentities($row['titulo']) . '</div> 
            <div class="aLeft" style="width:250px;">' . htmlentities($row['tipo']) . '</div>
            <a class="link" href="detalles_publicacion_inv.php?pub_id='.$row['idPub'].'">&gt&gt</a>';
            echo "</div>";
            echo "<br /> <br />";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
        echo "</div>";
    }
    echo "<br />";
}
else if($_SESSION['permisos'] === 'administrativo'){
    $sql = 'SELECT * 
            FROM investigacion
            WHERE idInv = :inv'; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
       ':inv' => $_REQUEST['inv_id']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row === false){
        $_SESSION['error'] = 'No se pudo cargar la investigacion';
        header('Location: listaInv_admin.php');
        return;
    }

    $codigo = htmlentities($row['codigo']);
    $titulo = htmlentities($row['nombre']);
    $nc = htmlentities($row['nombre_corto']);
    $ui = htmlentities($row['unidad_investigacion']);
    $resumen = htmlentities($row['resumen']);
    $finicio = htmlentities($row['fecha_inicio']);
    $ffinal = htmlentities($row['fecha_fin']);

    function loadAutorPrincipal($pdo, $inv_id){
        $sql = "SELECT autor.nombre 
                FROM autor, colaborador_inv ci, investigacion i
                WHERE i.idInv = :inv
                AND i.idInv = ci.idInv
                AND autor.idAutor = ci.idAutor
                AND autor.rol = 'principal'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id
        ));
        $principal = $stmt->fetch(PDO::FETCH_ASSOC);
        return $principal;
    }
    $principal = loadAutorPrincipal($pdo, $_REQUEST['inv_id']);

    function loadAutorInterno($pdo, $inv_id){
        $sql = "SELECT autor.nombre 
                FROM autor, colaborador_inv ci, investigacion i
                WHERE i.idInv = :inv
                AND i.idInv = ci.idInv
                AND autor.idAutor = ci.idAutor
                AND autor.rol = 'colaboracion'
                AND autor.tipo_filiacion = 'interno'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id
        ));
        $internos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $internos;
    }
    $internos = loadAutorInterno($pdo, $_REQUEST['inv_id']);

    function loadAutorExterno($pdo, $inv_id){
        $sql = "SELECT autor.nombre 
                FROM autor, colaborador_inv ci, investigacion i
                WHERE i.idInv = :inv
                AND i.idInv = ci.idInv
                AND autor.idAutor = ci.idAutor
                AND autor.rol = 'colaboracion'
                AND autor.tipo_filiacion = 'externo'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id
        ));
        $externos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $externos;
    }
    $externos = loadAutorExterno($pdo, $_REQUEST['inv_id']);

    function loadFinanciamiento($pdo, $inv_id){
        $sql = "SELECT f.nombre_financiador, f.idFinanciador
                FROM financiador f, investigacion i
                WHERE i.idInv = :inv
                AND i.idInv = f.idInv";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id
        ));
        $financiador = $stmt->fetch(PDO::FETCH_ASSOC);
        return $financiador;
    }
    $financiador = loadFinanciamiento($pdo, $_REQUEST['inv_id']);

    function loadActividad($pdo, $inv_id){
        $sql = "SELECT a.nombre, a.fecha_inicio, a.fecha_final 
                FROM actividad a, investigacion i
                WHERE i.idInv = :inv
                AND i.idInv = a.idInv";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id
        ));
        $actividades= $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $actividades;
    }
    $actividades = loadActividad($pdo, $_REQUEST['inv_id']);

    //datos generales
    echo '<div role="container">' . "\n";
    echo '<div role="fila"> <span>Codigo</span> <span>' . $codigo . ' </span></div>';
    echo '<div role="fila"> <span>Titulo</span> <span>' . $titulo . ' </span></div>';
    echo '<div role="fila"> <span>Nombre Corto </span> <span>' . $nc . ' </span></div>';
    echo '<div role="fila"> <span>Unidad de Investigacion</span> <span>' . $ui . ' </span></div>';
    echo '<div role="fila"> <span>Resumen </span> <span>' . $resumen . ' </span></div>';
    echo '<div role="fila"> <span>Fecha Inicio </span> <span>' . $finicio . ' </span></div>';
    echo '<div role="fila"> <span>Fecha Final </span> <span>' . $ffinal . ' </span></div>';

    //autores
    echo "<p>INVESTIGADORES</p>";
    echo '<div role="fila" id="autores">';
    echo '<ul>';
    if($principal !== false){
        echo '<li>' . htmlentities($principal['nombre']) . '</li>'; 
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

    //financiamiento
    echo "<p>FINANCIAMIENTO</p>";
    echo '<div role="fila">';
    if($financiador !== false){
        echo '<span>' . htmlentities($financiador['nombre_financiador']) . ' </span> <span> <a href="financiamiento.php?fin_id="' . $financiador['idFinanciador'] . '">Ver detalles</a></span>';
    }
    else{
        echo '<span>No existe financiamiento</span>';   
    }
    echo "</div>";

    //actividades
    echo "<p>ACTIVIDADES</p>";
    echo '<div role="fila" id="actividades"';
    if(count($actividades) !== 0){
        for ($i=0; $i < count($actividades); $i++) {
            echo '<div id="actividad' . ($i+1) .'">';
            echo '<p> <span> Nombre </span> <span>' . htmlentities($actividades[$i]['nombre']) . '</span>';
            echo "<br>";
            echo '<span> Fecha inicio </span> <span>' . htmlentities($actividades[$i]['fecha_inicio']) . '</span>';
            echo "<br>";
            echo '<span> Fecha finalizacion </span> <span>' . htmlentities($actividades[$i]['fecha_final']) . '</span> <p>';
            echo "</div>";
        }
    }
    else{
        echo "<span>No se han registrado actividades</span>";
    }
    echo '</div>';

    //publicaciones
    $sql = 'SELECT codigo, titulo, tipo, idPub 
            FROM publicacion
            WHERE idUsuario = :id
            AND idInv = :inv'; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
       ':id' => $_SESSION['idUsuario'],
       ':inv' => $_REQUEST['inv_id'],
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row !== false){
        echo '<div role="table">' . "\n";
        echo '<div role="cabecera"> <span>Codigo</span> </div>';
        echo '<div role="cabecera"> <span>Titulo</span> </div>';
        echo '<div role="cabecera"> <span>Tipo</span> </div>';
        do{
            echo '<div role="fila">';
            echo '<div role="celda"> <span>' . htmlentities($row['codigo']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($row['titulo']) . '</span> </div>';
            echo '<div role="celda"> <span>' . htmlentities($row['tipo']) . '</span> </div>';
            echo '<a href="ver_publicacion.php?pub_id='.$row['idPub'].'">&gt&gt</a>'; echo "</td>";
            echo "</div>\n";
        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
        echo "</div>";
    }
    echo "<br />";   
}
?>