<?php 
require_once "c_pdo.php";
require_once "Autor.php";

class AutorInterno extends Autor{
	protected $unidad_investigacion;
	protected $filiacion;
	
	public function setUnidadInvestigacion($ui){
		$this->unidad_investigacion = $ui;
	}

	public function getUnidadInvestigacion(){
		return $this->unidad_investigacion;
	}

	public function setFiliacion($filiacion){
		$this->filiacion = $filiacion;
	}

	public function getFiliacion(){
		return $this->filiacion;
	}

	// Editar desde aqui
	public function initInv($user_id, $pdo){
		$sql = 'SELECT codigo, nombre_corto, resumen, idInv 
		    	FROM investigacion
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
				$this->setNombreCorto($row['nombre_corto']);
				$this->setResumen($row['resumen']);
				$this->setId($row['idInv']);
				// TODO: deberia haber un link que contenga idInv para un acceso directo a sus detalles por algun lado

	            echo '<div class="aLeft container" style="width:26%;height:200px; padding:10px;margin:18px;">' . "\n";
	                echo 'TITULO: ' . htmlentities($this->getNombreCorto()) . "<br><br>"."\n";
	                echo 'CODIGO: ' . htmlentities($this->getCodigo()) . "<br><br>"."\n";
	                echo htmlentities($this->getResumen()) . "<br><br>"."\n";
	            echo '</div>' . "\n";
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
	        echo '</div>';
			return true;
		}
	}

	public function listaInv($user_id, $estado, $pdo){
		$sql = 'SELECT codigo, nombre_corto, fecha_fin, idInv 
	            FROM investigacion
	            WHERE idUsuario = :id
	            AND estado = :st';  // que pasara con las investigaciones terminadas??
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
                <div class="aLeft" style="width:320px;">CODIGO</div> 
                <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
                <div class="aLeft" style="width:250px;">FECHA FINALIZACION</div>
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
		$sql = 'SELECT codigo, nombre_corto, unidad_investigacion, idInv 
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
			    <div class="aLeft" style="width:320px;">CODIGO</div> 
			    <div class="aLeft" style="width:500px;">NOMBRE CORTO</div> 
			    <div class="aLeft" style="width:250px;">UNIDAD DE INVESTIGACION</div>
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
			$this->setId($row['idInv']);
			return true;
		}
	}

	public function loadAutorPrincipal($pdo, $inv_id){
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

    public function loadAutorInterno($pdo, $inv_id){
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

    public function loadAutorExterno($pdo, $inv_id){
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

    public function loadFinanciamiento($pdo, $inv_id){
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

    public function loadActividad($pdo, $inv_id){
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
}
?>