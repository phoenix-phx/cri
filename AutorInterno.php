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

	public function crearAutor($id, $type, $pdo){
        $sql = "INSERT INTO autor (nombre, tipo_filiacion, rol, unidad_investigacion, filiacion)
                VALUES (:no, :tf, :rol, :ui, :fl)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':no' => $this->getNombre(),
            ':tf' => $this->getTipoFiliacion(),
            ':rol' => $this->getRol(),
            ':ui' => $this->getUnidadInvestigacion(),
            ':fl' => $this->getFiliacion()
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