<?php
require_once "../services/connection.php";
session_start();
if ($_SESSION['email']=="") {
    header("location:login.html");
}else {
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
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <link rel="shortcut icon" type="image/png" href="../img/logo.png" />
        <title>Historial</title>
    </head>
    <body>
        <ul class="padding-lat">
            <li><a><?php echo $_SESSION["nombre"];?></a></li>
            <li class="right">
                <a href="../proceses/logout.proc.php">Logout</a>
            </li>
        </ul>
        <div class="row padding-top padding-lat">
            <div class="fondo">
            <button type="submit"><a type='button' href='vistareservasonline.php'>Ver reservas online</a></button>
            <button type="submit"><a type='button' href='zona.admin.php'>Ver mesas</a></button>
            <?php
                    if ($_SESSION['tipo_user']=='mantenimiento') {
                        echo "<button type='submit'><a type='button' href='vistaincidencia.php'>Ver incidencias</a></button>";
                    }else {
                        echo "";
                    }
                ?>
                <form action="vistahistorial.php" method="post">
                    <div class="column-4">
                        <label for="localizacion">Ubicacion</label><br>   
                        <select name="localizacion" id="localizacion" class="casilla">
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
                    </div>
                    <div class="column-4">
                        <label for="mesa">Nº de mesa</label><br>
                        <input type="number" name="mesa" id="mesa" class="casilla">
                    </div>
                    <!--
                    <div class="column-4">
                        <label for="fate">Fecha</label>
                        <input type="date" name="date" id="date">
                    </div>-->
                    <div class="column-1">
                        <input type="submit" value="FILTRAR" name="filtrar" class="filtrar">
                    </div>
                </form>
            </div>
        </div><br>
        <?php
        if (isset($_POST['filtrar'])) {
            $localizacion=$_POST['localizacion'];
            $mesa=$_POST['mesa'];
            /*$date=$_POST['date'];
            $date=date("d/m/Y",strtotime($date));*/
            $filtro=$pdo->prepare("SELECT tbl_historial.id_historial,tbl_mesa.id_mesa,tbl_localizacion.nombre_localizacion,DATE_FORMAT(tbl_historial.dia_historial,'%d/%m/%Y') as `fecha`,tbl_historial.inicio_historial,tbl_historial.fin_historial,tbl_historial.email,tbl_usuario.nombre
            FROM tbl_historial INNER JOIN tbl_mesa ON tbl_historial.id_mesa=tbl_mesa.id_mesa
            INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion=tbl_localizacion.id_localizacion 
            INNER JOIN tbl_usuario ON tbl_historial.email=tbl_usuario.email
            WHERE tbl_localizacion.nombre_localizacion like '%{$localizacion}%' and tbl_mesa.id_mesa like '%{$mesa}' 
            ORDER BY `fecha` DESC,tbl_historial.inicio_historial DESC");
            $filtro->execute();
            $filtrar=$filtro->fetchAll(PDO::FETCH_ASSOC);
            if (empty($filtrar)) {
                echo "<div class='row padding-top-less padding-lat'>";
                echo "<div>";
                echo "<h1>No se han encontrado elementos....</h1>";
                echo "</div>";
                echo "</div>";
               }else {
                echo  "<div class='row padding-top-less padding-lat'>";
                echo  "<div>";
                echo  "<table>";
                echo  "<tr>";
                echo  "<th class='blue'>Nº Reserva</th>";
                echo  "<th class='blue'>Localizacion</th>";
                echo  "<th class='blue'>ID de Mesa</th>";
                echo  "<th class='blue'>Fecha</th>";
                echo  "<th class='blue'>Hora inicio de reserva</th>";
                echo  "<th class='blue'>Hora final de reserva</th>";
                echo  "<th class='blue'>Camarero</th>";
                echo  "</tr>";
                foreach ($filtrar as $row) {
                        echo   "<tr>";
                        echo "<td class='gris'>{$row['id_historial']}</td>";
                        echo "<td class='gris'>{$row['nombre_localizacion']}</td>";
                        echo "<td class='gris'>{$row['id_mesa']}</td>";
                        echo "<td class='gris'>{$row['fecha']}</td>";
                        echo "<td class='gris'>{$row['inicio_historial']}</td>";
                        echo "<td class='gris'>{$row['fin_historial']}</td>";
                        echo "<td class='gris'>{$row['nombre']}</td>";
                        echo  "</tr>";
                }
                echo "</table>";
                echo "</div>";
                echo "</div>";
               }
        }else {
            $historial=$pdo->prepare("SELECT tbl_historial.id_historial,tbl_mesa.id_mesa,tbl_localizacion.nombre_localizacion,DATE_FORMAT(tbl_historial.dia_historial,'%d/%m/%Y') as `fecha`,tbl_historial.inicio_historial,tbl_historial.fin_historial,tbl_historial.email,tbl_usuario.nombre
            FROM tbl_historial INNER JOIN tbl_mesa ON tbl_historial.id_mesa=tbl_mesa.id_mesa
            INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion=tbl_localizacion.id_localizacion
            INNER JOIN tbl_usuario ON tbl_historial.email=tbl_usuario.email
            ORDER BY `fecha` DESC,tbl_historial.inicio_historial DESC");
            $historial->execute(); 
            echo  "<div class='row padding-top-less padding-lat'>";
            echo  "<div>";
            echo  "<table>";
            echo  "<tr>";
            echo  "<th class='blue'>Nº Reserva</th>";
            echo  "<th class='blue'>Localizacion</th>";
            echo  "<th class='blue'>ID Mesa</th>";
            echo  "<th class='blue'>Fecha</th>";
            echo  "<th class='blue'>Hora inicio de reserva</th>";
            echo  "<th class='blue'>Hora final de reserva</th>";
            echo  "<th class='blue'>Camarero</th>";
            echo  "</tr>";   
            foreach ($historial as $row) {
                        echo  "<tr>";
                        echo "<td class='gris'>{$row['id_historial']}</td>";
                        echo "<td class='gris'>{$row['nombre_localizacion']}</td>";
                        echo "<td class='gris'>{$row['id_mesa']}</td>";
                        echo "<td class='gris'>{$row['fecha']}</td>";
                        echo "<td class='gris'>{$row['inicio_historial']}</td>";
                        echo "<td class='gris'>{$row['fin_historial']}</td>";
                        echo "<td class='gris'>{$row['nombre']}</td>";
                        echo  "</tr>";
        }
        echo "</table>";
        echo "</div>";
        echo "</div>";
        ?> 
        </body>
        </html>
    <?php
    }
}