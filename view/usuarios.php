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
            <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
            <title>Administrador</title>
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
                <button type='submit'><a type='button' href='localizaciones.php'>Ver localizaciones</a></button>
                <button type='submit'><a type='button' href='vista.administrador.php'>Ver mesas</a></button>
                <button type="submit"><a type='button' href='formcrearuser.php'>Añadir usuario</a></button>
                <form action="usuarios.php" method="post">
                    <div class="column-4">
                        <label for="name">Nombre</label><br>
                        <input type="text" placeholder="Introduce nombre..." name="nombre" class="casilla">
                    </div>
                    <div class="column-4">
                        <label for="apellido">Apellido</label><br>
                        <input type="text" placeholder="Introduce apellido..." name="apellido" class="casilla">
                    </div>
                    <div class="column-1">
                        <input type="submit" value="FILTRAR" name="filtrar" class="filtrar">
                    </div>
                </form>
            </div>
        </div>
            </div>
        </div>
        <?php
            if (isset($_POST["filtrar"])) {
                $nombre=$_POST["nombre"];
                $apellido=$_POST["apellido"];
                $sentencia=$pdo->prepare("SELECT email,nombre,apellido,tipo FROM tbl_usuario WHERE nombre like '%{$nombre}%' AND apellido like '%{$apellido}%'");
                $sentencia->execute();
                $comprobacion=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $sentencia=$pdo->prepare("SELECT email,nombre,apellido,tipo FROM tbl_usuario");
                $sentencia->execute();
                $comprobacion=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            }
            if (empty($comprobacion)) {
                echo  "<div class='row padding-top-less padding-lat'>";
                echo  "<div>";
                echo "<h1>No se ha encontrado resultados</h1>";
                echo "</div>";
                echo "</div>";
            }else{
                echo  "<div class='row padding-top-less padding-lat'>";
                echo  "<div>";
                echo  "<table>";
                echo  "<tr>";
                echo  "<th class='blue'>Email</th>";
                echo  "<th class='blue'>Nombre</th>";
                echo  "<th class='blue'>Apellido</th>";
                echo  "<th class='blue'>Tipo</th>";
                echo  "</tr>";
                foreach ($comprobacion as $row) {
                    if ($row["nombre"]==$_SESSION['nombre']) {
                        # code...
                    }else{
                        echo "<tr>";
                        echo "<td class='gris'>{$row['email']}</td>";
                        echo "<td class='gris'>{$row['nombre']}</td>";
                        echo "<td class='gris'>{$row['apellido']}</td>";
                        echo "<td class='gris'>{$row['tipo']}</td>";
                        echo "<td><button type='submit'><a type='button' href='../view/formmodificarusuario.php?email={$row['email']}'>Modificar usuario</a></button></td>";
                        echo "<td><button class='buttononline' type='submit'><a type='button' href='../proceses/eliminarusuario.php?email={$row['email']}'>Eliminar usuario</a></button></td>";
                        echo "<tr>";
                    }
                }
                echo  "</div>";
                echo  "</div>";
                echo  "</table>";
            }
        ?>
        </body>
        </html>
    <?php
}