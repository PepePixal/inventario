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
        //CONEXIÓN A LA BD con try catch, por si hay error
        try {
            //conexión a la DB, instanciando class PDO,
            //requiere: nom_host;nom_DB, user, pass 
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

    //** SELECT */
    //método, con la instrucción SELECT SQL, recibida en $sql,
    //fetch() retorna :array, con el primer registro encontrado 
    public function query($sql='') :array
    {
        //valida si squl viene vacio, retorna false
        if (empty($sql)) return [];

        //consulta query, con la sentencia SQL recibida, llamando a la conn (conexión BD),
        //query() retorna un PDOStatement objec, o false si falla
        $stmt = $this->conn->query($sql);
        //obtiene la primera fila (fetcht()), de la respuesta en $stmt y
        //la asigna a $salida como arreglo
        $salida = $stmt -> fetch();

        //si $salida tiene contenido, lo retorna
        if($salida) {
            return $salida;
        }
        //si $salida no tiene contenido, retorna arreglo vacio
        return [];
    }

    //** UPDATE, DELETE, INSERT */
    //método, para UPDATE o DELETE o INSERT, recibida en $sql,
     
    public function queryNoSelect($sql, $data)
    {
        //php prepare(), prepara una sentencia SQL para su ejecución y devuelve un objeto de declaración.
        //php execute(), ejecuta la sentencia SQL preparada y devuelve true o false 
        return $this->conn->prepare($sql)->execute($data);
    }
}