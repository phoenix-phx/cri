<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <h1>Detalles</h1>
    <button onclick="document.location='editar_investigacion.php?inv_id='<?=$_REQUEST['inv_id']?>">Editar</button>
    <button onclick="document.location='cerrar_confirmacion.php'<?=$_REQUEST['inv_id']?>">Cerrar</button>
    
    <?php include "c_vistainvestigacion.php"?>
</body>
</html>