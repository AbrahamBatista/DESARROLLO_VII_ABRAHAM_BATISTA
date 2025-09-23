<?php
/**
 * Proyecto Final: Sistema de Gestión de Estudiantes
 * PHP avanzado: Arreglos, Objetos, Reportes y Persistencia JSON
 */

declare(strict_types=1);

/**
 * Clase Estudiante
 * Representa a un estudiante con materias y calificaciones
 */
class Estudiante
{
    private int $id;
    private string $nombre;
    private int $edad;
    private string $carrera;
    private array $materias; // ['materia' => calificacion]
    private array $flags;    // ['en riesgo', 'honor roll', ...]

    public function __construct(int $id, string $nombre, int $edad, string $carrera, array $materias = [])
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = $materias;
        $this->flags = [];
        $this->actualizarFlags();
    }

    // Agrega o actualiza una materia y su calificación
    public function agregarMateria(string $materia, float $calificacion): void
    {
        $this->materias[$materia] = $calificacion;
        $this->actualizarFlags();
    }

    // Calcula el promedio de todas las materias
    public function obtenerPromedio(): float
    {
        if (empty($this->materias)) return 0;
        return array_sum($this->materias) / count($this->materias);
    }

    // Retorna un arreglo con toda la información del estudiante
    public function obtenerDetalles(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias,
            'promedio' => $this->obtenerPromedio(),
            'flags' => $this->flags
        ];
    }

    // Actualiza los flags según promedio o materias reprobadas
    private function actualizarFlags(): void
    {
        $this->flags = [];
        $promedio = $this->obtenerPromedio();

        if ($promedio >= 90) $this->flags[] = 'honor roll';
        if ($promedio < 70 || in_array(true, array_map(fn($n) => $n < 60, $this->materias))) {
            $this->flags[] = 'en riesgo académico';
        }
    }

    // Permite imprimir información de manera amigable
    public function __toString(): string
    {
        $materiasStr = implode(", ", array_map(fn($m, $c) => "$m: $c", array_keys($this->materias), $this->materias));
        $flagsStr = empty($this->flags) ? "Ninguno" : implode(", ", $this->flags);
        return "ID: {$this->id} | Nombre: {$this->nombre} | Edad: {$this->edad} | Carrera: {$this->carrera}\n" .
               "Materias: {$materiasStr}\n" .
               "Promedio: " . number_format($this->obtenerPromedio(), 2) . " | Flags: {$flagsStr}\n";
    }

    // Retorna el ID
    public function getId(): int { return $this->id; }

    // Retorna el nombre
    public function getNombre(): string { return $this->nombre; }

    // Retorna la carrera
    public function getCarrera(): string { return $this->carrera; }
}

/**
 * Clase SistemaGestionEstudiantes
 * Maneja todos los estudiantes y operaciones avanzadas
 */
class SistemaGestionEstudiantes
{
    private array $estudiantes = [];
    private array $graduados = [];

    // Agrega un estudiante al sistema
    public function agregarEstudiante(Estudiante $estudiante): void
    {
        $this->estudiantes[$estudiante->getId()] = $estudiante;
    }

    // Obtiene un estudiante por ID
    public function obtenerEstudiante(int $id): ?Estudiante
    {
        return $this->estudiantes[$id] ?? null;
    }

    // Lista todos los estudiantes
    public function listarEstudiantes(): array
    {
        return array_values($this->estudiantes);
    }

    // Calcula el promedio general de todos los estudiantes
    public function calcularPromedioGeneral(): float
    {
        if (empty($this->estudiantes)) return 0;
        $promedios = array_map(fn($e) => $e->obtenerPromedio(), $this->estudiantes);
        return array_sum($promedios) / count($promedios);
    }

    // Obtiene los estudiantes de una carrera específica
    public function obtenerEstudiantesPorCarrera(string $carrera): array
    {
        return array_filter($this->estudiantes, fn($e) => strcasecmp($e->getCarrera(), $carrera) === 0);
    }

    // Obtiene el estudiante con el promedio más alto
    public function obtenerMejorEstudiante(): ?Estudiante
    {
        if (empty($this->estudiantes)) return null;
        return array_reduce($this->estudiantes, fn($mejor, $actual) => !$mejor || $actual->obtenerPromedio() > $mejor->obtenerPromedio() ? $actual : $mejor);
    }

    // Genera un reporte de rendimiento por materia
    public function generarReporteRendimiento(): array
    {
        $materias = [];
        foreach ($this->estudiantes as $e) {
            foreach ($e->obtenerDetalles()['materias'] as $materia => $calificacion) {
                $materias[$materia][] = $calificacion;
            }
        }

        $reporte = [];
        foreach ($materias as $materia => $calificaciones) {
            $reporte[$materia] = [
                'promedio' => array_sum($calificaciones) / count($calificaciones),
                'max' => max($calificaciones),
                'min' => min($calificaciones)
            ];
        }
        return $reporte;
    }

    // Gradúa a un estudiante, eliminándolo de activos y guardándolo en graduados
    public function graduarEstudiante(int $id): void
    {
        if (isset($this->estudiantes[$id])) {
            $this->graduados[$id] = $this->estudiantes[$id];
            unset($this->estudiantes[$id]);
        }
    }

    // Genera ranking descendente por promedio
    public function generarRanking(): array
    {
        $ranking = $this->listarEstudiantes();
        usort($ranking, fn($a, $b) => $b->obtenerPromedio() <=> $a->obtenerPromedio());
        return $ranking;
    }

    // Busca estudiantes por nombre o carrera (búsqueda parcial, insensible a mayúsculas)
    public function buscarEstudiantes(string $termino): array
    {
        $termino = strtolower($termino);
        return array_filter($this->estudiantes, fn($e) => 
            str_contains(strtolower($e->getNombre()), $termino) ||
            str_contains(strtolower($e->getCarrera()), $termino)
        );
    }

    // Guarda estudiantes en archivo JSON
    public function guardarJSON(string $archivo): void
    {
        $datos = array_map(fn($e) => $e->obtenerDetalles(), $this->estudiantes);
        file_put_contents($archivo, json_encode($datos, JSON_PRETTY_PRINT));
    }

    // Carga estudiantes desde archivo JSON
    public function cargarJSON(string $archivo): void
    {
        if (!file_exists($archivo)) return;
        $datos = json_decode(file_get_contents($archivo), true);
        foreach ($datos as $d) {
            $e = new Estudiante($d['id'], $d['nombre'], $d['edad'], $d['carrera'], $d['materias']);
            $this->agregarEstudiante($e);
        }
    }
}

/**
 * ----------- Sección de prueba del sistema -----------
 */

// Instancia el sistema
$sistema = new SistemaGestionEstudiantes();

// Crea estudiantes de ejemplo
$estudiantesEjemplo = [
    new Estudiante(1, "Ana", 20, "Ingeniería", ["Matemáticas"=>95, "Física"=>88]),
    new Estudiante(2, "Juan", 22, "Derecho", ["Historia"=>80, "Literatura"=>90]),
    new Estudiante(3, "María", 21, "Medicina", ["Biología"=>92, "Química"=>85]),
    new Estudiante(4, "Pedro", 23, "Ingeniería", ["Matemáticas"=>65, "Física"=>70]),
    new Estudiante(5, "Laura", 20, "Derecho", ["Historia"=>88, "Literatura"=>91]),
    new Estudiante(6, "Luis", 22, "Medicina", ["Biología"=>78, "Química"=>82]),
    new Estudiante(7, "Carla", 21, "Ingeniería", ["Matemáticas"=>90, "Física"=>95]),
    new Estudiante(8, "David", 23, "Derecho", ["Historia"=>60, "Literatura"=>75]),
    new Estudiante(9, "Sofía", 20, "Medicina", ["Biología"=>85, "Química"=>89]),
    new Estudiante(10, "Miguel", 22, "Ingeniería", ["Matemáticas"=>82, "Física"=>80]),
];

// Agrega los estudiantes al sistema
foreach ($estudiantesEjemplo as $e) {
    $sistema->agregarEstudiante($e);
}

// Muestra todos los estudiantes
echo "---- Listado de Estudiantes ----\n";
foreach ($sistema->listarEstudiantes() as $e) {
    echo $e . "\n";
}

// Calcula y muestra el promedio general
echo "Promedio general de la clase: " . number_format($sistema->calcularPromedioGeneral(), 2) . "\n\n";

// Muestra el mejor estudiante
$mejor = $sistema->obtenerMejorEstudiante();
echo "Mejor estudiante: {$mejor->getNombre()} con promedio " . number_format($mejor->obtenerPromedio(), 2) . "\n\n";

// Genera y muestra el ranking
echo "---- Ranking de Estudiantes ----\n";
foreach ($sistema->generarRanking() as $idx => $e) {
    echo ($idx+1) . ". {$e->getNombre()} - Promedio: " . number_format($e->obtenerPromedio(),2) . "\n";
}

// Genera reporte de rendimiento por materia
echo "\n---- Reporte de Materias ----\n";
$reporteMaterias = $sistema->generarReporteRendimiento();
foreach ($reporteMaterias as $materia => $info) {
    echo "$materia: Promedio={$info['promedio']}, Max={$info['max']}, Min={$info['min']}\n";
}

// Guarda los estudiantes en JSON
$sistema->guardarJSON('estudiantes.json');
echo "\nDatos guardados en estudiantes.json\n";

?>
