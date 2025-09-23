<?php
$estudiantes = [
    ["nombre" => "Ana", "calificaciones" => [85, 92, 78, 96, 88]],
    ["nombre" => "Juan", "calificaciones" => [75, 84, 91, 79, 86]],
    ["nombre" => "María", "calificaciones" => [92, 95, 89, 97, 93]],
    ["nombre" => "Pedro", "calificaciones" => [70, 72, 78, 75, 77]],
    ["nombre" => "Laura", "calificaciones" => [88, 86, 90, 85, 89]]
];

function calcularPromedio($calificaciones) {
    return array_sum($calificaciones) / count($calificaciones);
}

function asignarLetraCalificacion($promedio) {
    if ($promedio >= 90) return 'A';
    if ($promedio >= 80) return 'B';
    if ($promedio >= 70) return 'C';
    if ($promedio >= 60) return 'D';
    return 'F';
}

echo "Información de estudiantes:\n";
foreach ($estudiantes as &$estudiante) {
    $promedio = calcularPromedio($estudiante["calificaciones"]);
    $estudiante["promedio"] = $promedio;
    $estudiante["letra_calificacion"] = asignarLetraCalificacion($promedio);
    
    echo "{$estudiante['nombre']}:\n";
    echo "  Calificaciones: " . implode(", ", $estudiante["calificaciones"]) . "\n";
    echo "  Promedio: " . number_format($promedio, 2) . "\n";
    echo "  Calificación: {$estudiante['letra_calificacion']}\n\n";
}

$mejorEstudiante = array_reduce($estudiantes, function($mejor, $actual) {
    return (!$mejor || $actual["promedio"] > $mejor["promedio"]) ? $actual : $mejor;
});

echo "Estudiante con el promedio más alto: {$mejorEstudiante['nombre']} ({$mejorEstudiante['promedio']})\n";

$promedioGeneral = array_sum(array_column($estudiantes, "promedio")) / count($estudiantes);
echo "Promedio general de la clase: " . number_format($promedioGeneral, 2) . "\n";

$conteoCalificaciones = array_count_values(array_column($estudiantes, "letra_calificacion"));
echo "Distribución de calificaciones:\n";
foreach ($conteoCalificaciones as $letra => $cantidad) {
    echo "$letra: $cantidad estudiante(s)\n";
}

function estudiantesNecesitanTutoria($estudiantes) {
    return array_filter($estudiantes, function($e) {
        return $e["promedio"] < 75;
    });
}

function estudiantesHonor($estudiantes) {
    return array_filter($estudiantes, function($e) {
        return $e["promedio"] >= 90;
    });
}

echo "\nEstudiantes que necesitan tutoría:\n";
$tutoria = estudiantesNecesitanTutoria($estudiantes);
if (empty($tutoria)) {
    echo "Ninguno\n";
} else {
    foreach ($tutoria as $e) {
        echo "- {$e['nombre']} (Promedio: " . number_format($e['promedio'], 2) . ")\n";
    }
}

echo "\nEstudiantes de honor:\n";
$honor = estudiantesHonor($estudiantes);
if (empty($honor)) {
    echo "Ninguno\n";
} else {
    foreach ($honor as $e) {
        echo "- {$e['nombre']} (Promedio: " . number_format($e['promedio'], 2) . ")\n";
    }
}
?>
