<?php
require_once "../services/connection.php";
session_start();
if ($_SESSION['email']=="" || $_SESSION['tipo_user']!='administrador') {
    header("location:login.html");
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
                <button type="submit"><a type='button' href='vistahistorial.php'>Ver historial de reservas</a></button>
                <button type='submit'><a type='button' href='usuarios.php'>Ver usuarios</a></button>
                <button type="submit"><a type='button' href='formcrearmesa.php'>Crear mesa</a></button>
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
                        <input type="number" placeholder="Introduce cantidad mesas..." name="mesa" class="casilla">
                    </div>
                    <div class="column-2">
                        <label for="silla">Personas</label><br>
                        <input type="number" placeholder="Introduce cantidad de personas..." name="silla" class="casilla">
                    </div>
                    <div class="column-2">
                    <label for="disponibilidad">¿Mesa disponible?</label><br>
                        <select name="disponibilidad" class="casilla">
                            <option value="" default>Todos</option>
                            <option value="si">Si</option>
                            <option value="no">No</option>
                            <option value="mantenimiento">Mantenimiento</option>
                        </select>
                    </div>
                    <div class="column-1">
                        <input type="submit" value="FILTRAR" name="filtrar" class="filtrar">
                    </div>
                </form>
            </div>
        </div><br>
        <!--nav-->
       <?php
       //Con filtro
       if (isset($_POST['filtrar'])) {
           $localizacion=$_POST['localizacion'];
           $mesa=$_POST['mesa'];
           $personas=$_POST['silla'];
           $disponibilidad=$_POST['disponibilidad'];
           $filtro=$pdo->prepare("SELECT tbl_localizacion.id_localizacion,tbl_localizacion.nombre_localizacion,tbl_localizacion.img,tbl_mesa.id_mesa,tbl_mesa.mesa,tbl_mesa.silla,tbl_mesa.disponibilidad 
           FROM tbl_mesa 
           INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion=tbl_localizacion.id_localizacion
           WHERE tbl_localizacion.nombre_localizacion like '%{$localizacion}%' and tbl_mesa.mesa like '%{$mesa}' and tbl_mesa.silla like '%{$personas}' and tbl_mesa.disponibilidad like '%{$disponibilidad}%'
           ORDER BY tbl_mesa.id_mesa ASC");
           $filtro->execute();
           $filtrar=$filtro->fetchAll(PDO::FETCH_ASSOC);
           //Filtrar
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
            echo  "<th class='blue'>ID de Mesa</th>";
            echo  "<th class='blue'>Localizacion</th>";
            echo  "<th class='blue'>Nº Mesas</th>";
            echo  "<th class='blue'>Nº Personas</th>";
            echo  "</tr>";
            foreach ($filtrar as $row) {
                //Ponemos primero la localización
                    echo  "<tr>";
                        echo "<td class='gris'>{$row['id_mesa']}</td>";
                        echo "<td class='gris'>{$row['nombre_localizacion']}</td>";
                        echo "<td class='gris'>{$row['mesa']}</td>";
                        echo "<td class='gris'>{$row['silla']}</td>";
                        echo "<td><button type='submit'><a type='button' href='../view/formmodificarmesa.php?id={$row['id_mesa']}'>Modificar mesa</a></button></td>";
                        echo "<td><button type='submit'><a type='button' href='../proceses/eliminarmesa.php?id={$row['id_mesa']}&disponibilidad={$row['disponibilidad']}'>Eliminar mesa</a></button></td>";  
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
            echo "</div>";
           }
        //Sin filtro
       }else {
                //Cogemos las mesas y sitios con las localizaciones correspondientes
                $sentencia=$pdo->prepare("SELECT tbl_localizacion.id_localizacion,tbl_localizacion.nombre_localizacion,tbl_localizacion.img,tbl_mesa.id_mesa,tbl_mesa.mesa,tbl_mesa.silla,tbl_mesa.disponibilidad 
                FROM tbl_mesa 
                INNER JOIN tbl_localizacion ON tbl_mesa.id_localizacion=tbl_localizacion.id_localizacion
                ORDER BY tbl_mesa.id_mesa ASC");
                $sentencia->execute();
                echo  "<div class='row padding-top-less padding-lat'>";
                echo  "<div>";
                echo  "<table>";
                echo  "<tr>";
                echo  "<th class='blue'>ID de Mesa</th>";
                echo  "<th class='blue'>Localizacion</th>";
                echo  "<th class='blue'>Nº de Mesas</th>";
                echo  "<th class='blue'>Nº Personas</th>";
                echo  "</tr>";
                foreach ($sentencia as $localizacion) {
                    //Ponemos primero la localización
                    echo  "<tr>";
                        echo "<td class='gris'>{$localizacion['id_mesa']}</td>";
                        echo "<td class='gris'>{$localizacion['nombre_localizacion']}</td>";
                        echo "<td class='gris'>{$localizacion['mesa']}</td>";
                        echo "<td class='gris'>{$localizacion['silla']}</td>";
                        echo "<td><button type='submit'><a type='button' href='../view/formmodificarmesa.php?id={$localizacion['id_mesa']}'>Modificar mesa</a></button></td>";
                        echo "<td><button type='submit'><a type='button' href='../proceses/eliminarmesa.php?id={$localizacion['id_mesa']}&disponibilidad={$localizacion['disponibilidad']}'>Eliminar mesa</a></button></td>";             
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
                echo "</div>";
       }
       ?>
    </body>
    </html>