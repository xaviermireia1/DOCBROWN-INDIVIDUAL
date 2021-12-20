<?php
    require_once '../services/connection.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="../css/stylesviewclient.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Reservar mesas</title>
</head>
<body>
<div class="formclient">
<form class="form" action="../proceses/crearreservaonline.php" method="POST">
  <h2>Reserva aquí</h2>
  <p type="Email:"><input type="email" required name="email" placeholder="Introduce el email.."></input></p>
  <p type="Nombre:"><input name="nombre" required placeholder="Escribe tu nombre.."></input></p>
  <p type="Apellido:"><input name="apellido" required placeholder="Escribe el apellido.."></input></p>
  <?php
        if (empty($_SESSION['dateclient']) && empty($_SESSION['hourclient'])) {
            ?>
                  <p type="Fecha:"><input type="date" required name="fecha" min="<?php echo date("Y-m-d"); ?>"></input></p>
                  <p type="Hora:"><input type="time" required min="08:00" max="23:00" name="hora" step="3600"></input></p>
            <?php
        }else{
            ?>
                <p type="Fecha:"><input type="date" required name="fecha" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $_SESSION['dateclient']; ?>"></input></p>
                <p type="Hora:"><input type="time" required min="08:00" max="23:00" name="hora" step="3600" value="<?php echo $_SESSION['hourclient']; ?>"></input></p>
            <?php
        }
  ?>
  <input type="hidden" name="idmesa" value="<?php echo $_GET['idmesa']; ?>">
  <input type="submit" value="Enviar Reserva">
  <div>
    <span class="fa fa-phone"></span>633838756
    <span class="fa fa-envelope"></span> 100006207.joan23@fje.edu
  </div>
</form>
</div>
</body>
</html>