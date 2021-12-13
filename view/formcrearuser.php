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
    <title>Añadir usuario</title>
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
        <form action="../proceses/crearusuario.php" method="post">
            <label>Email</label><br><br>
            <input type="email" name="email" id="email">
            <br><br><label>Nombre</label><br><br>
            <input type="text" name="nombre" id="nombre">
            <br><br><label>Apellido</label><br><br>
            <input type="text" name="apellido" id="apellido">
            <br><br><label>Tipo usuario</label><br><br>
            <select name="option" id="option">
                <option value="mantenimiento">Mantenimiento</option>
                <option value="administrador">Administrador</option>
                <option value="camarero">Camarero</option>
            </select>
            <br><br><label>Contraseña</label><br><br>
            <input type="password" name="contraseña" id="contraseña">
             <br><br>
             <div class="column-1">
                <input class="filtrar" type="submit" value="Crear usuario">
            </div>
        </form>
    </div>
    </div>
</body>
</html>