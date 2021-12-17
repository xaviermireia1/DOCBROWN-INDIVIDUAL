<?php
require_once '../services/connection.php';
session_start();
if (empty($_POST['idmesa'])) {
    header("location:../view/index.php");
}
$idmesa=$_POST['idmesa'];
$email=$_POST['email'];
$fecha=$_POST['fecha'];
$hora=$_POST['hora'];
//Convertir hora menos
$horamenos=strtotime('-30 minute',strtotime($hora));
$horamenos = date('H:i',$horamenos);
//Convertir hora mas
$horamas=strtotime('+30 minute',strtotime($hora));
$horamas = date('H:i',$horamas);
//Comprobar email existe
$emailexiste=$pdo->prepare("SELECT * FROM tbl_historialonline WHERE email='{$email}'");
$emailexiste->execute();
$emailexiste=$emailexiste->fetchAll(PDO::FETCH_ASSOC);
//Comprobar si hay una reserva antes o despues de 59min
$reservaocupada=$pdo->prepare("SELECT * FROM tbl_historialonline WHERE id_mesa=$idmesa and fecha='{$fecha}' and (hora BETWEEN '{$horamenos}' and '{$horamas}')");
$reservaocupada->execute();
$reservaocupada=$reservaocupada->fetchAll(PDO::FETCH_ASSOC);
if (!empty($reservaocupada)) {
    if (empty($_SESSION['nombre'])) {
        exit(header('location:../view/index.php'));
    }else{
        exit(header('location:../view/zona.admin.php'));
    }
}else{
    if (empty($emailexiste)) {
            $nombre=$_POST["nombre"];
            $apellido=$_POST['apellido'];
    }else{
        foreach ($emailexiste as $row) {
            $nombre=$row['nombre'];
            $apellido=$row['apellido'];
        }
    }
    $insertarreservaonline=$pdo->prepare("INSERT INTO tbl_historialonline (email,nombre,apellido,fecha,hora,id_mesa) VALUES ('{$email}','{$nombre}','{$apellido}','{$fecha}','$hora',$idmesa)");
    $insertarreservaonline->execute();
    if (empty($_SESSION['nombre'])) {
        header('location:../view/reservasonlineclient.php');
    }else{
        header('location:../view/zona.admin.php');
    }
}
