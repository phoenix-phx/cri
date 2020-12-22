<!DOCTYPE html>
<html>
<head>
	<title>Investigaciones Registradas</title>
</head>
<body>
    <h1>Investigaciones</h1> 
    <button onclick="document.location='buscar_investigacion.php'">Buscar Investigacion</button>
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
    <?php include "c_listainv.php"?>
    <!-- Cambiar listado, tambien de publicaciones -->
</body>
</html>
