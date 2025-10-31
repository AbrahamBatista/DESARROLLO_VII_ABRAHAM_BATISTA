<?php
require_once "config_mysqli.php";

$sql = "SELECT p.nombre, p.precio, c.nombre AS categoria,
        (SELECT AVG(precio) FROM productos WHERE categoria_id = p.categoria_id) AS promedio_categoria
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.precio > (
            SELECT AVG(precio)
            FROM productos p2
            WHERE p2.categoria_id = p.categoria_id
        )";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: {$row['nombre']}, Precio: $" . $row['precio'] . ", ";
        echo "Categoría: {$row['categoria']}, Promedio categoría: $" . $row['promedio_categoria'] . "<br>";
    }
    mysqli_free_result($result);
}

$sql = "SELECT c.nombre, c.email,
        (SELECT SUM(total) FROM ventas WHERE cliente_id = c.id) AS total_compras,
        (SELECT AVG(total) FROM ventas) AS promedio_ventas
        FROM clientes c
        WHERE (
            SELECT SUM(total)
            FROM ventas
            WHERE cliente_id = c.id
        ) > (
            SELECT AVG(total)
            FROM ventas
        )";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Cliente: {$row['nombre']}, Total compras: $" . $row['total_compras'] . ", ";
        echo "Promedio general: $" . $row['promedio_ventas'] . "<br>";
    }
    mysqli_free_result($result);
}

mysqli_close($conn);
?>
