<?php 
require_once "c_pdo.php";
class Investigacion{
	protected $codigo;
	protected $titulo;
	protected $nombre_corto;
	protected $resumen;
	protected $fecha_inicio;
	protected $fecha_fin;
	protected $unidad_investigacion;
	protected $estado;
	protected $id;

	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}

	public function getCodigo(){
		return $this->codigo;
	}
	
	public function setNombreCorto($nc){
		$this->nombre_corto = $nc;
	}

	public function getNombreCorto(){
		return $this->nombre_corto;
	}	

	public function setResumen($resumen){
		$this->resumen = $resumen;
	}

	public function getResumen(){
		return $this->resumen;
	}

	public function initInv($user_id, $pdo){
		$sql = 'SELECT codigo, nombre_corto, resumen, idInv 
		    	FROM investigacion
				WHERE idUsuario = :id
		        LIMIT 3'; 
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
		   ':id' => $user_id
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			return false;
		}
		else{
			echo '<div class="aLeft" style="width:82%;padding-left:40px">';
	        do{
	        	$this->setCodigo($row['codigo']);
				$this->setNombreCorto($row['nombre_corto']);
				$this->setResumen($row['resumen']);
				$this->setId($row['idInv']);
				// TODO: deberia haber un link que contenga idInv para un acceso directo a sus detalles por algun lado

	            echo '<div class="aLeft container" style="width:26%;height:200px; padding:10px;margin:18px;">' . "\n";
	                echo 'TITULO: ' . htmlentities($this->getNombreCorto()) . "<br><br>"."\n";
	                echo 'CODIGO: ' . htmlentities($this->getCodigo()) . "<br><br>"."\n";
	                echo htmlentities($this->getResumen()) . "<br><br>"."\n";
	            echo '</div>' . "\n";
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
	        echo '</div>';
			return true;
		}
	}
}
?>