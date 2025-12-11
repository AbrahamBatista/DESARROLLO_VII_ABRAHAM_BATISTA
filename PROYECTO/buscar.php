<?php
require "config/database.php";

$entrada = $_GET['entrada'] ?? "";
$salida = $_GET['salida'] ?? "";
$personas = $_GET['personas'] ?? "";

if ($entrada == "" || $salida == "" || $personas == "") {
    header("Location: index.php");
    exit;
}

$hoy = date('Y-m-d');

if ($entrada < $hoy || $salida <= $entrada) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Fechas inválidas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-image: url('habi.jpg'); 
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                background-attachment: fixed;
            }
            h3, p {
                color: white;
                text-shadow: 2px 2px 5px black;
            }
        </style>
    </head>
    <body>
    <nav class="navbar navbar-dark bg-dark mb-4">
      <div class="container">
        <a class="navbar-brand" href="index.php">Hotel El Monumental - Habitaciones Disponibles</a>
      </div>
    </nav>

    <div class="container">
        <h3 class="mb-3">Fechas inválidas</h3>
        <div class="alert alert-danger">
            Las fechas seleccionadas no son válidas.<br>
            • La fecha de entrada no puede ser anterior a hoy.<br>
            • La fecha de salida debe ser mayor que la fecha de entrada.
        </div>
        <a href="index.php" class="btn btn-primary">Volver</a>
    </div>
    </body>
    </html>
    <?php
    exit;
}

$entrada_esc = $conn->real_escape_string($entrada);
$salida_esc = $conn->real_escape_string($salida);
$personas_int = (int)$personas;

$sql = "
SELECT * FROM habitaciones
WHERE capacidad >= $personas_int
AND id NOT IN (
    SELECT habitacion_id FROM reservas
    WHERE NOT (
        '$salida_esc' <= fecha_entrada
        OR '$entrada_esc' >= fecha_salida
    )
)
";

$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitaciones disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('habi.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        h3, p {
            color: white;
            text-shadow: 2px 2px 5px black;
        }

        .detalle-habitacion {
            color: #2c3e50;
            font-weight: 600;
            font-size: 15px;
            text-shadow: none;
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Hotel El Monumental - Habitaciones Disponibles</a>
  </div>
</nav>

<div class="container">
    <h3 class="mb-3">Habitaciones disponibles</h3>
    <p>Desde <strong><?= htmlspecialchars($entrada) ?></strong> hasta 
       <strong><?= htmlspecialchars($salida) ?></strong>
       para <strong><?= htmlspecialchars($personas) ?></strong> persona(s).</p>

    <?php if ($resultado->num_rows == 0): ?>
        <div class="alert alert-warning">No hay habitaciones disponibles para esas fechas.</div>

    <?php else: ?>
        <div class="row">
            <?php while($h = $resultado->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img 
                            src="habitacion_<?= $h['id'] ?>.jpg" 
                            class="card-img-top" 
                            alt="Imagen de <?= htmlspecialchars($h['nombre']) ?>"
                        >
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($h['nombre']) ?></h5>
                            <p class="card-text detalle-habitacion"><?= nl2br(htmlspecialchars($h['descripcion'])) ?></p>
                            <p class="card-text detalle-habitacion">
                                Capacidad: <?= $h['capacidad'] ?> personas<br>
                                Precio por noche: $<?= $h['precio'] ?>
                            </p>
                            <a class="btn btn-success"
                               href="reservar.php?id=<?= $h['id'] ?>&entrada=<?= $entrada ?>&salida=<?= $salida ?>">
                               Reservar
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
