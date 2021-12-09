<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="")) {
    header("location:../view/login.html");
}else {
    $id_mesa=$_POST["idmesa"];
    $id_localizacion=$_POST["idlocalizacion"];
    $nombre=$_SESSION["nombre"];
    $descripcion=$_POST['description'];
    $agregar=$pdo->prepare("INSERT INTO tbl_incidencia (id_mesa,id_localizacion,nombre,descripcion_incidencia,fecha_inicio_incidencia,fecha_fin_incidencia,hora_inicio_incidencia,hora_final_incidencia) VALUES ({$id_mesa},{$id_localizacion},'{$nombre}','{$descripcion}',curdate(),null,curtime(),null)");
    $disponibilidad=$pdo->prepare("UPDATE tbl_mesa SET disponibilidad='mantenimiento' WHERE id_mesa={$id_mesa}");
    try {
        $agregar->execute();
        $disponibilidad->execute();
        if (empty($agregar) && empty($disponibilidad)) {
            echo "No se ha ejecutado bien la sentencia";
        }else {
            header('location:../view/zona.admin.php');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}