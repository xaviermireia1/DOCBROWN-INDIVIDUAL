<?php
session_start();
require_once '../services/connection.php';
if ($_SESSION['tipo_user']=='administrador') {
    header("location:vista.administrador.php");
}
if ($_SESSION['email']=="") {
    header("location:login.html");
}
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
    <link rel="shortcut icon" type="image/png" href="../img/logo.png" />
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
            <label>Nombre cliente</label>
            <input class="casilla" type="text" name="nombre" id="nombre">
            <label>Apellido cliente</label>
            <input class="casilla" type="text" name="apellido" id="apellido">
            <br><label>Email cliente</label>
            <input class="casilla" type="email" name="email" id="email">
            <label>Dia de reserva</label>
            <input class="casilla" type="date" name="fecha" id="fecha" min="<?php echo date("Y-m-d"); ?>">
            <br><label>Hora de reserva</label>
            <input class="casilla" type="time" min="08:00" max="23:00" step="3600" name="hora" id="hora">
            <input type="hidden" name="idmesa" value="<?php echo $_GET['idmesa']; ?>">            
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