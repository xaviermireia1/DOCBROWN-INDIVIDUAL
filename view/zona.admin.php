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
        //$setmesaonline->execute();
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
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <script src="../js/script.js"></script>
        <title>Intranet</title>
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
                <button type="submit"><a type='button' href='vistareservasonline.php'>Ver reservas online</a></button>
                <?php
                    if ($_SESSION['tipo_user']=='mantenimiento') {
                        echo "<button type='submit'><a type='button' href='vistaincidencia.php'>Ver incidencias</a></button>";
                    }
                ?>
                <form action="zona.admin.php" method="post">
                    <div class="column-2">
                        <label for="localizacion">Ubicacion</label><br>
                        <select name="localizacion" class="casilla">
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
                    <div class="column-2">
                        <label for="mesa">Mesas</label><br>
                        <input type="number" min="1" placeholder="Introduce cantidad mesas..." name="mesa" class="casilla">
                    </div>
                    <div class="column-2">
                        <label for="silla">Personas</label><br>
                        <input type="number" min="1" placeholder="Introduce cantidad de personas..." name="silla" class="casilla">
                    </div>
                    <div class="column-2">
                    <label for="disponibilidad">¿Mesa disponible?</label><br>
                        <select name="disponibilidad" class="casilla">
                            <option value="" default>Todos</option>
                            <option value="si">Si</option>
                            <option value="no">No</option>
                            <option value="mantenimiento">Mantenimiento</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                    <div class="column-1">
                        <button type="submit" value="FILTRAR" name="filtrar" class="filtrar">Filtrar</button>
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
           $localizacion=$_POST['localizacion'];
           $mesa=$_POST['mesa'];
           $personas=$_POST['silla'];
           $disponibilidad=$_POST['disponibilidad'];
           $sentencia=$pdo->prepare("SELECT tbl_localizacion.id_localizacion,tbl_localizacion.nombre_localizacion,tbl_localizacion.img,tbl_mesa.id_mesa,tbl_mesa.mesa,tbl_mesa.silla,tbl_mesa.disponibilidad 
           FROM tbl_mesa 
           INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion=tbl_localizacion.id_localizacion
           WHERE tbl_localizacion.nombre_localizacion like '%{$localizacion}%' and tbl_mesa.mesa like '%{$mesa}' and tbl_mesa.silla like '%{$personas}' and tbl_mesa.disponibilidad like '%{$disponibilidad}%'
           ORDER BY tbl_mesa.id_mesa ASC");
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
                <th class='blue'>ID de Mesa</th>
                <th class='blue'>Localizacion</th>
                <th class='blue'>Nº Mesas</th>
                <th class='blue'>Nº Personas</th>
                <th class='blue'>Disponibilidad</th>
            </tr>
           <?php
           }
        //Sin filtro
       }else {
           ?>
            <tr>
                <th class='blue'>ID de Mesa</th>
                <th class='blue'>Localizacion</th>
                <th class='blue'>Nº Mesas</th>
                <th class='blue'>Nº Personas</th>
                <th class='blue'>Disponibilidad</th>
            </tr>
           <?php
            //Cogemos las mesas y sitios con las localizaciones correspondientes
            $sentencia=$pdo->prepare("SELECT tbl_localizacion.id_localizacion,tbl_localizacion.nombre_localizacion,tbl_localizacion.img,tbl_mesa.id_mesa,tbl_mesa.mesa,tbl_mesa.silla,tbl_mesa.disponibilidad 
            FROM tbl_mesa 
            INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion=tbl_localizacion.id_localizacion
            ORDER BY tbl_mesa.id_mesa ASC");
            $sentencia->execute();
            $mesas=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }
        foreach ($mesas as $row) {
                echo  "<tr>";
                    echo "<td class='gris'>{$row['id_mesa']}</td>";
                    echo "<td class='gris'>{$row['nombre_localizacion']}</td>";
                    echo "<td class='gris'>{$row['mesa']}</td>";
                    echo "<td class='gris'>{$row['silla']}</td>";
                    switch ($row['disponibilidad']) {
                        case 'si':
                            echo "<td class='gris'><i class='fas fa-check green'></i></td>";
                            if ($_SESSION['tipo_user']=='camarero') {
                                echo "<td><button type='submit'><a type='button' href='../proceses/agregareserva.php?idmesa={$row['id_mesa']}'>Reservar ya</a></button></td>";
                                echo "<td><button type='submit'><a type='button' href='../view/formagregarreservaonline.php?idmesa={$row['id_mesa']}'>Reservar online</a></button></td>";
                            }
                            echo "<td><button type='submit'><a type='button' href='formincidencia.php?idmesa={$row['id_mesa']}&idlocalizacion={$row['id_localizacion']}'>Añadir Incidencia</a></button></td>";
                            break;
                        
                        case 'no':
                            echo "<td class='gris'><i class='fas fa-times red'></i> <i class='fas fa-map-marker-alt red'></i></td>";
                            if ($_SESSION['tipo_user']=='camarero') {
                                echo "<td><button type='submit' class='buttononline'><a type='button' href='../proceses/eliminareserva.php?idmesa={$row['id_mesa']}'>Acabar reserva</a></button></td>";
                            }
                            break;
                        case 'mantenimiento':
                            if ($_SESSION['tipo_user']=='camarero') {
                                echo "<td class='gris'><i class='fas fa-briefcase brown'></i></td>";
                            }else{
                                echo "<td class='gris'><i class='fas fa-briefcase brown'></i></td>";
                                echo "<td><button type='submit' class='buttononline'><a type='button' href='../proceses/eliminarincidencia.php?idmesa={$row['id_mesa']}'>Eliminar Incidencia</a></button></td>";
                            }
                            break;
                        case 'online':
                            if ($_SESSION['tipo_user']=='camarero') {
                                echo "<td class='gris'><i class='fas fa-times red'></i> <i class='fas fa-globe red'></i></td>";
                                echo "<td><button type='submit'><a type='button' href='../view/vistareservasonline.php'>Ver reservas Online</a></button></td>";
                            }
                            break;
                    }
            echo "</tr>";
        }
       ?>
        </table>
        </div>
    </div>
    <?php
    if (!empty($_REQUEST['errorlocal'])) {
        if ($_REQUEST['errorlocal']==1) {
            echo "<script>yaReservado();</script>";
        }else if ($_REQUEST['error']==2) {
            echo "<script>reservaCorrecta();</script>";
        }   
    }
    if (!empty($_REQUEST['error'])) {
        if ($_REQUEST['error']==1) {
            echo "<script>yaReservadoOnline();</script>";
        }else if ($_REQUEST['error']==2) {
            echo "<script>reservaCorrecta();</script>";
        }   
    }
    ?>
    </body>
    </html>