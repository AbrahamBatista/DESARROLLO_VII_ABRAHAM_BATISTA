<?php
// Ejemplo de uso de date()
echo "Fecha actual: " . date("Y-m-d") . "</br>";
echo "Hora actual: " . date("H:i:s") . "</br>";
echo "Fecha y hora actuales: " . date("Y-m-d H:i:s") . "</br>";

// Ejercicio: Usa date() para mostrar la fecha actual en el formato "Día de la semana, día de mes de año"
// Agregando diferentes formatos de fecha
echo "Formato 1 (d/m/Y): " . date("d/m/Y") . "<br>";
echo "Formato 2 (D, d-M-Y): " . date("D, d-M-Y") . "<br>";
echo "Formato 3 (l, j \de F \de Y): " . date("l, j \de F \de Y") . "<br>";
echo "Formato 4 (F j, Y g:i A): " . date("F j, Y g:i A") . "<br>";

// Bonus: Crea una función que devuelva la diferencia en días entre dos fechas
function diasEntre($fecha1, $fecha2) {
    $timestamp1 = strtotime($fecha1);
    $timestamp2 = strtotime($fecha2);
    $diferencia = abs($timestamp2 - $timestamp1);
    return floor($diferencia / (60 * 60 * 24));
}

// Calcular días transcurridos desde una fecha de inicio hasta hoy
$fechaInicio = "2025-01-01";
$fechaFin = date("Y-m-d"); // Fecha actual
$diasTranscurridos = diasEntre($fechaInicio, $fechaFin);
echo "</br>Días transcurridos desde el $fechaInicio hasta hoy: $diasTranscurridos días</br>";

// Calcular diferencia entre otras fechas
$otraFecha1 = "2025-08-01";
$otraFecha2 = "2025-09-02";
$diasEntreFechas = diasEntre($otraFecha1, $otraFecha2);
echo "Días entre $otraFecha1 y $otraFecha2: $diasEntreFechas días<br>";

// Extra: Mostrar zona horaria actual
echo "</br>Zona horaria actual: " . date_default_timezone_get() . "</br>";

// Cambiar zona horaria y mostrar la hora en diferentes regiones
$zonas = ["America/New_York", "Europe/London", "Asia/Tokyo", "Australia/Sydney"];
foreach ($zonas as $zona) {
    date_default_timezone_set($zona);
    echo "Hora en $zona: " . date("H:i:s") . "<br>";
}

// Restaurar zona horaria original
date_default_timezone_set("America/Panama");
?>
