<!DOCTYPE html>
<html>
<head>
    <title>Detalles de Investigacion</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <div style="padding-left:5%;padding-right:5%;">
        <h1 class="aLeft">Detalles</h1>
        <?php $cad = $_REQUEST['inv_id'] ?>
        <button class="button aRight" onclick="document.location='editar_investigacion.php?inv_id=<?php echo $cad ?>'">Editar</button>
        <?php  $cad = 'cerrar_confirmacion.php?inv_id='.$_REQUEST['inv_id']?>
        <button class="button aRight" onclick="document.location='<?php echo $cad; ?>'">Cerrar</button>
    </div>
    
    <?php include "c_vistainvestigacion.php"?>
</body>
</html>