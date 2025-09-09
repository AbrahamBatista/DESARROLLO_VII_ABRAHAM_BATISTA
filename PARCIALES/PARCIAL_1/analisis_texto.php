<?php

include 'utilidades_texto.php';

// Array con 3 frases diferentes
$frases = [
    "Hoy Panamá le gana a Guatemala",
    "Clasificaremos al mundial 2026 aunque hayamos empatado con Surinam",
    "Somos la marea roja"
];

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Frase</th><th>Numero de palabras</th><th>Numero de vocales</th><th>Palabras invertidas</th></tr>";

foreach ($frases as $frase) {
    echo "<tr>";
    echo "<td>$frase</td>";
    echo "<td>" . contar_palabras($frase) . "</td>";
    echo "<td>" . contar_vocales($frase) . "</td>";
    echo "<td>" . invertir_palabras($frase) . "</td>";
    echo "</tr>";
}

echo "</table>";
?>






