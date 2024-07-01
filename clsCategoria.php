<?php
include_once('clsConexion.php');

class Categoria extends Conexion
{
    // atributos
    private $id_categoria;
    private $nombre;
    
    // constructor
    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase padre
        $this->id_categoria = 0;
        $this->nombre = "";
    }

    // propiedades de acceso
    public function setIdCategoria($valor)
    {
        $this->id_categoria = $valor;
    }

    public function getIdCategoria()
    {
        return $this->id_categoria;
    }

    public function setNombre($valor)
    {
        $this->nombre = $valor;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function guardar()
    {
        $sql = "INSERT INTO categoria(nombre) VALUES ('$this->nombre')";
        
        if(parent::ejecutar($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function modificar()
    {
        $sql = "UPDATE categoria SET nombre='$this->nombre' WHERE id_categoria=$this->id_categoria";
        
        if(parent::ejecutar($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function eliminar()
    {
        $sql = "DELETE FROM categoria WHERE id_categoria=$this->id_categoria";
        
        if(parent::ejecutar($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function buscar()
    {
        $sql = "SELECT * FROM categoria";
        return parent::ejecutar($sql);
    }

    public function buscarPorNombre($criterio)
    {
        $sql = "SELECT * FROM categoria WHERE nombre LIKE '$criterio%'";
        return parent::ejecutar($sql);
    }
}
?>
