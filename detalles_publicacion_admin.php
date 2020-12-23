<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <h1>Detalles</h1>
    <button onclick="document.location='c_historialpub.php?pub_id=<?php echo($_REQUEST['pub_id']) ?>'">Ver Historial de Publicacion</button>
    
    <?php include "c_vistapublicacion.php"?>
</body>
</html>