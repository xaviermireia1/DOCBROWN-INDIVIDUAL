<?php
session_start();
require_once '../services/connection.php';
if ((empty($_SESSION['email'])) || ($_SESSION['tipo_user']!="administrador")) {
    header("location:../view/login.html");
}else {
    $idlocalizacion=$_POST['idlocalizacion'];
    $nombre=$_POST['nombre'];
    $path="../img/".$_FILES['img']['name']; 
    if (move_uploaded_file($_FILES['img']['tmp_name'],$path)) {
        $sentencia=$pdo->prepare("UPDATE tbl_localizacion SET nombre_localizacion='{$nombre}',img='{$path}'WHERE id_localizacion=$idlocalizacion");
        $sentencia->execute();
        header("location:../view/localizaciones.php");
    }else{
        //Si no lo subio lo dejamos tal y como estamos y los datos correspondientes introducidos en el formulario
        $sentencia=$pdo->prepare("UPDATE tbl_localizacion SET nombre_localizacion='{$nombre}' WHERE id_localizacion=$idlocalizacion");
        $sentencia->execute();
        header("location:../view/localizaciones.php");
    }
}