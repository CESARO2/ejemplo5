<?php
include_once('clsConexion.php');

class Producto extends Conexion
{
    // atributos
    private $id_producto;
    private $descripcion;
    private $precio;
    private $id_categoria;
    private $stock;

    
    // constructor
    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase padre
        $this->id_producto = 0;
        $this->descripcion = "";
        $this->precio = 0;
        $this->id_categoria = 0;
    }

    // propiedades de acceso
    public function setIdProducto($valor)
    {
        $this->id_producto = $valor;
    }

    public function getIdProducto()
    {
        return $this->id_producto;
    }

    public function setDescripcion($valor)
    {
        $this->descripcion = $valor;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setPrecio($valor)
    {
        $this->precio = $valor;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setIdCategoria($valor)
    {
        $this->id_categoria = $valor;
    }

    public function getIdCategoria()
    {
        return $this->id_categoria;
    }
    
    public function setStock($stock)
{
    $this->stock = $stock;
}

public function getStock()
{
    return $this->stock;
}


    public function guardar()
    {
        $sql = "INSERT INTO Producto (descripcion, precio, id_categoria, stock) VALUES (
            '{$this->descripcion}', 
            {$this->precio}, 
            {$this->id_categoria}, 
            {$this->stock}
        )";
        
        if(parent::ejecutar($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function modificar()
    {
        $sql = "UPDATE Producto SET 
        descripcion='{$this->descripcion}', 
        precio={$this->precio}, 
        id_categoria={$this->id_categoria}, 
        stock={$this->stock} 
        WHERE id_producto={$this->id_producto}";
        
        if(parent::ejecutar($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function eliminar()
    {
        $sql = "DELETE FROM producto WHERE id_producto=$this->id_producto";
        
        if(parent::ejecutar($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function buscar()
    {
        $sql = "SELECT p.id_producto, p.descripcion, p.precio, c.nombre,p.stock 
                FROM producto p
                INNER JOIN categoria c ON p.id_categoria = c.id_categoria";
        return parent::ejecutar($sql);
    }

    public function buscarPorCodigo($criterio)
    {
        $sql = "SELECT p.id_producto, p.descripcion, p.precio, c.nombre,p.stock
                FROM producto p
                INNER JOIN categoria c ON p.id_categoria = c.id_categoria
                WHERE p.id_producto LIKE '$criterio%'";
        return parent::ejecutar($sql);
    }

    public function buscarPorDescripcion($criterio)
    {
        $sql = "SELECT p.id_producto, p.descripcion, p.precio, c.nombre,p.stock
                FROM producto p
                INNER JOIN categoria c ON p.id_categoria = c.id_categoria
                WHERE p.descripcion LIKE '$criterio%'";
        return parent::ejecutar($sql);
    }

        public function buscarPorRangoStock($stockInicial, $stockFinal)
    {
        $sql = "SELECT * FROM Producto WHERE stock BETWEEN {$stockInicial} AND {$stockFinal}";
    return parent::ejecutar($sql);
    }
}
?>
