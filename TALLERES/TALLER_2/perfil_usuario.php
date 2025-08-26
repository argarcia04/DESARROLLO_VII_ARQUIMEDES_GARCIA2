<?php
// Definición de variables
$nombre_completo = "Arquimedes Garcia Lorenzo";
$edad = 26;
$correo = "garquimedes2@gmail.com";
$telefono = 66122629;

// Definición de constante
define("OCUPACION", "Estudiante");

// Creación de mensaje usando diferentes métodos de concatenación e impresión
$mensaje1 = "Hola, mi nombre es " . $nombre_completo . " y tengo " . $edad . " años.";
$mensaje2 = "Mi correo es $correo. Mi número de teléfono es $telefono y soy " . OCUPACION . ".";

echo $mensaje1 . "<br>";
print($mensaje2 . "<br>");

printf("En resumen: %s, %d años, %s, %s, %s.<br>", $nombre_completo, $edad, $correo, $telefono, OCUPACION);

echo "<br>Información de debugging:<br>";
echo var_dump($nombre_completo) . "<br>";
echo var_dump($edad) . "<br>";
echo var_dump($correo) . "<br>";
echo var_dump($telefono) . "<br>";
echo var_dump(OCUPACION) . "<br>";
?>