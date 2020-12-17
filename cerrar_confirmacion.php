<!DOCTYPE html>
<html>
<head>
	<title>Confirmar Cierre</title>
</head>
<body>
    <h1>Cerrar investigacion</h1>
    Esta accion no puede deshacerse, Esta seguro que desea cerra la investigacion?<br>
    <button onclick="document.location='investigacion_cerrada.php'<?=$_REQUEST['inv_id']?>">Confirmar</button>
    <button onclick="document.location='detalles_investigacion_inv.php'<?=$_REQUEST['inv_id']?>">Cancelar</button>
</body>
</html>