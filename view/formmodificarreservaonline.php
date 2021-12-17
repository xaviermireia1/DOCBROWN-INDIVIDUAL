<?php
session_start();
require_once '../services/connection.php';
if ($_SESSION['email']=="" || $_SESSION['tipo_user']!='camarero'){
    header("location:login.html");
}
$historialonline=$pdo->prepare("SELECT tbl_historialonline.*,tbl_mesa.* FROM tbl_historialonline INNER JOIN tbl_mesa ON tbl_mesa.id_mesa=tbl_historialonline.id_mesa WHERE tbl_historialonline.id_historialonline={$_GET['id']}");
$historialonline->execute();
$historialonline=$historialonline->fetchAll(PDO::FETCH_ASSOC);
foreach ($historialonline as $row) {
  $email=$row["email"];
  $nombre=$row["nombre"];
  $apellido=$row["apellido"];
  $fecha=$row["fecha"];
  $silla=$row["silla"];
}
$fechasistema=date('Y-m-d');
$horasistema=date('H:i');
$mesaonline=$pdo->prepare("SELECT * FROM tbl_historialonline WHERE fecha='{$fechasistema}' AND hora<='{$horasistema}'");
$mesaonline->execute();
$mesaonline=$mesaonline->fetchAll(PDO::FETCH_ASSOC);
if (!empty($mesaonline)) {
    foreach ($mesaonline as $row) {
        $idmesa=$row['id_mesa'];
        $setmesaonline=$pdo->prepare("UPDATE tbl_mesa SET disponibilidad='online' WHERE id_mesa=$idmesa");
        $setmesaonline->execute();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar reserva online</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="shortcut icon" type="image/png" href="../img/logo.png" />
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
        <form action="../proceses/modificarreservaonline.php" method="post" onsubmit="return validarmodreservaonline()">
            <label>Nombre cliente</label>
            <input class="casilla" type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
            <label>Apellido cliente</label>
            <input class="casilla" type="text" name="apellido" id="apellido" value="<?php echo $apellido; ?>">
            <label>¿Cuantas personas?</label>
            <input class="casilla" type="number" min="1" name="silla" id="silla" value="<?php echo $silla; ?>">
            <label>Dia de reserva</label>
            <input class="casilla" type="date" name="fecha" id="fecha" value="<?php echo $fecha; ?>" min="<?php echo $fechasistema ?>">
            <label>Hora de reserva</label>
            <input class="casilla" type="time" step="3600" name="hora" id="hora">
            <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
            <input type="hidden" name="idhistorial" id="idhistorial" value="<?php echo $_GET['id']; ?>">
             <div class="column-1">
                <input class="filtrar" type="submit" value="Modificar reserva Online">
            </div>
        </form>
    </div>
    </div>
</body>
</html>
</body>
</html>