<?php
require "config/database.php";

$id = $_GET['id'] ?? "";
$entrada = $_GET['entrada'] ?? "";
$salida = $_GET['salida'] ?? "";

if ($id == "" || $entrada == "" || $salida == "") {
    header("Location: index.php");
    exit;
}

$id_int = (int)$id;
$habitacion = $conn->query("SELECT * FROM habitaciones WHERE id = $id_int")->fetch_assoc();
$servicios = $conn->query("SELECT * FROM servicios");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar habitación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Hotel - Reservas</a>
  </div>
</nav>

<div class="container">
    <h3 class="mb-3">Reservar: <?= htmlspecialchars($habitacion['nombre']) ?></h3>

    <div class="row mb-4">



        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">

                <div class="row align-items-center">
                <div class="col-md-5">
                    <img src="habitacion_<?= $habitacion['id'] ?>.jpg"
                         alt="Imagen habitación"
                         class="img-fluid rounded shadow">
                </div>

                <div class="col-md-7">
                    <p><?= nl2br(htmlspecialchars($habitacion['descripcion'])) ?></p>
                    <p><strong>Capacidad:</strong> <?= $habitacion['capacidad'] ?> personas</p>
                    <p><strong>Precio por noche:</strong> $<?= $habitacion['precio'] ?></p>
                    <p>Desde <strong><?= htmlspecialchars($entrada) ?></strong> 
                       hasta <strong><?= htmlspecialchars($salida) ?></strong></p>
                    </div>

                </div>

            </div>
        </div>
    </div>

    </div>


    <form method="POST" action="pago.php" class="card">
        <div class="card-body">
            <input type="hidden" name="id" value="<?= $id_int ?>">
            <input type="hidden" name="entrada" value="<?= htmlspecialchars($entrada) ?>">
            <input type="hidden" name="salida" value="<?= htmlspecialchars($salida) ?>">

            <div class="mb-3">
                <label class="form-label">Ingrese su nombre</label>
                <input type="text" name="cliente" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ingrese su correo de contacto</label>
                <input type="email" name="correo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Servicios adicionales</label><br>
                <?php while($s = $servicios->fetch_assoc()): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="servicios[]" value="<?= $s['id'] ?>" id="serv<?= $s['id'] ?>">
                        <label class="form-check-label" for="serv<?= $s['id'] ?>">
                            <?= htmlspecialchars($s['nombre']) ?> ($<?= $s['precio'] ?>)
                        </label>
                    </div>
                <?php endwhile; ?>
  3          </div>

            <button class="btn btn-primary">Continuar al pago</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

</body>
</html>
