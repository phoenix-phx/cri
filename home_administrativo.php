<!DOCTYPE html>
<html>
<head>
    <title>Home Administrativo</title>
    <?php session_start() ?>
</head>
<body>
    <div>
        <!-- Colocar imagenes -->
        <div>
            <nav>
                <a href="listaInv_admin.php">Investigaciones</a>
                <a href="listaPub_admin.php">Publicaciones</a>
                <a href="nuevo_usuario.php">Usuarios</a>
                <a href="">Notificaciones</a>
                <a href="c_logout.php">Logout</a>
                <!-- Agregar notifiaciones -->
            </nav>
        </div>
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
        <div>
            <img src="">
            <h1><a href="listaInv_admin.php">Investigaciones</a></h1>
            <a href="buscar_investigacion.php">Buscar investigacion</a><br>
            <a href="reporte_investigacion.php">Reporte investigacion</a>
        </div>
        <div>
            <img src="">
            <h1><a href="listaPub_admin.php">Publicaciones</a></h1>
            <a href="buscar_publicacion.php">Buscar publicacion</a><br>
            <a href="reporte_publicacion.php">Reporte publicacion</a>
        </div>
        <div>
            <img src="">
            <h1>Reportes</h1>
            <a href="reporte_investigacion.php">Reporte investigacion</a><br>
            <a href="reporte_publicacion.php">Reporte publicacion</a>
        </div>
        <div>
            <img src="">
            <h1>Usuarios</h1>
            <a href="nuevo_usuario.php">Crear usuario</a>
        </div>
    </div>
    
</body>
</html>
