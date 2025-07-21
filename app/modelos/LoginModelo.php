<?php
/** */
class LoginModelo
{
    private $db = "";
    
    function __construct()
    {
        //instancia conexión BD
        $this->db = new MySQLdb();
    }

    //Actualiza la clave de acceso y pone el estado de usuario en Activo 1
    //Los :, en la sentencia SQL son marcadores de posición, indican que la info de las variables
    //serán recibidos de una var ($data) y no va directamente en la sentencia SQL,
    //se usan por seguridad, para evitar inyecciones maliciosas en la DB
    public function actualizarClaveAcceso($data='')
    {
        //valida si $data no vienevacio
        if ($data!="") {
            //define la instruccón SQL a la DB
            $sql = "UPDATE usuarios SET clave=:clave, estadoUsuario=".USUARIO_ACTIVO." WHERE id=:id";
            return $this->db->queryNoSelect($sql, $data);
        }
    }
    
    //actualiza la fecha de login (login_dt) del usuario (id), en la DB,
    //asignándole la fecha actual NOW()
    public function actualizarLogin($id='')
    {
        //valida si $data no vienevacio
        if ($id!="") {
            //define la instruccón SQL a la DB
            $sql = "UPDATE usuarios SET login_dt=(NOW()) WHERE id=".$id;
            return $this->db->queryNoSelect($sql);
        }
    }

    //buaca si el usuario (email) recibido existe ne la BD, retorna :array 
    //con los datos del usuario
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
}