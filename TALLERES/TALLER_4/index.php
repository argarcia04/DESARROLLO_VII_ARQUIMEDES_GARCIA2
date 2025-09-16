<?php
require_once 'Empresa.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';

$gerente1 = new Gerente("Arquimeds", 1, 5000, "Ventas");
$gerente2 = new Gerente("Jasmin",5 , 6000, "Redes");
$desarrollador1 = new Desarrollador("Javier", 2, 4000, "PHP", "Senior");
$desarrollador2 = new Desarrollador("Sofia", 3, 2500, "JavaScript", "Mid");
$desarrollador3 = new Desarrollador("Humbert", 4, 1, "HTML", "junior");

$empresa = new Empresa();

$empresa->agregarEmpleado($gerente1);
$empresa->agregarEmpleado($desarrollador1);
$empresa->agregarEmpleado($desarrollador2);
$empresa->agregarEmpleado($desarrollador3);
$empresa->agregarEmpleado($gerente2);

echo "<h2>Listado de mpleados:</h2>";
$empresa->listarEmpleados();

$nominaTotal = $empresa->calcularNominaTotal();
echo "<h2>Nomina Total:</h2>";
echo "Total: $" . number_format($nominaTotal, 2) . "<br>";

echo "<h2>Evaluaciones de Desempeño:</h2>";
$empresa->realizarEvaluaciones();
?>