<?php
require "config/database.php";

$id = $_POST['id'] ?? "";
$entrada = $_POST['entrada'] ?? "";
$salida = $_POST['salida'] ?? "";
$cliente = trim($_POST['cliente'] ?? "");
$servicios = $_POST['servicios'] ?? [];
$correo = trim($_POST['correo'] ?? "");


$nombre_tarjeta = $_POST['nombre_tarjeta'] ?? "";
$numero_tarjeta = $_POST['numero_tarjeta'] ?? "";
$mes_vencimiento = $_POST['mes_vencimiento'] ?? "";
$anio_vencimiento = $_POST['anio_vencimiento'] ?? "";
$cvv = $_POST['cvv'] ?? "";

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
    if ($row) {
        $total += (float)$row['precio'];
    }
}

$stmt = $conn->prepare("INSERT INTO reservas (habitacion_id, nombre_cliente, email_cliente, fecha_entrada, fecha_salida, total, estado)
                        VALUES (?, ?, ?, ?, ?, ?, 'Confirmada')");
$stmt->bind_param("issssd", $id_int, $cliente, $correo, $entrada, $salida, $total);

$stmt->execute();

$idReserva = $stmt->insert_id;

foreach ($servicios as $sid) {
    $sid_int = (int)$sid;
    $conn->query("INSERT INTO reserva_servicios (reserva_id, servicio_id) VALUES ($idReserva, $sid_int)");
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
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">¡Reserva confirmada!</h4>
        </div>

        <div class="card-body">
            <p><strong>Cliente:</strong> <?= htmlspecialchars($cliente) ?></p>
            <p><strong>Correo al que se envio la informacion de la reserva:</strong> <?= htmlspecialchars($correo) ?></p>
            <p><strong>Habitación:</strong> <?= htmlspecialchars($habitacion['nombre']) ?></p>
            <p><strong>Fecha de entrada:</strong> <?= htmlspecialchars($entrada) ?></p>
            <p><strong>Fecha de salida:</strong> <?= htmlspecialchars($salida) ?></p>
            <p><strong>Noches:</strong> <?= $diferencia ?></p>

            <p><strong>Total pagado:</strong> $<?= number_format($total, 2, '.', '') ?></p>

            <p><strong>Servicios adicionales:</strong>
                <?php
                if (empty($servicios)) {
                    echo "Sin servicios adicionales";
                } else {
                    $nombres = [];
                    foreach ($servicios as $sid) {
                        $row = $conn->query("SELECT nombre FROM servicios WHERE id = " . (int)$sid)->fetch_assoc();
                        if ($row) $nombres[] = $row['nombre'];
                    }
                    echo htmlspecialchars(implode(", ", $nombres));
                }
                ?>
            </p>

            <hr>

            <p class="text-success fw-bold">La reserva ha sido registrada correctamente en el sistema.</p>

            <a href="index.php" class="btn btn-primary">Volver al inicio</a>
        </div>
    </div>
</div>

</body>
</html>
