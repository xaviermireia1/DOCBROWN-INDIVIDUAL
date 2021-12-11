<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="") || ($_SESSION['tipo_user']=="camarero")) {
    header("location:../view/login.html");
}else {
    $id_mesa=$_GET['idmesa'];
    $resuelto=$_SESSION['nombre'];
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $pdo->exec("UPDATE tbl_incidencia SET fecha_fin_incidencia=curdate(),hora_final_incidencia=curtime(),resuelto='{$resuelto}' WHERE id_mesa={$id_mesa} and isnull(fecha_fin_incidencia) and isnull(hora_final_incidencia)");
        $pdo->exec("UPDATE tbl_mesa SET disponibilidad='si' WHERE id_mesa={$id_mesa}");
        $pdo->commit();
        header('location:../view/zona.admin.php');
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo $e->getMessage();
    }
}