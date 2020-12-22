<!DOCTYPE html>
<html>
<head>
	<title>Detalles Investigacion</title>
</head>
<body>
    <h1>Detalles</h1>
    <button onclick="document.location='c_historialinv.php?inv_id=<?php echo($_REQUEST['inv_id']) ?>'">Ver Historial de Investigacion</button>
    
    <?php include "c_vistainvestigacion.php"?>
</body>
</html>