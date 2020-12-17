<!DOCTYPE html>
<html>
<head></head>
<body>
    <h1>Detalles</h1> 
    <button onclick="document.location='editar_publicacion.php'<?=$_REQUEST['pub_id']?>">Editar</button>
    <button onclick="document.location='subir_entrega_final.php'<?=$_REQUEST['pub_id']?>">Subir Entrega Final</button>
    <?php include "c_vistapublicacion.php" ?>
</body>
</html>