<?php
session_start();
require_once '../services/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar reserva online</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/script.js"></script>
</head>
<body>
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
        <form action="../proceses/crearreservaonline.php" method="post" onsubmit="return validarreservaonline()">
            <label>Nombre cliente</label><br><br>
            <input type="text" name="nombre" id="nombre">
            <br><br><label>Apellido cliente</label><br><br>
            <input type="text" name="apellido" id="apellido">
            <br><br><label>Email cliente</label><br><br>
            <input type="email" name="email" id="email">
            <br><br><label>Dia de reserva</label><br><br>
            <input type="date" name="fecha" id="fecha">
            <br><br><label>Hora de reserva</label><br><br>
            <input type="time" step="3600" name="hora" id="hora">
            <input type="hidden" name="idmesa" value="<?php echo $_GET['idmesa']; ?>">
             <br><br>
             <div class="column-1">
                <input class="filtrar" type="submit" value="Crear reserva Online">
            </div>
        </form>
    </div>
    </div>
</body>
</html>
</body>
</html>