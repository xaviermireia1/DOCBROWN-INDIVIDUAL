<?php
session_start();
require_once '../services/connection.php';
if ((empty($_SESSION['email'])) || ($_SESSION['tipo_user']!="administrador")) {
    header("location:../view/login.html");
}else {
    $email=$_POST['email'];
    $nombre=$_POST['nombre'];
    $apellido=$_POST['apellido'];
    $tipo=$_POST['option'];
    $modificarusuario=$pdo->prepare("UPDATE tbl_usuario SET nombre='{$nombre}',apellido='{$apellido}',tipo='{$tipo}' WHERE email='{$email}'");
    try {
        $modificarusuario->execute();
        if (empty($modificarusuario)) {
            echo "No se ha ejecutado bien la sentencia";
        }else {
            header('location:../view/usuarios.php');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}