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

	public function crearAutor($id, $type, $pdo){
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

        if($type === 'investigacion'){
            $sql = "INSERT INTO colaborador_inv (idInv, idAutor)
                    VALUES (:id, :auth)";
        }
        else if($type === 'publicacion'){
            $sql = "INSERT INTO colaborador_pub (idPub, idAutor)
                    VALUES (:id, :auth)";
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':id' => $id,
            ':auth' => $this->getId()
        ));
    }    
}
?>