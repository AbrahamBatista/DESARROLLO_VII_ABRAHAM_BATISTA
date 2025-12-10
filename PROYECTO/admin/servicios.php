<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? "");
    $precio = (float)($_POST['precio'] ?? 0);
    if ($nombre !== "" && $precio >= 0) {
        $stmt = $conn->prepare("INSERT INTO servicios (nombre, precio) VALUES (?, ?)");
        $stmt->bind_param("sd", $nombre, $precio);
        $stmt->execute();
    }
}

if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];

    if ($id > 0) {
  
        $stmtRel = $conn->prepare("DELETE FROM reserva_servicios WHERE servicio_id = ?");
        $stmtRel->bind_param("i", $id);
        $stmtRel->execute();

       
        $stmtServ = $conn->prepare("DELETE FROM servicios WHERE id = ?");
        $stmtServ->bind_param("i", $id);
        $stmtServ->execute();
    }

    header("Location: servicios.php");
    exit;
}

$servicios = $conn->query("SELECT * FROM servicios ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios adicionales</title>
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
    <h3 class="mb-3">Gestión de servicios adicionales</h3>

    <div class="card mb-4">
        <div class="card-header">Nuevo servicio</div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control" min="0" required>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">Guardar servicio</button>
                </div>
            </form>
        </div>
    </div>

    <h5>Listado de servicios</h5>
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th><th>Nombre</th><th>Precio</th><th>Acciones</th>
        </tr>
        <?php while($s = $servicios->fetch_assoc()): ?>
        <tr>
            <td><?= $s['id'] ?></td>
            <td><?= htmlspecialchars($s['nombre']) ?></td>
            <td>$<?= $s['precio'] ?></td>
            <td>
                <a href="servicios.php?eliminar=<?= $s['id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Eliminar este servicio y quitarlo de las reservas relacionadas?');">
                   Eliminar
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
