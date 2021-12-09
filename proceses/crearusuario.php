<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="") || ($_SESSION['tipo_user']!="administrador")) {
    header("location:../view/login.html");
}else {
    $email=$_POST["email"];
    $nombre=$_POST["nombre"];
    $apellido=$_POST["apellido"];
    $tipo=$_POST["option"];
    $password=$_POST["contraseña"];
    $agregar=$pdo->prepare("INSERT INTO tbl_usuario (email,nombre,apellido,contraseña,tipo) VALUES ('{$email}','{$nombre}','{$apellido}','md5({$password})','{$tipo}')");
    try {
        $agregar->execute();
        if (empty($agregar)){
            echo "No se ha ejecutado bien la sentencia";
        }else {
            header('location:../view/usuarios.php');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}