<?php
session_start();
if (isset($_SESSION["usuario"])) {
    header("Location: validar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h2>Inicio de sesión</h2>

<?php
if (isset($_GET["error"])) {
    echo "<p style='color:red;'>".htmlspecialchars($_GET["error"])."</p>";
}
?>

<form method="post" action="validar.php">
    Usuario: <br>
    <input type="text" name="usuario" required><br><br>

    Contraseña: <br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Ingresar</button>
</form>

</body>
</html>
