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
        $this->setId($row['idAutor']);
        $this->setNombre($row['nombre']);
        $this->setTipoFiliacion($row['tipo_filiacion']);
        $this->setRol($row['rol']);
        $this->setUniversidad($row['universidad']);           
    }

    public function actualizarAutor($autor_id, $pdo){
        $sql = 'UPDATE autor
                SET nombre = :no, tipo_filiacion = :tf, unidad_investigacion = :ui, filiacion = :fl, universidad = :uni
                WHERE idAutor = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':no' => $this->getNombre(),
            ':tf' => $this->getTipoFiliacion(),
            ':ui' => null,
            ':fl' => null,
            ':uni' => $this->getUniversidad(),
            ':id' => $autor_id
        ));
    }
}
?>