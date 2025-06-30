<?php
/**
 * 
 */
class MySQLdb 
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "inventario";
    private $port = "";
    private $conn;

    function __construct() 
    {
        //try catch por si hay error
        try {
            //conexión a la DB con instancia a la class PDO
            $this->conn = new PDO(
                'mysql:host='.$this->host.';dbname='.$this->db,
                $this->user,
                $this->pass
            );
            
            //echo "conectado a la DB";

        } catch (Exception $e) {
            die("No se pudo conectar: " . $e->getMessage());
        }
        
    }
}