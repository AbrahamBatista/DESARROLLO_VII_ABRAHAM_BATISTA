<?php
include 'config_sesion.php';

$productos = [
    1 => ['nombre' => 'Producto 1', 'precio' => 10],
    2 => ['nombre' => 'Producto 2', 'precio' => 15],
    3 => ['nombre' => 'Producto 3', 'precio' => 20],
    4 => ['nombre' => 'Producto 4', 'precio' => 25],
    5 => ['nombre' => 'Producto 5', 'precio' => 30]
];
?>

<h2>Lista de Productos</h2>
<ul>
<?php foreach($productos as $id => $p): ?>
    <li>
        <?php echo htmlspecialchars($p['nombre']) . " - $" . $p['precio']; ?>
        <form method="post" action="agregar_al_carrito.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="number" name="cantidad" value="1" min="1">
            <input type="submit" value="Añadir al carrito">
        </form>
    </li>
<?php endforeach; ?>
</ul>
<a href="ver_carrito.php">Ver Carrito</a>
