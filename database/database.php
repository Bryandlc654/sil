<?php
require_once (__DIR__ . '/../config/config.php');


class Database
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function getConexion()
    {
        return $this->conexion;
    }

    public function closeConexion()
    {
        $this->conexion->close();
    }
}

// Crear una instancia de la clase Database
$database = new Database();
$conexion = $database->getConexion();
?>