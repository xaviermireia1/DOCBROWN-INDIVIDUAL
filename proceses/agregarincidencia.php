<?php
session_start();
require_once '../services/connection.php';
if ($_SESSION['email']=="") {
    header("location:../view/login.html");
}else {
    $id_mesa=$_POST["idmesa"];
    $id_localizacion=$_POST["idlocalizacion"];
    $email=$_SESSION["email"];
    $descripcion=$_POST['description'];
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $pdo->exec("INSERT INTO tbl_incidencia (id_mesa,id_localizacion,email,descripcion_incidencia,fecha_inicio_incidencia,fecha_fin_incidencia,hora_inicio_incidencia,hora_final_incidencia) VALUES ({$id_mesa},{$id_localizacion},'{$email}','{$descripcion}',curdate(),null,curtime(),null)");
        $pdo->exec("UPDATE tbl_mesa SET disponibilidad='mantenimiento' WHERE id_mesa={$id_mesa}");
        $pdo->commit();
        header('location:../view/zona.admin.php');
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo $e->getMessage();
    }
}