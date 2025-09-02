<?php

$contenidoArchivo = file_get_contents("inventario.json");

$productos = json_decode($contenidoArchivo, true);


function primerLetraMinuscula($frase) {
    $palabras = explode(" ", trim($frase)); 
    $palabrasModificadas = array_map(function($palabra) {
        return strtolower(substr($palabra, 0, 1)) . substr($palabra, 1);
      
    }, $palabras);
    return implode(" ", $palabrasModificadas); 
}

function MostrarInventario($productos){
    $nombres = array_map(function($p) {
        return strtolower($p['nombre']); 
    }, $productos);

    
    sort($nombres);

    echo "Resumen del Inventario\n";
    echo str_pad("Producto", 20)  
    . str_pad("Precio", 15)     
    . str_pad("Cantidad", 10)  
    . "\n";

    echo str_repeat("-", 45) . "\n";

    
    foreach ($nombres as $nombre) {
        foreach ($productos as $p) {
            if (strtolower($p['nombre']) === $nombre) {
                echo str_pad($p['nombre'], 20)
                   . str_pad("$" . round($p['precio'], 2), 15)
                   . $p['cantidad'] . "\n";
            }
        }
    }
}
function InventarioBajo($productos){
$stockbajo = array_filter($productos, function($productos) {
    return $productos['cantidad'] < 10;
});
echo "</br>Productos con inventario bajo:</br>";
foreach ($stockbajo as $productos) {
    echo "- {$productos['nombre']} ({$productos['cantidad']} cantidad)</br>";
}
}
MostrarInventario($productos);
InventarioBajo($productos);
?>
