<!DOCTYPE html>
<html>
<head>
	<title>Mis Investigaciones</title>
</head>
<body>
    <h1>Mis Investigaciones</h1> 
    <button onclick="document.location='nueva_investigacion.php'">+ Investigacion nueva</button>
    <br>
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
</body>
</html>
