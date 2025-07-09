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
    //métodos, con la instrucción SELECT SQL, recibida en $sql,
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

    public function querySelect($sql='') {

        //valida Si sql viene vacio, retorna false
        if (empty($sql)) return false;
        
        //define arreglo para los datos de la respuesta
        $data = [];

        //consulta con el método php query() de la conexión php PDO a la DB,
        //enviando la sentencia $sql recibida.
        //PDO::query retorna a PDOStatement object, or FALSE on failure.
        $stmt = $this->conn->query($sql);

        //ferch() obtinene la siguiente fila del objeto almacenado en $stmt,
        //PDO::FETCHT_ASSOC, indica a fetch en que formato quiere la fila obtenida, array assoc 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        do {
            //inserta, al final del arreglo index $data, la fila obtenida en $row
            array_push($data, $row);
        //mientras obtenga una siguiente fila del objeto almacenado en $stmt 
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));

        //valida si no hay info en la primera posición del arreglo $data[0]
        if (!$data[0]) {
            // asigna arreglo vacio a $data
            $data = [];
        }

        //retorna el arreglo index $data, con la info de la tabla o vacio
        return $data;
    }

    //** INSERT, UPDATE, DELETE */
    //método, para INSERT o UPDATE o DELETE, recibida en $sql y $data
     
    public function queryNoSelect($sql, $data="")
    {
        //valida si data viene vacio, $sql es un INSERT nuevo directo a la DB
        if ($data=="") {
            //agrega nuevo registro a la BD. retorna a PDOStatement object, o FALSE si falla.
            return $this->conn->query($sql);

        //si data NO viene vacio, es para un UPDATE o DELETE
        } else {
            //php prepare(), prepara una sentencia SQL para su ejecución y devuelve un objeto de declaración.
            //php execute(), ejecuta la sentencia SQL preparada y devuelve true o false 
            return $this->conn->prepare($sql)->execute($data);
        }
    }
}
?>