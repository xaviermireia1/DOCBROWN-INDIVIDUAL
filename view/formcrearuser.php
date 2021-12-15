<?php
session_start();
require_once '../services/connection.php';
if ($_SESSION['email']=="" || $_SESSION['tipo_user']!='administrador'){
    header("location:login.html");
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
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/script.js"></script>
    <title>Añadir usuario</title>
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
        <form action="../proceses/crearusuario.php" method="post" onsubmit="return validaruser();">
            <label>Email</label>
            <input class="casilla" type="email" name="email" id="email">
            <label>Nombre</label>
            <input class="casilla" type="text" name="nombre" id="nombre">
            <label>Apellido</label>
            <input class="casilla" type="text" name="apellido" id="apellido">
            <br><label>Tipo usuario</label>
            <select class="casilla" name="option" id="option">
                <option value="mantenimiento">Mantenimiento</option>
                <option value="administrador">Administrador</option>
                <option value="camarero">Camarero</option>
            </select>
            <label>Contraseña</label>
            <input class="casilla" type="password" name="contraseña" id="contraseña">
             
             <div class="column-1">
                <input class="filtrar" type="submit" value="Crear usuario">
            </div>
        </form>
    </div>
    </div>
</body>
</html>