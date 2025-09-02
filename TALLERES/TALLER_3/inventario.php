<?php
function leerInventario($archivo) {
    if (!file_exists($archivo)) {
        echo "El archivo $archivo no existe.</br>";
        return [];
    }
    $contenido = file_get_contents($archivo);
    return json_decode($contenido, true);
}

function ordenarInventarioPorNombre($inventario) {
    usort($inventario, function($a, $b) {
        return strcmp($a['nombre'], $b['nombre']);
    });
    return $inventario;
}


function mostrarResumenInventario($inventario) {
    echo "</br>Resumen del inventario:</br>";
    echo str_pad("Producto", 20) . str_pad("Precio", 10) . str_pad("Cantidad", 10) . "</br>";
    echo str_repeat("-", 40) . "</br>";
    foreach ($inventario as $producto) {
        echo str_pad($producto['nombre'], 20) .
             str_pad("$" . number_format($producto['precio'], 2), 10) .
             str_pad($producto['cantidad'], 10) . "</br>";
    }
}


function calcularValorTotal($inventario) {
    return array_sum(array_map(function($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $inventario));
}

function productosStockBajo($inventario) {
    return array_filter($inventario, function($producto) {
        return $producto['cantidad'] < 5;
    });
}

// --- Script principal ---
$archivoInventario = "inventario.json";


$inventario = leerInventario($archivoInventario);


$inventario = ordenarInventarioPorNombre($inventario);


mostrarResumenInventario($inventario);


$valorTotal = calcularValorTotal($inventario);
echo "</br>Valor total del inventario: $" . number_format($valorTotal, 2) . "</br>";

$stockBajo = productosStockBajo($inventario);
if (!empty($stockBajo)) {
    echo "</br>Productos con stock bajo (menos de 5 unidades):</br>";
    foreach ($stockBajo as $producto) {
        echo "- {$producto['nombre']} (Cantidad: {$producto['cantidad']})</br>";
    }
} else {
    echo "</br>No hay productos con stock bajo.</br>";
}
?>
