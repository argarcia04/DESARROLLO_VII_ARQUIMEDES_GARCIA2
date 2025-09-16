<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Desarrollador extends Empleado implements Evaluable {
    private $lenguajePrincipal;
    private $nivelExperiencia;

    public function __construct($nombre, $idEmpleado, $salarioBase, $lenguajePrincipal, $nivelExperiencia) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        #$this->nombre = $nombre;
        $this->lenguajePrincipal = $lenguajePrincipal;
        $this->nivelExperiencia = $nivelExperiencia;
    }

    public function getLenguajePrincipal() {
        return $this->lenguajePrincipal;
    }

    public function setLenguajePrincipal($lenguajePrincipal) {
        $this->lenguajePrincipal = $lenguajePrincipal;
    }


    public function getNivelExperiencia() {
        return $this->nivelExperiencia;
    }

    public function setNivelExperiencia($nivelExperiencia) {
        $this->nivelExperiencia = $nivelExperiencia;
    }

    #public function evaluarDesempenio() {
        #return "Evaluacion del desempeño del desarrollado: El desarrollador". $this->getnombre() ."Maneja a la perfeccion " . $this->lenguajePrincipal . " con nivel de experiencia " . $this->nivelExperiencia;
     #usamos getnombre() para que no de error al querer heredar propiedad privada.

    public function mostrarInformacion() {
        return parent::mostrarInformacion() . 
               "<b>Nombre del Desarrollador:</b>   " . $this->NombreDesarrollador .
               "<b>Lenguaje Principal:</b>   " . $this->lenguajePrincipal . 
               "<b>Nivel de Experiencia:</b>    " . $this->nivelExperiencia;
    }

    public function evaluarDesempenio() {
    $experiencia = $this->nivelExperiencia;
    $descripcion = "";

    if (strtolower($experiencia) === "junior") {
        $descripcion = "maneja con limitaciones el lenguaje";
    } elseif (strtolower($experiencia) === "mid") {
        $descripcion = "maneja los conocimientos básicos del lenguaje";
    } elseif (strtolower($experiencia) === "senior") {
        $descripcion = "maneja a la perfección";
    
    }  #USAMOS PROPIEDAD DEL TALLER ANTERIOR

    return "Evaluacion del desempeño del desarrollador " . $this->getnombre() . ": " . $descripcion . " " . $this->lenguajePrincipal . " con nivel de experiencia " . $this->nivelExperiencia;
}

}
?>