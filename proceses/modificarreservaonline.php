<?php
require_once '../services/connection.php';
session_start();
if (empty($_POST['idhistorial']) && empty($_SESSION['nombre'])) {
    header("location:../view/index.php");
}elseif (empty($_POST['idhistorial'])) {
    header("location:../view/zona.admin.php");
}
$idhistorial=$_POST['idhistorial'];
$email=$_POST['email'];
$nombre=$_POST["nombre"];
$apellido=$_POST['apellido'];
$fecha=$_POST['fecha'];
$hora=$_POST['hora'];
$silla=$_POST['silla'];
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
$reservaocupada=$pdo->prepare("SELECT tbl_mesa.*
                                FROM tbl_mesa LEFT JOIN (SELECT * FROM tbl_historialonline WHERE tbl_historialonline.fecha ='{$fecha}' and (tbl_historialonline.hora BETWEEN '{$horamenos}' and '{$horamas}')) as qryreserva
                                ON  tbl_mesa.id_mesa=qryreserva.id_mesa
                                WHERE isnull(qryreserva.id_mesa) and tbl_mesa.silla=$silla
                                LIMIT 1");
$reservaocupada->execute();
$reservaocupada=$reservaocupada->fetchAll(PDO::FETCH_ASSOC);
if (!empty($reservaocupada)) {
        foreach ($reservaocupada as $row) {
            $actualizarreservaonline=$pdo->prepare("UPDATE tbl_historialonline SET email='{$email}',nombre='{$nombre}',apellido='{$apellido}',fecha='{$fecha}',hora='{$hora}',id_mesa={$row['id_mesa']} WHERE id_historialonline=$idhistorial");
            $actualizarreservaonline->execute();
        }
        if (empty($_SESSION['nombre'])) {
            header('location:../view/index.php');
        }else{
            header('location:../view/zona.admin.php');
        }
}else{
    if (empty($_SESSION['nombre'])) {
        exit(header('location:../view/index.php'));
    }else{
        exit(header('location:../view/zona.admin.php'));
    } 
}
