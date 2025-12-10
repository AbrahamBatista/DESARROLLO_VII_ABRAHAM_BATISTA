<?php
require "config/database.php";

$id = $_POST['id'] ?? "";
$entrada = $_POST['entrada'] ?? "";
$salida = $_POST['salida'] ?? "";
$cliente = trim($_POST['cliente'] ?? "");
$servicios = $_POST['servicios'] ?? [];

if ($id == "" || $entrada == "" || $salida == "" || $cliente == "") {
    header("Location: index.php");
    exit;
}

$id_int = (int)$id;

$habitacion = $conn->query("SELECT * FROM habitaciones WHERE id = $id_int")->fetch_assoc();
$precio_base = (float)$habitacion['precio'];

$datetime1 = new DateTime($entrada);
$datetime2 = new DateTime($salida);
$diferencia = $datetime1->diff($datetime2)->days;
if ($diferencia <= 0) { $diferencia = 1; }

$total = $precio_base * $diferencia;

foreach ($servicios as $sid) {
    $sid_int = (int)$sid;
    $row = $conn->query("SELECT precio FROM servicios WHERE id = $sid_int")->fetch_assoc();
    $total += (float)$row['precio'];
}

$stmt = $conn->prepare("INSERT INTO reservas (habitacion_id, nombre_cliente, fecha_entrada, fecha_salida, total, estado) VALUES (?, ?, ?, ?, ?, 'Pagado')");
$stmt->bind_param("isssd", $id_int, $cliente, $entrada, $salida, $total);
$stmt->execute();
$reserva_id = $stmt->insert_id;

foreach ($servicios as $sid) {
    $sid_int = (int)$sid;
    $conn->query("INSERT INTO reserva_servicios (reserva_id, servicio_id) VALUES ($reserva_id, $sid_int)");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva confirmada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Hotel - Reservas</a>
  </div>
</nav>

<div class="container">
    <div class="alert alert-success">
        <h4 class="alert-heading">Reserva confirmada</h4>
        <p>La reserva ha sido registrada como <strong>Pagado</strong> (simulación de pago).</p>
        <hr>
        <p><strong>Cliente:</strong> <?= htmlspecialchars($cliente) ?></p>
        <p><strong>Total a pagar:</strong> $<?= number_format($total, 2, '.', '') ?></p>
    </div>
    <a href="index.php" class="btn btn-primary">Volver al inicio</a>
</div>
</body>
</html>
