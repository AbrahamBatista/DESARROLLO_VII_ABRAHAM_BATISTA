<?php
// === CONFIGURACIÓN PDO ===
define('DB_SERVIDOR', 'localhost');
define('DB_PUERTO', 3308);
define('DB_USUARIO', 'root');
define('DB_CONTRASENA', '12345');
define('DB_NOMBRE', 'taller8_db');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_SERVIDOR . ";port=" . DB_PUERTO . ";dbname=" . DB_NOMBRE,
        DB_USUARIO,
        DB_CONTRASENA
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: No se pudo conectar. " . $e->getMessage());
}
?>
