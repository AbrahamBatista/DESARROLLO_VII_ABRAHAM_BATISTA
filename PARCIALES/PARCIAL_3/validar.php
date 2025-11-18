<?php
session_start();
require "datos.php";

$usuario = trim($_POST["usuario"] ?? "");
$password = trim($_POST["password"] ?? "");

// VALIDACION
if ($usuario === "" || $password === "") {
    header("Location: index.php?error=Todos los campos son obligatorios.");
    exit;
}

if (!preg_match('/^[a-zA-Z0-9]{3,}$/', $usuario)) {
    header("Location: index.php?error=Usuario invalido (mín 3 caracteres, solo letras y numeros).");
    exit;
}

if (strlen($password) < 5) {
    header("Location: index.php?error=La contraseña debe tener al menos 5 caracteres.");
    exit;
}

// VERIFICAR 
if (!isset($usuarios[$usuario]) || $usuarios[$usuario]["password"] !== $password) {
    header("Location: index.php?error=Credenciales incorrectas.");
    exit;
}

// GUARDAR 
$_SESSION["usuario"] = $usuario;
$_SESSION["rol"] = $usuarios[$usuario]["rol"];

// Rol
if ($_SESSION["rol"] === "Profesor") {
    header("Location: dashboard_profesor.php");
} else {
    header("Location: dashboard_estudiante.php");
}
exit;
?>
