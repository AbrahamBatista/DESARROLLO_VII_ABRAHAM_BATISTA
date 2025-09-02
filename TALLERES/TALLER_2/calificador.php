<?php
// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $calificacion = (int) $_POST['calificacion'];

    // Validar que esté en el rango 0-100
    if ($calificacion >= 0 && $calificacion <= 100) {
        // Determinar letra
        if ($calificacion >= 90) {
            $letra = "A";
        } elseif ($calificacion >= 80) {
            $letra = "B";
        } elseif ($calificacion >= 70) {
            $letra = "C";
        } elseif ($calificacion >= 60) {
            $letra = "D";
        } else {
            $letra = "F";
        }

        // Imprimir calificación
        echo "<p>Tu calificación es $letra</p>";
        $estado = ($letra != "F") ? "Aprobado" : "Reprobado";
        echo "<p>Estado: $estado</p>";

        // Switch para mensaje adicional
        switch ($letra) {
            case "A":
                echo "<p>Excelente trabajo</p>";
                break;
            case "B":
                echo "<p>Buen trabajo</p>";
                break;
            case "C":
                echo "<p>Trabajo aceptable</p>";
                break;
            case "D":
                echo "<p>Necesitas mejorar</p>";
                break;
            case "F":
                echo "<p>Debes esforzarte más</p>";
                break;
        }
    } else {
        echo "<p style='color:red;'>Por favor ingresa un valor entre 0 y 100.</p>";
    }
}
?>

<form method="post" action="">
    <label for="calificacion">Ingrese su calificación (0-100):</label>
    <input type="number" name="calificacion" id="calificacion" min="0" max="100" required>
    <button type="submit">Calificar</button>
</form>
