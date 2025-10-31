<?php
require_once "config_mysqli.php";

echo "<h3>1. Productos que nunca se han vendido</h3>";
$sql1 = "
SELECT p.id, p.nombre, p.precio
FROM productos p
WHERE p.id NOT IN (
    SELECT DISTINCT producto_id FROM detalles_venta
)
";
$r1 = mysqli_query($conn, $sql1);
while ($row = mysqli_fetch_assoc($r1)) {
    echo "Producto: {$row['nombre']} - $" . $row['precio'] . "<br>";
}
mysqli_free_result($r1);

echo "<h3>2. Categorías con número de productos y valor total de inventario</h3>";
$sql2 = "
SELECT c.nombre AS categoria,
       COUNT(p.id) AS cantidad_productos,
       SUM(p.precio * p.stock) AS valor_inventario
FROM categorias c
LEFT JOIN productos p ON p.categoria_id = c.id
GROUP BY c.id, c.nombre
";
$r2 = mysqli_query($conn, $sql2);
while ($row = mysqli_fetch_assoc($r2)) {
    echo "Categoría: {$row['categoria']} - Productos: {$row['cantidad_productos']} - Inventario: $" . $row['valor_inventario'] . "<br>";
}
mysqli_free_result($r2);

echo "<h3>3. Clientes que han comprado todos los productos de una categoría específica</h3>";
$sql3 = "
SELECT DISTINCT cl.nombre AS cliente, cat.nombre AS categoria
FROM clientes cl
JOIN ventas v ON v.cliente_id = cl.id
JOIN detalles_venta dv ON dv.venta_id = v.id
JOIN productos p ON p.id = dv.producto_id
JOIN categorias cat ON cat.id = p.categoria_id
WHERE NOT EXISTS (
    SELECT p2.id
    FROM productos p2
    WHERE p2.categoria_id = cat.id
    AND p2.id NOT IN (
        SELECT dv2.producto_id
        FROM ventas v2
        JOIN detalles_venta dv2 ON dv2.venta_id = v2.id
        WHERE v2.cliente_id = cl.id
    )
)
";
$r3 = mysqli_query($conn, $sql3);
while ($row = mysqli_fetch_assoc($r3)) {
    echo "Cliente: {$row['cliente']} - Categoría completa: {$row['categoria']}<br>";
}
mysqli_free_result($r3);

echo "<h3>4. Porcentaje de ventas de cada producto respecto al total vendido</h3>";
$sql4 = "
SELECT p.nombre,
       SUM(dv.subtotal) AS total_producto,
       (SELECT SUM(subtotal) FROM detalles_venta) AS total_global,
       (SUM(dv.subtotal) / (SELECT SUM(subtotal) FROM detalles_venta)) * 100 AS porcentaje_participacion
FROM detalles_venta dv
JOIN productos p ON p.id = dv.producto_id
GROUP BY p.id, p.nombre
ORDER BY porcentaje_participacion DESC
";
$r4 = mysqli_query($conn, $sql4);
while ($row = mysqli_fetch_assoc($r4)) {
    echo "Producto: {$row['nombre']} - Total: $" . $row['total_producto'] . " - Participación: " . $row['porcentaje_participacion'] . "%<br>";
}
mysqli_free_result($r4);

mysqli_close($conn);
?>
