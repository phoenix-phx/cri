<?php 
require_once "c_pdo.php";
class Usuario{
	protected $nombre;
	protected $correo;
	protected $celular;
	protected $telefono;
	
	private $user;
	private $pass;

	protected $rol;
	protected $id;
	private $salt = '*cRriII20#_';

	public function setRol($rol){
		$this->rol = $rol;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getRol(){
		return $this->rol;
	}

	public function getId(){
		return $this->id;
	}

	public function login($user, $pass, $mode, $pdo){
		$try = hash('sha256', $this->salt . $pass);
		$stmt = $pdo->prepare('SELECT idUsuario, rol
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
			return true;
		}	
	}
}
?>