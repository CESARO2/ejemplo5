<?php
class Conexion {
    // atributos
    private $servidor;
    private $usuario;
    private $password;
    private $basededatos;

    // constructor
    public function __construct() {
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->password = "";
        $this->basededatos = "ejemplo5pro";
    }

    // métodos de acceso set y get
    public function setServidor($valor) {
        $this->servidor = $valor;
    }

    public function getServidor() {
        return $this->servidor;
    }

    public function setUsuario($valor) {
        $this->usuario = $valor;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setPassword($valor) {
        $this->password = $valor;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setBasedatos($valor) {
        $this->basededatos = $valor;
    }

    public function getBasedatos() {
        return $this->basededatos;
    }

    // métodos
    public function conectar() {
        $bd = mysqli_connect($this->servidor, $this->usuario, $this->password, $this->basededatos);
        if ($bd) {
            return $bd;
        } else {
            echo "ERROR AL CONECTAR LA BASE DE DATOS...!!!";
            return null;
        }
    }

    public function desconectar($cnx) {
        mysqli_close($cnx);
    }

    public function ejecutar($sql) {
        $bd = $this->conectar();
        if ($bd) {
            $registros = mysqli_query($bd, $sql);
            $this->desconectar($bd);
            return $registros;
        } else {
            return null;
        }
    }
}
?>
