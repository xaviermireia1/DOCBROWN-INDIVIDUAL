<?php
session_start();
require_once '../services/connection.php';
if ((empty($_SESSION['email'])) || ($_SESSION['tipo_user']!="administrador")) {
    header("location:../view/login.html");
}else {
    $email=$_GET['email'];
    $quitarusuario=$pdo->prepare("DELETE FROM tbl_usuario WHERE email='{$email}'");
    try {
        $quitarusuario->execute();
        if (empty($quitarusuario)) {
            echo "No se ha ejecutado bien la sentencia";
        }else {
            header('location:../view/usuarios.php');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}