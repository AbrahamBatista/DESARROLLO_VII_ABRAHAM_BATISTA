<?php
include 'config_sesion.php';

$productos = [
    1 => ['nombre' => 'Producto 1', 'precio' => 10],
    2 => ['nombre' => 'Producto 2', 'precio' => 15],
    3 => ['nombre' => 'Producto 3', 'precio' => 20],
    4 => ['nombre' => 'Producto 4', 'precio' => 25],
    5 => ['nombre' => 'Producto 5', 'precio' => 30]
];

$carrito = $_SESSION['carrito'] ?? [];
$total = 0;

foreach($carrito as $id => $cantidad) {
    $total += $productos[$id]['precio'] * $cantidad;
}

if(isset($_SESSION['usuario'])) {
    setcookie("usuario", $_SESSION['usuario'], time() + 86400, "/", "", true, true);
}

$_SESSION['carrito'] = []; // Vaciar carrito
?>

<h2>Resumen de Compra</h2>
<?php if(!$carrito): ?>
    <p>No hay productos comprados.</p>
<?php else: ?>
    <ul>
        <?php foreach($carrito as $id => $cantidad): ?>
            <li><?php echo htmlspecialchars($productos[$id]['nombre']); ?> - Cantidad: <?php echo $cantidad; ?></li>
        <?php endforeach; ?>
    </ul>
    <p>Total a pagar: $<?php echo $total; ?></p>
<?php endif; ?>
<a href="productos.php">Volver a Productos</a>
