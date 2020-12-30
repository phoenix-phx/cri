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

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}

	public function getTipo(){
		return $this->tipo;
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

	public function listaInv($user_id, $pdo){
		$sql = 'SELECT codigo, titulo, tipo, idPub 
		    	FROM publicacion
				WHERE idUsuario = :id'; 
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
		   ':id' => $user_id
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			return false;
		}
		else{
			echo '<div style="padding-left:5%;padding-right:5%;">' . "\n";
            echo '<div role="cabecera" align="center"> 
                <div class="aLeft" style="width:320px;">CODIGO</div> 
                <div class="aLeft" style="width:500px;">TITULO</div> 
                <div class="aLeft" style="width:250px;">TIPO</div>
                </div><br><br>
            </div>';
    
			echo '<div style="padding-left:4%;padding-right:4%;">';
        	do{
	        	$this->setCodigo($row['codigo']);
				$this->setTitulo($row['titulo']);
				$this->setTipo($row['tipo']);
				$this->setId($row['idPub']);

	            echo '<div role="fila" class="container" 
	            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
	            <div class="aLeft" style="width:320px;">' . htmlentities($this->getCodigo()) . '</div> 
	            <div class="aLeft" style="width:500px;">' . htmlentities($this->getTitulo()) . '</div> 
	            <div class="aLeft" style="width:250px;">' . htmlentities($this->getTipo()) . '</div>
	            <a class="link" href="detalles_publicacion_inv.php?pub_id='.$this->getId().'">&gt&gt</a>';
	            echo "</div>";
	            echo "<br /> <br />";
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
	        echo '</div>';
			return true;
		}
	}

	public function listaAdmin($pdo){
		$sql = 'SELECT codigo, titulo, tipo, idPub 
	            FROM publicacion';
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	    if($row === false){
			return false;
		}
		else{
			echo '<div style="padding-left:5%;padding-right:5%;">' . "\n";
	            echo '<div role="cabecera" align="center"> 
	                <div class="aLeft" style="width:320px;">CODIGO</div> 
	                <div class="aLeft" style="width:500px;">TITULO</div> 
	                <div class="aLeft" style="width:250px;">TIPO</div>
	                </div><br><br>
	            </div>';
	    
			echo '<div style="padding-left:4%;padding-right:4%;">';
        	do{
	        	$this->setCodigo($row['codigo']);
				$this->setTitulo($row['titulo']);
				$this->setTipo($row['tipo']);
				$this->setId($row['idPub']);

	            echo '<div role="fila" class="container" 
	            style="height:60px;padding:10px;padding-top:35px;font-size:18px;" align="center"> 
	            <div class="aLeft" style="width:320px;">' . htmlentities($row['codigo']) . '</div> 
	            <div class="aLeft" style="width:500px;">' . htmlentities($row['titulo']) . '</div> 
	            <div class="aLeft" style="width:250px;">' . htmlentities($row['tipo']) . '</div>
	            <a class="link" href="detalles_publicacion_inv.php?pub_id='.$row['idPub'].'">&gt&gt</a>';
	            echo "</div>";
	            echo "<br /> <br />";
	        }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
	        echo '</div>';
			return true;
		}
	}
}
?>