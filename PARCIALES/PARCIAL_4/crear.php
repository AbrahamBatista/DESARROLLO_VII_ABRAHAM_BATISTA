<?php
require 'database.php';
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? "");
    $categoria = trim($_POST['categoria'] ?? "");
    $precio = $_POST['precio'] ?? "";
    $cantidad = $_POST['cantidad'] ?? "";

    if ($nombre !== "" && $categoria !== "" && is_numeric($precio) && $precio >= 0 && ctype_digit((string)$cantidad) && (int)$cantidad >= 0) {
        $stmt = $conn->prepare("INSERT INTO productos (nombre, categoria, precio, cantidad) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $nombre, $categoria, $precio, $cantidad);
        $stmt->execute();
        header("Location: index.php");
        exit;
    } else {
        $mensaje = "Complete todos los campos correctamente.";
    }
}
function e($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Registrar Producto</title></head>
<body>
<h2>Registrar Producto</h2>
<?php if($mensaje!==""): ?><p style="color:red;"><?= e($mensaje) ?></p><?php endif; ?>
<form method="POST">
  Nombre: <input type="text" name="nombre" required><br><br>
  Categoría: <input type="text" name="categoria" required><br><br>
  Precio: <input type="number" step="0.01" name="precio" min="0" required><br><br>
  Cantidad: <input type="number" name="cantidad" min="0" required><br><br>
  <input type="submit" value="Guardar">
  <a href="index.php">Volver</a>
</form>
</body>
</html>
