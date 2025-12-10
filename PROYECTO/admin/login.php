<?php
session_start();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? "";
    $clave = $_POST['clave'] ?? "";

    if ($usuario === "admin" && $clave === "1234") {
        $_SESSION['admin'] = $usuario;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="card" style="min-width:350px;">
        <div class="card-header bg-dark text-white">Panel Administrativo</div>
        <div class="card-body">
            <?php if($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" name="usuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="clave" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">Ingresar</button>
                <a href="../index.php" class="btn btn-link w-100 mt-2">Volver al sitio</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
