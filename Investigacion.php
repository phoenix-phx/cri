<?php 
require_once "c_pdo.php";
require_once "Publicacion.php";
require_once "Autor.php";
require_once "Financiador.php";
require_once "Actividad.php";

class Investigacion{
	protected $codigo;
	protected $titulo;
	protected $nombre_corto;
	protected $resumen;
	protected $fecha_inicio;
	protected $fecha_fin;
	protected $unidad_investigacion;
	protected $estado;
	protected $id;

	protected $idUsuario;

	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function setIdUsuario($id){
		$this->idUsuario = $id;
	}

	public function getIdUsuario(){
		return $this->idUsuario;
	}

	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}

	public function getCodigo(){
		return $this->codigo;
	}
	
	public function setTitulo($titulo){
		$this->titulo = $titulo;
	}

	public function getTitulo(){
		return $this->titulo;
	}

	public function setNombreCorto($nc){
		$this->nombre_corto = $nc;
	}

	public function getNombreCorto(){
		return $this->nombre_corto;
	}	

	public function setResumen($resumen){
		$this->resumen = $resumen;
	}

	public function getResumen(){
		return $this->resumen;
	}

	public function setFechaInicio($fi){
		$this->fecha_inicio = $fi;
	}

	public function getFechaInicio(){
		return $this->fecha_inicio;
	}

	public function setFechaFinal($ff){
		$this->fecha_fin = $ff;
	}

	public function getFechaFinal(){
		return $this->fecha_fin;
	}

	public function setUnidadInvestigacion($ui){
		$this->unidad_investigacion = $ui;
	}

	public function getUnidadInvestigacion(){
		return $this->unidad_investigacion;
	}

	public function setEstado($estado){
		$this->estado = $estado;
	}

	public function getEstado(){
		return $this->estado;
	}

	public function initInv($user_id, $pdo){
		$sql = 'SELECT substring(codigo,1,25) as codigo, substring(nombre_corto,1,25) as nombre_corto, substring(resumen,1,100) as resumen, idInv 
		    	FROM investigacion
				WHERE idUsuario = :id
				AND estado = :es
		        LIMIT 3';
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
		   ':id' => $user_id,
		   ':es' => 'en curso'
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			return false;
		}
		else{
			echo '<div style="height:280px;width:100%;">';
			echo '<div class="aLeft" style="width:82%;height:280px;padding-left:40px;padding-right:40px;">';
	        do{
	        	$this->setCodigo($row['codigo']);
				$this->setNombreCorto($row['nombre_corto']);
				$this->setResumen($row['resumen']);
				$this->setId($row['idInv']);
				echo '<a class="link" href="detalles_investigacion_inv.php?inv_id='.$this->getId().'">';
	            echo '<div class="aLeft container" style="width:26%;height:200px; padding:10px;margin:18px;">' . "\n";
	                echo 'TITULO: ' . htmlentities($this->getNombreCorto()) . "<br><br>"."\n";
	                echo 'C&Oacute;DIGO: ' . htmlentities($this->getCodigo()) . "<br><br>"."\n";
	                echo htmlentities($this->getResumen()) . "<br><br>"."\n";
				echo '</div>' . "\n";
				echo '</a>';
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
			echo '</div>';
			echo '</div>';
			return true;
		}
	}

	public function listaInv($user_id, $estado, $pdo){
		$sql = 'SELECT substring(codigo,1,25) as codigo, substring(nombre_corto,1,25) as nombre_corto, fecha_fin, idInv 
	            FROM investigacion
	            WHERE idUsuario = :id
	            AND estado = :st';
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	       ':id' => $user_id,
	       ':st' => $estado
	    ));
	    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	    if($row === false){
			return false;
		}
		else{
			echo '<div style="padding-left:5%;padding-right:5%;">' . "\n";
            echo '<div role="cabecera" align="center"> 
                <div class="aLeft" style="width:320px;">C&Oacute;DIGO</div> 
                <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
                <div class="aLeft" style="width:250px;">FECHA FINALIZACI&Oacute;N</div>
                </div><br><br>
            </div>';
    
			echo '<div style="padding-left:4%;padding-right:4%;">';
        	do{
	        	$this->setCodigo($row['codigo']);
				$this->setNombreCorto($row['nombre_corto']);
				$this->setFechaFinal($row['fecha_fin']);
				$this->setId($row['idInv']);

	            echo '<div role="fila" class="container" 
	            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
	                <div class="aLeft" style="width:320px;">' . htmlentities($this->getCodigo()) . '</div> 
	                <div class="aLeft" style="width:500px;">' . htmlentities($this->getNombreCorto()) . '</div> 
	                <div class="aLeft" style="width:250px;">' . htmlentities($this->getFechaFinal()) . '</div>
	                <a class="link" href="detalles_investigacion_inv.php?inv_id='.$this->getId().'">&gt&gt</a>
	                </div>';
	            echo "<br> <br>";
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
	        echo '</div>';
			return true;
		}
	}

	public function listaAdmin($pdo){
		$sql = 'SELECT substring(codigo,1,25) as codigo, substring(nombre_corto,1,25) as nombre_corto, substring(unidad_investigacion,1,25) as unidad_investigacion, idInv 
				FROM investigacion';
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	    if($row === false){
			return false;
		}
		else{
			echo '<div style="padding-left:5%;padding-right:5%;">' . "\n";
			echo '<div role="cabecera" align="center"> 
			    <div class="aLeft" style="width:320px;">C&Oacute;DIGO</div> 
			    <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
			    <div class="aLeft" style="width:250px;">UNIDAD DE INVESTIGACI&Oacute;N</div>
			    </div><br><br>
			</div>';

			echo '<div style="padding-left:4%;padding-right:4%;">';
        	do{
	        	$this->setCodigo($row['codigo']);
				$this->setNombreCorto($row['nombre_corto']);
				$this->setUnidadInvestigacion($row['unidad_investigacion']);
				$this->setId($row['idInv']);

	            echo '<div role="fila" class="container" 
	            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
	                <div class="aLeft" style="width:320px;">' . htmlentities($row['codigo']) . '</div> 
	                <div class="aLeft" style="width:500px;">' . htmlentities($row['nombre_corto']) . '</div> 
	                <div class="aLeft" style="width:250px;">' . htmlentities($row['unidad_investigacion']) . '</div>
	                <a class="link" href="detalles_investigacion_admin.php?inv_id='.$row['idInv'].'">&gt&gt</a>
	                </div>';
	            echo "<br> <br>";
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
	        echo '</div>';
			return true;
		}
	}

	public function loadDetalles($user_id, $inv_id, $role, $pdo){
		if($role === 'investigador'){
			$sql = 'SELECT * 
		        	FROM investigacion
		    		WHERE idUsuario = :id
		            AND idInv = :inv'; 
			$stmt = $pdo->prepare($sql);
		    $stmt->execute(array(
		       ':id' => $user_id,
		       ':inv' => $inv_id
		    ));
		}
		else if($role === 'administrativo'){
			$sql = 'SELECT * 
		            FROM investigacion
		            WHERE idInv = :inv'; 
		    $stmt = $pdo->prepare($sql);
		    $stmt->execute(array(
		       ':inv' => $inv_id
		    ));   
		}
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	    if($row === false){
			return false;
		}
		else{
			$this->setCodigo($row['codigo']);
			$this->setTitulo($row['nombre']);
			$this->setNombreCorto($row['nombre_corto']);
			$this->setUnidadInvestigacion($row['unidad_investigacion']);
			$this->setResumen($row['resumen']);
			$this->setFechaInicio($row['fecha_inicio']);
			$this->setFechaFinal($row['fecha_fin']);
			$this->setEstado($row['estado']);
			$this->setId($row['idInv']);
			$this->setIdUsuario($row['idUsuario']);
			return true;
		}
	}

	public function loadAutorPrincipal($pdo, $inv_id){
		$auth = new Autor();
		$principal = $auth->loadNombreAutorPrincipal($inv_id, $pdo, 'investigacion');
        return $principal;
    }

    public function loadAutorInterno($pdo, $inv_id){
        $auth = new Autor();
        $internos = $auth->loadNombreAutorInterno($pdo, $inv_id, 'investigacion');
        return $internos;
    }

    public function loadAutorExterno($pdo, $inv_id){
        $auth = new Autor();
        $externos = $auth->loadNombreAutorExterno($pdo, $inv_id, 'investigacion');
        return $externos;
    }

    public function loadFinanciamiento($pdo, $inv_id){
        $fin = new Financiador();
        $financiador = $fin->loadNombreFinanciamiento($pdo, $inv_id);
        return $financiador;
    }

    public function loadActividad($pdo, $inv_id){
    	$act = new Actividad();
    	$actividades = $act->loadActividad($pdo, $inv_id);
        return $actividades;
    }

	public function loadPubAsociadas($user_id, $role, $pdo){
        $pub = new Publicacion();
        $estado = $pub->listaPubAsociadas($user_id, $this->getId(), $role, $pdo);
        if($estado === false){
        	return false;
        }
        else{
        	return true;
        }
    }    

  	public function crear($user_id, $pdo){
		$sql = "INSERT INTO investigacion (idUsuario, nombre, nombre_corto, resumen, fecha_fin, unidad_investigacion, estado)
            	VALUES (:us, :no, :nc, :res, :ff, :ui, :st)";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':us' => $user_id,
	        ':no' => $this->getTitulo(),
	        ':nc' => $this->getNombreCorto(),
	        ':res' => $this->getResumen(),
	        ':ff' => $this->getFechaFinal(),
	        ':ui' => $this->getUnidadInvestigacion(),
	        ':st' => $this->getEstado()
	    ));
	    $inv_id = $pdo->lastInsertId();
	    $this->setId($inv_id);
	}  

	public function completarDetalles($user_id, $pdo){
		$sql = "UPDATE investigacion
	            SET  codigo = :cd, fecha_inicio = :fi
	            WHERE idUsuario = :id
	            AND idInv = :inv";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':cd' => $this->getCodigo(),
	        ':fi' => $this->getFechaInicio(),
	        ':id' => $user_id,
	        ':inv' => $this->getId() 
	    ));	    
	}

	public function actualizarDatos($user_id, $inv_id, $pdo){
		$sql = 'UPDATE investigacion
	            SET nombre = :no, nombre_corto = :nc, resumen = :res, fecha_fin = :ff, unidad_investigacion = :ui
	            WHERE idInv = :inv
	            AND idUsuario = :us';                
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':no' => $this->getTitulo(),
	        ':nc' => $this->getNombreCorto(),
	        ':res' => $this->getResumen(),
	        ':ff' => $this->getFechaFinal(),
	        ':ui' => $this->getUnidadInvestigacion(),
	        ':inv' => $inv_id,
	        ':us' => $user_id
	    ));
	}  

	public function cerrarInv($user_id, $inv_id, $pdo){
		$sql = "UPDATE investigacion
		        SET  estado = :st
		        WHERE idUsuario = :id
		        AND idInv = :inv";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
		    ':st' => $this->getEstado(),
		    ':id' => $user_id,
		    ':inv' => $inv_id
		));
	}  

	public function busqueda($type, $data, $pdo){
		if($type === 'Ninguno'){
	        $sql = 'SELECT substring(codigo,1,25) as codigo, substring(nombre_corto,1,25) as nombre_corto, substring(unidad_investigacion,1,25) as unidad_investigacion, idInv 
	                FROM investigacion';    
	        $stmt = $pdo->prepare($sql);
	        $stmt->execute();
	    }
		else if ($type === 'Unidad de Investigacion') {
            $sql = 'SELECT substring(codigo,1,25) as codigo,substring(nombre_corto,1,25) as nombre_corto, substring(unidad_investigacion,1,25) as unidad_investigacion, idInv 
                    FROM investigacion
                    WHERE unidad_investigacion LIKE :ui';    
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
	    }
	    else if ($type === 'Nombre Investigacion') {
            $sql = 'SELECT substring(codigo,1,25) as codigo, substring(nombre_corto,1,25) as nombre_corto, substring(unidad_investigacion,1,25) as unidad_investigacion, idInv 
                    FROM investigacion
                    WHERE nombre LIKE :no
                    OR nombre_corto LIKE :nc';    
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
	    }
	    else if ($type === 'Codigo Investigacion') {
            $sql = 'SELECT substring(codigo,1,25) as codigo, substring(nombre_corto,1,25) as nombre_corto, substring(unidad_investigacion,1,25) as unidad_investigacion, idInv 
                    FROM investigacion
                    WHERE codigo LIKE :cd';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }
	    else if ($type === 'Nombre Investigador') {
            $sql = 'SELECT substring(i.codigo,1,25) as codigo, substring(i.nombre_corto,1,25) as nombre_corto, substring(i.unidad_investigacion,1,25) as unidad_investigacion, i.idInv
                    FROM investigacion i, colaborador_inv ci, autor a
                    WHERE a.idAutor = ci.idAutor
                    AND ci.idInv = i.idInv
                    AND a.nombre LIKE :no';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
	    }
	    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $resultados;
	}  

	public function reporte($sentence, $data, $type, $pdo){
		if($type !== 'Ninguno'){
			$stmt = $pdo->prepare($sentence);
	        $stmt->execute($data);
	    }
	    else{
	    	$stmt = $pdo->prepare($sentence);
	        $stmt->execute();
	    }
	    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $resultados;
	}  

	public function counting($sentence, $data, $type, $pdo){
		if($type !== 'Ninguno'){
			$stmt = $pdo->prepare($sentence);
		    $stmt->execute($data);
		}
		else{
			$stmt = $pdo->prepare($sentence);
	        $stmt->execute();
		}
	    $numero = $stmt->fetch(PDO::FETCH_ASSOC);
	    return $numero;
	}  

	public function searchID($code, $pdo){
		$sql = 'SELECT * 
				FROM investigacion
				WHERE codigo = :cod';
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':cod' => $code
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			return false;
		}
		else{
			return $row['idInv'];
		}
	}  

	public function searchNOMBRE($inv_id, $pdo){
		$sql = 'SELECT * 
				FROM investigacion
				WHERE idInv = :inv';
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':inv' => $inv_id
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			return false;
		}
		else{
			return $row['nombre'];
		}
	}

	public function searchCODIGO($inv_id, $pdo){
		$sql = 'SELECT * 
				FROM investigacion
				WHERE idInv = :inv';
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':inv' => $inv_id
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			return false;
		}
		else{
			return $row['codigo'];
		}
	}

	public function fechas($user_id, $pdo){
		$sql = 'SELECT codigo, nombre, nombre_corto, fecha_fin, idInv 
		    	FROM investigacion
				WHERE idUsuario = :id
				ORDER BY fecha_fin ASC'; 
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
		   ':id' => $user_id
		));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if(count($row) === 0){
			return false;
		}
		else{
			return $row;
		}
	}
}
?>