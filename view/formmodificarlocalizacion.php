<?php
session_start();
require_once '../services/connection.php';
if ($_SESSION['email']=="" || $_SESSION['tipo_user']!='administrador'){
    header("location:login.html");
}
$idlocalizacion=$_GET['id'];
$localizaciones=$pdo->prepare("SELECT * FROM tbl_localizacion WHERE id_localizacion=$idlocalizacion");
$localizaciones->execute();
$localizacion=$localizaciones->fetchAll(PDO::FETCH_ASSOC);
foreach ($localizacion as $row) {
    $nombrelocalizacion=$row['nombre_localizacion'];
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
    <link rel="shortcut icon" type="image/png" href="../img/logo.png" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/script.js"></script>
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
        <form action="../proceses/modificarlocalizacion.php" method="post" enctype="multipart/form-data" onsubmit="return validarlocalizacion()">
            <label>Nombre localizacion</label>
            <input class="casilla" type="text" name="nombre" id="nombre" value="<?php echo $nombrelocalizacion; ?>">
            <label>Imagen de la localizacion</label>
            <input type="file" name="img" id="img">
            <input type="hidden" name="idlocalizacion" value="<?php echo $idlocalizacion; ?>">
             
             <div class="column-1">
                <input class="filtrar" type="submit" value="Modificar localizacion">
            </div>
        </form>
    </div>
    </div>
</body>
</html>