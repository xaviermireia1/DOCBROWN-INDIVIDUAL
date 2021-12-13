<?php
session_start();
require_once '../services/connection.php';
if ((empty($_SESSION['email'])) || ($_SESSION['tipo_user']!="administrador")) {
    header("location:../view/login.html");
}else {
    $mesa=$_POST['mesa'];
    $silla=$_POST['silla'];
    $disponibilidad=$_POST['disponibilidad'];
    $idmesa=$_POST['idmesa'];
    $localizacion=$_POST['localizacion'];
    $modificarmesa=$pdo->prepare("UPDATE tbl_mesa SET mesa=$mesa,silla=$silla,disponibilidad='{$disponibilidad}',id_localizacion=$localizacion WHERE id_mesa='{$idmesa}'");
    try {
        $modificarmesa->execute();
        if (empty($modificarmesa)) {
            echo "No se ha ejecutado bien la sentencia";
        }else {
            header('location:../view/vista.administrador.php');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}