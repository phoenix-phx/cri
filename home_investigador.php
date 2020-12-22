<!DOCTYPE html>
<html>
<head>
    <title>Home Investigador</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body> 
    <!-- header -->
    <div class="bar" style="height: 50px; background-color: #0b1f3f;">
        <a href="home_investigador.html" class="aLeft textIblue">
            <img src="imagenes/LogoU.png" style="height: 50px;">
        </a>
        <div style="padding-top: 15px; padding-bottom: 15px;">
            <a href="home_investigador.html" class="aLeft textIblue">
                Unidad de Investigacion UCB
            </a>
            <a href="" class="aRight textIblue">
                <!-- Agregar usuario -->
            </a>
        </div>
        
    </div>
    <!--  -->

        <!-- Nav bar izq -->
        <div class="aLeft" style="background-color:#fff9e6;width:200px;position:fixed;height:100%;position:fixed;">
            <nav class="fHeight">
                <ul>
                    <li><a href="listaInv_investigador.php">Investigaciones</a></li>
                    <li><a href="listaPub_investigador.php">Publicaciones</a></li>
                    <li><a href="cronograma.php">Cronograma</a></li>
                    <li><a href="">Notificaciones</a></li>
                    <li><a href="c_logout.php">Logout</a></li>
                    <!-- Agregar notifiaciones -->
                </ul>
            </nav>
        </div>
        <?php include "c_homeinv.php" ?>      
        <!-- hacer que los divs sean links -->
        <!-- arreglar cuando no hay publicaciones pero si investigaciones -->
         
</body>
</html>
