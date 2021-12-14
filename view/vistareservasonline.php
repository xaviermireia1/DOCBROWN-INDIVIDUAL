<?php
require_once "../services/connection.php";
session_start();
//Hay que añadir si el usuario es administrador redirigirlo a una pagina admin donde solo pueda hacer crud de usuarios y eventos
if ($_SESSION['tipo_user']=='administrador') {
    header("location:vista.administrador.php");
}
if ($_SESSION['email']=="") {
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
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <title>Reservas online</title>
    </head>
    <body>
        <!--Header-->
        <ul class="padding-lat">
            <li><a><?php echo $_SESSION["nombre"];?></a></li>
            <li class="right">
                <a href="../proceses/logout.proc.php">Logout</a>
            </li>
        </ul>
        <!--Header-->
        <!--nav-->
        <div class="row padding-top padding-lat">
            <div class="fondo">
                <button type="submit"><a type='button' href='vistahistorial.php'>Ver historial de reservas</a></button>
                <button type="submit"><a type='button' href='zona.admin.php'>Ver mesas</a></button>
                <?php
                    if ($_SESSION['tipo_user']=='mantenimiento') {
                        echo "<button type='submit'><a type='button' href='vistaincidencia.php'>Ver incidencias</a></button>";
                    }
                ?>
                <form action="vistareservasonline.php" method="post">
                    <div class="column-4">
                        <label for="Nombre">Nombre</label><br>
                        <input type="text" name="nombre" class="casilla">
                    </div>
                    <div class="column-4">
                        <label for="Apellido">Apellido</label><br>
                        <input type="text" name="apellido" class="casilla">
                    </div>
                    <div class="column-1">
                        <input type="submit" value="FILTRAR" name="filtrar" class="filtrar">
                    </div>
                </form>
            </div>
        </div><br>
        <!--nav-->
        <div class='row padding-top-less padding-lat'>
            <div>
            <table>
       <?php
       //Con filtro
       if (isset($_POST['filtrar'])) {
           $nombre=$_POST['nombre'];
           $apellido=$_POST['apellido'];
           $sentencia=$pdo->prepare("SELECT tbl_historialonline.id_historialonline,tbl_historialonline.email,tbl_historialonline.nombre,tbl_historialonline.apellido,DATE_FORMAT(tbl_historialonline.fecha,'%d/%m/%Y') as `fecha`,TIME_FORMAT(tbl_historialonline.hora,'%H:%i') as `hora`,tbl_historialonline.id_mesa,tbl_localizacion.* FROM tbl_historialonline
           INNER JOIN tbl_mesa ON tbl_mesa.id_mesa=tbl_historialonline.id_mesa INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion=tbl_localizacion.id_localizacion
           WHERE tbl_historialonline.nombre like '%{$nombre}%' and tbl_historialonline.apellido like '%{$apellido}'
           ORDER BY `fecha` DESC,`hora` DESC");
           $sentencia->execute();
           $mesas=$sentencia->fetchAll(PDO::FETCH_ASSOC);
           //Filtrar
           if (empty($mesas)) {
                echo "<div class='row padding-top-less padding-lat'>";
                echo "<div>";
                echo "<h1>No se han encontrado elementos....</h1>";
                echo "</div>";
                echo "</div>";
           }else{
            ?>
            <tr>
                <th class='blue'>Nombre</th>
                <th class='blue'>Apellido</th>
                <th class='blue'>Fecha</th>
                <th class='blue'>Hora</th>
                <th class='blue'>Numero de Mesa</th>
                <th class='blue'>Localizacion</th>
            </tr>
           <?php
           }
        //Sin filtro
       }else {
            //Cogemos las mesas y sitios con las localizaciones correspondientes
            $sentencia=$pdo->prepare("SELECT tbl_historialonline.id_historialonline,tbl_historialonline.email,tbl_historialonline.nombre,tbl_historialonline.apellido,DATE_FORMAT(tbl_historialonline.fecha,'%d/%m/%Y') as `fecha`,TIME_FORMAT(tbl_historialonline.hora,'%H:%i') as `hora`,tbl_historialonline.id_mesa,tbl_localizacion.* FROM tbl_historialonline
            INNER JOIN tbl_mesa ON tbl_mesa.id_mesa=tbl_historialonline.id_mesa INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion=tbl_localizacion.id_localizacion
            ORDER BY `fecha` DESC,`hora` DESC");
            $sentencia->execute();
            $mesas=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            if (empty($mesas)) {
                echo "<div class='row padding-top-less padding-lat'>";
                echo "<div>";
                echo "<h1>No hay ninguna reserva online....</h1>";
                echo "</div>";
                echo "</div>";
            }else{
                ?>
                <tr>
                <th class='blue'>Nombre</th>
                <th class='blue'>Apellido</th>
                <th class='blue'>Fecha</th>
                <th class='blue'>Hora</th>
                <th class='blue'>Numero de Mesa</th>
                <th class='blue'>Localizacion</th>
                </tr>
               <?php
                    foreach ($mesas as $row) {
                    echo  "<tr>";
                        echo "<td class='gris'>{$row['nombre']}</td>";
                        echo "<td class='gris'>{$row['apellido']}</td>";
                        echo "<td class='gris'>{$row['fecha']}</td>";
                        echo "<td class='gris'>{$row['hora']}</td>";
                        echo "<td class='gris'>{$row['id_mesa']}</td>";
                        echo "<td class='gris'>{$row['nombre_localizacion']}</td>";
                        echo "<td><button type='submit'><a type='button' href='../view/formmodificarreservaonline.php?id={$row['id_historialonline']}'>Modificar reserva</a></button></td>";
                        echo "<td><button type='submit'><a type='button' href='../proceses/eliminareservaonline.php?id={$row['id_historialonline']}'>Quitar reserva</a></button></td>";
                    echo "</tr>";
                }
            }
        }
       ?>
        </table>
        </div>
    </div>
    </body>
    </html>