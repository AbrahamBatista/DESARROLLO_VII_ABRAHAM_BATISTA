<?php
// Definición de variables
$nombre_completo = "Abraham Batista";
$edad = 24;
$correo = "Abraham.Batista@utp.ac.pa";
$telefono = "+507 6000-0000";

// Definición de constante
define("OCUPACION", "Estudiante");

// Uso de echo
echo "<p>Nombre completo: " . $nombre_completo . "</p>";
echo "<p>Edad: $edad</p>";

// Uso de print
print "<p>Correo electrónico: $correo</p>";

// Uso de printf (con formato)
printf("<p>Teléfono: %s</p>", $telefono);

// Constante
echo "<p>Ocupación: " . OCUPACION . "</p>";

// Salto de línea
echo "<hr>";

// Uso de var_dump para mostrar tipo y valor
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
                    
