<?php
require_once 'includes/funciones.php';
include 'includes/encabezado.php';

$libros = obtenerLibros();
foreach ($libros as $libro) {
    echo mostrarDetallesLibro($libro);
}

include 'includes/pie_pagina.php';
?>

