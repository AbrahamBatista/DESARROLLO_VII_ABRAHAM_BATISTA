<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <span class="navbar-brand">Panel Administrativo</span>
    <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
  </div>
</nav>

<div class="container">
    <div class="row g-3">
        <div class="col-md-4">
            <a href="habitaciones.php" class="btn btn-primary w-100">Gestión de habitaciones</a>
        </div>
        <div class="col-md-4">
            <a href="servicios.php" class="btn btn-primary w-100">Gestión de servicios</a>
        </div>
        <div class="col-md-4">
            <a href="reservas.php" class="btn btn-primary w-100">Ver reservas</a>
        </div>
    </div>
</div>
</body>
</html>
