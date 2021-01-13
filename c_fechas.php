<?php 
require_once "c_pdo.php";
date_default_timezone_set('America/La_Paz');

$sql = 'SELECT fecha_inicio, fecha_fin, nombre
    	FROM investigacion'; 
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row !== false){
	$suma = 0;
	do{
		// more info at: 
		// https://programacion.net/articulo/calcular_la_diferencia_entre_dos_fechas_con_php_1566#:~:text=Para%20calcular%20la%20diferencia%20entre%20dos%20fechas%20utilizo%20DateTime%3A%3A,trabajar%20con%20fechas%20y%20horas.
		$nombre = $row['nombre'];
		$inicio = $row['fecha_inicio'];
		$final = $row['fecha_fin'];

		$date1 = new DateTime($inicio);
		$date2 = new DateTime($final);
		$diff = $date1->diff($date2); // esto calcula la diferencia entre fechas
		echo "<pre>";
		echo $nombre . "\n";
		echo $diff->days . ' days '. "\n\n"; // esto imprime cuantos dias de diferencia existen entre ambas fechas
		$suma += $diff->days;
		echo "</pre>";
		//se pueden imprimir u obtener diferencia de años, meses, etc. Visitar la pagina web del inicio

		// write code here
    }while($row = $stmt->fetch(PDO::FETCH_ASSOC));
    echo "suma total: ".$suma;
}
?>