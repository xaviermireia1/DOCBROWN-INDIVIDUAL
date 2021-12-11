<?php
session_start();
require_once '../services/connection.php';
if ((empty($_SESSION['email'])) || ($_SESSION['tipo_user']!="administrador")) {
    header("location:../view/login.html");
}else {
    $email=$_GET['email'];
    $historial=$pdo->prepare("SELECT * FROM tbl_historial WHERE email='{$email}'");
    $historial->execute();
    $historialexist=$historial->fetchAll(PDO::FETCH_ASSOC);
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        if (!empty($historialexist)) {
            $pdo->exec("DELETE FROM tbl_historial WHERE email='{$email}'");
        }
        $pdo->exec("DELETE FROM tbl_usuario WHERE email='{$email}'");
        $pdo->commit();
        header("location:../view/usuarios.php");
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo $e->getMessage();
    }
}