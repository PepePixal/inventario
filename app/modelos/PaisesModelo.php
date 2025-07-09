<?php

class PaisesModelo
{
    private $db = "";

    function __construct()
    {
        //instancia conexión BD
        $this->db = new MySQLdb();
    }

    //agrega nuevo registro pais a la tabla paises de la BD
    public function alta($data='')
    {
        //definición de sentencia SQL para insertar un nuevo pais
        $sql = "INSERT INTO paises VALUES(0,";      //1. id
        $sql.= "'".$data['pais']."', ";             //2. pais
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
        $sql = "UPDATE paises SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
        //llama metodo query en db, enviando la sql
        $salida = $this->db->queryNoSelect($sql);
        return $salida;

    }


    //obtiene los datos de la tabla paises, requiere
    //el registro inicio y la cantidad de registroa a mostrar
    public function getTabla($inicio=1, $tamano=0)
    {
        //define la intrucción SQL . concatenada, para la consulta
        $sql = "SELECT id, pais ";
        $sql.= "FROM paises ";
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
        $sql = "SELECT * FROM paises WHERE id='".$id."'";
        //hace la consulta query a la db y retorna a PDOStatement object, or FALSE si falla.
        return $this->db->query($sql);
    }

    public function modificar($data)
    {
        $salida = false;
        //valida si el id NO esta vacio
        if (!empty($data["id"])) {
            //define la instrucción SQL que enviará al query
            $sql = "UPDATE paises SET ";
            $sql.= "pais='".$data['pais']."', ";
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