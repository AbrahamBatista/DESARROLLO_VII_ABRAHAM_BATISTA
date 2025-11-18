<?php
session_start();
require "datos.php";

if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "Estudiante") {
    header("Location: index.php?error=Acceso no autorizado.");
    exit;
}

$usuario = $_SESSION["usuario"];
$nota = $calificaciones[$usuario] ?? "Sin nota registrada";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Estudiante</title>
</head>
<body>

<h2>Bienvenido Estudiante: <?php echo $usuario; ?></h2>
<p>Tu calificación es: <strong><?php echo $nota; ?></strong></p>

<br>
<a href="logout.php">Cerrar sesión</a>

</body>
</html>
