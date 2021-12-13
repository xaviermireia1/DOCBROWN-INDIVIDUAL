<?php
session_start();
require_once '../services/connection.php';
if ((empty($_SESSION['email'])) || ($_SESSION['tipo_user']!="administrador")) {
    header("location:../view/login.html");
}else {
    $idmesas=[];
    $idlocalizacion=$_GET['id'];
    $mesas=$pdo->prepare("SELECT * FROM tbl_mesa WHERE id_localizacion='{$idlocalizacion}'");
    $mesas->execute();
    $mesa=$mesas->fetchAll(PDO::FETCH_ASSOC);
    foreach ($mesa as $id) {
        array_push($idmesas,$id['id_mesa']);
    }
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        if (!empty($mesa)) {
            foreach ($idmesas as $id) {
                $historial=$pdo->prepare("SELECT * FROM tbl_historial WHERE id_mesa=$id");
                $historialonline=$pdo->prepare("SELECT * FROM tbl_historialonline WHERE id_mesa=$id");
                $historial->execute();
                $historialres=$historial->fetchAll(PDO::FETCH_ASSOC);
                $historialonl=$historialonline->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($historialres)) {
                    $pdo->exec("DELETE FROM tbl_historial WHERE id_mesa=$id");
                }
                if (!empty($historialonl)) {
                    $pdo->exec("DELETE FROM tbl_historialonline WHERE id_mesa=$id");
                }
            }
            $pdo->exec("DELETE FROM tbl_mesa WHERE id_localizacion='{$idlocalizacion}'");
        }
        $pdo->exec("DELETE FROM tbl_localizacion WHERE id_localizacion='{$idlocalizacion}'");
        $pdo->commit();
        header("location:../view/localizaciones.php");
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo $e->getMessage();
    }
}