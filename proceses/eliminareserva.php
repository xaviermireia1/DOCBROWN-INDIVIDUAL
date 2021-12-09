<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="") || ($_SESSION['tipo_user']=="mantenimiento")) {
    header("location:../view/login.html");
}else {
    $id_mesa=$_GET['idmesa'];
    $quitarreserva=$pdo->prepare("UPDATE tbl_historial SET fin_historial=curtime() WHERE id_mesa={$id_mesa} and isnull(fin_historial)");
    $disponibilidad=$pdo->prepare("UPDATE tbl_mesa SET disponibilidad='si' WHERE id_mesa={$id_mesa}");
    try {
        $quitarreserva->execute();
        $disponibilidad->execute();
        if (empty($quitarreserva) && empty($disponibilidad)) {
            echo "No se ha ejecutado bien la sentencia";
        }else {
            header('location:../view/zona.admin.php');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}