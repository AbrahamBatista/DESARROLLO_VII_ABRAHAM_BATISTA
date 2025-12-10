<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require "../config/database.php";

if (isset($_GET['eliminar'])) {
    $id = (int) $_GET['eliminar'];

    if ($id > 0) {
        $stmtServ = $conn->prepare("DELETE FROM reserva_servicios WHERE reserva_id = ?");
        $stmtServ->bind_param("i", $id);
        $stmtServ->execute();

        $stmtRes = $conn->prepare("DELETE FROM reservas WHERE id = ?");
        $stmtRes->bind_param("i", $id);
        $stmtRes->execute();
    }

    header("Location: reservas.php");
    exit;
}

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
            <th>ID</th>
            <th>Habitación</th>
            <th>Cliente</th>
            <th>Entrada</th>
            <th>Salida</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Servicios adicionales</th>
            <th>Acciones</th>
        </tr>
        <?php while($r = $reservas->fetch_assoc()): ?>
        <?php
            $idReserva = (int)$r['id'];
            $serviciosTxt = "Sin servicios";

            $sqlServ = "SELECT s.nombre 
                        FROM reserva_servicios rs
                        JOIN servicios s ON rs.servicio_id = s.id
                        WHERE rs.reserva_id = $idReserva";
            $resServ = $conn->query($sqlServ);
            if ($resServ && $resServ->num_rows > 0) {
                $nombres = [];
                while ($rowS = $resServ->fetch_assoc()) {
                    $nombres[] = $rowS['nombre'];
                }
                $serviciosTxt = implode(", ", $nombres);
            }
        ?>
        <tr>
            <td><?= $r['id'] ?></td>
            <td><?= htmlspecialchars($r['habitacion']) ?></td>
            <td><?= htmlspecialchars($r['nombre_cliente']) ?></td>
            <td><?= $r['fecha_entrada'] ?></td>
            <td><?= $r['fecha_salida'] ?></td>
            <td>$<?= $r['total'] ?></td>
            <td><?= htmlspecialchars($r['estado']) ?></td>
            <td><?= htmlspecialchars($serviciosTxt) ?></td>
            <td>
                <a href="reservas.php?eliminar=<?= $r['id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Eliminar esta reserva y sus servicios asociados?');">
                   Eliminar
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
