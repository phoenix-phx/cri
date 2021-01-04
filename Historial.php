<?php 
require_once "c_pdo.php";
require_once "Publicacion.php";
require_once "Investigacion.php";

class Historial{
	protected $fecha_cambio;
	protected $detalle;
	protected $id;

	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function setFechaCambio($fc){
		$this->fecha_cambio = $fc;
	}

	public function getFechaCambio(){
		return $this->fecha_cambio;
	}

	public function setDetalle($detalle){
		$this->detalle = $detalle;
	}

	public function getDetalle(){
		return $this->detalle;
	}

	public function registrarCambio($id, $doc, $pdo){
		if($doc === 'investigacion'){
			$sql = 'INSERT INTO historial_inv (idInv, fecha_cambio, detalle)
					VALUES (:id, :fc, :det)';
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
				':id' => $id,
				':fc' => $this->getFechaCambio(),
				':det' => $this->getDetalle()
			));
		}
		else if($doc === 'publicacion'){
			$sql = 'INSERT INTO historial_pub (idPub, fecha_cambio, detalle)
					VALUES (:id, :fc, :det)';
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
				':id' => $id,
				':fc' => $this->getFechaCambio(),
				':det' => $this->getDetalle()
			));
		}
		$cambio_id = $pdo->lastInsertId();
		$this->setId($cambio_id);
	}

	public function loadHistorial($id, $doc, $pdo){
		if($doc === 'investigacion'){
			$sql = 'SELECT fecha_cambio, detalle 
		            FROM historial_inv
		            WHERE idInv = :inv
		            ORDER BY fecha_cambio ASC';
		    $stmt = $pdo->prepare($sql);
		    $stmt->execute(array(
		        ':inv' => $id
		    ));   
		}
		else if($doc === 'publicacion'){
			$sql = 'SELECT fecha_cambio, detalle 
		            FROM historial_pub
		            WHERE idPub = :pub
		            ORDER BY fecha_cambio ASC';
		    $stmt = $pdo->prepare($sql);
		    $stmt->execute(array(
		        ':pub' => $id
		    ));
		}
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row !== false){
	        echo '<table class="container" border="3" style="border-radius:0px;border-collapse:collapse;" >' . "\n";
	        echo "<tr> <th> Fecha de Suceso </th> <th>Suceso </th>";
	        do{
	            echo "<tr>";
	            echo "<td align='center'>";  echo (htmlentities($row['fecha_cambio'])); echo "</td>";
	            echo "<td>"; echo '<pre>'; echo (htmlentities($row['detalle'])); echo '</pre>'; echo "</td>";
	            echo "</tr>\n";
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
	        echo "</table>";
	    }
	    else{
	        echo "Esta investigacion no tiene cambios registrados";
	    }
	    echo "<br />";   
	    echo "<br />";
	}
}
?>