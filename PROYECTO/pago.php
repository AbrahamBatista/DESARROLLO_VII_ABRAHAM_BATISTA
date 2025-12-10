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

$listaServicios = [];
foreach ($servicios as $sid) {
    $sid_int = (int)$sid;
    $row = $conn->query("SELECT nombre, precio FROM servicios WHERE id = $sid_int")->fetch_assoc();
    if ($row) {
        $total += (float)$row['precio'];
        $listaServicios[] = $row['nombre'] . " ($" . $row['precio'] . ")";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago de reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Hotel - Reservas</a>
  </div>
</nav>

<div class="container">
    <h3 class="mb-3">Paso 2: Datos de pago</h3>

    <div class="card mb-3">
        <div class="card-header">Resumen de la reserva</div>
        <div class="card-body">
            <p><strong>Cliente:</strong> <?= htmlspecialchars($cliente) ?></p>
            <p><strong>Habitación:</strong> <?= htmlspecialchars($habitacion['nombre']) ?></p>
            <p><strong>Fechas:</strong> <?= htmlspecialchars($entrada) ?> a <?= htmlspecialchars($salida) ?> (<?= $diferencia ?> noche(s))</p>
            <p><strong>Servicios adicionales:</strong>
                <?php
                if (count($listaServicios) == 0) {
                    echo "Sin servicios adicionales";
                } else {
                    echo htmlspecialchars(implode(", ", $listaServicios));
                }
                ?>
            </p>
            <h4>Total a pagar: $<?= number_format($total, 2, '.', '') ?></h4>
        </div>
    </div>

    <form method="POST" action="confirmar.php" class="card">
        <div class="card-header">Formulario de pago (simulado)</div>
        <div class="card-body">

            <input type="hidden" name="id" value="<?= $id_int ?>">
            <input type="hidden" name="entrada" value="<?= htmlspecialchars($entrada) ?>">
            <input type="hidden" name="salida" value="<?= htmlspecialchars($salida) ?>">
            <input type="hidden" name="cliente" value="<?= htmlspecialchars($cliente) ?>">

            <?php foreach($servicios as $sid): ?>
                <input type="hidden" name="servicios[]" value="<?= (int)$sid ?>">
            <?php endforeach; ?>

            <div class="mb-3">
                <label class="form-label">Nombre en la tarjeta</label>
                <input type="text" name="nombre_tarjeta" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Número de tarjeta</label>
                <input type="text" name="numero_tarjeta" class="form-control" maxlength="19" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Mes de vencimiento</label>
                    <select name="mes_vencimiento" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <option value="01">01 - Enero</option>
                        <option value="02">02 - Febrero</option>
                        <option value="03">03 - Marzo</option>
                        <option value="04">04 - Abril</option>
                        <option value="05">05 - Mayo</option>
                        <option value="06">06 - Junio</option>
                        <option value="07">07 - Julio</option>
                        <option value="08">08 - Agosto</option>
                        <option value="09">09 - Septiembre</option>
                        <option value="10">10 - Octubre</option>
                        <option value="11">11 - Noviembre</option>
                        <option value="12">12 - Diciembre</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Año de vencimiento</label>
                    <select name="anio_vencimiento" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <?php 
                            $anioActual = date("Y");
                            for ($i = 0; $i < 12; $i++):
                                $anio = $anioActual + $i;
                        ?>
                            <option value="<?= $anio ?>"><?= $anio ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">CVV</label>
                <input type="password" name="cvv" class="form-control" maxlength="4" required>
            </div>


            <button class="btn btn-success">Confirmar pago y registrar reserva</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
