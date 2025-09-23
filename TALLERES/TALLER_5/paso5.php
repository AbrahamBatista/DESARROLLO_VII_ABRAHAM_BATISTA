<?php
$jsonDatos = '
{
    "tienda": "ElectroTech",
    "productos": [
        {"id": 1, "nombre": "Laptop Gamer", "precio": 1200, "categorias": ["electrónica", "computadoras"]},
        {"id": 2, "nombre": "Smartphone 5G", "precio": 800, "categorias": ["electrónica", "celulares"]},
        {"id": 3, "nombre": "Auriculares Bluetooth", "precio": 150, "categorias": ["electrónica", "accesorios"]},
        {"id": 4, "nombre": "Smart TV 4K", "precio": 700, "categorias": ["electrónica", "televisores"]},
        {"id": 5, "nombre": "Tablet", "precio": 300, "categorias": ["electrónica", "computadoras"]}
    ],
    "clientes": [
        {"id": 101, "nombre": "Ana López", "email": "ana@example.com"},
        {"id": 102, "nombre": "Carlos Gómez", "email": "carlos@example.com"},
        {"id": 103, "nombre": "María Rodríguez", "email": "maria@example.com"}
    ]
}
';

$tiendaData = json_decode($jsonDatos, true);

function imprimirProductos($productos) {
    foreach ($productos as $producto) {
        echo "{$producto['nombre']} - \${$producto['precio']} - Categorías: " . implode(", ", $producto['categorias']) . "\n";
    }
}

echo "Productos de {$tiendaData['tienda']}:\n";
imprimirProductos($tiendaData['productos']);

$valorTotal = array_reduce($tiendaData['productos'], function($total, $producto) {
    return $total + $producto['precio'];
}, 0);
echo "\nValor total del inventario: $$valorTotal\n";

$productoMasCaro = array_reduce($tiendaData['productos'], function($max, $producto) {
    return ($producto['precio'] > $max['precio']) ? $producto : $max;
}, $tiendaData['productos'][0]);
echo "\nProducto más caro: {$productoMasCaro['nombre']} (${$productoMasCaro['precio']})\n";

function filtrarPorCategoria($productos, $categoria) {
    return array_filter($productos, function($producto) use ($categoria) {
        return in_array($categoria, $producto['categorias']);
    });
}

$productosDeComputadoras = filtrarPorCategoria($tiendaData['productos'], "computadoras");
echo "\nProductos en la categoría 'computadoras':\n";
imprimirProductos($productosDeComputadoras);

$nuevoProducto = [
    "id" => 6,
    "nombre" => "Smartwatch",
    "precio" => 250,
    "categorias" => ["electrónica", "accesorios", "wearables"]
];
$tiendaData['productos'][] = $nuevoProducto;

$jsonActualizado = json_encode($tiendaData, JSON_PRETTY_PRINT);
echo "\nDatos actualizados de la tienda (JSON):\n$jsonActualizado\n";

// Función para generar resumen de ventas
$ventas = [
    ["producto_id" => 1, "cliente_id" => 101, "cantidad" => 1, "fecha" => "2025-09-22"],
    ["producto_id" => 2, "cliente_id" => 102, "cantidad" => 2, "fecha" => "2025-09-22"],
    ["producto_id" => 1, "cliente_id" => 103, "cantidad" => 1, "fecha" => "2025-09-22"],
    ["producto_id" => 5, "cliente_id" => 101, "cantidad" => 3, "fecha" => "2025-09-22"],
    ["producto_id" => 6, "cliente_id" => 102, "cantidad" => 1, "fecha" => "2025-09-22"]
];

function generarResumenVentas($ventas, $productos, $clientes) {
    $totalVentas = array_sum(array_column($ventas, 'cantidad'));
    
    $ventasPorProducto = [];
    foreach ($ventas as $v) {
        $ventasPorProducto[$v['producto_id']] = ($ventasPorProducto[$v['producto_id']] ?? 0) + $v['cantidad'];
    }
    arsort($ventasPorProducto);
    $productoMasVendidoId = array_key_first($ventasPorProducto);
    $productoMasVendido = array_filter($productos, fn($p) => $p['id'] == $productoMasVendidoId);
    $productoMasVendido = array_values($productoMasVendido)[0]['nombre'];

    $comprasPorCliente = [];
    foreach ($ventas as $v) {
        $comprasPorCliente[$v['cliente_id']] = ($comprasPorCliente[$v['cliente_id']] ?? 0) + $v['cantidad'];
    }
    arsort($comprasPorCliente);
    $clienteTopId = array_key_first($comprasPorCliente);
    $clienteTop = array_filter($clientes, fn($c) => $c['id'] == $clienteTopId);
    $clienteTop = array_values($clienteTop)[0]['nombre'];

    return [
        "total_ventas" => $totalVentas,
        "producto_mas_vendido" => $productoMasVendido,
        "cliente_mas_comprador" => $clienteTop
    ];
}

$resumen = generarResumenVentas($ventas, $tiendaData['productos'], $tiendaData['clientes']);
echo "\nResumen de ventas:\n";
print_r($resumen);

?>
