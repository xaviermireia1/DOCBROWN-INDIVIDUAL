<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="") || ($_SESSION['tipo_user']=="camarero")) {
    header("location:../view/login.html");
}else {
    $id_mesa=$_GET['idmesa'];
    $resuelto=$_SESSION['nombre'];
    $quitarincidencia=$pdo->prepare("UPDATE tbl_incidencia SET fecha_fin_incidencia=curdate(),hora_final_incidencia=curtime(),resuelto='{$resuelto}' WHERE id_mesa={$id_mesa} and isnull(fecha_fin_incidencia) and isnull(hora_final_incidencia)");
    $disponibilidad=$pdo->prepare("UPDATE tbl_mesa SET disponibilidad='si' WHERE id_mesa={$id_mesa}");
    try {
        $quitarincidencia->execute();
        $disponibilidad->execute();
        if (empty($quitarincidencia) && empty($disponibilidad)) {
            echo "No se ha ejecutado bien la sentencia";
        }else {
            header('location:../view/zona.admin.php');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}