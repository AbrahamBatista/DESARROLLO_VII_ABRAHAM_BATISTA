<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require "../config/database.php";

$sql = "SELECT r.*, h.nombre AS habitacion
        FROM reservas r
        JOIN habitaciones h ON r.habitacion_id = h.id
        ORDER BY r.id DESC";
$reservas = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Panel Admin</a>
    <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
  </div>
</nav>

<div class="container">
    <h3 class="mb-3">Reservas registradas</h3>
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th><th>Habitación</th><th>Cliente</th>
            <th>Entrada</th><th>Salida</th><th>Total</th><th>Estado</th>
        </tr>
        <?php while($r = $reservas->fetch_assoc()): ?>
        <tr>
            <td><?= $r['id'] ?></td>
            <td><?= htmlspecialchars($r['habitacion']) ?></td>
            <td><?= htmlspecialchars($r['nombre_cliente']) ?></td>
            <td><?= $r['fecha_entrada'] ?></td>
            <td><?= $r['fecha_salida'] ?></td>
            <td>$<?= $r['total'] ?></td>
            <td><?= htmlspecialchars($r['estado']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
