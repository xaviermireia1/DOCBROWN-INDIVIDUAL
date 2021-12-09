<?php
session_start();
require_once '../services/connection.php';
if ($_SESSION['email']==""){
    header("location:login.html");
}else {
$id_mesa=$_GET["idmesa"];
$id_localizacion=$_GET['idlocalizacion'];
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
        <form action="../proceses/agregarincidencia.php" method="post">
            <?php
            echo "<h1>Añadir incidencia en el ID mesa: {$id_mesa}</h1>";
            echo "<input type='hidden' name='idmesa' value={$id_mesa}>";
            echo "<input type='hidden' name='idlocalizacion' value={$id_localizacion}>";
            ?>
             <textarea name="description" id="description" cols="50" rows="10"></textarea>
             <br><br>
             <div class="column-1">
                <input class="filtrar" type="submit" value="Enviar">
            </div>
        </form>
    </div>
    </div>
</body>
</html>
<?php
}