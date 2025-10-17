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
?>

<h2>Carrito de Compras</h2>
<?php if(!$carrito): ?>
    <p>El carrito está vacío.</p>
<?php else: ?>
    <ul>
    <?php foreach($carrito as $id => $cantidad): 
        $subtotal = $productos[$id]['precio'] * $cantidad;
        $total += $subtotal;
    ?>
        <li>
            <?php echo htmlspecialchars($productos[$id]['nombre']); ?> - Cantidad: <?php echo $cantidad; ?> - Subtotal: $<?php echo $subtotal; ?>
            <a href="eliminar_del_carrito.php?id=<?php echo $id; ?>">Eliminar</a>
        </li>
    <?php endforeach; ?>
    </ul>
    <p>Total: $<?php echo $total; ?></p>
    <a href="checkout.php">Finalizar Compra</a>
<?php endif; ?>
<a href="productos.php">Seguir Comprando</a>
