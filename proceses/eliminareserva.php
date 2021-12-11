<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="") || ($_SESSION['tipo_user']=="mantenimiento")) {
    header("location:../view/login.html");
}else {
    $id_mesa=$_GET['idmesa'];
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $pdo->exec("UPDATE tbl_historial SET fin_historial=curtime() WHERE id_mesa={$id_mesa} and isnull(fin_historial)");
        $pdo->exec("UPDATE tbl_mesa SET disponibilidad='si' WHERE id_mesa={$id_mesa}");
        $pdo->commit();
        header('location:../view/zona.admin.php');
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo $e->getMessage();
    }
}