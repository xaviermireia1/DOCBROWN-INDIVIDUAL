<?php
session_start();
require_once '../services/connection.php';
if ($_SESSION['email']=="" || $_SESSION['tipo_user']!='administrador'){
    header("location:login.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Añadir mesa</title>
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
        <form action="../proceses/crearmesa.php" method="post">
            <label>Cantidad de mesas</label><br><br>
            <input type="number" name="mesa" id="mesa">
            <br><br><label>Cantidad de sillas</label><br><br>
            <input type="number" name="silla" id="silla">
            <br><br><label>Ubicacion</label><br><br>
            <select name="localizacion" class="casilla">
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
             <br><br>
             <div class="column-1">
                <input class="filtrar" type="submit" value="Crear mesa">
            </div>
        </form>
    </div>
    </div>
</body>
</html>