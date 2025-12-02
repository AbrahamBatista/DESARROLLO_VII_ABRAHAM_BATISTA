<?php
require 'database.php';
$res = $conn->query("SELECT * FROM productos ORDER BY id DESC");
function e($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Gestión de Productos</title></head>
<body>
<h2>Lista de Productos</h2>
<a href="crear.php">Registrar nuevo producto</a><br><br>
<table border="1" cellpadding="6">
  <tr>
    <th>ID</th><th>Nombre</th><th>Categoría</th><th>Precio</th><th>Cantidad</th><th>Fecha</th><th>Acciones</th>
  </tr>
  <?php while($f = $res->fetch_assoc()): ?>
  <tr>
    <td><?= e($f['id']) ?></td>
    <td><?= e($f['nombre']) ?></td>
    <td><?= e($f['categoria']) ?></td>
    <td>$<?= e(number_format((float)$f['precio'],2,'.','')) ?></td>
    <td><?= e($f['cantidad']) ?></td>
    <td><?= e($f['fecha_registro']) ?></td>
    <td>
      <a href="editar.php?id=<?= e($f['id']) ?>">Editar</a> |
      <a href="eliminar.php?id=<?= e($f['id']) ?>" onclick="return confirm('¿Eliminar producto?')">Eliminar</a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>
</body>
</html>
