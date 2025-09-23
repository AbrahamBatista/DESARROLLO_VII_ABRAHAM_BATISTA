<?php
$ventas = [
    "Norte" => [
        "Producto A" => [100, 120, 140, 110, 130],
        "Producto B" => [85, 95, 105, 90, 100],
        "Producto C" => [60, 55, 65, 70, 75]
    ],
    "Sur" => [
        "Producto A" => [80, 90, 100, 85, 95],
        "Producto B" => [120, 110, 115, 125, 130],
        "Producto C" => [70, 75, 80, 65, 60]
    ],
    "Este" => [
        "Producto A" => [110, 115, 120, 105, 125],
        "Producto B" => [95, 100, 90, 105, 110],
        "Producto C" => [50, 60, 55, 65, 70]
    ],
    "Oeste" => [
        "Producto A" => [90, 85, 95, 100, 105],
        "Producto B" => [105, 110, 100, 115, 120],
        "Producto C" => [80, 85, 75, 70, 90]
    ]
];

function promedioVentas($ventas) {
    return array_sum($ventas) / count($ventas);
}

echo "Promedio de ventas por región y producto:\n";
foreach ($ventas as $region => $productos) {
    echo "$region:\n";
    foreach ($productos as $producto => $ventasProducto) {
        $promedio = promedioVentas($ventasProducto);
        echo "  $producto: " . number_format($promedio, 2) . "\n";
    }
    echo "\n";
}

function productoMasVendido($productos) {
    $maxVentas = 0;
    $productoTop = '';
    foreach ($productos as $producto => $ventas) {
        $totalVentas = array_sum($ventas);
        if ($totalVentas > $maxVentas) {
            $maxVentas = $totalVentas;
            $productoTop = $producto;
        }
    }
    return [$productoTop, $maxVentas];
}

echo "Producto más vendido por región:\n";
foreach ($ventas as $region => $productos) {
    [$productoTop, $ventasTop] = productoMasVendido($productos);
    echo "$region: $productoTop (Total: $ventasTop)\n";
}

$ventasTotalesPorProducto = [];
foreach ($ventas as $region => $productos) {
    foreach ($productos as $producto => $ventasProducto) {
        $ventasTotalesPorProducto[$producto] = ($ventasTotalesPorProducto[$producto] ?? 0) + array_sum($ventasProducto);
    }
}

echo "\nVentas totales por producto:\n";
arsort($ventasTotalesPorProducto);
foreach ($ventasTotalesPorProducto as $producto => $total) {
    echo "$producto: $total\n";
}

$ventasTotalesPorRegion = array_map(function($productos) {
    return array_sum(array_map('array_sum', $productos));
}, $ventas);

$regionTopVentas = array_keys($ventasTotalesPorRegion, max($ventasTotalesPorRegion))[0];
echo "\nRegión con mayores ventas totales: $regionTopVentas\n";

// Análisis de crecimiento de ventas
echo "\nCrecimiento de ventas por producto y región:\n";
$crecimientoMax = ['region' => '', 'producto' => '', 'crecimiento' => -INF];

foreach ($ventas as $region => $productos) {
    foreach ($productos as $producto => $ventasProducto) {
        $primerMes = $ventasProducto[0];
        $ultimoMes = $ventasProducto[count($ventasProducto)-1];
        $crecimiento = (($ultimoMes - $primerMes) / $primerMes) * 100;
        echo "$region - $producto: " . number_format($crecimiento, 2) . "%\n";
        if ($crecimiento > $crecimientoMax['crecimiento']) {
            $crecimientoMax = ['region' => $region, 'producto' => $producto, 'crecimiento' => $crecimiento];
        }
    }
}

echo "\nMayor crecimiento: {$crecimientoMax['producto']} en {$crecimientoMax['region']} ({$crecimientoMax['crecimiento']}%)\n";
?>
