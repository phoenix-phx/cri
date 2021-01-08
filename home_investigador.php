<!DOCTYPE html>
<html>
<head>
    <title>Home Investigador</title>
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
</head>
<body> 
    <!-- header -->
    <div class="bar" style="height: 50px; background-color: #0b1f3f;">
        <a href="home_investigador.php" class="aLeft textIblue">
            <img src="imagenes/LogoU.png" style="height: 50px;">
        </a>
        <div style="padding-top: 15px; padding-bottom: 15px;padding-right:50px;">
            <a href="home_investigador.php" class="aLeft textIblue">
                Unidad de Investigaci&oacute;n UCB
            </a>
            <a class="aRight textIblue">
                <?php 
                    session_start();
                    echo $_SESSION['nombre'];
                ?>
            </a>
        </div>
    </div>


    <!-- Left Nav bar -->
    <div class="aLeft" style="background-color:#fff9e6;width:200px;position:relative;height:720px;">
        <nav class="fHeight">
            <ul>
                <li><a href="listaInv_investigador.php">Investigaciones</a></li>
                <li><a href="listaPub_investigador.php">Publicaciones</a></li>
                <li><a href="cronograma.php">Cronograma</a></li>
                <li><a href="">Notificaciones</a></li>
                <li><a href="editar_usuario.php?user_id=<?php echo($_SESSION['idUsuario']) ?>">Editar Usuario</a></li>
                <li><a href="c_logout.php">Logout</a></li>
                <!-- Agregar notificaiones -->
            </ul>
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
    <?php include "c_homeinv.php";
    ?>  
    
    <!-- hacer que los divs sean links -->
    <!-- arreglar cuando no hay publicaciones pero si investigaciones -->
         
</body>
</html>
