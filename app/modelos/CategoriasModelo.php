<?php

class CategoriasModelo
{
    private $db = "";

    function __construct()
    {
        //instancia conexión BD
        $this->db = new MySQLdb();
    }

    //agrega nuevo registro categoria a la tabla categorias de la BD
    public function alta($data='')
    {
        //definición de sentencia SQL para insertar un nuevo pais
        $sql = "INSERT INTO categorias VALUES(0,";      //1. id
        $sql.= "'".$data['categoria']."', ";             //2. categoria
        $sql.= "0, ";                               //3. baja
        $sql.= "NOW(), ";                           //4. fecha alta
        $sql.= "'', ";                              //5. fecha baja
        $sql.= "'')";                              //6. fecha cambio

        //llama método queryNoSelect() enviando $sql y retorna el resultado
        return $this->db->queryNoSelect($sql);
    }

    //actualiza la columna baja y baja_dt del registro pais, según su id
    public function bajaLogica($id) {

        $salida = true;
        //define la sentencia SQL para el query
        $sql = "UPDATE categorias SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
        //llama metodo query en db, enviando la sql
        $salida = $this->db->queryNoSelect($sql);
        return $salida;

    }

    //obtinene la cantidad de registros, de alta, de la tabla paises
    public function getNumRegistros()
    {
        //define la instrucción SQL, que cuenta la cantida de registros
        $sql = "SELECT COUNT(*) FROM categorias WHERE baja=0";
        
        //ejecuta la consulta query()
        $salida = $this->db->query($sql);

        //retorna solo la cantidad de la consulta
        return $salida["COUNT(*)"];
    }

    //obtiene los datos de la tabla categorias, requiere: el registro inicio,
    //a partir del cual obtener y la cantidad de registros a obtener
    public function getTabla($inicio=1, $tamano=0)
    {
        //define la intrucción SQL . concatenada, para la consulta
        $sql = "SELECT id, categoria ";
        $sql.= "FROM categorias ";
        $sql.= "WHERE baja=0";

        //si la cantidad de registros a mostra $tamano > 0
        if ($tamano > 0) {
            //limita los registros consultados desde $inicio a $tamano
            $sql.= " LIMIT " . $inicio . ", " . $tamano;
        }

        //hace la consulta sql con el método querySelect() y retorna el resultado
        return $this->db->querySelect($sql);
    }

    //obtiene un registro de la tabla paises, por us id
    public function getId($id='')
    {
        if (empty($id)) return false;
        //define la sentencia SQL para el query
        $sql = "SELECT id, categoria FROM categorias WHERE id='".$id."'";
        //hace la consulta query a la db y retorna a PDOStatement object, or FALSE si falla.
        return $this->db->query($sql);
    }

    public function modificar($data)
    {
        $salida = false;
        //valida si el id NO esta vacio
        if (!empty($data["id"])) {
            //define la instrucción SQL que enviará al query
            $sql = "UPDATE categorias SET ";
            $sql.= "categoria='".$data['categoria']."', ";
            $sql.= "cambio_dt=(NOW()) ";
            $sql.= "WHERE id=".$data['id'];

            //llama metodo queryNoSelect() enviando $sql y asigna el result a $salida
            $salida = $this->db->queryNoSelect($sql);
        }
        //retorna $salida con el resultado del query o false
        return $salida;
    }
}
?>