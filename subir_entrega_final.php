<!DOCTYPE html>
<html>
<head>
	<title>Subir Entrega</title>
	<?php include "c_subirentrega.php" ?>
</head>
<body>
    <h1>Entrega final</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo ('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <h3><i>Sube el documento final de la publicacion para enviarla</i></h3>
    <form action="c_subirentrega.php?pub_id="<?= $_REQUEST['pub_id']?> method="post">
        <input name="archivoEntregaF" type="file"><br>
        Descripcion del envio:<br><br>
        <textarea name="descripcionEnvio" rows="4" cols="100" placeholder="Escribe una pequeña descripcion"></textarea><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>