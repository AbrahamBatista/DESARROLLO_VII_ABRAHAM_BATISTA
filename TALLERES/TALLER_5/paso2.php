<?php
$inventario = [
    "laptop" => ["cantidad" => 50, "precio" => 800],
    "smartphone" => ["cantidad" => 100, "precio" => 500],
    "tablet" => ["cantidad" => 30, "precio" => 300],
    "smartwatch" => ["cantidad" => 25, "precio" => 150]
];

function mostrarInventario($inv) {
    foreach ($inv as $producto => $info) {
        echo "$producto: {$info['cantidad']} unidades, Precio: \${$info['precio']}\n";
    }
}

function actualizarInventario(&$inv, $producto, $cantidad, $precio = null) {
    if (!isset($inv[$producto])) {
        $inv[$producto] = ["cantidad" => $cantidad, "precio" => $precio];
    } else {
        $inv[$producto]["cantidad"] += $cantidad;
        if ($precio !== null) {
            $inv[$producto]["precio"] = $precio;
        }
    }
}

function valorTotalInventario($inv) {
    $total = 0;
    foreach ($inv as $info) {
        $total += $info['cantidad'] * $info['precio'];
    }
    return $total;
}

function productoMayorValor($inv) {
    $mayorProducto = null;
    $mayorValor = 0;
    foreach ($inv as $producto => $info) {
        $valor = $info['cantidad'] * $info['precio'];
        if ($valor > $mayorValor) {
            $mayorValor = $valor;
            $mayorProducto = $producto;
        }
    }
    return ["producto" => $mayorProducto, "valor" => $mayorValor];
}

echo "Inventario inicial:\n";
mostrarInventario($inventario);

actualizarInventario($inventario, "laptop", -5);
actualizarInventario($inventario, "smartphone", 50, 450);
actualizarInventario($inventario, "auriculares", 100, 50);

echo "\nInventario actualizado:\n";
mostrarInventario($inventario);

echo "\nValor total del inventario: $" . valorTotalInventario($inventario) . "\n";

$mayor = productoMayorValor($inventario);
echo "\nProducto con mayor valor en inventario: {$mayor['producto']} (\${$mayor['valor']})\n";
?>
