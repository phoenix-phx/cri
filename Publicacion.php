<?php 
require_once "c_pdo.php";
class Publicacion{
	protected $codigo;
	protected $titulo;
	protected $resumen;
	protected $tipo;
	protected $documento;
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
	
	public function setTitulo($nc){
		$this->nombre_corto = $nc;
	}

	public function getTitulo(){
		return $this->nombre_corto;
	}	

	public function setResumen($resumen){
		$this->resumen = $resumen;
	}

	public function getResumen(){
		return $this->resumen;
	}

	public function initPub($user_id, $pdo){
		$sql = 'SELECT codigo, titulo, resumen, idPub 
		        FROM publicacion
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
				$this->setTitulo($row['titulo']);
				$this->setResumen($row['resumen']);
				$this->setId($row['idPub']);
				// TODO: deberia haber un link que contenga idInv para un acceso directo a sus detalles por algun lado

		        echo '<div class="aLeft container" style="width:26%;height:200px; padding:10px;margin:18px;">' . "\n";
		            echo 'TITULO: ' . htmlentities($row['titulo']) . '<br>' . "\n";
		            echo 'CODIGO: ' . htmlentities($row['codigo']) . "<br><br>"."\n";
		            echo htmlentities($row['resumen']) . "<br><br>"."\n";
		        echo '</div>' . "\n";
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
	        echo '</div>';
			return true;
		}
	}
}
?>