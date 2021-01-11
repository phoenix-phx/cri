<?php 
require_once "c_pdo.php";
require_once "Usuario.php";
class Notificacion{
	// fields go here
	protected $rol;
	protected $id;
	
	// getters and setters go here
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function getNombre(){
		return $this->nombre;
	}

	// methods go here
	public function nuevoUsuario($addresses, $user){
		foreach ($addresses as $index => $destiny) {
			// funcionamiento comprobado
			// $index es el indice del array
			// $destiny es el destinatario del correo
			// write code here...
		}		
	}

	public function cierreInv($addresses, $nombre_investigacion, $investigador){
		foreach ($addresses as $index => $destiny) {
			// informar el cierre de una investigacion
			// $index es el indice del array
			// $destiny es el destinatario del correo
			// write code here...
		}		
	}
}
?>