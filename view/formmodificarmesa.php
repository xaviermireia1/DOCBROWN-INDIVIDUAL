<?php
session_start();
require_once '../services/connection.php';
if ($_SESSION['email']=="" || $_SESSION['tipo_user']!='administrador'){
    header("location:login.html");
}
$idmesa=$_GET['idmesa'];
$disponibilidad=$_GET['disponibilidad'];
$mesas=$pdo->prepare("SELECT * FROM tbl_mesa WHERE id_mesa=$idmesa");
$mesas->execute();
$mesa=$mesas->fetchAll(PDO::FETCH_ASSOC);
foreach ($mesa as $row) {
    $cantmesa=$row['mesa'];
    $cantsillas=$row['silla'];
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
    <title>Modificar mesa</title>
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
        <form action="../proceses/modificarmesa.php" method="post" onsubmit="return validarmesa()">
        <h1>Modificando la mesa: <?php echo $idmesa; ?></h1>
            <label>Cantidad de mesas</label>
            <input class="casilla" type="number" name="mesa" id="mesa" value="<?php echo $cantmesa; ?>">
            <label>Cantidad de sillas</label>
            <input class="casilla" type="number" name="silla" id="silla" value="<?php echo $cantsillas; ?>">
            <input type="hidden" name="disponibilidad" value="<?php echo $disponibilidad; ?>">
            <input type="hidden" name="idmesa" value="<?php echo $idmesa; ?>">
            <br><label>Ubicacion</label>
            <select class="casilla" name="localizacion" class="casilla">
                <?php
                // Mostrar todas las localizaciones que existen
                    $option=$pdo->prepare("SELECT * FROM tbl_localizacion");
                    $option->execute();
                    $listaoption=$option->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($listaoption as $row) {
                        echo "<option value='{$row['id_localizacion']}'>{$row['nombre_localizacion']}</option>";
                    }
                ?>
            </select>
             <div class="column-1">
                <input class="filtrar" type="submit" value="Modificar mesa">
            </div>
        </form>
    </div>
    </div>
</body>
</html>