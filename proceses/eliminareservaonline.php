<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="") || ($_SESSION['tipo_user']=="mantenimiento")) {
    header("location:../view/login.html");
}else {
    $id_historial=$_GET['id'];
    $historialonline=$pdo->prepare("SELECT * FROM tbl_historialonline WHERE id_historialonline=$id_historial");
    $historialonline->execute();
    $historialonline=$historialonline->fetchAll(PDO::FETCH_ASSOC);
    foreach ($historialonline as $row) {
        $idmesa=$row["id_mesa"];
    }
    $mesaocupadalibre=$pdo->prepare("SELECT * FROM tbl_mesa WHERE id_mesa=$idmesa");
    $mesaocupadalibre->execute();
    $mesaocupadalibre=$mesaocupadalibre->fetchAll(PDO::FETCH_ASSOC);
    foreach ($mesaocupadalibre as $row) {
        $disponibilidad=$row['disponibilidad'];
    }
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $pdo->exec("DELETE FROM tbl_historialonline WHERE id_historialonline={$id_historial}");
        switch ($disponibilidad) {
            case 'si':
                $pdo->exec("UPDATE tbl_mesa SET disponibilidad='si' WHERE id_mesa={$idmesa}");
                break;
            case 'no':
                $pdo->exec("UPDATE tbl_mesa SET disponibilidad='no' WHERE id_mesa={$idmesa}");
                break;
            case 'mantenimiento':
                $pdo->exec("UPDATE tbl_mesa SET disponibilidad='mantenimiento' WHERE id_mesa={$idmesa}");
                break;
            case 'online':
                $pdo->exec("UPDATE tbl_mesa SET disponibilidad='si' WHERE id_mesa={$idmesa}");
                break;
        }
        $pdo->commit();
        header('location:../view/vistareservasonline.php');
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo $e->getMessage();
    }
}