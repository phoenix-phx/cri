<!DOCTYPE html>
<html>
<head>
	<title>Ver Publicacion</title>
</head>
<body>
    <h1>Detalles</h1> 
    <button onclick="document.location='editar_publicacion.php?pub_id=<?php echo $_REQUEST['pub_id']?>'">Editar</button>
    <button onclick="document.location='subir_entrega_final.php?pub_id=<?php echo $_REQUEST['pub_id']?>'">Subir Entrega Final</button>
    <?php include "c_vistapublicacion.php" ?>
    <?php
        if (isset($_SESSION['error'])) {
            echo ('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo ('<p style="color:green;">'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['success']);
        }
        ?>
</body>
</html>