<?php 
require_once "c_pdo.php";
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

	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}

	public function getCodigo(){
		return $this->codigo;
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
}
?>