<?php

class Estudiante {
    private $id;
    private $nombre;
    private $edad;
    private $carrera;
    private $materias;

    public function __construct($id, $nombre, $edad, $carrera, $materias = []) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = $materias;
    }

    public function agregarMateria($materia, $calificacion) {
        $this->materias[$materia] = $calificacion;
    }

    public function obtenerPromedio() {
        if (empty($this->materias)) {
            return 0;
        }
        $suma = array_sum($this->materias);
        return $suma / count($this->materias);
    }

    public function esHonorRoll() {
        return $this->obtenerPromedio() >= 90;
    }

    public function enRiesgoAcademico() {
        foreach ($this->materias as $calificacion) {
            if ($calificacion < 60) {
                return true;
            }
        }
        return $this->obtenerPromedio() < 70;
    }

    public function obtenerDetalles() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias,
            'promedio' => $this->obtenerPromedio(),
            'honor_roll' => $this->esHonorRoll(),
            'riesgo_academico' => $this->enRiesgoAcademico()
        ];
    }

    public function __toString() {
        $flagHonor = $this->esHonorRoll() ? " (Honor Roll)" : "";
        $flagRiesgo = $this->enRiesgoAcademico() ? " (En Riesgo Académico)" : "";
        return "ID: {$this->id}, Nombre: {$this->nombre}, Edad: {$this->edad}, Carrera: {$this->carrera}, Promedio: " . number_format($this->obtenerPromedio(), 2) . "$flagHonor$flagRiesgo";
    }
}

class SistemaGestionEstudiantes {
    private $estudiantes = [];
    private $graduados = [];

    public function agregarEstudiante(Estudiante $estudiante) {
        $this->estudiantes[$estudiante->obtenerDetalles()['id']] = $estudiante;
    }

    public function listarEstudiantes() {
        return $this->estudiantes;
    }

    public function flagEstudiantes() {
        $honorRoll = array_filter($this->estudiantes, function($estudiante) {
            return $estudiante->esHonorRoll();
        });

        $enRiesgo = array_filter($this->estudiantes, function($estudiante) {
            return $estudiante->enRiesgoAcademico();
        });

        return [
            'honor_roll' => $honorRoll,
            'riesgo_academico' => $enRiesgo
        ];
    }
}

// ejemplo

$sistema = new SistemaGestionEstudiantes();

$estudiante1 = new Estudiante(1, "Arquimedes Garcia", 20, "Ingeniería", ["Matemáticas" => 85, "Física" => 90]);
$estudiante2 = new Estudiante(2, "Lorenzo Gómez", 22, "Medicina", ["Anatomía" => 95, "Biología" => 88, "Química" => 58]);  // Estudiante con materia reprobada
$estudiante3 = new Estudiante(3, "María Pineda", 21, "Ingeniería", ["Química" => 95, "Programación" => 92]);  // Estudiante en Honor Roll

$sistema->agregarEstudiante($estudiante1);
$sistema->agregarEstudiante($estudiante2);
$sistema->agregarEstudiante($estudiante3);

function mostrarTablaEstudiantes($estudiantes) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<thead><tr><th>ID</th><th>Nombre</th><th>Edad</th><th>Carrera</th><th>Promedio</th><th>Flag</th></tr></thead>";
    echo "<tbody>";
    foreach ($estudiantes as $estudiante) {
        $detalles = $estudiante->obtenerDetalles();
        $flag = $detalles['honor_roll'] ? "Honor Roll" : ($detalles['riesgo_academico'] ? "En Riesgo Académico" : "");
        echo "<tr>
                <td>{$detalles['id']}</td>
                <td>{$detalles['nombre']}</td>
                <td>{$detalles['edad']}</td>
                <td>{$detalles['carrera']}</td>
                <td>" . number_format($detalles['promedio'], 2) . "</td>
                <td>$flag</td>
            </tr>";
    }
    echo "</tbody></table>";
}

echo "<h2>Listado de estudiantes</h2>";
mostrarTablaEstudiantes($sistema->listarEstudiantes());

// mejores estudiantes
$flags = $sistema->flagEstudiantes();
echo "<h2>Estudiantes en Honor Roll</h2>";
if (!empty($flags['honor_roll'])) {
    mostrarTablaEstudiantes($flags['honor_roll']);
} else {
    echo "<p>No hay estudiantes en Honor Roll</p>";
}

//estudiantes en riesgo
echo "<h2>Estudiantes en Riesgo Académico</h2>";
if (!empty($flags['riesgo_academico'])) {
    mostrarTablaEstudiantes($flags['riesgo_academico']);
} else {
    echo "<p>No hay estudiantes en Riesgo Académico</p>";
}

?>
