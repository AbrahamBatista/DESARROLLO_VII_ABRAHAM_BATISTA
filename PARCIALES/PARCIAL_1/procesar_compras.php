<?php

include 'funciones_tienda.php';

// Array de productos con precios
$productos = [
    'camisa' => 50,
    'pantalon' => 70,
    'zapatos' => 80,
    'calcetines' => 10,
    'gorra' => 25
];

// Carrito de compras con cantidades
$carrito = [
    'camisa' => 2,
    'pantalon' => 4,
    'zapatos' => 3,
    'calcetines' => 4,
    'gorra' => 2
];

// Calcular subtotal
$subtotal = 0;
foreach ($carrito as $producto => $cantidad) {
    $subtotal += $productos[$producto] * $cantidad;
}

// Calcular descuento, impuesto y total
$descuento = calcular_descuento($subtotal);
$impuesto = aplicar_impuesto($subtotal - $descuento);
$total = calcular_total($subtotal, $descuento, $impuesto);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Resumen de Compra</title>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Resumen de la Compra</h2>
    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($carrito as $producto => $cantidad): 
            if ($cantidad > 0):
        ?>
        <tr>
            <td><?php echo $producto; ?></td>
            <td><?php echo $cantidad; ?></td>
            <td><?php echo "$".$productos[$producto]; ?></td>
            <td><?php echo "$".$productos[$producto] * $cantidad; ?></td>
        </tr>
        <?php 
            endif;
            endforeach; 
        ?>
        <tr>
            <td colspan="3"><strong>Subtotal</strong></td>
            <td><?php echo "$".$subtotal; ?></td>
        </tr>
        <tr>
            <td colspan="3"><strong>Descuento</strong></td>
            <td><?php echo "$".$descuento; ?></td>
        </tr>
        <tr>
            <td colspan="3"><strong>Impuesto</strong></td>
            <td><?php echo "$".$impuesto; ?></td>
        </tr>
        <tr>
            <td colspan="3"><strong>Total a pagar</strong></td>
            <td><?php echo "$".$total; ?></td>
        </tr>
    </table>
</body>
</html>





        


