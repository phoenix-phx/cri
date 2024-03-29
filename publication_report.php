<?php 
session_start();
require_once "c_pdo.php";

// security control
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('No ha iniciado sesion');
}

if( $_SESSION['permisos'] !== "administrativo"){
    die('Acceso denegado');
}

// display headers
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=ReportePublicaciones.xls");
header("Pragma: no-cache");
?>

<table>
	<tr>
		<!-- general data -->
		<th>Codigo</th>
		<th>Titulo</th>
		<th>Resumen</th>
		<th>Investigacion Asociada</th>
		<th>Tipo de Publicacion</th>
		<th>Cita APA</th>
		<th>Unidad de Investigacion</th>
		<th>Linea de Investigacion</th>
		<th>Estado</th>

		<!-- principal author -->
		<th>Autor Principal</th>

	</tr>

	<?php
	function parse_string($target){
		$response = str_replace(
			array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'á', 'é', 'í', 'ó', 'ú', 'ñ'), 
			array('A', 'E', 'I', 'O', 'U', 'N', 'a', 'e', 'i', 'o', 'u', 'n'), 
			$target);
		return $response;
	}

	$sql = "SELECT i.codigo, i.titulo, i.resumen, i.idInv, i.tipo, i.APA, i.unidad_investigacion, i.linea_investigacion, i.estado, a.nombre as autor
			FROM publicacion i, colaborador_pub ci, autor a
			WHERE i.idPub = ci.idPub
			AND ci.idAutor = a.idAutor
			AND a.rol = 'principal'";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	?>

	<tr>
		<!-- general data -->
		<td> <?php echo parse_string($row['codigo'])?> </td>
		<td> <?php echo parse_string($row['titulo'])?> </td>
		<td> <?php echo parse_string($row['resumen'])?> </td>
		<td> 
			<?php 
			if($row['idInv'] !== null){
				$subQuery = "SELECT i.nombre as inv 
							 FROM investigacion i
							 WHERE i.idInv =" . $row['idInv'];
				$subStmt = $pdo->prepare($subQuery);
				$subStmt->execute();
				$subRow = $subStmt->fetch(PDO::FETCH_ASSOC);
				echo parse_string($subRow['inv']);
			}
			else{
				echo parse_string($row['idInv']);
			}
			?> 
		</td>
		<td> <?php echo parse_string($row['tipo'])?> </td>
		<td> <?php echo parse_string($row['APA'])?> </td>
		<td> <?php echo parse_string($row['unidad_investigacion'])?> </td>
		<td> <?php echo parse_string($row['linea_investigacion'])?> </td>
		<td> <?php echo parse_string($row['estado'])?> </td>

		<!-- principal author -->
		<td> <?php echo parse_string($row['autor'])?> </td>
	</tr>

	<?php
	}
	?>
</table>

<br> <br>