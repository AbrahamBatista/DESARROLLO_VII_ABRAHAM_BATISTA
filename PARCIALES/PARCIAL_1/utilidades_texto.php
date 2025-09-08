<?php


// Función 1: contar_palabras
function contar_palabras($texto) {
    return str_word_count($texto);
}

// Función 2: contar_vocales
function contar_vocales($texto) {
    $texto = strtolower($texto);
    preg_match_all('/[aeiou]/', $texto, $coincidencias);
    return count($coincidencias[0]);
}

// Función 3: invertir_palabras
function invertir_palabras($texto) {
    $palabras = explode(" ", $texto);
    $palabras = array_reverse($palabras);
    return implode(" ", $palabras);
}
?>
