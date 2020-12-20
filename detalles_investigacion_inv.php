<!DOCTYPE html>
<html>
<head>
	<title>Detalles de Investigacion</title>
</head>
<body>
    <h1>Detalles</h1>
    <?php $cad = $_REQUEST['inv_id'] ?>
    <button onclick="document.location='editar_investigacion.php?inv_id=<?php echo $cad ?>'">Editar</button>
    <?php  $cad = 'cerrar_confirmacion.php?inv_id='.$_REQUEST['inv_id']?>
    <button onclick="document.location='<?php echo $cad; ?>'">Cerrar</button>
    
    <?php include "c_vistainvestigacion.php"?>
</body>
</html>