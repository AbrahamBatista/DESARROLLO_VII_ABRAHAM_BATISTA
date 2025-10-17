<?php
// Ruta del archivo JSON donde se guardan los registros
$archivo = 'registros.json';

// Verificar si el archivo existe y contiene datos
if (!file_exists($archivo)) {
    echo "<h2>No hay registros todavía.</h2>";
    exit;
}

$contenido = file_get_contents($archivo);
$registros = json_decode($contenido, true);

if (empty($registros)) {
    echo "<h2>No hay registros todavía.</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Registros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }
        h2 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        img {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <h2>📋 Resumen de Registros</h2>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Edad</th>
            <th>Sitio Web</th>
            <th>Género</th>
            <th>Intereses</th>
            <th>Comentarios</th>
            <th>Foto de Perfil</th>
        </tr>

        <?php foreach ($registros as $registro): ?>
        <tr>
            <td><?= htmlspecialchars($registro['nombre']) ?></td>
            <td><?= htmlspecialchars($registro['email']) ?></td>
            <td><?= htmlspecialchars($registro['edad']) ?></td>
            <td>
                <?php if (!empty($registro['sitio_web'])): ?>
                    <a href="<?= htmlspecialchars($registro['sitio_web']) ?>" target="_blank">Visitar</a>
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($registro['genero']) ?></td>
            <td><?= implode(", ", $registro['intereses']) ?></td>
            <td><?= htmlspecialchars($registro['comentarios']) ?></td>
            <td>
                <?php if (!empty($registro['foto_perfil'])): ?>
                    <img src="<?= htmlspecialchars($registro['foto_perfil']) ?>" width="80">
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
