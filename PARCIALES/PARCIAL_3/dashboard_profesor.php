<?php
session_start();
require "datos.php";

if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "Profesor") {
    header("Location: index.php?error=Acceso no autorizado.");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Profesor</title>
</head>
<body>

<h2>Bienvenido Profe: <?php echo $_SESSION["usuario"]; ?></h2>

<h3>Calificaciones de estudiantes</h3>

<table border="1" cellpadding="5">
<tr>
    <th>Estudiante</th>
    <th>Calificación</th>
</tr>

<?php
foreach ($calificaciones as $est => $nota) {
    echo "<tr><td>$est</td><td>$nota</td></tr>";
}
?>

</table>

<br>
<a href="logout.php">Cerrar sesion</a>

</body>
</html>
