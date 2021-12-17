<?php
require_once "../services/connection.php";
session_start();
if ($_SESSION['email']=="" || $_SESSION['tipo_user']!='administrador') {
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
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <link rel="shortcut icon" type="image/png" href="../img/logo.png" />
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
                <button type='submit'><a type='button' href='vista.administrador.php'>Ver mesas</a></button>
                <button type="submit"><a type='button' href='formcrearlocalizacion.php'>Crear localizacion</a></button>
                <form action="localizaciones.php" method="post">
                    <div class="column-2">
                        <label for="mesa">Localizacion</label>
                        <input type="text" placeholder="Introduce la localizacion.." name="localizacion" class="casilla">
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
           if ($_POST['localizacion']!=null) {
                $localizacion=$_POST['localizacion'];
                $sentencia=$pdo->prepare("SELECT * FROM tbl_localizacion WHERE nombre_localizacion like '%{$localizacion}%'");
           }else{
                $sentencia=$pdo->prepare("SELECT * FROM tbl_localizacion");
           }
           $sentencia->execute();
           $localizaciones=$sentencia->fetchAll(PDO::FETCH_ASSOC);
           //Filtrar
           if (empty($localizaciones)) {
                echo "<div class='row padding-top-less padding-lat'>";
                echo "<div>";
                echo "<h1>No se han encontrado elementos....</h1>";
                echo "</div>";
                echo "</div>";
           }else{
               ?>
                <tr>
                    <th class='blue'>ID de localizacion</th>
                    <th class='blue'>Nombre de localizacion</th>
                    <th class='blue'>Imagen</th>
                </tr>
                <?php
           }
        //Sin filtro
       }else {
            ?>
            <tr>
                <th class='blue'>ID de localizacion</th>
                <th class='blue'>Nombre de localizacion</th>
                <th class='blue'>Imagen</th>
            </tr>
            <?php
            //Cogemos las mesas y sitios con las localizaciones correspondientes
            $sentencia=$pdo->prepare("SELECT * FROM tbl_localizacion");
            $sentencia->execute();
            $localizaciones=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }
        foreach ($localizaciones as $row) {
                    echo  "<tr>";
                        echo "<td class='gris'>{$row['id_localizacion']}</td>";
                        echo "<td class='gris'>{$row['nombre_localizacion']}</td>";
                        echo "<td class='gris'><img src='{$row['img']}'></td>";
                        echo "<td><button type='submit'><a type='button' href='../view/formmodificarlocalizacion.php?id={$row['id_localizacion']}'>Modificar localizacion</a></button></td>";
                        echo "<td><button class='buttononline' type='submit'><a type='button' href='../proceses/eliminarlocalizacion.php?id={$row['id_localizacion']}'>Eliminar localizacion</a></button></td>";
                    echo "</tr>";
                }
       ?>
        </table>
        </div>
    </div>
    </body>
    </html>