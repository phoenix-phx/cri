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

    public function registrar($pdo, $inv_id){
        $sql = "INSERT INTO financiador (idInv, tipo_financiamiento, tipo_financiador, nombre_financiador)
                VALUES (:inv, :tfm, :tfr, :nfr)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id,
            ':tfm' => $this->getTipoFinanciamiento(),
           	':tfr' => $this->getTipoFinanciador(),
            ':nfr' => $this->getNombreFinanciador()
        ));
        $financiador = $pdo->lastInsertId();
        $this->setId($financiador);
    }

    public function registrarMonto($pdo, $inv_id){
        $sql = "UPDATE financiador
                SET  monto = :mn
                WHERE idFinanciador = :id
                AND idInv = :inv";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':mn' => $this->getMonto(),
            ':id' => $this->getId(),
            ':inv' => $inv_id 
        ));     
    }

    public function registrarObservaciones($pdo, $inv_id){
        $sql = 'UPDATE financiador
                SET  observaciones = :obs
                WHERE idFinanciador = :id
                AND idInv = :inv';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':obs' => $this->getObservaciones(),
            ':id' => $this->getId(),
            ':inv' => $inv_id 
        ));
    }
}
?>