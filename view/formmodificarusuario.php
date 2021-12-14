<?php
session_start();
require_once '../services/connection.php';
if ($_SESSION['email']==""){
    header("location:login.html");
}else {
$email=$_GET["email"];
$sentencia=$pdo->prepare("SELECT * FROM tbl_usuario WHERE email='{$email}'");
$sentencia->execute();
foreach ($sentencia as $row) {
    $nombre=$row["nombre"];
    $apellido=$row["apellido"];
    $tipo=$row["tipo"];
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
    <title>Añadir incidencia</title>
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
        <form action="../proceses/modificarusuario.php" method="post" onsubmit="return validarmoduser();">
            <?php
            echo "<h1>Modificar usuario: {$nombre}</h1>";
            echo "<input type='hidden' name='email' value={$email}>";
            echo "<br><label>Nombre</label><br><br>";
            echo "<input type='text' name='nombre' id='nombre' value={$nombre}>";
            echo "<br><br><label>Apellido</label><br><br>";
            echo "<input type='text' name='apellido' id='apellido' value={$apellido}>";
            echo "<br><br><label>Tipo</label><br><br>";
            ?>
            <select name="option" id="option">
                <option value="mantenimiento">Mantenimiento</option>
                <option value="administrador">Administrador</option>
                <option value="camarero">Camarero</option>
            </select>
             <br><br>
             <div class="column-1">
                <input class="filtrar" type="submit" value="Modificar usuario">
            </div>
        </form>
    </div>
    </div>
</body>
</html>
<?php
}