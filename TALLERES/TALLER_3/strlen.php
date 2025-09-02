
<?php
// Ejemplo de uso de strlen()
<<<<<<< HEAD
$nombre = "ABRAHAM BATISTA";
=======
$nombre = "Juan Pérez";
>>>>>>> e1ac8084fda0605c23fe732a9eb9ad8db247d636
$longitud = strlen($nombre);

echo "El nombre '$nombre' tiene $longitud caracteres.";

// Ejercicio: Crea una variable con tu nombre completo y usa strlen() para mostrar su longitud
$miNombre = ""; // Reemplaza esto con tu nombre completo
$longitudMiNombre = strlen($miNombre);

echo "Mi nombre completo tiene $longitudMiNombre caracteres.";

// Bonus: Crea una función que tome un string como parámetro y devuelva si es "corto" (menos de 5 caracteres), "medio" (entre 5 y 10 caracteres) o "largo" (más de 10 caracteres)
function categorizarLongitud($texto) {
    $longitud = strlen($texto);
    if ($longitud < 5) {
        return "corto";
    } elseif ($longitud <= 10) {
        return "medio";
    } else {
        return "largo";
    }
}

$categoria = categorizarLongitud($miNombre);
echo "</br>Mi nombre es considerado $categoria.";
?>
<<<<<<< HEAD
          

=======
>>>>>>> e1ac8084fda0605c23fe732a9eb9ad8db247d636
          
