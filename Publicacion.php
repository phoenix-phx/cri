<?php 
require_once "c_pdo.php";
require_once "Autor.php";
require_once "Investigacion.php";

class Publicacion{
	protected $codigo;
	protected $titulo;
	protected $resumen;
	protected $tipo;
	protected $unidad_investigacion;
	protected $estado;
	protected $id;

	protected $idInv;
	protected $NombreInv;
	protected $CodigoInv;

	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function setIdInv($id){
		$this->idInv = $id;
	}

	public function getIdInv(){
		return $this->idInv;
	}

	public function setNombreInv($id){
		$this->NombreInv = $id;
	}

	public function getNombreInv(){
		return $this->NombreInv;
	}

	public function setCodigoInv($id){
		$this->CodigoInv = $id;
	}

	public function getCodigoInv(){
		return $this->CodigoInv;
	}

	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}

	public function getCodigo(){
		return $this->codigo;
	}
	
	public function setTitulo($nc){
		$this->nombre_corto = $nc;
	}

	public function getTitulo(){
		return $this->nombre_corto;
	}	

	public function setResumen($resumen){
		$this->resumen = $resumen;
	}

	public function getResumen(){
		return $this->resumen;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}

	public function getTipo(){
		return $this->tipo;
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

	public function initPub($user_id, $pdo){
		$sql = 'SELECT codigo, titulo, resumen, idPub 
		        FROM publicacion
		        WHERE idUsuario = :id
		        LIMIT 3'; 
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
		':id' => $user_id
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			return false;
		}
		else{
			echo '<div class="aLeft" style="width:82%;padding-left:40px">';
    		do{
	        	$this->setCodigo($row['codigo']);
				$this->setTitulo($row['titulo']);
				$this->setResumen($row['resumen']);
				$this->setId($row['idPub']);
				// TODO: deberia haber un link que contenga idInv para un acceso directo a sus detalles por algun lado
				echo '<a class="link" href="detalles_publicacion_inv.php?pub_id='.$this->getId().'">';
		        echo '<div class="aLeft container" style="width:26%;height:200px; padding:10px;margin:18px;">' . "\n";
		            echo 'TITULO: ' . htmlentities($row['titulo']) . '<br>' . "\n";
		            echo 'C&Oacute;DIGO: ' . htmlentities($row['codigo']) . "<br><br>"."\n";
		            echo htmlentities($row['resumen']) . "<br><br>"."\n";
				echo '</div>' . "\n";
				echo '</a>';
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
	        echo '</div>';
			return true;
		}
	}

	public function listaInv($user_id, $pdo){
		$sql = 'SELECT codigo, titulo, tipo, idPub 
		    	FROM publicacion
				WHERE idUsuario = :id'; 
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
		   ':id' => $user_id
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			return false;
		}
		else{
			echo '<div style="padding-left:5%;padding-right:5%;">' . "\n";
            echo '<div role="cabecera" align="center"> 
                <div class="aLeft" style="width:320px;">C&Oacute;DIGO</div> 
                <div class="aLeft" style="width:500px;">TITULO</div> 
                <div class="aLeft" style="width:250px;">TIPO</div>
                </div><br><br>
            </div>';
    
			echo '<div style="padding-left:4%;padding-right:4%;">';
        	do{
	        	$this->setCodigo($row['codigo']);
				$this->setTitulo($row['titulo']);
				$this->setTipo($row['tipo']);
				$this->setId($row['idPub']);

	            echo '<div role="fila" class="container" 
	            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
	            <div class="aLeft" style="width:320px;">' . htmlentities($this->getCodigo()) . '</div> 
	            <div class="aLeft" style="width:500px;">' . htmlentities($this->getTitulo()) . '</div> 
	            <div class="aLeft" style="width:250px;">' . htmlentities($this->getTipo()) . '</div>
	            <a class="link" href="detalles_publicacion_inv.php?pub_id='.$this->getId().'">&gt&gt</a>';
	            echo "</div>";
	            echo "<br /> <br />";
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
	        echo '</div>';
			return true;
		}
	}

	public function listaAdmin($pdo){
		$sql = 'SELECT codigo, titulo, tipo, idPub 
	            FROM publicacion';
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
	                <div class="aLeft" style="width:500px;">TITULO</div> 
	                <div class="aLeft" style="width:250px;">TIPO</div>
	                </div><br><br>
	            </div>';
	    
			echo '<div style="padding-left:4%;padding-right:4%;">';
        	do{
	        	$this->setCodigo($row['codigo']);
				$this->setTitulo($row['titulo']);
				$this->setTipo($row['tipo']);
				$this->setId($row['idPub']);

	            echo '<div role="fila" class="container" 
	            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
	            <div class="aLeft" style="width:320px;">' . htmlentities($row['codigo']) . '</div> 
	            <div class="aLeft" style="width:500px;">' . htmlentities($row['titulo']) . '</div> 
	            <div class="aLeft" style="width:250px;">' . htmlentities($row['tipo']) . '</div>
	            <a class="link" href="detalles_publicacion_admin.php?pub_id='.$row['idPub'].'">&gt&gt</a>';
	            echo "</div>";
	            echo "<br /> <br />";
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
	        echo '</div>';
			return true;
		}
	}

	public function listaPubAsociadas($user_id, $inv_id, $role, $pdo){
		if($role === 'investigador'){
			$sql = 'SELECT codigo, titulo, tipo, idPub 
		            FROM publicacion
		            WHERE idUsuario = :id
		            AND idInv = :inv'; 
		    $stmt = $pdo->prepare($sql);
		    $stmt->execute(array(
		       ':id' => $user_id,
		       ':inv' => $inv_id
		    ));
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
		    if($row === false){
				return false;
			}
			else{
				echo'<div style="padding-left:5%;padding-right:5%;">' . "\n";
			        echo '<div role="cabecera" align="center"> 
			            <div class="aLeft" style="width:320px;">C&Oacute;DIGO</div> 
			            <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
			            <div class="aLeft" style="width:250px;">FECHA FINALIZACI&Oacute;N</div>
			            </div><br><br>
			        </div>';

				echo '<div style="padding-left:4%;padding-right:4%;">';
	        	do{
		        	$this->setCodigo($row['codigo']);
					$this->setTitulo($row['titulo']);
					$this->setTipo($row['tipo']);
					$this->setId($row['idPub']);

		            echo '<div role="fila" class="container" 
		            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
		            <div class="aLeft" style="width:320px;">' . htmlentities($this->getCodigo()) . '</div> 
		            <div class="aLeft" style="width:500px;">' . htmlentities($this->getTitulo()) . '</div> 
		            <div class="aLeft" style="width:250px;">' . htmlentities($this->getTipo()) . '</div>
		            <a class="link" href="detalles_publicacion_inv.php?pub_id='.$this->getId().'">&gt&gt</a>';
		            echo "</div>";
		            echo "<br /> <br />";
		        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
		        echo '</div>';
				return true;
			}
		}
		else if($role === 'administrativo'){
			$sql = 'SELECT codigo, titulo, tipo, idPub 
		            FROM publicacion
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
				echo'<div style="padding-left:5%;padding-right:5%;">' . "\n";
			        echo '<div role="cabecera" align="center"> 
			            <div class="aLeft" style="width:320px;">C&Oacute;DIGO</div> 
			            <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
			            <div class="aLeft" style="width:250px;">FECHA FINALIZACI&Oacute;N</div>
			            </div><br><br>
			        </div>';

				echo '<div style="padding-left:4%;padding-right:4%;">';
	        	do{
		        	$this->setCodigo($row['codigo']);
					$this->setTitulo($row['titulo']);
					$this->setTipo($row['tipo']);
					$this->setId($row['idPub']);

		            echo '<div role="fila" class="container" 
		            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
		            <div class="aLeft" style="width:320px;">' . htmlentities($this->getCodigo()) . '</div> 
		            <div class="aLeft" style="width:500px;">' . htmlentities($this->getTitulo()) . '</div> 
		            <div class="aLeft" style="width:250px;">' . htmlentities($this->getTipo()) . '</div>
		            <a class="link" href="detalles_publicacion_admin.php?pub_id='.$this->getId().'">&gt&gt</a>';
		            echo "</div>";
		            echo "<br /> <br />";
		        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
		        echo '</div>';
				return true;
			}
		}
	}

	public function loadDetalles($user_id, $pub_id, $role, $pdo){
		if($role === 'investigador'){
			$sql = 'SELECT * 
		        	FROM publicacion
		    		WHERE idUsuario = :id
		            AND idPub = :pub'; 
		    $stmt = $pdo->prepare($sql);
		    $stmt->execute(array(
		       ':id' => $user_id,
		       ':pub' => $pub_id
		    ));
		}
		else if($role === 'administrativo'){
			$sql = 'SELECT * 
		            FROM publicacion
		            WHERE idPub = :pub'; 
		    $stmt = $pdo->prepare($sql);
		    $stmt->execute(array(
		       ':pub' => $pub_id
		    ));      
		}
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	    if($row === false){
			return false;
		}
		else{
			$this->setCodigo($row['codigo']);
			$this->setTitulo($row['titulo']);
			$this->setResumen($row['resumen']);
			$this->setTipo($row['tipo']);
			$this->setUnidadInvestigacion($row['unidad_investigacion']);
			$this->setEstado($row['estado']);
			$this->setId($row['idInv']);
			$this->setIdInv($row['idInv']);
			if($row['idInv'] !== null){
				$inv = new Investigacion();
				$codigo = $inv->searchCODIGO($row['idInv'], $pdo);
				$this->setCodigoInv($codigo);
				$nombre = $inv->searchNOMBRE($row['idInv'], $pdo);
				$this->setNombreInv($nombre);
			}
			return true;
		}
	}

	public function loadAutorPrincipal($pdo, $pub_id){
        $auth = new Autor();
		$principal = $auth->loadNombreAutorPrincipal($pub_id, $pdo, 'publicacion');
        return $principal;
    }

    public function loadAutorInterno($pdo, $pub_id){
        $auth = new Autor();
		$internos = $auth->loadNombreAutorInterno($pdo, $pub_id, 'publicacion');
        return $internos;
    }

    public function loadAutorExterno($pdo, $pub_id){
        $auth = new Autor();
		$externos = $auth->loadNombreAutorExterno($pdo, $pub_id, 'publicacion');
        return $externos;
    }

    public function crear($user_id, $pdo){
		$sql = "INSERT INTO publicacion (idUsuario, titulo, resumen, tipo, unidad_investigacion, estado)
	            VALUES (:us, :no, :res, :ti, :ui, :st)";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':us' => $user_id,
	        ':no' => $this->getTitulo(),
	        ':res' => $this->getResumen(),
	        ':ti' => $this->getTipo(),
	        ':ui' => $this->getUnidadInvestigacion(),
	        ':st' => $this->getEstado()
	    ));
	    $pub_id = $pdo->lastInsertId();
	    $this->setId($pub_id);
	}

	public function completarDetalles($user_id, $pdo){
		$sql = "UPDATE publicacion
	            SET  codigo = :cd
	            WHERE idUsuario = :id
	            AND idPub = :pub";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':cd' => $this->getCodigo(),
	        ':id' => $user_id,
	        ':pub' => $this->getId() 
	    ));
	}

	public function asociarInvestigacion($user_id, $inv_id, $pdo){
		$sql = "UPDATE publicacion
	            SET  idInv = :inv
	            WHERE idUsuario = :id
	            AND idPub = :pub";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':inv' => $inv_id,
	        ':id' => $user_id,
	        ':pub' => $this->getId() 
	    ));
	}

	public function actualizarDatos($user_id, $pub_id, $pdo){
		$sql = 'UPDATE publicacion
	            SET titulo = :no, resumen = :res, tipo = :ti, unidad_investigacion = :ui
	            WHERE idPub = :pub
	            AND idUsuario = :us';
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':no' => $this->getTitulo(),
	        ':res' => $this->getResumen(),
	        ':ti' => $this->getTipo(),
	        ':ui' => $this->getUnidadInvestigacion(),
	        ':pub' => $pub_id,
	        ':us' => $user_id
	    ));
	    $this->setId($pub_id);
	}  

	public function busqueda($type, $data, $pdo){
		if($type === 'Ninguno'){
	        $sql = 'SELECT codigo, titulo, tipo, idPub 
		            FROM publicacion';    
		    $stmt = $pdo->prepare($sql);
		    $stmt->execute();
	    }
		else if ($type === 'Unidad de Investigacion') {
            $sql = 'SELECT codigo, titulo, tipo, idPub 
                    FROM publicacion
                    WHERE unidad_investigacion LIKE :ui';    
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
	    }
	    else if ($type === 'Nombre') {
            $sql = 'SELECT codigo, titulo, tipo, idPub 
                    FROM publicacion
                    WHERE titulo LIKE :no';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
	    }
	    else if ($type === 'Codigo') {
            $sql = 'SELECT codigo, titulo, tipo, idPub 
                    FROM publicacion
                    WHERE codigo LIKE :cd';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }
	    else if ($type === 'Tipo') {
            $sql = 'SELECT codigo, titulo, tipo, idPub 
                    FROM publicacion
                    WHERE tipo LIKE :ti';
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

	public function subirEntrega($pub_id, $name, $type, $data, $pdo){
		$sql = "INSERT INTO documento (idPub, nombre, tipo, doc)
                VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $pub_id);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $type);
       	$stmt->bindParam(4, $data);
        $stmt->execute();
	}  

	public function existsDoc($pub_id, $pdo){
		$sql = "SELECT *
				FROM documento JOIN publicacion
                ON documento.idPub = publicacion.idPub
                AND publicacion.idPub = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $pub_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row === false){
        	return false;
        }
        else{
        	return true;
        }
	}  

	public function loadDoc($pub_id, $pdo){
		$sql = "SELECT * FROM documento 
                WHERE idPub = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $pub_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row; 
	}  
}
?>