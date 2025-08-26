<?php

$nombre_completo = "Abraham Batista";
$edad = 24;
$correo = "Abraham.Batista@utp.ac.pa";
$telefono = "+507 6000-0000";
define("OCUPACION", "Estudiante");

echo "<p>Nombre completo: " . $nombre_completo . "</p>";
echo "<p>Edad: $edad</p>";

print "<p>Correo electrónico: $correo</p>";
printf("<p>Teléfono: %s</p>", $telefono);
echo "<p>Ocupación: " . OCUPACION . "</p>";
echo "<hr>";

var_dump($nombre_completo);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($correo);
echo "<br>";
var_dump($telefono);
echo "<br>";
var_dump(OCUPACION);
?>

                    

git add TALLERES/TALLER_2/perfil_usuario.php
git commit -m "Ejercicio de perfil de usuario completado"
git push origin main
                    

