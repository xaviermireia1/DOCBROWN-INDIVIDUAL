<?php
session_start();
require_once '../services/connection.php';
if (($_SESSION['email']=="") || ($_SESSION['tipo_user']=="mantenimiento")) {
    header("location:../view/login.html");
}else {
    $id_mesa=$_GET['idmesa'];
    $email=$_SESSION['email'];
    $horasistema=date('H:i');
    $fechasistema=date('Y-m-d');
    $horamas=strtotime('+1 hours',strtotime($horasistema));
    $horamas = date('H:i',$horamas);
    $mesaonline=$pdo->prepare("SELECT * FROM tbl_historialonline WHERE fecha='{$fechasistema}' AND (hora BETWEEN '{$horasistema}' AND '{$horamas}') AND id_mesa=$id_mesa");
    $mesaonline->execute();
    $mesaonline=$mesaonline->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($mesaonline)) {
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
        header('location:../view/zona.admin.php?errorlocal=1');
        die;
    }else{
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $pdo->exec("INSERT INTO tbl_historial (id_mesa,dia_historial,inicio_historial,fin_historial,email) VALUES ({$id_mesa},curdate(),curtime(),null,'{$email}')");
            $pdo->exec("UPDATE tbl_mesa SET disponibilidad='no' WHERE id_mesa={$id_mesa}");
            $pdo->commit();
            header('location:../view/zona.admin.php?errorlocal=2');
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo $e->getMessage();
        }
    }
}