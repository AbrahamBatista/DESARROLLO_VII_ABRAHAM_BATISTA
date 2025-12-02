<?php
require 'database.php';
function e($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$id = $_GET['id'] ?? "";
if (!ctype_digit((string)$id)) { header("Location: index.php"); exit; }

$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$producto = $stmt->get_result()->fetch_assoc();
if (!$producto) { header("Location: index.php"); exit; }

$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? "");
    $categoria = trim($_POST['categoria'] ?? "");
    $precio = $_POST['precio'] ?? "";
    $cantidad = $_POST['cantidad'] ?? "";

    if ($nombre !== "" && $categoria !== "" && is_numeric($precio) && $precio >= 0 && ctype_digit((string)$cantidad) && (int)$cantidad >= 0) {
        $upd = $conn->prepare("UPDATE productos SET nombre=?, categoria=?, precio=?, cantidad=? WHERE id=?");
        $upd->bind_param("ssdii", $nombre, $categoria, $precio, $cantidad, $id);
        $upd->execute();
        header("Location: index.php");
        exit;
    } else {
        $mensaje = "Complete todos los campos correctamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Editar Producto</title></head>
<body>
<h2>Editar Producto</h2>
<?php if($mensaje!==""): ?><p style="color:red;"><?= e($mensaje) ?></p><?php endif; ?>
<form method="POST">
  Nombre: <input type="text" name="nombre" value="<?= e($producto['nombre']) ?>" required><br><br>
  Categoría: <input type="text" name="categoria" value="<?= e($producto['categoria']) ?>" required><br><br>
  Precio: <input type="number" step="0.01" name="precio" value="<?= e($producto['precio']) ?>" min="0" required><br><br>
  Cantidad: <input type="number" name="cantidad" value="<?= e($producto['cantidad']) ?>" min="0" required><br><br>
  <input type="submit" value="Actualizar">
  <a href="index.php">Volver</a>
</form>
</body>
</html>
