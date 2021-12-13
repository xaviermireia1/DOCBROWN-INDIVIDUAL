<?php
session_start();
require_once '../services/connection.php';
if ($_SESSION['email']=="" || $_SESSION['tipo_user']!='administrador'){
    header("location:login.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Modificar localizacion</title>
</head>
<body>
    <!--Header-->
    <ul class="padding-lat">
            <li><a><?php echo $_SESSION["nombre"];?></a></li>
            <li class="right">
                <a href="../proceses/logout.proc.php">Logout</a>
            </li>
    </ul>
    <div class="row padding-top padding-lat">
    <div class="fondo">        
        <form action="../proceses/crearlocalizacion.php" method="post" enctype="multipart/form-data">
            <label>Nombre localizacion</label><br><br>
            <input type="text" name="nombre" id="nombre">
            <br><br><label>Imagen de la localizacion</label><br><br>
            <input type="file" name="img" id="img">
             <br><br>
             <div class="column-1">
                <input class="filtrar" type="submit" value="Crear localizacion">
            </div>
        </form>
    </div>
    </div>
</body>
</html>