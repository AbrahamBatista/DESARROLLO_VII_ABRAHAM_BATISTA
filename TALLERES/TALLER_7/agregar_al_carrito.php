<?php
include 'config_sesion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $cantidad = max(1, (int)$_POST['cantidad']);

    if(!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];
    if(isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id] += $cantidad;
    } else {
        $_SESSION['carrito'][$id] = $cantidad;
    }
}

header("Location: ver_carrito.php");
exit();
?>
