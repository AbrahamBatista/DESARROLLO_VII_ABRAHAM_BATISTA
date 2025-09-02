<?php
$paginaActual = 'inicio';
require_once 'plantillas/funciones.php';
$tituloPagina = obtenerTituloPagina($paginaActual);
include 'plantillas/encabezado.php';
?>

<h2>Contenido de la Página de Inicio</h2>
<p>Este es el contenido específico sobre nosotros.</p>

<?php include 'plantillas/pie_pagina.php'; ?>
