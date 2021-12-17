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
    <input type="checkbox" id="active">
    <label for="active" class="menu-btn"><i class="fas fa-bars"></i></label>
    <div class="menu">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="reservasonlinecliente.php">Reservar Mesa</a></li>
            <li><a href="login.html">Iniciar sesion</a></li>
        </ul>
    </div>
    <div class="contenido_inicio">
        <h1>Reserva tu mesa</h1>
    </div>
    <center><form action="reservasonlinecliente.php" method="POST">
            <input type="date" class="input_filtro" name="fecha" required min="<?php $fechasistema=date('Y-m-d'); echo $fechasistema ?>" placeholder="Indica la fecha">
            <input type="time" step="3600" class="input_filtro" required name="hora" placeholder="Indica la hora">
            <input type="number" min="1" class="input_filtro" name="capacidad" placeholder="Indica el numero de personas">
            <select name="localizacion" class="input_filtro">
                <option value="" default>Todas las localizaciones</option>
                <?php
                // Mostrar todas las localizaciones que existen
                    $option=$pdo->prepare("SELECT * FROM tbl_localizacion");
                    $option->execute();
                    $listaoption=$option->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($listaoption as $row) {
                        echo "<option value='{$row['nombre_localizacion']}'>{$row['nombre_localizacion']}</option>";
                    }
                ?>
            </select>
            <input type="submit" class="boton_filtrar_user" value="Filtrar" name="filtrar"> 
    </form></center>
    <?php
        $fechasistema=date('Y-m-d');
        $horasistema=date('H:i');
        $horamas=strtotime('+1 hours',strtotime($horasistema));
        $horamas = date('H:i',$horamas);
        if (isset($_POST['filtrar'])) {
            $fecha=$_POST['fecha'];
            $hora=$_POST['hora'];
            $_SESSION['dateclient']=$fecha;
            $_SESSION['hourclient']=$hora;
            $horains=strtotime('+1 hours',strtotime($hora));
            $horains = date('H:i',$horains);
            $localizacion=$_POST['localizacion'];
            if ($_POST['capacidad']!=null) {
                $capacidad=$_POST['capacidad'];
                $mesas=$pdo->prepare("SELECT tbl_mesa.*,tbl_localizacion.*
                FROM tbl_mesa LEFT JOIN (SELECT * FROM tbl_historialonline WHERE tbl_historialonline.fecha ='{$fecha}' and (tbl_historialonline.hora BETWEEN '{$hora}' and '{$horains}')) as qryreserva
                ON  tbl_mesa.id_mesa=qryreserva.id_mesa 
                INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion = tbl_localizacion.id_localizacion
                WHERE isnull(qryreserva.id_mesa) and tbl_mesa.silla like '{$capacidad}'  and tbl_localizacion.nombre_localizacion like '%{$localizacion}%'");
            }else{
                $mesas=$pdo->prepare("SELECT tbl_mesa.*,tbl_localizacion.*
                FROM tbl_mesa LEFT JOIN (SELECT * FROM tbl_historialonline WHERE tbl_historialonline.fecha ='{$fecha}' and (tbl_historialonline.hora BETWEEN '{$hora}' and '{$horains}')) as qryreserva
                ON  tbl_mesa.id_mesa=qryreserva.id_mesa 
                INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion = tbl_localizacion.id_localizacion
                WHERE isnull(qryreserva.id_mesa) and tbl_mesa.silla like '%%'  and tbl_localizacion.nombre_localizacion like '%{$localizacion}%'");
            }
        }else{
            $mesas=$pdo->prepare("SELECT tbl_mesa.*,tbl_localizacion.*
                FROM tbl_mesa LEFT JOIN (SELECT * FROM tbl_historialonline WHERE tbl_historialonline.fecha ='{$fechasistema}' and (tbl_historialonline.hora BETWEEN '{$horasistema}' and '{$horamas}')) as qryreserva
                ON  tbl_mesa.id_mesa=qryreserva.id_mesa 
                INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion = tbl_localizacion.id_localizacion
                WHERE isnull(qryreserva.id_mesa) and tbl_mesa.silla like '%%'  and tbl_localizacion.nombre_localizacion like '%%'");
        }
        $mesas->execute();
        $mesas=$mesas->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="cos">
        <?php
            foreach ($mesas as $row) {
                echo "<div class='row'>";
                    echo "<h1>{$row['nombre_localizacion']}</h1>";
                    echo "<img src='../img/mesas.png'>";
                    echo "<h4>Capacidad: {$row['silla']}</h4>";
                    ?>
                    <button class="raise" onclick="location.href='formcrearreservacliente.php?idmesa=<?php echo $row['id_mesa'];?>'">Reservar</button>
                    <?php
                echo "</div>";
            }
        ?>
    </div>
</body>
</html>