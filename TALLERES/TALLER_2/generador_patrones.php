<?php
// 1. Patrón de triángulo con bucle for
echo "<h3>Patrón de Triángulo</h3>";
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "<br>";
}

echo "<hr>";

// 2. Secuencia de números impares con bucle while
echo "<h3>Números Impares del 1 al 20</h3>";
$numero = 1;
while ($numero <= 20) {
    if ($numero % 2 != 0) {  // Condicional para verificar si es impar
        echo $numero . " ";
    }
    $numero++;
}

echo "<hr>";

// 3. Contador regresivo con bucle do-while (saltando el número 5)
echo "<h3>Contador regresivo desde 10 hasta 1 (sin mostrar 5)</h3>";
$contador = 10;
do {
    if ($contador != 5) {  // Condicional para saltar el número 5
        echo $contador . " ";
    }
    $contador--;
} while ($contador >= 1);
?>
