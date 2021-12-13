<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="") || ($_SESSION['tipo_user']!="administrador")) {
    header("location:../view/login.html");
}else {
    $nombre=$_POST['nombre'];
    $path="../img/".$_FILES['img']['name']; 
    if (move_uploaded_file($_FILES['img']['tmp_name'],$path)) {
        $sentencia=$pdo->prepare("INSERT INTO tbl_localizacion (nombre_localizacion,img) VALUES ('{$nombre}','{$path}')");
        $sentencia->execute();
        header("location:../view/localizaciones.php");
    }else{
        //En caso que no subio foto ponemos como nulo
        $sentencia=$pdo->prepare("INSERT INTO tbl_localizacion (nombre_localizacion,img) VALUES ('{$nombre}',null)");
        $sentencia->execute();
        header("location:../view/localizaciones.php");
    }
}