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
header("Content-Disposition: attachment; filename=ReporteUsuarios.xls");
header("Pragma: no-cache");
?>

<table>
	<tr>
		<!-- general data -->
		<th>Nombre</th>
		<th>Correo</th>
		<th>Celular</th>
		<th>Telefono</th>
		<th>Filiacion</th>
		<th>Unidad de Investigacion</th>
		<th>Investigaciones Creadas</th>
		<th>Publicaciones Creadas</th>
	</tr>

	<?php
	$sql = 'SELECT *
			FROM usuario';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	?>

	<tr>
		<!-- general data -->
		<td> <?php echo $row['nombre']?> </td>
		<td> <?php echo $row['correo']?> </td>
		<td> <?php echo $row['celular']?> </td>
		<td> <?php echo $row['telefono']?> </td>
		<td> <?php echo $row['filiacion']?> </td>
		<td> <?php echo $row['unidad_investigacion']?> </td>
		<td>
			<?php 
			$subCounter1 = 'SELECT count(*) as invs
							FROM usuario u, investigacion i
							WHERE u.idUsuario = i.idUsuario
							AND u.idUsuario = '.$row['idUsuario'];
			$stmt1 = $pdo->prepare($subCounter1);
			$stmt1->execute();
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			echo $row1['invs'];
			?>
		</td>
		<td>
			<?php 
			$subCounter2 = 'SELECT count(*) as pubs
							FROM usuario u, publicacion p
							WHERE u.idUsuario = p.idUsuario
							AND u.idUsuario = '.$row['idUsuario'];
			$stmt2 = $pdo->prepare($subCounter2);
			$stmt2->execute();
			$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
			echo $row2['pubs'];
			?>
		</td>
	</tr>

	<?php
	}
	?>
</table>

<br> <br>