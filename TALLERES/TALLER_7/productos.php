<?php
//los productos en arreglo
$productos = [
    ["nombre" => "Laptop", "Precio" => 385.99],
    ["nombre" => "Iphone 12", "Precio" => 285.50],
    ["nombre" => "Bolsa para laptop", "Precio" => 78],
    ["nombre" => "Cargador tipo c", "Precio" => 7.5],
    ["nombre" => "Cable HDMI", "Precio" => 5.5],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Productos</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>Listado de Productos</h1>

    <ul>
        <?php foreach ($productos as $item) { ?>
            <li>
                <?= htmlspecialchars($item['nombre']) ?> - 
                $ <?= htmlspecialchars($item['Precio']) ?>
                <button>Agregar</button>
                
            </li>
            
        <?php } ?>
    </ul>
    <button><a href="ver_carrito.php">Ver Carrito</a></button>
</body>
</html>