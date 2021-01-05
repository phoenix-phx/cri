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

    public function loadData($id, $pdo, $doc){
        if($doc === 'investigacion'){
            $stmt = $pdo->prepare("SELECT a.idAutor, a.nombre, a.tipo_filiacion, a.rol, a.unidad_investigacion, a.filiacion, a.universidad
                                   FROM autor a, colaborador_inv ci, investigacion i
                                   WHERE i.idInv = ci.idInv
                                   AND ci.idAutor = a.idAutor
                                   AND a.rol = 'principal'
                                   AND i.idInv = :inv");
            $stmt->execute(array(
                ':inv' => $id
            ));
        }
        else if($doc === 'publicacion'){
            $stmt = $pdo->prepare("SELECT a.idAutor, a.nombre, a.tipo_filiacion, a.rol, a.unidad_investigacion, a.filiacion, a.universidad
                               FROM autor a, colaborador_pub ci, publicacion i
                               WHERE i.idPub = ci.idPub
                               AND ci.idAutor = a.idAutor
                               AND a.rol = 'principal'
                               AND i.idPub = :pub");
            $stmt->execute(array(
            ':pub' => $id
            ));
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row !== false){
            $this->setId($row['idAutor']);
            $this->setNombre($row['nombre']);
            $this->setTipoFiliacion($row['tipo_filiacion']);
            $this->setRol($row['rol']);
            $this->setUnidadInvestigacion($row['unidad_investigacion']);           
            $this->setFiliacion($row['filiacion']);
        }
    }

    public function actualizarAutor($autor_id, $pdo){
        $sql = 'UPDATE autor
                SET nombre = :no, tipo_filiacion = :tf, unidad_investigacion = :ui, filiacion = :fl, universidad = :uni
                WHERE idAutor = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':no' => $this->getNombre(),
            ':tf' => $this->getTipoFiliacion(),
            ':ui' => $this->getUnidadInvestigacion(),
            ':fl' => $this->getFiliacion(),
            ':uni' => null,
            ':id' => $autor_id
        ));
    }
}
?>