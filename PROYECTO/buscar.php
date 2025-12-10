<?php
require "config/database.php";

$entrada = $_GET['entrada'] ?? "";
$salida = $_GET['salida'] ?? "";
$personas = $_GET['personas'] ?? "";

if ($entrada == "" || $salida == "" || $personas == "") {
    header("Location: index.php");
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
            background-image: url('habitacion.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        /* Opcional: darle un poco de fondo a los títulos para más visibilidad */
        h3, p {
            color: white;
            text-shadow: 2px 2px 5px black;
        }

    .detalle-habitacion {
        color: #2c3e50;        /* Color de texto */
        font-weight: 600;      /* Semi-negrita */
        font-size: 15px;       /* Tamaño */
        text-shadow: none;     /* Sin sombra para más claridad */
    }

    </style>

</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Hotel El Monumental - Buscar Reservas Disponibles</a>
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
