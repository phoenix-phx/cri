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
}
?>