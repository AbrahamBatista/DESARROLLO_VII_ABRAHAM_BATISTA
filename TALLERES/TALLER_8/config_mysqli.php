<?php
// === CONFIGURACIONYSQLI ===
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');         // usuario por defecto de Laragon
define('DB_PASSWORD', '');             // contraseña VACIA
define('DB_NAME', 'taller8_db');

// Creando la conexion 
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificar conexion
if ($conn === false) {
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}
?>
