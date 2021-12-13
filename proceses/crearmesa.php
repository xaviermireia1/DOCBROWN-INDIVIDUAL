<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="") || ($_SESSION['tipo_user']!="administrador")) {
    header("location:../view/login.html");
}else {
    $cantmesas=$_POST['mesa'];
    $cantsillas=$_POST['silla'];
    $localizacion=$_POST['localizacion'];
    $agregar=$pdo->prepare("INSERT INTO tbl_mesa (mesa,silla,disponibilidad,id_localizacion) VALUES ($cantmesas,$cantsillas,'si',$localizacion)");
    try {
        $agregar->execute();
        if (empty($agregar)){
            echo "No se ha ejecutado bien la sentencia";
        }else {
            header('location:../view/vista.administrador.php');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}