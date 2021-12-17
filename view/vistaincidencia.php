<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="") || ($_SESSION["tipo_user"]!="mantenimiento")) {
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
        <title>Incidencias</title>
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
            <button type="submit"><a type='button' href='zona.admin.php'>VER MESAS</a></button>
            <button type="submit"><a type='button' href='vistahistorial.php'>VER HISTORIAL DE RESERVAS</a></button>
            <form action="vistaincidencia.php" method="post">
                <div class="column-4"><br>
                    <label for="name">¿Quien hizo la incidencia?</label>
                    <input type="text" name="nombre" id="nombre" class="casilla">
                </div>
                    <div class="column-1">
                        <input class="filtrar" type="submit" value="FILTRAR" name="filtrar">
                    </div>
            </form>
            </div>
        </div>
        <?php
            //Con filtros
            if (isset($_POST['filtrar'])) {
                $nombre=$_POST["nombre"];
                $filtro=$pdo->prepare("SELECT tbl_incidencia.*,tbl_usuario.nombre FROM tbl_incidencia INNER JOIN tbl_usuario on tbl_incidencia.email=tbl_usuario.email WHERE tbl_usuario.nombre like '%{$nombre}%' ORDER BY fecha_inicio_incidencia DESC,hora_inicio_incidencia DESC");
                $filtro->execute();
                $filtrar=$filtro->fetchAll(PDO::FETCH_ASSOC);               
                if (empty($filtrar)) {
                    echo "<div class='row padding-top-less padding-lat'>";
                    echo "<div>";
                    echo "<h1>No se han encontrado elementos....</h1>";
                    echo "</div>";
                    echo "</div>";
                }else {
                    for ($i=0; $i < count($filtrar); $i++) { 
                        if ($i==0) {
                            echo  "<div class='row padding-top-less padding-lat'>";
                            echo  "<div>";
                            echo  "<table>";
                            echo  "<tr>";
                            echo  "<th class='blue'>Nº Incidencia</th>";
                            echo  "<th class='blue'>Nº de Mesa</th>";
                            echo  "<th class='blue'>Persona</th>";
                            echo  "<th class='blue'>Descripción</th>";
                            echo  "<th class='blue'>Fecha inicio incidencia</th>";
                            echo  "<th class='blue'>Hora inicio de reserva</th>";
                            echo  "<th class='blue'>Fecha fin incidencia</th>";
                            echo  "<th class='blue'>Hora fin de reserva</th>";
                            echo  "<th class='blue'>Resuelto por</th>";
                            echo  "</tr>";
                            }
                    if (is_null($filtrar[$i]['fecha_fin_incidencia']) && is_null($filtrar[$i]['hora_final_incidencia']) && is_null($filtrar[$i]['resuelto'])) {
                                echo "<tr>";
                                echo "<td class='gris'>{$filtrar[$i]['id_incidencia']}</td>";
                                echo "<td class='gris'>{$filtrar[$i]['id_mesa']}</td>";
                                echo "<td class='gris'>{$filtrar[$i]['nombre']}</td>";
                                echo "<td class='gris'>{$filtrar[$i]['descripcion_incidencia']}</td>";
                                echo "<td class='gris'>{$filtrar[$i]['fecha_inicio_incidencia']}</td>";
                                echo "<td class='gris'>{$filtrar[$i]['hora_inicio_incidencia']}</td>";
                                echo "<td><button type='submit'><a type='button' href='../proceses/eliminarincidencia.php?idmesa={$filtrar[$i]['id_mesa']}'>Eliminar Incidencia</a></button></td>";
                                echo  "</tr>";
                    }else {
                            echo "<tr>";
                            echo "<td class='gris'>{$filtrar[$i]['id_incidencia']}</td>";
                            echo "<td class='gris'>{$filtrar[$i]['id_mesa']}</td>";
                            echo "<td class='gris'>{$filtrar[$i]['nombre']}</td>";
                            echo "<td class='gris'>{$filtrar[$i]['descripcion_incidencia']}</td>";
                            echo "<td class='gris'>{$filtrar[$i]['fecha_inicio_incidencia']}</td>";
                            echo "<td class='gris'>{$filtrar[$i]['hora_inicio_incidencia']}</td>";
                            echo "<td class='gris'>{$filtrar[$i]['fecha_fin_incidencia']}</td>";
                            echo "<td class='gris'>{$filtrar[$i]['hora_final_incidencia']}</td>";
                            echo "<td class='gris'>{$filtrar[$i]['resuelto']}</td>";
                            echo  "</tr>";
                        }
                    }echo "</table>";
                    echo "</div>";
                    echo "</div>";
                }
                //Sin filtros
            }else {
                $sinfiltro=$pdo->prepare("SELECT tbl_incidencia.*,tbl_usuario.nombre FROM tbl_incidencia INNER JOIN tbl_usuario on tbl_incidencia.email=tbl_usuario.email ORDER BY fecha_inicio_incidencia DESC,hora_inicio_incidencia DESC");
                $sinfiltro->execute();
                $sinfiltrar=$sinfiltro->fetchAll(PDO::FETCH_ASSOC);               
                if (empty($sinfiltrar)) {
                    echo "<div class='row padding-top-less padding-lat'>";
                    echo "<div>";
                    echo "<h1>No se han encontrado elementos....</h1>";
                    echo "</div>";
                    echo "</div>";
                }else {
                    for ($i=0; $i < count($sinfiltrar); $i++) { 
                        if ($i==0) {
                            echo  "<div class='row padding-top-less padding-lat'>";
                            echo  "<div>";
                            echo  "<table>";
                            echo  "<tr>";
                            echo  "<th class='blue'>Nº Incidencia</th>";
                            echo  "<th class='blue'>Nº de Mesa</th>";
                            echo  "<th class='blue'>Persona</th>";
                            echo  "<th class='blue'>Descripción</th>";
                            echo  "<th class='blue'>Fecha inicio incidencia</th>";
                            echo  "<th class='blue'>Hora inicio de reserva</th>";
                            echo  "<th class='blue'>Fecha fin incidencia</th>";
                            echo  "<th class='blue'>Hora fin de reserva</th>";
                            echo  "<th class='blue'>Resuelto por</th>";
                            echo  "</tr>";
                            }
                    if (is_null($sinfiltrar[$i]['fecha_fin_incidencia']) && is_null($sinfiltrar[$i]['hora_final_incidencia']) && is_null($sinfiltrar[$i]['resuelto'])) {
                                echo "<tr>";
                                echo "<td class='gris'>{$sinfiltrar[$i]['id_incidencia']}</td>";
                                echo "<td class='gris'>{$sinfiltrar[$i]['id_mesa']}</td>";
                                echo "<td class='gris'>{$sinfiltrar[$i]['nombre']}</td>";
                                echo "<td class='gris'>{$sinfiltrar[$i]['descripcion_incidencia']}</td>";
                                echo "<td class='gris'>{$sinfiltrar[$i]['fecha_inicio_incidencia']}</td>";
                                echo "<td class='gris'>{$sinfiltrar[$i]['hora_inicio_incidencia']}</td>";
                                echo "<td><button type='submit'><a type='button' href='../proceses/eliminarincidencia.php?idmesa={$sinfiltrar[$i]['id_mesa']}'>Eliminar Incidencia</a></button></td>";
                                echo  "</tr>";
                    }else {
                            echo "<tr>";
                            echo "<td class='gris'>{$sinfiltrar[$i]['id_incidencia']}</td>";
                            echo "<td class='gris'>{$sinfiltrar[$i]['id_mesa']}</td>";
                            echo "<td class='gris'>{$sinfiltrar[$i]['nombre']}</td>";
                            echo "<td class='gris'>{$sinfiltrar[$i]['descripcion_incidencia']}</td>";
                            echo "<td class='gris'>{$sinfiltrar[$i]['fecha_inicio_incidencia']}</td>";
                            echo "<td class='gris'>{$sinfiltrar[$i]['hora_inicio_incidencia']}</td>";
                            echo "<td class='gris'>{$sinfiltrar[$i]['fecha_fin_incidencia']}</td>";
                            echo "<td class='gris'>{$sinfiltrar[$i]['hora_final_incidencia']}</td>";
                            echo "<td class='gris'>{$sinfiltrar[$i]['resuelto']}</td>";
                            echo  "</tr>";
                        }
                    }echo "</table>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        ?>
    </body>
    </html>
    <?php
}