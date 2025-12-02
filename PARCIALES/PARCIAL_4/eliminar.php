<?php
require 'database.php';
$id = $_GET['id'] ?? "";
if (ctype_digit((string)$id)) {
    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: index.php");
exit;
