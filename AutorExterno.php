<?php 
require_once "c_pdo.php";
require_once "Autor.php";

class AutorExterno extends Autor{
	protected $universidad;
	
	public function setUniversidad($universidad){
		$this->universidad = $universidad;
	}

	public function getUniversidad(){
		return $this->universidad;
	}

	public function crearAutor($inv_id, $pdo){
        $sql = "INSERT INTO autor (nombre, tipo_filiacion, rol, universidad)
                VALUES (:no, :tf, :rol, :uni)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':no' => $this->getNombre(),
            ':tf' => $this->getTipoFiliacion(),
            ':rol' => $this->getRol(),
            ':uni' => $this->getUniversidad()
        ));
        $autor_id = $pdo->lastInsertId();
        $this->setId($autor_id);

        $sql = "INSERT INTO colaborador_inv (idInv, idAutor)
                VALUES (:inv, :auth)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':inv' => $inv_id,
            ':auth' => $this->getId()
        ));
    }    
}
?>