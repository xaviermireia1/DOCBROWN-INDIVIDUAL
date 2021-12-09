# DOC-BROWN21
## Conexión a base de datos
### Necesitas crear el archivo connection.php y añadir las sentencias de la siguiente manera como demostraré a continuación que es con el metodo de mysql.
```
<?php
// ESTILO POR PROCEDIMIENTOS

$host = "conexion";
$user = "usuario";
$pass = "contraseña";
$db = "nombre base de datos";

// Crear la conexión
$conn = mysqli_connect($host, $user, $pass, $db);

// Checkear la conexión
if (!$conn) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "Error de depuración: " . mysqli_connect_errno() . PHP_EOL;
    exit;
} else {
	mysqli_set_charset($conn, "utf8");
}
```
### Metodo de PDO
```
define("SERVIDOR","conexion");
define("USUARIO","usuario");
define("PASSWORD","contraseña");
define("BD","nombre base de datos");
$servidor = "mysql:host=".SERVIDOR.";dbname=".BD;
try{
    $pdo= new PDO($servidor,USUARIO,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
    //echo "<script>alert('Conexion establecida')</script>";
}catch(PDOException $e){
    //Exception coge todos los errores pero PDOException para errores de PDO
    echo $e->getMessage();
}
```