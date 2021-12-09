<?php
/*
if (isset($_POST['email']) && isset($_POST['password'])) {
        // 1. Conexión con la base de datos	
    include '../services/connection.php';

    $email=$_REQUEST['email'];
    $psswd=$_REQUEST['password'];

    $email=mysqli_real_escape_string($conn,$email);

    $user = mysqli_query($conn,"SELECT * FROM tbl_usuario WHERE email='$email' and contraseña=MD5('{$psswd}')");

    if (mysqli_num_rows($user) == 1) {
        // coincidencia de credenciales
        session_start();
        $_SESSION['email']=$email;
        if (!empty($user) && mysqli_num_rows($user) > 0) {
                while ($row = mysqli_fetch_array($user)) {
                $_SESSION['name']=$row['Name'];
                }
            }
        header("location: ../view/zona.admin.php");
    } else {
        // usuario o contraseña erróneos
        header("location: ../view/login.html");
    }
    mysqli_free_result($user);
}else{
    header("location: ../view/login.html");
}*/
if (isset($_POST['email']) && isset($_POST['password'])) {
    session_start();
    require_once '../services/connection.php';
    $email=$_POST['email'];
    $password=$_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM tbl_usuario WHERE email='$email' and contraseña=MD5('{$password}')");
    $stmt->execute();
    $comprobacion=$stmt->fetchAll(PDO::FETCH_ASSOC);
    try {
            if (!empty($comprobacion)) {
                foreach ($comprobacion as $row) {
                    $_SESSION['nombre']=$row['nombre'];
                    $_SESSION['tipo_user']=$row['tipo'];
                 }   
                //print_r($comprobacion);
                $_SESSION['email']=$email;
                header("location:../view/zona.admin.php");
            }else {
                header("location: ../view/login.html");
            }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}else{
    header("location: ../view/login.html");
}