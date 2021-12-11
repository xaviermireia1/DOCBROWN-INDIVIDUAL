<?php
require_once "../services/connection.php";
session_start();
if ($_SESSION['email']=="" || $_SESSION['tipo_user']!='administrador') {
    header("location:login.html");
}
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <title>Administrador</title>
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
                <button type='submit'><a type='button' href='usuarios.php'>Ver usuarios</a></button>
                <button type="submit"><a type='button' href='formcrearmesa.php'>Crear mesa</a></button>
                <form action="vista.administrador.php" method="post">
                    <div class="column-1">
                        <br><label for="mesa">Numero de Mesa</label><br>
                        <input type="number" min='1' placeholder="Introduce el numero de mesa..." name="mesa" class="casilla">
                    </div>
                    <div class="column-1">
                        <br>
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
           if ($_POST['mesa']!=null) {
                $mesa=$_POST['mesa'];
                $sentencia=$pdo->prepare("SELECT tbl_localizacion.id_localizacion,tbl_localizacion.nombre_localizacion,tbl_localizacion.img,tbl_mesa.id_mesa,tbl_mesa.mesa,tbl_mesa.silla,tbl_mesa.disponibilidad 
                FROM tbl_mesa 
                INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion=tbl_localizacion.id_localizacion
                WHERE tbl_mesa.id_mesa like '%'+$mesa+'%'
                ORDER BY tbl_mesa.id_mesa ASC");
           }else{
                $sentencia=$pdo->prepare("SELECT tbl_localizacion.id_localizacion,tbl_localizacion.nombre_localizacion,tbl_localizacion.img,tbl_mesa.id_mesa,tbl_mesa.mesa,tbl_mesa.silla,tbl_mesa.disponibilidad 
                FROM tbl_mesa 
                INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion=tbl_localizacion.id_localizacion
                ORDER BY tbl_mesa.id_mesa ASC");
           }
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
                            echo "<td><button type='submit'><a type='button' href='../view/formmodificarmesa.php?idmesa={$row['id_mesa']}&disponibilidad={$row['disponibilidad']}'>Modificar mesa</a></button></td>";
                            echo "<td><button type='submit'><a type='button' href='../proceses/eliminarmesa.php?idmesa={$row['id_mesa']}'>Eliminar mesa</a></button></td>";
                            break;                       
                        case 'no':
                            echo "<td class='gris'><i class='fas fa-times red'></i></td>";
                            echo "<td><button type='submit'><a type='button' href='../view/formmodificarmesa.php?idmesa={$row['id_mesa']}&disponibilidad={$row['disponibilidad']}'>Modificar mesa</a></button></td>";
                            break;
                        case 'mantenimiento':
                            echo "<td class='gris'><i class='fas fa-briefcase brown'></i></td>";
                            echo "<td><button type='submit'><a type='button' href='../view/formmodificarmesa.php?idmesa={$row['id_mesa']}&disponibilidad={$row['disponibilidad']}'>Modificar mesa</a></button></td>";
                            echo "<td><button type='submit'><a type='button' href='../proceses/eliminarmesa.php?idmesa={$row['id_mesa']}'>Eliminar mesa</a></button></td>";
                            break;
                    }
            echo "</tr>";
                }
       ?>
        </table>
        </div>
    </div>
    </body>
    </html>