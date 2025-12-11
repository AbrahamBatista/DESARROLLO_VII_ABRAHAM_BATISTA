<?php require "config/database.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Reservas de Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('fondo.jpg'); 
            background-size: cover;               
            background-position: center;          
            background-repeat: no-repeat;         
            background-attachment: fixed;         
        }
        h3{
            color: white;
            text-shadow: 2px 2px 5px black;
        }
       
        .card {
            backdrop-filter: blur(5px);
            background-color: rgba(255, 255, 255, 0.75);
        }
    </style>
</head>

<body>
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Hotel El Monumental </a>
    <a class="btn btn-outline-light btn-sm" href="admin/login.php">Panel Admin</a>
  </div>
</nav>

<div class="container">
    <h3 class="mb-3 text-light">Búsqueda de habitaciones por fechas</h3>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="buscar.php" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Fecha de entrada</label>
                    <input type="date" name="entrada" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha de salida</label>
                    <input type="date" name="salida" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Numero de huespedes</label>
                    <input type="number" name="personas" class="form-control" min="1" required>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">Buscar habitaciones</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
