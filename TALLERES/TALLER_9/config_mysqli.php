<?php
define('DB_SERVIDOR', 'localhost');
define('DB_PUERTO', 3306);
define('DB_USUARIO', 'root');
define('DB_CONTRASENA', '12345');
define('DB_NOMBRE', 'taller9_db');

$conn = mysqli_connect(DB_SERVIDOR, DB_USUARIO, DB_CONTRASENA, DB_NOMBRE, DB_PUERTO);

if ($conn === false) {
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}
?>
