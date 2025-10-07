<?php
// Archivo: clases.php

interface Inventariable { //agregamos la interfaz     
public function obtenerInformacionInventario(): string;
    }

class Producto {
    public $id;
    public $nombre;
    public $descripcion;
    public $estado;
    public $stock;
    public $fechaIngreso;
    public $categoria;

    public function __construct($datos) {
        foreach ($datos as $clave => $valor) {
            if (property_exists($this, $clave)) {
                $this->$clave = $valor;
            }
        }
    }
}

class ProductoElectronico extends Producto implements Inventariable {
    public int $garantiaMeses = 0;

    public function __construct(array $datos = []) {
        parent::__construct($datos);
        if (isset($datos['garantiaMeses'])) {
            $this->garantiaMeses = (int)$datos['garantiaMeses'];
        }
        $this->categoria = $this->categoria ?: 'electronico';
    }

    public function obtenerInformacionInventario(): string {
        return "Garantía: {$this->garantiaMeses} meses";
    }
}


class ProductoAlimento extends Producto implements Inventariable {
    public string $fechaVencimiento = ''; 

    public function __construct(array $datos = []) {
        parent::__construct($datos);
        if (isset($datos['fechaVencimiento'])) {
            $this->fechaVencimiento = (string)$datos['fechaVencimiento'];
        }
        $this->categoria = $this->categoria ?: 'alimento';
    }

    public function obtenerInformacionInventario(): string {
        return "Fecha de vencimiento: {$this->fechaVencimiento}";
    }
}


class ProductoRopa extends Producto implements Inventariable {
    public string $talla = ''; // S, M, L...

    public function __construct(array $datos = []) {
        parent::__construct($datos);
        if (isset($datos['talla'])) {
            $this->talla = (string)$datos['talla'];
        }
        $this->categoria = $this->categoria ?: 'ropa';
    }

    public function obtenerInformacionInventario(): string {
        return "Talla: {$this->talla}";
    }
}

$estadosLegibles = [
    "disponible" => "Disponible",
    "agotado" => "Agotado",
    "por_recibir" => "Por Recibir"
];

$categoriasLegibles = [
    "electronico" => "Electronico",
    "alimento" => "Alimento",
    "ropa" => "Ropa"
];


class GestorInventario {
    private array $items = [];
    private string $rutaArchivo = 'productos.json';

    public function obtenerTodos(): array {
        if (empty($this->items)) {
            $this->cargarDesdeArchivo();
        }
        return $this->items;
    }

    private function crearProducto(array $datos): Producto {
        $categoria = strtolower($datos['categoria'] ?? '');

        switch ($categoria) {
            case 'electronico':
            case 'electrónico':
                return new ProductoElectronico($datos);
            case 'alimento':
                return new ProductoAlimento($datos);
            case 'ropa':
                return new ProductoRopa($datos);
            default:
                return new Producto($datos);
        }
    }

    private function cargarDesdeArchivo(): void {
        if (!file_exists($this->rutaArchivo)) {
            $this->items = [];
            return;
        }

        $jsonContenido = @file_get_contents($this->rutaArchivo);
        if ($jsonContenido === false) {
            $this->items = [];
            return;
        }

        $arrayDatos = json_decode($jsonContenido, true);
        if (!is_array($arrayDatos)) {
            $this->items = [];
            return;
        }

        $this->items = []; 
        foreach ($arrayDatos as $datos) {
            if (is_array($datos)) {
                $this->items[] = $this->crearProducto($datos);
            }
        }
    }

    private function persistirEnArchivo(): void {
        $arrayParaGuardar = array_map(function($item) {
            return get_object_vars($item);
        }, $this->items);

        file_put_contents(
            $this->rutaArchivo,
            json_encode($arrayParaGuardar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    public function obtenerMaximoId(): int {
        $this->obtenerTodos(); 
        if (empty($this->items)) {
            return 0;
        }
        $ids = array_map(function($item) {
            return (int)($item->id ?? 0);
        }, $this->items);
        return max($ids);
    }

    public function obtenerPorId($idBuscado) {
        $this->obtenerTodos();
        foreach ($this->items as $p) {
            if ((string)($p->id ?? '') === (string)$idBuscado) {
                return $p;
            }
        }
        return null;
    }


    public function agregar($nuevoProducto): void {
        $this->obtenerTodos();

        $nuevoId = $this->obtenerMaximoId() + 1;
        $nuevoProducto->id = $nuevoId;

        $this->items[] = $nuevoProducto;
        $this->persistirEnArchivo();
    }

    public function eliminar($idProducto): bool {
        $this->obtenerTodos();

        foreach ($this->items as $i => $p) {
            if ((string)($p->id ?? '') === (string)$idProducto) {
                array_splice($this->items, $i, 1);
                $this->persistirEnArchivo();
                return true;
            }
        }
        return false;
    }

    public function actualizar($productoActualizado): bool {
        $this->obtenerTodos();

        if (!isset($productoActualizado->id)) {
            return false; 
        }

        foreach ($this->items as $i => $p) {
            if ((string)($p->id ?? '') === (string)$productoActualizado->id) {
                $this->items[$i] = $productoActualizado;
                $this->persistirEnArchivo();
                return true;
            }
        }
        return false;
    }

    public function cambiarEstado($idProducto, $estadoNuevo): bool {
        $this->obtenerTodos();

        foreach ($this->items as $i => $p) {
            if ((string)($p->id ?? '') === (string)$idProducto) {
                $this->items[$i]->estado = $estadoNuevo;
                $this->persistirEnArchivo();
                return true;
            }
        }
        return false;
    }

    public function filtrarPorEstado($estadoBuscado): array {
        $this->obtenerTodos();

        $estadoBuscado = trim((string)$estadoBuscado);
        if ($estadoBuscado === '') {
            return $this->items; 
        }

        $needle = mb_strtolower($estadoBuscado);
        return array_values(array_filter($this->items, function ($p) use ($needle) {
            $estado = mb_strtolower((string)($p->estado ?? ''));
            return $estado === $needle;
        }));
    }
}

