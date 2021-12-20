<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="") || ($_SESSION['tipo_user']!="administrador")) {
    header("location:../view/login.html");
}else {
    $idmesa=$_GET['idmesa'];
    $historial=$pdo->prepare("SELECT * FROM tbl_historial WHERE id_mesa=$idmesa");
    $historialonline=$pdo->prepare("SELECT * FROM tbl_historialonline WHERE id_mesa=$idmesa");
    $historial->execute();
    $historialonline->execute();
    $historialres=$historial->fetchAll(PDO::FETCH_ASSOC);
    $historialonl=$historialonline->fetchAll(PDO::FETCH_ASSOC);
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        if (!empty($historialres)) {
            $pdo->exec("DELETE FROM tbl_historial WHERE id_mesa=$idmesa");
        }
        if (!empty($historialonl)) {
            $pdo->exec("DELETE FROM tbl_historialonline WHERE id_mesa=$idmesa");
        }
        $pdo->exec("DELETE FROM tbl_mesa WHERE id_mesa=$idmesa");
        $pdo->commit();
            header("location:../view/vista.administrador.php");
    }catch(PDOException $e){
        $pdo->rollBack();
        echo "Fallo: " . $e->getMessage();
    }
}