<?php

class Database {
    private $host = "127.0.0.1"; // Nombre del servidor de la base de datos (generalmente "localhost")
    private $username = "root"; // Nombre de usuario de la base de datos
    private $password = "root"; // Contraseña de la base de datos
    private $dbname = "blogprueba"; // Nombre de la base de datos

    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

?>

