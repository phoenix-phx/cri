<?php 
require_once "c_pdo.php";

class Financiador{
	protected $tipo_financiador;
	protected $nombre_financiador;
	protected $tipo_financiamiento;
	protected $monto;
	protected $observaciones;
	protected $id;

	public function setTipoFinanciador($tf){
		$this->tipo_financiador = $tf;
	}

	public function getTipoFinanciador(){
		return $this->tipo_financiador;
	}

	public function setNombreFinanciador($nombre){
		$this->nombre_financiador = $nombre;
	}

	public function getNombreFinanciador(){
		return $this->nombre_financiador;
	}
	
	public function setTipoFinanciamiento($tf){
		$this->tipo_financiamiento = $tf;
	}

	public function getTipoFinanciamiento(){
		return $this->tipo_financiamiento;
	}

	public function setMonto($monto){
		$this->monto = $monto;
	}

	public function getMonto(){
		return $this->monto;
	}	

	public function setObservaciones($obs){
		$this->observaciones = $obs;
	}

	public function getObservaciones(){
		return $this->observaciones;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function loadNombreFinanciamiento($pdo, $inv_id){
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
}
?>