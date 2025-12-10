<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? "");
    $descripcion = trim($_POST['descripcion'] ?? "");
    $capacidad = (int)($_POST['capacidad'] ?? 1);
    $precio = (float)($_POST['precio'] ?? 0);

    if ($nombre !== "" && $precio >= 0) {
        $stmt = $conn->prepare("INSERT INTO habitaciones (nombre, descripcion, capacidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssId", $nombre, $descripcion, $capacidad, $precio);
        $stmt->execute();
    }
}

if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $conn->query("DELETE FROM habitaciones WHERE id = $id");
}

$habitaciones = $conn->query("SELECT * FROM habitaciones ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitaciones</title>
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
    <h3 class="mb-3">Gestión de habitaciones</h3>

    <div class="card mb-4">
        <div class="card-header">Nueva habitación</div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Capacidad</label>
                    <input type="number" name="capacidad" class="form-control" min="1" value="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Precio por noche</label>
                    <input type="number" step="0.01" name="precio" class="form-control" min="0" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2"></textarea>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">Guardar habitación</button>
                </div>
            </form>
        </div>
    </div>

    <h5>Listado de habitaciones</h5>
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th><th>Nombre</th><th>Capacidad</th><th>Precio</th><th>Acciones</th>
        </tr>
        <?php while($h = $habitaciones->fetch_assoc()): ?>
        <tr>
            <td><?= $h['id'] ?></td>
            <td><?= htmlspecialchars($h['nombre']) ?></td>
            <td><?= $h['capacidad'] ?></td>
            <td>$<?= $h['precio'] ?></td>
            <td>
                <a href="habitaciones.php?eliminar=<?= $h['id'] ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Eliminar habitación?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
