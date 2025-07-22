<?php

class ProveedoresModelo
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
        //definición de sentencia SQL para insertar un nuevo usuario
        $sql = "INSERT INTO proveedores VALUES(0,";     //1. id
        $sql.= "'".$data['nombre']."', ";               //2. nombre
        $sql.= "'".$data['idPais']."', ";                 //3. web
        $sql.= "'".$data['web']."', ";                 //4. pais
        $sql.= "0, ";                                 //5. baja
        $sql.= "NOW(), ";                             //6. fecha alta
        $sql.= "'', ";                                //7. fecha baja
        $sql.= "'')";                                 //8. fecha cambio

        //llama método queryNoSelect() enviando $sql y retorna el resultado
        return $this->db->queryNoSelect($sql);
    }

    //actualiza la columna baja y baja_dt del registro proveedores, según su id
    public function bajaLogica($id) {

        $salida = true;
        //define la sentencia SQL para el query
        $sql = "UPDATE proveedores SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
        //llama metodo query en db, enviando la sql
        $salida = $this->db->queryNoSelect($sql);

        return $salida;
    }
    
    //obtiene los campos del registro de la tabla proveedores, por su id,
    //retorna un arreglo idexado y asoc, con los campos
    public function getId($id='')
    {
        if (empty($id)) return false;
        //define la sentencia SQL para el query
        $sql = "SELECT id, nombre, idPais, web FROM proveedores WHERE id='".$id."' AND baja=0";
        //hace la consulta query a la db y retorna a PDOStatement object, or FALSE si falla.
        return $this->db->query($sql);
    }
    
    //obtinene la cantidad de registros, de alta, de la tabla paises
    public function getNumRegistros()
    {
        //define la instrucción SQL, que cuenta la cantida de registros
        $sql = "SELECT COUNT(*) FROM proveedores WHERE baja=0";
        
        //ejecuta la consulta query()
        $salida = $this->db->query($sql);

        //retorna solo la cantidad de la consulta
        return $salida["COUNT(*)"];
    }
    
    //obtiene los generos de usuarios de la tabla generos
    public function getPaises()
    {
        $sql = "SELECT id, pais FROM paises WHERE baja=0 ORDER BY pais";
        return $this->db->querySelect($sql);
    }
    
    //obtiene los datos de la tabla proveedores, requiere: el registro inicio,
    //a partir del cual obtener y la cantidad de registros a obtener
    public function getTabla($inicio=1, $tamano=0)
    {
        //define la intrucción SQL . concatenada, para la consulta
        $sql = "SELECT pro.id, pro.nombre, ";
        $sql.= "pro.idPais, p.pais ";
        $sql.= "FROM proveedores as pro, paises as p ";
        $sql.= "WHERE pro.baja=0 AND ";
        $sql.= "pro.idPais=p.id ";

        //si la cantidad de registros a mostra $tamano > 0
        if ($tamano > 0) {
            //limita los registros consultados desde $inicio a $tamano
            $sql.= " LIMIT " . $inicio . ", " . $tamano;
        }

        //hace la consulta sql con el método querySelect() y retorna el resultado
        return $this->db->querySelect($sql);
    }

    public function modificar($data)
    {
        $salida = false;

        //valida si el id NO esta vacio
        if (!empty($data["id"])) {

            //define la instrucción SQL que enviará al query
            $sql = "UPDATE proveedores SET ";
            $sql.= "nombre='".$data['nombre']."', ";
            $sql.= "idPais='".$data['idPais']."', ";
            $sql.= "web='".$data['web']."', ";
            $sql.= "cambio_dt=(NOW()) ";
            $sql.= "WHERE id=".$data['id'];

            //en la modificación no enviamos ni la clave ni el estadoUsuario,
            //para que no se cambien en la DB

            //llama metodo queryNoSelect() enviando $sql y asigna el result a $salida
            $salida = $this->db->queryNoSelect($sql);
        }
        //retorna $salida con el resultado del query o false
        return $salida;
    }
}
?>