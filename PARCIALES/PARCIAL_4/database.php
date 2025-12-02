<?php
$host = "localhost";
$usuario = "root";
$contrasena = "12345";
$base_datos = "techparts_db";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

      