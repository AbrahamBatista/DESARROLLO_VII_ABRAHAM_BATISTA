<?php
include 'config_sesion.php';

$id = (int)($_GET['id'] ?? 0);
if(isset($_SESSION['carrito'][$id])) {
    unset($_SESSION['carrito'][$id]);
}
header("Location: ver_carrito.php");
exit();
?>
