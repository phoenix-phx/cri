<?php 
require_once "c_pdo.php";

class Autor{
	protected $nombre;
	protected $tipo_filiacion;
	protected $rol;
	protected $id;
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function setTipoFiliacion($tf){
		$this->tipo_filiacion = $tf;
	}

	public function getTipoFiliacion(){
		return $this->tipo_filiacion;
	}
	
	public function setRol($rol){
		$this->rol = $rol;
	}

	public function getRol(){
		return $this->rol;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function loadNombreAutorPrincipal($id, $pdo, $doc){
        if($doc === 'investigacion'){
            $sql = "SELECT autor.nombre 
                    FROM autor, colaborador_inv ci, investigacion i
                    WHERE i.idInv = :inv
                    AND i.idInv = ci.idInv
                    AND autor.idAutor = ci.idAutor
                    AND autor.rol = 'principal'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':inv' => $id
            ));
        }
        else if($doc === 'publicacion'){
            $sql = "SELECT autor.nombre 
                    FROM autor, colaborador_pub cp, publicacion p
                    WHERE p.idPub = :pub
                    AND p.idPub = cp.idPub
                    AND autor.idAutor = cp.idAutor
                    AND autor.rol = 'principal'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':pub' => $id
            ));
        }
        $principal = $stmt->fetch(PDO::FETCH_ASSOC);
        return $principal;
    }

    public function loadNombreAutorInterno($pdo, $id, $doc){
        if($doc === 'investigacion'){
            $sql = "SELECT autor.nombre 
                    FROM autor, colaborador_inv ci, investigacion i
                    WHERE i.idInv = :inv
                    AND i.idInv = ci.idInv
                    AND autor.idAutor = ci.idAutor
                    AND autor.rol = 'colaboracion'
                    AND autor.tipo_filiacion = 'interno'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':inv' => $id
            ));
        }
        else if($doc === 'publicacion'){
            $sql = "SELECT autor.nombre 
                    FROM autor, colaborador_pub cp, publicacion p
                    WHERE p.idPub = :pub
                    AND p.idPub = cp.idPub
                    AND autor.idAutor = cp.idAutor
                    AND autor.rol = 'colaboracion'
                    AND autor.tipo_filiacion = 'interno'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':pub' => $id
            ));
        }
        $internos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $internos;
    }

    public function loadNombreAutorExterno($pdo, $id, $doc){
        if($doc === 'investigacion'){
            $sql = "SELECT autor.nombre 
                    FROM autor, colaborador_inv ci, investigacion i
                    WHERE i.idInv = :inv
                    AND i.idInv = ci.idInv
                    AND autor.idAutor = ci.idAutor
                    AND autor.rol = 'colaboracion'
                    AND autor.tipo_filiacion = 'externo'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':inv' => $id
            ));
        }
        else if($doc === 'publicacion'){
            $sql = "SELECT autor.nombre 
                    FROM autor, colaborador_pub cp, publicacion p
                    WHERE p.idPub = :pub
                    AND p.idPub = cp.idPub
                    AND autor.idAutor = cp.idAutor
                    AND autor.rol = 'colaboracion'
                    AND autor.tipo_filiacion = 'externo'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':pub' => $id
            ));
        }
        $externos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $externos;
    }

    public function testAutorPrincipal($id, $pdo, $doc){
        if($doc === 'investigacion'){
            $sql = "SELECT autor.universidad 
                    FROM autor, colaborador_inv ci, investigacion i
                    WHERE i.idInv = :inv
                    AND i.idInv = ci.idInv
                    AND autor.idAutor = ci.idAutor
                    AND autor.rol = 'principal'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':inv' => $id
            ));
        }
        else if($doc === 'publicacion'){
            $sql = "SELECT autor.universidad 
                    FROM autor, colaborador_pub cp, publicacion p
                    WHERE p.idPub = :pub
                    AND p.idPub = cp.idPub
                    AND autor.idAutor = cp.idAutor
                    AND autor.rol = 'principal'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':pub' => $id
            ));
        }
        $state = $stmt->fetch(PDO::FETCH_ASSOC);
        return $state;
    }

    function loadAutores($pdo, $id, $doc){
        if($doc === 'investigacion'){
            $sql = "SELECT a.idAutor, a.nombre, a.tipo_filiacion, a.rol, a.unidad_investigacion, a.filiacion, a.universidad
                    FROM autor a, colaborador_inv ci, investigacion i
                    WHERE i.idInv = ci.idInv
                    AND ci.idAutor = a.idAutor
                    AND a.rol = 'colaboracion'
                    AND i.idInv = :inv";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':inv' => $id
            ));
        }
        else if($doc === 'publicacion'){
            // TODO
        }
        $investigadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $investigadores;
    }
}
?>