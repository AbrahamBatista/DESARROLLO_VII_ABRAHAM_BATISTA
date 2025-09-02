<?php
function obtenerLibros() {
    return [
        [
            'titulo' => 'El Quijote',
            'autor' => 'Miguel de Cervantes',
            'anio_publicacion' => 1605,
            'genero' => 'Novela',
            'descripcion' => 'La historia del ingenioso hidalgo Don Quijote de la Mancha.'
        ],
        [
            'titulo' => 'Cien Años de Soledad',
            'autor' => 'Gabriel García Márquez',
            'anio_publicacion' => 1967,
            'genero' => 'Realismo mágico',
            'descripcion' => 'La historia de la familia Buendía en Macondo.'
        ],
        [
            'titulo' => 'La Sombra del Viento',
            'autor' => 'Carlos Ruiz Zafón',
            'anio_publicacion' => 2001,
            'genero' => 'Misterio',
            'descripcion' => 'Un joven descubre un libro que cambiará su vida.'
        ],
        [
            'titulo' => '1984',
            'autor' => 'George Orwell',
            'anio_publicacion' => 1949,
            'genero' => 'Distopía',
            'descripcion' => 'Una sociedad vigilada por un régimen totalitario.'
        ],
        [
            'titulo' => 'El Principito',
            'autor' => 'Antoine de Saint-Exupéry',
            'anio_publicacion' => 1943,
            'genero' => 'Fábula',
            'descripcion' => 'Un niño que viaja desde un pequeño planeta reflexiona sobre la vida.'
        ]
    ];
}

function mostrarDetallesLibro($libro) {
    return "
    <div class='libro'>
        <h3>{$libro['titulo']}</h3>
        <p><strong>Autor:</strong> {$libro['autor']}</p>
        <p><strong>Año de Publicación:</strong> {$libro['anio_publicacion']}</p>
        <p><strong>Género:</strong> {$libro['genero']}</p>
        <p>{$libro['descripcion']}</p>
    </div>
    <hr>
    ";
}
?>

