<?php
require_once 'includes/funciones.php';
include 'includes/encabezado.php';
///prueba

// Obtener la lista de libros
$libros = obtenerLibros();

// Mostrar los detalles de cada libro
foreach ($libros as $libro) {
    echo mostrarDetallesLibro($libro);
}

include 'includes/pie_pagina.php';
?>
