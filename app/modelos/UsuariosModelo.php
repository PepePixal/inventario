<?php

class UsuariosModelo
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
        $sql = "INSERT INTO usuarios VALUES(0,";      //1. id
        $sql.= "'".$data['tipoUsuario']."', ";        //2. tipoUsuario
        $sql.= "'".$data['nombres']."', ";            //3. nombres
        $sql.= "'".$data['apellidos']."', ";          //4. apellidos
        $sql.= "'".$data['direccion']."', ";          //5. direccion
        $sql.= "'".$data['telefono']."', ";           //6. telefono
        $sql.= "'".$data['correo']."', ";             //7. correo
        $sql.= "'".$data['clave']."', ";              //8. clave
        $sql.= "'".$data['genero']."', ";             //9. genero
        $sql.= "'".$data['estadoUsuario']."', ";      //10. estadoUsuario
        $sql.= "0, ";                                 //11. baja
        $sql.= "'', ";                                //12. fecha login
        $sql.= "NOW(), ";                             //13. fecha alta
        $sql.= "'', ";                                //14. fecha baja
        $sql.= "'')";                                 //15. fecha cambio

        //llama método queryNoSelect() enviando $sql y retorna el resultado
        return $this->db->queryNoSelect($sql);
    }

    //buaca si el usuario (email) recibido existe ne la BD, retorna :array
    public function buscarCorreo( string $usuario='') :array
    {
        //valida si el usuario email viene vacio, retorna false
        if (empty($usuario)) return [];
        
        //define la consulta SQL para el query()
        $sql = "SELECT id, tipoUsuario, nombres, apellidos, direccion, telefono, correo, clave, genero, estadoUsuario FROM usuarios WHERE baja=0 AND correo='".$usuario."'";
        //llama al método query de la class MySQLdb, enviando la consulta sql
        //y retorna la respuesta.
        return $this->db->query($sql);
    }

    //actualiza la columna baja y baja_dt del registro pais, según su id
    public function bajaLogica($id) {

        $salida = true;
        //define la sentencia SQL para el query
        $sql = "UPDATE usuarios SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
        //llama metodo query en db, enviando la sql
        $salida = $this->db->queryNoSelect($sql);
        return $salida;

    }

    //obtinene la cantidad de registros, de alta, de la tabla paises
    public function getNumRegistros()
    {
        //define la instrucción SQL, que cuenta la cantida de registros
        $sql = "SELECT COUNT(*) FROM usuarios WHERE baja=0";
        
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
        $sql = "SELECT u.id, CONCAT(u.apellidos,' ',u.nombres) as nombre, ";
        $sql.= "tu.tipoUsuario, eu.estado ";
        $sql.= "FROM usuarios as u, tipoUsuario as tu, estadoUsuario as eu ";
        $sql.= "WHERE baja=0 AND ";
        $sql.= "u.estadoUsuario=eu.id AND ";
        $sql.= "u.tipoUsuario=tu.id";

        //si la cantidad de registros a mostra $tamano > 0
        if ($tamano > 0) {
            //limita los registros consultados desde $inicio a $tamano
            $sql.= " LIMIT " . $inicio . ", " . $tamano;
        }

        //hace la consulta sql con el método querySelect() y retorna el resultado
        return $this->db->querySelect($sql);
    }

    //obtiene los campos del registro de la tabla paises, por us id,
    //retorna un arreglo idexado y asoc, con los campos
    public function getId($id='')
    {
        if (empty($id)) return false;
        //define la sentencia SQL para el query
        $sql = "SELECT id, tipoUsuario, nombres, apellidos, direccion, telefono, correo, clave, genero, estadoUsuario FROM usuarios WHERE id='".$id."' AND baja=0";
        //hace la consulta query a la db y retorna a PDOStatement object, or FALSE si falla.
        return $this->db->query($sql);
    }

        //obtiene un registro de la tabla paises, por us id
    public function getCorreo($correo='')
    {
        if (empty($correo)) return false;
        //define la sentencia SQL para el query
        $sql = "SELECT id FROM usuarios WHERE correo='".$correo."' AND baja=0";
        //hace la consulta query a la db y retorna a PDOStatement object, or FALSE si falla.
        return $this->db->query($sql);
    }

    //obtiene los tipos de usuarios de la tabla tipousuario
    public function getTiposUsuarios()
    {
        $sql = "SELECT id, tipoUsuario FROM tipousuario";
        return $this->db->querySelect($sql);

    }

    //obtiene los estados de usuarios de la tabla estadousuario
    public function getEstadosUsuarios()
    {
        $sql = "SELECT id, estado FROM estadousuario";
        return $this->db->querySelect($sql);

    }

    //obtiene los generos de usuarios de la tabla generos
    public function getGeneros()
    {
        $sql = "SELECT id, genero FROM generos";
        return $this->db->querySelect($sql);

    }

    public function modificar($data)
    {
        $salida = false;
        //valida si el id NO esta vacio
        if (!empty($data["id"])) {
            //define la instrucción SQL que enviará al query
            $sql = "UPDATE usuarios SET ";
            $sql.= "tipoUsuario='".$data['tipoUsuario']."', ";
            $sql.= "nombres='".$data['nombres']."', ";
            $sql.= "apellidos='".$data['apellidos']."', ";
            $sql.= "direccion='".$data['direccion']."', ";
            $sql.= "telefono='".$data['telefono']."', ";
            $sql.= "correo='".$data['correo']."', ";
            $sql.= "genero='".$data['genero']."', ";
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