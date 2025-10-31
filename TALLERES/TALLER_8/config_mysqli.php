<?php
// === CONFIGURACIÓN MYSQLI ===
define('DB_SERVIDOR', 'localhost');
define('DB_PUERTO', 3308);             
define('DB_USUARIO', 'root');
define('DB_CONTRASENA', '12345');
define('DB_NOMBRE', 'taller8_db');

// Creando la coonexion 
$conn = mysqli_connect(DB_SERVIDOR, DB_USUARIO, DB_CONTRASENA, DB_NOMBRE, DB_PUERTO);

// Verificar conexion 
if ($conn === false) {
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}
?>
