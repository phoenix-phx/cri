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
header("Content-Disposition: attachment; filename=ReporteInvestigaciones.xls");
header("Pragma: no-cache");
?>

<table>
	<tr>
		<!-- general data -->
		<th>Codigo</th>
		<th>Nombre</th>
		<th>Nombre Corto</th>
		<th>Resumen</th>
		<th>Fecha Inicio</th>
		<th>Fecha Fin</th>
		<th>Unidad de Investigacion</th>
		<th>Linea de Investigacion</th>
		<th>Estado</th>

		<!-- finance data -->
		<th>Existe Financiamiento</th>
		<th>Nombre Financiador</th>
		<th>Tipo Financiador</th>
		<th>Tipo Financiamiento</th>
		<th>Monto</th>
		<th>Observaciones</th>

		<!-- principal author -->
		<th>Autor Principal</th>

	</tr>

	<?php
	$sql = 'SELECT i.codigo, i.nombre, i.nombre_corto, i.resumen, i.fecha_inicio, i.fecha_fin, i.unidad_investigacion, i.linea_investigacion, i.estado, f.nombre_financiador, f.tipo_financiador, f.tipo_financiamiento, f.monto, f.observaciones, a.nombre as autor
			FROM investigacion i, financiador f, colaborador_inv ci, autor a
			WHERE i.idInv = f.idInv
			AND i.idInv = ci.idInv
			AND ci.idAutor = a.idAutor';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	?>

	<tr>
		<!-- general data -->
		<td> <?php echo $row['codigo']?> </td>
		<td> <?php echo $row['nombre']?> </td>
		<td> <?php echo $row['nombre_corto']?> </td>
		<td> <?php echo $row['resumen']?> </td>
		<td> <?php echo $row['fecha_inicio']?> </td>
		<td> <?php echo $row['fecha_fin']?> </td>
		<td> <?php echo $row['unidad_investigacion']?> </td>
		<td> <?php echo $row['linea_investigacion']?> </td>
		<td> <?php echo $row['estado']?> </td>

		<!-- finance data -->
		<td> 
			<?php 
			if ($row['nombre_financiador'] === "") {
				echo "No";
			}
			else{
				echo "Si";
			}
			?>
		</td>
		<td> <?php echo $row['nombre_financiador']?> </td>
		<td> <?php echo $row['tipo_financiador']?> </td>
		<td> <?php echo $row['tipo_financiamiento']?> </td>
		<td> <?php echo $row['monto']?> </td>
		<td> <?php echo $row['observaciones']?> </td>

		<!-- principal author -->
		<td> <?php echo $row['autor']?> </td>
	</tr>

	<?php
	}
	?>
</table>

<br> <br>