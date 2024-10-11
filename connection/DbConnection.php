<?php

require_once __DIR__ . "/../interfaces/DbConnectionInterface.php";

class ConnectionBd implements PDOConnectionInterface

{

    private $server = "localhost";
    private $user = "root";
    private $password = "";
    private $db = "knowledge";
    private $connection;

    public function getConexion(): PDO

    {
        try {
            $this->connection = new PDO("mysql:host=$this->server;dbname=$this->db", $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "conectado";
            return $this->connection;
        } catch (PDOException $error) {
            echo "Conexion fallida" . $error->getMessage();
            return null;
        }
    }

}
