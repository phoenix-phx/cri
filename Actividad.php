<?php 
require_once "c_pdo.php";

class Actividad{
	protected $nombre;
	protected $fecha_inicio;
	protected $fecha_final;
	protected $id;

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function setFechaInicio($fi){
		$this->fecha_inicio = $fi;
	}

	public function getFechaInicio(){
		return $this->fecha_inicio;
	}
	
	public function setFechaFinal($ff){
		$this->fecha_final = $ff;
	}

	public function getFechaFinal(){
		return $this->fecha_final;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function loadActividad($pdo, $inv_id){
        $sql = "SELECT a.idActividad, a.nombre, a.fecha_inicio, a.fecha_final 
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

    public function registrar($pdo, $inv_id){
        $sql = 'INSERT INTO actividad (idInv, nombre, fecha_inicio, fecha_final)
                VALUES (:inv, :no, :fi, :ff)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id,
            ':no' => $this->getNombre(),
            ':fi' => $this->getFechaInicio(),
            ':ff' => $this->getFechaFinal()
        ));
    }   

    public function eliminar($pdo, $inv_id){
        $sql = 'DELETE FROM actividad
		        WHERE idInv = :inv';
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
		    ':inv' => $inv_id 
		));
    }  
	public function compare($actividad){
		if($this->getNombre() === $actividad->getNombre() &&
		   $this->getFechaFinal() === $actividad->getFechaFinal() &&
		   $this->getFechaInicio() === $actividad->getFechaInicio())
		   return true;
		else return false;
	}
}
?>