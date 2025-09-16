
<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Gerente extends Empleado implements Evaluable {
    private $departamento;


    public function __construct($nombre, $idEmpleado, $salarioBase, $departamento) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->departamento = $departamento;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function asignarBono($montoBono) {
        if ($montoBono > 0) {
            $this->salarioBase += $montoBono;
        }
    }

    #public function evaluarDesempenio() {

     #   return "Evaluacion del desempeño del gerente: Buen desempeño en el area encargada " . $this->departamento;
    #}

    public function evaluarDesempenio() {
        return "Evaluacion del desempeño del Gerente: El Gerente". $this->getnombre() ."Tiene una evaluacion en el area " . $this->departamento . " con nivel de evaluacion de:  98% ";
    } #usamos getnombre() para que no de error al querer heredar propiedad privada.


    public function mostrarInformacion() {
        return parent::mostrarInformacion() . "Departamento:" . $this->departamento;
    }
}
?>
