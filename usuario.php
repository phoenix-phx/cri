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
}
?>