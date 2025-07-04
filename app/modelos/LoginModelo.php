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

    public function actualizarClaveAcceso($data='')
    {
        //valida si $data no vienevacio
        if ($data!="") {
            //define la instruccón SQL a la DB
            $sql = "UPDATE usuarios SET clave=:clave WHERE id=:id";
            return $this->db->queryNoSelect($sql, $data);
        }
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
}