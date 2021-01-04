<!DOCTYPE html>
<html>
<head>
    <title>Home Administrativo</title>
    <link rel="stylesheet" href="style/styles.css">
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 60px;
        } 
        li{
            padding: 10px; 
        }
        li a {
            display: block;
            color: black;
            text-decoration: none;
            font-size: 20px;
        }
    </style>
    <?php session_start(); ?>

</head>
<body>
    <!-- header -->
    <div class="bar" style="height: 50px; background-color: #0b1f3f;">
        <a href="home_administrativo.php" class="aLeft textIblue">
            <img src="imagenes/LogoU.png" style="height: 50px;">
        </a>
        <div style="padding-top: 15px; padding-bottom: 15px;padding-right:50px;">
            <a href="home_administrativo.php" class="aLeft textIblue">
                Unidad de Investigacion UCB
            </a>
            <a class="aRight textIblue">
                <?php 
                    //session_start();
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>
    <!-- left nav bar -->
    <div class="aLeft" style="background-color:#fff9e6;width:200px;position:relative;height:650px;">
        <nav class="fHeight">
            <ul>
            <li><a href="listaInv_admin.php">Investigaciones</a></li>
            <li><a href="listaPub_admin.php">Publicaciones</a></li>
            <li><a href="nuevo_usuario.php">Usuarios</a></li>
            <li><a href="">Notificaciones</a></li>
            <li><a href="c_logout.php">Logout</a></li>
            <!-- Agregar notifiaciones -->
            </ul>
        </nav>
    </div>
    <!-- Middle nav bar -->
    <div style="padding-left:300px;padding-right:200px;">
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
        <div class="container" style="margin:30px;padding:5px;height:110px;">
            <img src="imagenes/Administrativo/home/investigaciones_home.jpg" class="aLeft" style="height:110px;width:185px;">
            <div class="aLeft" style="padding:15px;">
                <h3 style="margin:5px;font-size:20px;"><a class="link" href="listaInv_admin.php">Investigaciones</a></h3>
                <a class="link" href="buscar_investigacion.php">Buscar investigacion</a><br>
                <a class="link" href="reporte_investigacion.php">Reporte investigacion</a>
            </div>
        </div>
        <div class="container" style="margin:30px;padding:5px;height:110px;">
            <img src="imagenes/Administrativo/home/publicaciones_home.jpg" class="aLeft" style="height:110px;width:185px;">
            <div class="aLeft" style="padding:15px;">
                <h3 style="margin:5px;font-size:20px;"><a class="link" href="listaPub_admin.php">Publicaciones</a></h3>
                <a class="link" href="buscar_publicacion.php">Buscar publicacion</a><br>
                <a class="link" href="reporte_publicacion.php">Reporte publicacion</a>
            </div>
        </div>
        <div class="container" style="margin:30px;padding:5px;height:110px;">
            <img src="imagenes/Administrativo/home/reportes_home.jpg" class="aLeft" style="height:110px;width:185px;">
            <div class="aLeft" style="padding:15px;">
                <h3 style="margin:5px;font-size:20px;">Reportes</h3>
                <a class="link" href="reporte_investigacion.php">Reporte investigacion</a><br>
                <a class="link" href="reporte_publicacion.php">Reporte publicacion</a>
            </div>
        </div>
        <div class="container" style="margin:30px;padding:5px;height:110px;">
            <img src="imagenes/Administrativo/home/usuarios_home.jpg" class="aLeft" style="height:110px;width:185px;">
            <div class="aLeft" style="padding:15px;">
                <h3 style="margin:5px;font-size:20px;">Usuarios</h3>
                <a class="link" href="nuevo_usuario.php">Crear usuario</a>
            </div>  
        </div>
    </div>
    <?php 
    if(isset($_SESSION['resultados'])){
        unset($_SESSION['resultados']);
    }
    if(isset($_SESSION['numeros'])){
        unset($_SESSION['numeros']);
    }
     ?>
</body>
</html>
