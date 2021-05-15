<?php 
require_once "c_pdo.php";
class Usuario{
	protected $nombre;
	protected $correo;
	protected $celular;
	protected $telefono;
	protected $filiacion;
	protected $unidad_investigacion;
	
	private $user;
	private $pass;

	protected $rol;
	protected $id;
	private $salt = '*cRriII20#_';

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function setCorreo($correo){
		$this->correo = $correo;
	}

	public function getCorreo(){
		return $this->correo;
	}

	public function setCelular($celular){
		$this->celular = $celular;
	}

	public function getCelular(){
		return $this->celular;
	}

	public function setTelefono($fono){
		$this->telefono = $fono;
	}

	public function getTelefono(){
		return $this->telefono;
	}

	public function setFiliacion($fl){
		$this->filiacion = $fl;
	}

	public function getFiliacion(){
		return $this->filiacion;
	}

	public function setUnidadInvestigacion($ui){
		$this->unidad_investigacion = $ui;
	}

	public function getUnidadInvestigacion(){
		return $this->unidad_investigacion;
	}


	public function setUser($user){
		$this->user = $user;
	}
	
	public function getUser(){
		return $this->user;
	}

	public function setPass($pass){
		$this->pass = $pass;
	}

	public function getPass(){
		return $this->pass;
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

	public function login($user, $pass, $mode, $pdo){
		$try = hash('sha256', $this->salt . $pass);
		$stmt = $pdo->prepare('SELECT idUsuario, rol, nombre
							   FROM usuario
							   WHERE user = :us
							   AND pass = :pw
							   AND rol = :perm');
		$stmt->execute(array(
			':us' => $user,
			':pw' => $try,
			':perm' => $mode
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			return false;
		}
		else{
			$this->setRol($row['rol']);
			$this->setId($row['idUsuario']);
			$this->setNombre($row['nombre']);
			return true;
		}	
	}

	public function crear($pdo){
		$sql = "INSERT INTO usuario (nombre, filiacion, unidad_investigacion, rol, correo)
                VALUES (:na, :fi, :ui, :pm, :em)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':na' => $this->getNombre(),
            ':fi' => $this->getFiliacion(),
            ':ui' => $this->getUnidadInvestigacion(),
            ':pm' => $this->getRol(),
            ':em' => $this->getCorreo()
        ));

        $profile_id = $pdo->lastInsertId();
        $this->setId($profile_id);
	}

	public function agregarCelular($pdo){
		$sql = "UPDATE usuario
                SET  celular = :ce
                WHERE idUsuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':ce' => $this->getCelular(),
            ':id' => $this->getId()
        ));
	}

	public function agregarTelefono($pdo){
		$sql = "UPDATE usuario
                SET  telefono = :tf
                WHERE idUsuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':tf' => $this->getTelefono(),
            ':id' => $this->getId()
        ));
	}

	public function asignarDatosLogin($pdo){
		$nombre = explode(' ', $this->getNombre());
	    $user = '';
	    for ($i=0; $i < count($nombre); $i++) { 
	    	if ($i == count($nombre) - 1) {
	    		$user .= strtolower($nombre[$i]);
	    	}
	    	else{
	    		$user .= strtolower($nombre[$i]) . '_';
	    	}
	    }
	    $cs = hash('sha256', $this->salt.$user);
	    $this->setUser($user);
	    $this->setPass($cs);

		$sql = "UPDATE usuario
	            SET  user = :us, pass = :pw
	            WHERE idUsuario = :id";

	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':us' => $this->getUser(),
	        ':pw' => $this->getPass(),
	        ':id' => $this->getId()
	    ));
	}

	public function loadDetalles($user_id, $pdo){
		$stmt = $pdo->prepare('SELECT *
							   FROM usuario
							   WHERE idUsuario = :us');
		$stmt->execute(array(
			':us' => $user_id
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			return false;
		}
		else{
			$this->setNombre($row['nombre']);
			$this->setCorreo($row['correo']);
			$this->setCelular($row['celular']);
			$this->setTelefono($row['telefono']);
			$this->setFiliacion($row['filiacion']);
			$this->setUnidadInvestigacion($row['unidad_investigacion']);
			$this->setRol($row['rol']);
			$this->setId($row['idUsuario']);

			$this->setUser($row['user']);
			$this->setPass($row['pass']);
			return true;
		}	
	}

	public function actualizarDatos($pdo){
		$sql = "UPDATE usuario 
				SET nombre = :na, correo = :em
				WHERE idUsuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':na' => $this->getNombre(),
            ':em' => $this->getCorreo(),
            ':id' => $this->getId()
        ));
	}

	public function actualizarDatosAdmin($pdo){
		$sql = "UPDATE usuario 
				SET nombre = :na, correo = :em, filiacion = :fi, unidad_investigacion = :ui, rol = :ro
				WHERE idUsuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':na' => $this->getNombre(),
            ':em' => $this->getCorreo(),
            ':fi' => $this->getFiliacion(),
            ':ui' => $this->getUnidadInvestigacion(),
            ':ro' => $this->getRol(),
            ':id' => $this->getId()
        ));
	}

	public function busqueda($type, $data, $pdo){
		if($type === 'Ninguno'){
	        $sql = 'SELECT nombre, user, unidad_investigacion, idUsuario 
		            FROM usuario';    
		    $stmt = $pdo->prepare($sql);
		    $stmt->execute();
	    }
		else if ($type === 'Nombre') {
            $sql = 'SELECT nombre, user, unidad_investigacion, idUsuario 
                    FROM usuario
                    WHERE nombre LIKE :no';    
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
	    }
	    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $resultados;
	}  

	public function authenticatePass($user_id, $pass, $mode, $pdo){
		$try = hash('sha256', $this->salt . $pass);
		$stmt = $pdo->prepare('SELECT idUsuario
							   FROM usuario
							   WHERE idUsuario = :us
							   AND pass = :pw
							   AND rol = :perm');
		$stmt->execute(array(
			':us' => $user_id,
			':pw' => $try,
			':perm' => $mode
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			return false;
		}
		else{
			return $row['idUsuario'];
		}	
	}

	public function changePass($user_id, $npass, $pdo){
		$cs = hash('sha256', $this->salt.$npass);
	    $this->setPass($cs);

		$sql = "UPDATE usuario
	            SET  pass = :pw
	            WHERE idUsuario = :id";

	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':pw' => $this->getPass(),
	        ':id' => $user_id
	    ));
	}

	public function searchEmail($user_id, $pdo){
	    $sql = 'SELECT correo 
	            FROM usuario
	            WHERE idUsuario = :id';    
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	    	':id' => $user_id
	    ));
	    $mail = $stmt->fetch(PDO::FETCH_ASSOC);
	    if($mail === false){
	    	return false;
	    }
	    return $mail;
	}

	public function searchAdminEmails($pdo){
	    $sql = 'SELECT correo 
	            FROM usuario
	            WHERE rol = :rol';    
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	    	':rol' => 'administrativo'
	    ));
	    $mails = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    if($mails === false){
	    	return false;
	    }
	    return $mails;
	}

	public function uploadCV($user_id, $name, $type, $data, $pdo){
		$sql = "INSERT INTO curriculum (idUsuario, nombre, tipo, doc)
                VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $type);
       	$stmt->bindParam(4, $data);
        $stmt->execute();
	}

	public function updateCV($user_id, $name, $type, $data, $pdo){
		$sql = 'UPDATE curriculum 
        		SET nombre = ?, tipo = ?, doc = ?
        		WHERE idUsuario = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $type);
       	$stmt->bindParam(3, $data);
        $stmt->bindParam(4, $user_id);
        $stmt->execute();
	}  

	public function existsCV($user_id, $pdo){
		$sql = "SELECT *
				FROM curriculum JOIN usuario
                ON curriculum.idUsuario = usuario.idUsuario
                AND usuario.idUsuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row === false){
        	return false;
        }
        else{
        	return true;
        }
	}

	public function loadCV($user_id, $pdo){
		$sql = "SELECT * FROM curriculum 
                WHERE idUsuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row; 
	}  

}
?>