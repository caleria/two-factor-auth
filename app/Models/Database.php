<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    protected $db;

    private $host = 'localhost';
    private $dbname = 'twofactor';
    private $username = 'root';
    private $password = '';

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";

            $this->db = new PDO($dsn, $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            //echo "Error de conexion: " . $e->getMessage();
            throw new \Exception("Error de conexión: " . $e->getMessage());
        }
    }




    public function __destruct()
    {
        $this->db = null;
    }



    
    public function obtenerConexion()
    {
        return $this->db;
    }
}
