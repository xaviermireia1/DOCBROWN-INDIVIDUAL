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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
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
        <form action="../proceses/modificarusuario.php" method="post">
            <?php
            echo "<h1>Modificar usuario: {$nombre}</h1>";
            echo "<input type='hidden' name='email' value={$email}>";
            echo "<br><label>Nombre</label><br><br>";
            echo "<input type='text' name='nombre' value={$nombre}>";
            echo "<br><br><label>Apellido</label><br><br>";
            echo "<input type='text' name='apellido' value={$apellido}>";
            echo "<br><br><label>Tipo</label><br><br>";
            ?>
            <select name="option" id="option">
                <option value="mantenimiento">Mantenimiento</option>
                <option value="administrador">Administrador</option>
                <option value="camarero">Camarero</option>
            </select>
             <br><br>
             <div class="column-1">
                <input class="filtrar" type="submit" value="Modificar">
            </div>
        </form>
    </div>
    </div>
</body>
</html>
<?php
}