<?php
require_once 'validaciones.php';
require_once 'sanitizacion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errores = [];
    $datos = [];

    // Campos del formulario (se reemplaza edad por fecha_nacimiento)
    $campos = ['nombre', 'email', 'fecha_nacimiento', 'sitio_web', 'genero', 'intereses', 'comentarios'];

    foreach ($campos as $campo) {
        if (isset($_POST[$campo])) {
            $valor = $_POST[$campo];
            $funcSanitizar = "sanitizar" . ucfirst($campo);
            $funcValidar = "validar" . ucfirst($campo);

            if (function_exists($funcSanitizar)) {
                $valorSanitizado = call_user_func($funcSanitizar, $valor);
            } else {
                $valorSanitizado = $valor;
            }

            $datos[$campo] = $valorSanitizado;

            if (function_exists($funcValidar) && !call_user_func($funcValidar, $valorSanitizado)) {
                $errores[] = "El campo $campo no es válido.";
            }
        }
    }

    // Calcular edad automáticamente
    if (isset($datos['fecha_nacimiento']) && empty($errores)) {
        $fecha_nac = new DateTime($datos['fecha_nacimiento']);
        $hoy = new DateTime();
        $datos['edad'] = $hoy->diff($fecha_nac)->y;
    }

    // Procesar la foto de perfil con nombre único
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_NO_FILE) {
        if (!validarFotoPerfil($_FILES['foto_perfil'])) {
            $errores[] = "La foto de perfil no es válida.";
        } else {
            $nombreArchivo = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_FILENAME);
            $extension = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
            $nombreUnico = $nombreArchivo . "_" . time() . "." . $extension;
            $rutaDestino = 'uploads/' . $nombreUnico;

            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                $datos['foto_perfil'] = $rutaDestino;
            } else {
                $errores[] = "Hubo un error al subir la foto de perfil.";
            }
        }
    }

    // Si no hay errores → guardar datos en JSON
    if (empty($errores)) {
        $file = 'registros.json';
        $registros = [];

        if (file_exists($file)) {
            $contenido = file_get_contents($file);
            $registros = json_decode($contenido, true) ?: [];
        }

        $registros[] = $datos;

        file_put_contents($file, json_encode($registros, JSON_PRETTY_PRINT));

        // Mostrar resultados
        echo "<h2>Datos Recibidos:</h2>";
        echo "<table border='1'>";
        foreach ($datos as $campo => $valor) {
            echo "<tr><th>" . ucfirst($campo) . "</th><td>";
            if ($campo === 'intereses') {
                echo implode(", ", $valor);
            } elseif ($campo === 'foto_perfil') {
                echo "<img src='$valor' width='100'>";
            } else {
                echo htmlspecialchars($valor);
            }
            echo "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>Errores:</h2><ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }

    echo "<br><a href='formulario.html'>Volver al formulario</a><br>";
    echo "<a href='resumen.php'>Ver resumen de registros</a>";
} else {
    echo "Acceso no permitido.";
}
?>
